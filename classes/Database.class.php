<?php
class Database
{
	public static $mysqli;
	
	public static function getConnection()
	{
		$mysqli = new mysqli(HOST, DB_USER, DB_PASS);
		if(mysqli_connect_errno()) {
			throw new Exception('<div style="text-align:center; line-height:20px; padding:30px; border:#FF0000 1px solid;">'.TEMPORARILY_UNAVAILABLE.'</div>');
		} else if(!$mysqli->select_db(DATABASE)) {
			throw new Exception('Database is not Found !');
		} else {
			self::$mysqli = $mysqli;
		}
		
		/* change character set to utf8 */
		if (!mysqli_set_charset($mysqli, "utf8")) {
			printf("Error loading character set utf8: %s\n", mysqli_error($mysqli));
		} else {
			//printf("Current character set: %s\n", mysqli_character_set_name($mysqli));
		}
}
	
	public static function query($sql, $returnType, $fileName, $lineNumber, $dieOnError = 1)
	{
		/*
		 * PLEASE MAKE SURE THE returnType=2 WHILE QUERY-TYPE IN NOT SELECT
		*/
		
		$result = self::$mysqli->query($sql);
		if($result==false)
		{
			echo Common::errorHandler('Query is not executed', 'Error in '.$sql.PHP_EOL.self::$mysqli->error, $fileName, $lineNumber);			
			
			if($dieOnError==1)
			{
				exit(0);
			}
		}
		else
		{
			//create recordset
			if((int)$returnType===1)
			{
				$show = $result->fetch_array(MYSQL_BOTH);
				return $show;
			}
			else if((int)$returnType===2)
			{
				return $result;
			}
			else
			{
				throw new Exception(Common::errorHandler('Unknow return type', $fileName, $lineNumber, $errorOutputType));
			}
		}
	}

	public static function lastID()
	{
		return self::$mysqli->insert_id;
	}
	
	public static function stopAutoCommit()
	{
		self::$mysqli->autocommit(FALSE);
	}
	
	public static function commitDb()
	{
		self::$mysqli->commit();
	}
	
	public static function rollback()
	{
		self::$mysqli->rollback();
	}
	
	public static function close()
	{
		self::$mysqli->close();
	}
	
	public static function affectedRows()
	{
		return self::$mysqli->affected_rows;
	}
}
?>