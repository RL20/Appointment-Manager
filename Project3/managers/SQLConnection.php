<?php
class SQLConnection {
	
	private static $servername = "localhost";
	private static $username = "admin";
	private static $password = "12345678";
	private static $dbname = "appointmentappdbnew";
	public  $mysqli;
	/*
	private static $servername = "localhost";
	private static $username = "root";
	private static $password = "";
	private static $dbname = "appointmentappdb";
	public  $mysqli;
	*/
	
	private function __construct() {}
	

	
	public static function getConnection() 
	{
	      // Create connection
	     $mysqli = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
	      // Check connection
	
	if ($mysqli->connect_errno) {
		printToTerminal( "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
	}
	
	return $mysqli;
	}
}

