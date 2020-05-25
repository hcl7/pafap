<?php

class pafap_mysql
{
	var $strLastError;				
	var $strLastQuery;				
	var $aResult;					
	var $iRecords;					
	var $iAffected;
    var $iAssoc;
	var $aResults;
	var $aArrayedResult;
	var $aArrayedResults;

	var $sHostname = MYSQL_HOST;	
	var $sUsername = MYSQL_USER;	
	var $sPassword = MYSQL_PASS;	
	var $sDatabase = MYSQL_NAME;	

	var $dbConnLink;
	//constructor;
	function pafap_mysql(){
	  $this->Connect();
	}
	// Connects class to database
	function Connect($persist = false)
    {
      if($this->dbConnLink)
      {
        mysql_close($this->dbConnLink);
	  }
	  if($persist)
      {
        $this->dbConnLink = mysql_pconnect($this->sHostname, $this->sUsername, $this->sPassword);
	  }
      else
      {
        $this->dbConnLink = mysql_connect($this->sHostname, $this->sUsername, $this->sPassword);
	  }
	  if (!$this->dbConnLink)
      {
        $this->strLastError = 'Could not connect to server: ' . mysql_error($this->dbConnLink);
		return false;
	  }
	  if(!$this->UseDB())
      {
        $this->strLastError = 'Could not connect to database: ' . mysql_error($this->dbConnLink);
		return false;
	  }
	  return true;
	}
	// Select database to use
	function UseDB()
    {
      if (!mysql_select_db($this->sDatabase, $this->dbConnLink))
      {
	  	$this->strLastError ='Cannot select database: ' . mysql_error($this->dbConnLink);
	  	return false;
	  }
      else
      {
	  	return true;
	  }
	}
	// Executes MySQL query (select);
	function ExecuteSQL($strSQLQuery)
	{
	  $this->strLastQuery = $strSQLQuery;
	  if($this->aResult = mysql_query($strSQLQuery))
	  {
	    $this->iRecords = @mysql_num_rows($this->aResult);
		$this->iAffected = @mysql_affected_rows($this->dbConnLink);
        $this->iAssoc = @array_values(mysql_fetch_assoc($this->aResult));
        $this->aResults = @mysql_fetch_array($this->aResult, MYSQL_BOTH);
		return true;
	  }
	  else
	  {
	    $this->strLastError = mysql_error($this->dbConnLink);
		return false;
	  }
	}

	// 'Arrays' multiple result;
	function ArrayResults($sql, $field=''){
	  $this->aArrayedResults = array();
	  if ($field == NULL){
        $result = mysql_query($sql);
	    while ($aData = mysql_fetch_array($result)){
	  	  $this->aArrayedResults[] = $aData;
	    }
      }
      else
      {
        $result = mysql_query($sql);
	    while ($aData = mysql_fetch_assoc($result)){
	  	  $this->aArrayedResults[] = $aData[$field];
	    }
      }
      return $this->aArrayedResults;
	}

	// Performs a 'mysql_real_escape_string' on the entire array/string
	function SecureData($aData)
	{
	  $aData = mysql_real_escape_string($aData, $this->dbConnLink);
	  return $aData;
	}

    function dbCloseConn()
    {
      mysql_close($this->dbConnLink);
    }

}

?>
