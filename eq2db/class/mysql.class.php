<?php
/***************************************************************************
 *                                 mysql.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: mysql.php,v 1.2 2003/11/09 21:34:32 jonohlsson Exp $
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

class sql_db
{

	var $db_connect_id;
	var $query_result;
	var $row = array();
	var $rowset = array();
	var $num_queries = 0;

	//
	// Constructor
	//
	function __construct($sqlserver, $sqluser, $sqlpassword, $database, $persistency = true)
	{

		$this->persistency = $persistency;
		$this->user = $sqluser;
		$this->password = $sqlpassword;
		$this->server = $sqlserver;
		$this->dbname = $database;

		$this->db_connect_id = mysqli_connect($this->server, $this->user, $this->password);

		/*
		if($this->persistency)
		{
			$this->db_connect_id = @mysql_pconnect($this->server, $this->user, $this->password);
		}
		else
		{
			$this->db_connect_id = @mysql_connect($this->server, $this->user, $this->password);
		}
		*/
		if($this->db_connect_id)
		{
			if($database != "")
			{
				$this->dbname = $database;
				$dbselect = mysqli_select_db($this->db_connect_id, $this->dbname);
				if(!$dbselect)
				{
					@mysqli_close($this->db_connect_id);
					$this->db_connect_id = $dbselect;
				}
			}
			return $this->db_connect_id;
		}
		else
		{
			return false;
		}
	}

	//
	// Other base methods
	//
	function sql_dbselect($database)
	{
		if ($this->db_connect_id)
			return @mysqli_select_db($this->$database, $this->db_connect_id);
		else
			return false;
	}
	
	function sql_close()
	{
		if($this->db_connect_id)
		{
			if($this->query_result)
			{
				@mysqli_free_result($this->query_result);
			}
			$result = @mysqli_close($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}

	//
	// Base query method
	//
	function sql_query($query = "", $transaction = FALSE)
	{
		// Remove any pre-existing queries
		unset($this->query_result);
		if($query != "")
		{
			$this->num_queries++;

			$this->query_result = @mysqli_query($this->db_connect_id, $query);
		}
		if($this->query_result)
		{
			//unset($this->row[$this->query_result]);
			//unset($this->rowset[$this->query_result]);
			return $this->query_result;
		}
		else
		{
			return ( $transaction == 'END_TRANSACTION' ) ? true : false;
		}
	}

	//
	// Other query methods
	//
	function sql_numrows($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = @mysqli_num_rows($query_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_affectedrows()
	{
		if($this->db_connect_id)
		{
			$result = @mysqli_affected_rows($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_numfields($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = @mysqli_num_fields($query_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fieldname($offset, $query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = @mysqli_fetch_field_direct($query_id, $offset);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fieldtype($offset, $query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = @mysqli_fetch_field_direct($query_id, $offset);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fetchrow($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			//$this->row[$query_id] = @mysql_fetch_array($query_id);
			return mysqli_fetch_array($query_id, MYSQLI_ASSOC); //$this->row[$query_id];
		}
		else
		{
			return false;
		}
	}
	function sql_fetchrowset($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			unset($this->rowset[$query_id]);
			unset($this->row[$query_id]);
			while($this->rowset[$query_id] = @mysqli_fetch_array($query_id))
			{
				$result[] = $this->rowset[$query_id];
			}
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fetchfield($field, $rownum = -1, $query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			if($rownum > -1)
			{
				$result2 = sql_rowseek($rownum, $query_id);
				$datarow = mysqli_fetch_array($result2);
				$result = $datarow[$field];
				//$result = @mysql_result($query_id, $rownum, $field);
			}
			else
			{
				if(empty($this->row[$query_id]) && empty($this->rowset[$query_id]))
				{
					if($this->sql_fetchrow())
					{
						$result = $this->row[$query_id][$field];
					}
				}
				else
				{
					if($this->rowset[$query_id])
					{
						$result = $this->rowset[$query_id][$field];
					}
					else if($this->row[$query_id])
					{
						$result = $this->row[$query_id][$field];
					}
				}
			}
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_rowseek($rownum, $query_id = 0){
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = @mysqli_data_seek($query_id, $rownum);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_last_insert_id(){
		if($this->db_connect_id)
		{
			$result = @mysqli_insert_id($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_freeresult($query_id = 0){
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}

		if ( $query_id )
		{
			//unset($this->row[$query_id]);
			//unset($this->rowset[$query_id]);

			@mysqli_free_result($query_id);

			return true;
		}
		else
		{
			return false;
		}
	}
	function sql_error($query_id = 0)
	{
		$result["message"] = @mysqli_error($this->db_connect_id);
		$result["code"] = @mysqli_errno($this->db_connect_id);

		return $result;
	}

	/**
	* Escape string used in sql query
	*/
	function sql_escape($msg)
	{
		return @mysqli_real_escape_string($this->db_connect_id, $msg);
	}

	function __destruct()
	{
		$this->sql_close();
	}

	function sql_begin_transaction()
	{
		if($this->db_connect_id)
		{
			return @mysqli_begin_transaction($this->db_connect_id);
		}
		else
		{
			return false;
		}
	}

	function sql_commit()
	{
		if($this->db_connect_id)
		{
			return @mysqli_commit($this->db_connect_id);
		}
		else
		{
			return false;
		}
	}

	function sql_rollback()
	{
		if($this->db_connect_id)
		{
			return @mysqli_rollback($this->db_connect_id);
		}
		else
		{
			return false;
		}
	}
}
?>