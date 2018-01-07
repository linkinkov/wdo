<?php

class Arbitrage
{
	// protected $ticket_id;
	public function __construct($ticket_id = false, $project_id = false, $respond_id = false, $descr = "")
	{
		global $db;
		global $current_user;
		if ( $current_user->user_id <= 0 )
		{
			$this->message = "Доступ запрещен";
			return $this;
		}
		if ( $ticket_id )
		{
			try {
				$sql = sprintf("SELECT * FROM `arbitrage` WHERE `ticket_id` = '%s'",$ticket_id);
				$i = $db->queryRow($sql);
				if ( isset($i->ticket_id) )
				{
					foreach ( $i as $f=>$v ) $this->$f = $v;
				}
				else
				{
					throw new Exception(sprintf("Запрос %s не найден",$ticket_id));
				}
			}
			catch ( Exception $e ) {
				return $e->getMessage();
				return false;
			}
		}
		else if ( intval($project_id) > 0 && intval($respond_id) > 0 && $descr != "" )
		{
			try {
				$this->create_ticket(intval($project_id),intval($respond_id), $descr);
				// return true;
			}
			catch ( Exception $e ) {
				// return "Can't create ticket: ".$e->getMessage();
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	private function create_ticket($project_id, $respond_id, $descr)
	{
		global $db;
		global $current_user;
		try {
			$this->ticket_id = md5($project_id.$respond_id);
			$sql = sprintf("INSERT INTO `arbitrage` (`ticket_id`, `project_id`, `respond_id`, `user_id`, `descr`, `status_id`, `timestamp`, `timestamp_modified`) VALUES ('%s','%d','%d','%d','%s',1,UNIX_TIMESTAMP(),UNIX_TIMESTAMP())", $this->ticket_id, $project_id, $respond_id, $current_user->user_id, trim($descr));
			if ( $db->query($sql) )
			{
				// $this->project_id = $project_id;
				// $this->respond_id = $respond_id;
				// $this->user_id = $current_user->user_id;
				// $this->descr = $descr;
				$this->result = "true";
				return true;
			}
		}
		catch ( Exception $e ) {
			$this->message = ( $e->getCode() == 1062 ) ? "Заявка уже существует" : $e->getMessage();
			return false;
		}
	}

	public function get_comments()
	{
		global $db;
		global $current_user;
		if ( $current_user->user_id <= 0 || $current_user->template_id != 2 )
		{
			$this->message = "Доступ запрещен";
			return $this;
		}
		try {
			$sql = sprintf("SELECT `message`,`timestamp`,`real_user_name`,`arbitrage_comments`.`user_id`
			FROM `arbitrage_comments`
			LEFT JOIN `users` ON `users`.`user_id` = `arbitrage_comments`.`user_id`
			WHERE `ticket_id` = '%s'
			ORDER BY `timestamp` ASC
			",$this->ticket_id);
			return $db->queryRows($sql);
		}
		catch ( Exception $e )
		{
			$this->message = $e->getMessage();
		}
	}

	public function add_comment($message)
	{
		global $db;
		global $current_user;
		$response["result"] = "false";
		$response["message"] = "Доступ запрещен";
		if ( $current_user->user_id <= 0 || $current_user->template_id != 2 )
		{
			return $response;
		}
		$db->autocommit(false);
		try {
			$comment_id = md5($this->ticket_id.$current_user->user_id.$message);
			$sql = sprintf("INSERT INTO `arbitrage_comments` (`comment_id`,`ticket_id`,`message`,`user_id`,`timestamp`) VALUES ('%s','%s','%s','%d',UNIX_TIMESTAMP())",
			$comment_id, $this->ticket_id, $message, $current_user->user_id);
			if ( $db->query($sql) && $db->affected_rows > 0 )
			{
				if ( $this->status_id == 1 ) $db->query(sprintf("UPDATE `arbitrage` SET `status_id` = 2 WHERE `ticket_id` = '%s'",$this->ticket_id));
				$sql = sprintf("UPDATE `arbitrage` SET `timestamp_modified` = UNIX_TIMESTAMP() WHERE `ticket_id` = '%s'",$this->ticket_id);
				if ( $db->query($sql) && $db->affected_rows > 0 )
				{
					$response["comment"] = $db->queryRow(
						sprintf("SELECT `message`,`timestamp`,`real_user_name`,`arbitrage_comments`.`user_id`
						FROM `arbitrage_comments`
						LEFT JOIN `users` ON `users`.`user_id` = `arbitrage_comments`.`user_id`
						WHERE `comment_id` = '%s'",$comment_id));
					$db->commit();
					$response["result"] = "true";
				}
			}
		}
		catch ( Exception $e )
		{
			$response["message"] = $e->getMessage();
		}
		return $response;
	}

	public function resolve($profit_for,$resolve_text)
	{
		global $db;
		global $current_user;
		$response["result"] = "false";
		$response["message"] = "Доступ запрещен";
		if ( $current_user->user_id <= 0 || $current_user->template_id != 2 )
		{
			return $response;
		}
		$db->autocommit(false);
		try {
			$project_user = new User($db->getValue("project","user_id","user_id",Array("project_id"=>$this->project_id)));
			$project_user->init_wallet();

			$respond_user = new User($db->getValue("project_responds","user_id","user_id",Array("respond_id"=>$this->respond_id)));
			$respond_user->init_wallet();

			$system_user = new User(1);
			$system_user->init_wallet();

			$transactions = Array(
				"safe_hold" => Array(),
				"safe_hold_comission" => Array(),
				"overcost" => Array(),
				"overcost_comission" => Array(),
				"vip" => Array()
			);
			// Find all transactions related to project
			$find_transaction = Array (
				"for_project_id" => $this->project_id,
				"type" => "HOLD",
				"descr" => "Удержание за безопасную сделку"
			);
			$transactions["safe_hold"] = $project_user->wallet->find_transaction($find_transaction);
			if ( !isset($transactions["safe_hold"]->transaction_id) )
			{
				$response["message"] = "Невозможно найти транзакцию на удержание (БС)";
				return $response;
			}

			// get HOLD transaction for safe project comission
			$find_transaction = Array (
				"reference_id" => $transactions["safe_hold"]->transaction_id,
				"for_project_id" => $this->project_id,
				"type" => "HOLD",
				"descr" => "Удержание за безопасную сделку (комиссия)"
			);
			$transactions["safe_hold_comission"] = $project_user->wallet->find_transaction($find_transaction);

			// more to withdrawal hold transaction
			$find_transaction = Array (
				"reference_id" => $transactions["safe_hold"]->transaction_id,
				"for_project_id" => $this->project_id,
				"type" => "HOLD",
				"descr" => "Удержание сверх бюджета в проекте"
			);
			$transactions["overcost"] = $project_user->wallet->find_transaction($find_transaction);

			$find_transaction = Array (
				"reference_id" => $transactions["safe_hold"]->transaction_id,
				"for_project_id" => $this->project_id,
				"type" => "HOLD",
				"descr" => "Удержание сверх бюджета в проекте (комиссия)"
			);
			$transactions["overcost_comission"] = $project_user->wallet->find_transaction($find_transaction);


			if ( $profit_for == "respond_user" )
			{
				// confirm transactions
				foreach ( $transactions as $name => $transaction )
				{
					if ( !isset($transaction->transaction_id) ) continue;
					$transaction->commit = false;
					if ( $project_user->wallet->confirm_holded_transaction((array)$transaction) !== true )
					{
						$response["message"] = "Не удалось подтвердить транзакцию HOLD";
						return $response;
					}
					// Make a comission payment to system user
					if ( strstr($name,"comission") !== false )
					{
						// Payment to system (comission)
						$new_transaction = Array (
							"reference_id"=>$transaction->transaction_id,
							"type"=>"PAYMENT",
							"amount"=>intval($transaction->amount),
							"descr"=>$transaction->descr,
							"for_project_id"=>$this->project_id,
							"commit"=>false
						);
						if ( $system_user->wallet->create_transaction($new_transaction) === false )
						{
							$response["message"] = "Ошибка зачисления средств в систему";
							return $response;
						}
					}
				}
				$project_cost = $db->getValue("project","cost","cost",Array("project_id"=>$this->project_id,"user_id"=>$project_user->user_id));
				$respond_cost = $db->getValue("project_responds","cost","cost",Array("respond_id"=>$this->respond_id,"user_id"=>$respond_user->user_id));
				$cost = (intval($respond_cost) > 0) ? intval($respond_cost) : intval($project_cost);
				$new_transaction = Array (
					"reference_id"=>$transactions["safe_hold"]->transaction_id,
					"type"=>"PAYMENT",
					"amount"=>intval($cost),
					"descr"=>"Зачисление за исполненную заявку",
					"for_project_id"=>$this->project_id,
					"commit"=>false
				);

				if ( ($transaction_id = $respond_user->wallet->create_transaction($new_transaction)) === false )
				{
					$response["message"] = "Ошибка зачисления средств исполнителю";
					return $response;
				}
				$db->query(sprintf("UPDATE `project_responds` SET `status_id` = 5 WHERE `respond_id` = '%d'",$this->respond_id));
				$db->query(sprintf("UPDATE `project` SET `status_id` = '3' WHERE `project_id` = '%d' AND `user_id` = '%d'",$this->project_id,$project_user->user_id));
				$db->commit();
				$response["result"] = "true";
				$response["message"] = "Средства зачислены исполнителю";
			}
			else if ( $profit_for == "project_user" )
			{
/*
				// also cancel VIP HOLD transaction
				$find_transaction = Array (
					"type"=>"HOLD",
					"descr"=>"Удержание за платный проект",
					"for_project_id"=>$this->project_id,
				);
				$transactions["vip"] = $project_user->wallet->find_transaction($find_transaction);
*/
				// cancel transactions
				foreach ( $transactions as $name => $transaction )
				{
					if ( !isset($transaction->transaction_id) ) continue;
					$transaction->commit = false;
					if ( $project_user->wallet->cancel_holded_transaction((array)$transaction) !== true )
					{
						$response["message"] = "Не удалось отменить транзакцию HOLD";
						return $response;
					}
				}
				$db->query(sprintf("UPDATE `project_responds` SET `status_id` = 4 WHERE `respond_id` = '%d'",$this->respond_id));
				$db->query(sprintf("UPDATE `project` SET `status_id` = '3' WHERE `project_id` = '%d' AND `user_id` = '%d'",$this->project_id,$project_user->user_id));
				$db->query(sprintf("UPDATE `arbitrage` SET `status_id` = 3 WHERE `ticket_id` = '%s'",$this->ticket_id));
				$db->commit();
				$response["result"] = "true";
				$response["message"] = "Средства возвращены заказчику";
			}
		}
		catch ( Exception $e )
		{
			$response["error"] = $e->getMessage();
		}
		return $response;
	}
}