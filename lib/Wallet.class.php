<?php

class Wallet
{
	private $wallet_id;
	private $transactions;
	public function __construct($user_id)
	{
		global $db;
		global $current_user;
		// $this->user_id = $user_id;
		if ( $current_user->user_id <= 0 || intval($user_id) <= 0 ) return false;
		$this->wallet_id = "";
		try {
			$this->user_id = $user_id;
			$sql = sprintf("SELECT `wallet_id`,`balance` FROM `user_wallets` WHERE `user_id` = '%d'",$this->user_id);
			$i = $db->queryRow($sql);
			if ( !isset($i->wallet_id) )
			{
				$wallet_id = md5($this->user_id.time());
				$sql = sprintf("INSERT INTO `user_wallets` (`wallet_id`,`user_id`) VALUES ('%s','%d')",$wallet_id,$this->user_id);
				$db->query($sql);
				$this->wallet_id = $wallet_id;
				$this->balance = 0;
			}
			else
			{
				$this->wallet_id = $i->wallet_id;
				$this->balance = $i->balance;
			}
			$this->transactions = false;
			$sql = sprintf("SELECT
			(
				(
					SELECT COALESCE(SUM(`amount`), 0)
					FROM `wallet_transactions`
					WHERE `type` IN('PAYMENT') AND `wallet_id` = '%s'
				) - 
				(
					SELECT COALESCE(SUM(`amount`),0)
					FROM `wallet_transactions`
					WHERE `type` IN('HOLD', 'WITHDRAWAL') AND `wallet_id` = '%s'
				)
			) AS `balance`
			FROM `user_wallets`
			WHERE `wallet_id` = '%s'
			",$this->wallet_id,$this->wallet_id,$this->wallet_id);
			// echo $sql;
			$tmp = $db->queryRow($sql);
			if ( intval($tmp->balance) != intval($this->balance) )
			{
				$sql = sprintf("UPDATE `user_wallets` SET `balance` = '%d' WHERE `wallet_id` = '%s' AND `user_id` = '%d'",$tmp->balance,$this->wallet_id,$this->user_id);
				if ( $db->query($sql) )
				{
					$this->balance = intval($tmp->balance);
				}
			}
		}
		catch ( Exception $e )
		{
			// return $e->getMessage();
			return false;
		}
	}

	public function create_transaction($transaction_data)
	{
		global $db;
		global $current_user;
		if ( $current_user->user_id <= 0 || $this->user_id <= 0 ) return false;
		if ( 
			strlen($this->wallet_id) != 32
			|| !in_array($transaction_data["type"],Array("PAYMENT","HOLD","WITHDRAWAL"))
			|| (intval($transaction_data["amount"]) <= 0)
			|| ($this->balance < intval($transaction_data["amount"]))
		) return false;
		$transaction_id = md5($this->user_id.$this->wallet_id.$transaction_data["type"].$transaction_data["amount"].$transaction_data["descr"].time());
		$sql = sprintf("INSERT INTO `wallet_transactions` (
			`transaction_id`,
			`wallet_id`,
			`reference_id`,
			`type`,
			`amount`,
			`timestamp`,
			`descr`,
			`for_project_id`)
		VALUES ('%s','%s','%s','%s','%d',UNIX_TIMESTAMP(),'%s','%d')",
			$transaction_id,
			$this->wallet_id,
			$transaction_data["reference_id"],
			$transaction_data["type"],
			intval($transaction_data["amount"]),
			trim($transaction_data["descr"]),
			intval($transaction_data["for_project_id"])
		);
		// echo $sql;
		$db->autocommit(false);
		try {
				// echo "success";
			if ( $db->query($sql) && $db->affected_rows > 0 )
			{
				if ( $transaction_data["commit"] == true ) $db->commit();
				return true;
			}
		}
		catch ( Exception $e )
		{
			// echo $e->getMessage();
		}
		return false;
	}

	public function find_transaction($transaction_data)
	{
		global $db;
		global $current_user;
		if ( $current_user->user_id <= 0 || $this->user_id <= 0 ) return false;
		if ( strlen($this->wallet_id) != 32 ) return false;
		if ( !in_array($transaction_data["type"],Array("PAYMENT","HOLD","WITHDRAWAL")) ) return false;
		$where = Array();
		foreach ( $transaction_data as $k=>$v )
		{
			$where[] = sprintf("`%s` = '%s'",$k,$v);
		}
		$where = implode(" AND",$where);
		// echo sprintf("SELECT * FROM `wallet_transactions` WHERE `wallet_id` = '%s' AND %s",$this->wallet_id,$where);
		$transaction = $db->queryRow(sprintf("SELECT * FROM `wallet_transactions` WHERE `wallet_id` = '%s' AND %s",$this->wallet_id,$where));
		return $transaction;
	}

	public function confirm_holded_transaction($transaction_data)
	{
		global $db;
		global $current_user;
		if ( $current_user->user_id <= 0 || $this->user_id <= 0 ) return false;
		if ( strlen($this->wallet_id) != 32 ) return false;
		if ( strlen($transaction_data["transaction_id"]) != 32 ) return false;
		$db->autocommit(false);
		$sql = sprintf("UPDATE `wallet_transactions` 
			SET `type` = 'WITHDRAWAL',
					`descr` = 'Списание средств за безопасную сделку'
			WHERE `wallet_id` = '%s' 
				AND `transaction_id` = '%s' 
				AND `type` = 'HOLD'",
				$this->wallet_id,
				$transaction_data["transaction_id"]);
		try {
			if ( $db->query($sql) && $db->affected_rows > 0 )
			{
				if ( $transaction_data["commit"] == true ) $db->commit();
				return true;
			}
		}
		catch ( Exception $e )
		{
			// echo $e->getMessage();
		}
		return false;
	}

}