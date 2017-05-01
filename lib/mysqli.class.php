<?php
require_once(PD.'/includes/phrdb.config.php');

class db extends mysqli
{
	protected static $instance;
	protected static $options = array();

	public function __construct() {
		$o = self::$options;

		// turn of error reporting
		mysqli_report(MYSQLI_REPORT_OFF);

		// connect to database
		@parent::__construct(isset($o['host'])   ? $o['host']   : PHR_HOST,
													isset($o['user'])   ? $o['user']   : PHR_USER,
													isset($o['pass'])   ? $o['pass']   : PHR_PASSWORD,
													isset($o['dbname']) ? $o['dbname'] : PHR_DATABASE,
													isset($o['port'])   ? $o['port']   : 3306,
													isset($o['sock'])   ? $o['sock']   : false );

		// check if a connection established
		if( mysqli_connect_errno() ) {
			throw new exception(mysqli_connect_error(), mysqli_connect_errno()); 
		}
	}

	public static function getInstance($new_link = false) {
		if( !self::$instance ) {
			self::$instance = new self();
		}
		if ( $new_link ) {
			self::$instance = new self();
		}
		mysqli_set_charset( self::$instance, 'utf8');
		return self::$instance;
	}

	public static function setOptions( array $opt ) {
		self::$options = array_merge(self::$options, $opt);
	}

	public function query($query) {
		if( !$this->real_query($query) ) {
			throw new exception( $this->error, $this->errno );
		}

		$result = new mysqli_result($this);
		return $result;
	}

	public function prepare($query) {
		$stmt = new mysqli_stmt($this, $query);
		return $stmt;
	}

	public function queryRow($sql,$array = false) {
		if( !$this->real_query($sql) ) {
			if ( !$sql ) return false;
			throw new exception( $this->error, $this->errno );
		}

		$result = new mysqli_result($this);
		if ( $array == true )
			$result = $result->fetch_array();
		else
			$result = $result->fetch_object();
		return $result;
	}
	public function queryRows($sql,$array = false) {
		$aaData = Array();
		if ( !$sql ) return false;
		if( !$this->real_query($sql) ) {
			throw new exception( $this->error, $this->errno );
		}

		$result = new mysqli_result($this);
		if ( $array )
		{
			while ( $row = $result->fetch_assoc() ) {
				$aaData[] = $row;
			};
		}
		else
		{
			while ( $row = $result->fetch_object() ) {
				$aaData[] = $row;
			};
		}
		return $aaData;
	}

	public function getValue($table, $field, $as = false, $where = Array(), $logic_glue = "AND", $group_by = false)
	{
		$where_entries = Array();
		$as = ($as) ? $as : $field;
		// print_r($where);
		foreach ( $where as $colName=>$colValue )
		{
			// preg_match('/(>)(<)(=)(>=)(<=)(!=)/',$colValue,$operand)
			// if ( in_array($colValue[0],Array(">","<","=")) )
			if ( preg_match('/(!=)|(>=)|(<=)|(>)|(<)|(=)/',$colValue,$operand) )
			{
				// $operand = $operand[0];
				$colValue = ltrim($colValue,$operand[0]);
				$where_entries[] = sprintf("`%s` %s '%s'",$colName,$operand[0],$colValue);
			}
			else
			{
				$where_entries[] = sprintf("`%s` = '%s'",$colName,$colValue);
			}
		}
		$sqlWhere = (sizeof($where)) ? "(".implode(" ".$logic_glue,$where_entries).")" : "1";
		$groupBy = ($group_by) ? sprintf('GROUP BY `%s`',$group_by) : "";
		$sql = sprintf("SELECT %s as %s FROM `%s` WHERE %s %s",$field,$as,$table,$sqlWhere,$groupBy);
		// echo $sql."\n<br />";
		try {
			$res = $this->queryRow($sql);
			return (isset($res->$as)) ? $res->$as : false;
		}
		catch (Exception $e)
		{
			return false;
		}
	}
}
