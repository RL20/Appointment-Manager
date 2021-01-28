<?php
require_once  __DIR__.'/../requires.php';
class OpeningHoursDBDAO {
// 	private static OpeningHoursDBDAO;
	
	
// 	private function __construct(){}
	
// 	public static function getInstance()
// 	{
// 		if(!isset(self::OpeningHoursDBDAO))
// 		{
// 			self::OpeningHoursDBDAO = new OpeningHoursDBDAO;
// 		}
// 		return self::OpeningHoursDBDAO;
// 	}
	

	static function getOpeningHours($day)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT DAY_,FROM_HOUR1,TO_HOUR1,FROM_HOUR2,TO_HOUR2 FROM opening_hours WHERE DAY_ = ?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		if (!$stmt->bind_param("s", $day)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		 
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		$row = $result->fetch_object();
	
	
		$openingHours =new OpeningHours( $row->DAY_,$row->FROM_HOUR1,$row->TO_HOUR1,$row->FROM_HOUR2,$row->TO_HOUR2);
	
		
		$mysqli->close();
		
		return $openingHours;
	}
	
//************************************************************************************************************************************************
	
static function getAllDaysOpeningHours()//����� // �������� ������ ���� �� ��������� -�� ����� ����� ������
{
	$mysqli = SQLConnection::getConnection();

	if (!($result = $mysqli->query("SELECT * FROM opening_hours "))) {
		printToTerminal( "Getting result set failed: (" . $mysqli->errno . ") " . $mysqli->error);
		//printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		
	}

	$allDaysOpeningHours=[];
	while ($row = $result->fetch_object())
	{
		$OpeningHours =new OpeningHours($row->DAY_,$row->FROM_HOUR1,$row->TO_HOUR1,$row->FROM_HOUR2,$row->TO_HOUR2);
		$allDaysOpeningHours[]=$OpeningHours;
	}

	$mysqli->close();

	return $allDaysOpeningHours;
}
	
	
//************************************************************************************************************************************************
	static function createOpeningHours(OpeningHours $openingHours)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("INSERT INTO opening_hours (DAY_,FROM_HOUR1,TO_HOUR1,FROM_HOUR2,TO_HOUR2) VALUES (?,?,?,?,?)"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		 $day=$openingHours->getDay();
		 $fromHour1=$openingHours->getFromHour1();
		 $toHour1=$openingHours->getToHour1();
		 $fromHour2=$openingHours->getFromHour2();
		 $toHour2=$openingHours->getToHour2();
		
		/*
		$day=$workHours->getDay();
		$fromHour1=date ("Y-m-d H:i:s",$workHours->getFromHour1());
		$toHour1=date ("Y-m-d H:i:s",$workHours->getToHour1());
		$fromHour2=date ("Y-m-d H:i:s",$workHours->getFromHour2());
		$toHour2=date ("Y-m-d H:i:s",$workHours->getToHour2());*/
		
	
		//�� ����� ������� ��������
		if (!$stmt->bind_param("sssss",$day, $fromHour1, $toHour1, $fromHour2,$toHour2)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		else
		{
			printToTerminal( "OpeningHourse created successfuly!!<br/>");
		}
	
		$mysqli->close();
	
	}
	
//************************************************************************************************************************************************
	static function updateOpeningHours(OpeningHours $openingHours)
	{
		$mysqli = SQLConnection::getConnection();
	
		
		if (!($stmt = $mysqli->prepare("UPDATE opening_hours SET  FROM_HOUR1=?,TO_HOUR1=?,FROM_HOUR2=?,TO_HOUR2=? WHERE DAY_=?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		$day=$openingHours->getDay();
		$fromHour1=$openingHours->getFromHour1();
		$toHour1=$openingHours->getToHour1();
		$fromHour2=$openingHours->getFromHour2();
		$toHour2=$openingHours->getToHour2();
		if (!$stmt->bind_param("sssss",$fromHour1, $toHour1, $fromHour2,$toHour2,$day)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		else
		{
			printToTerminal( "OpeningHours updated successfuly!!<br/>");
		}
	
		
		$mysqli->close();
	
	}
//************************************************************************************************************************************************	
	static function deleteOpeningHours( $day)// ����� ���� ���� �������� ���� ������ ������� ����� 7 ������ ����� ������ �������� �� ����� ��� �����
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("DELETE FROM opening_hours WHERE DAY_=?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
	
		
		if (!$stmt->bind_param("s", $day)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
	
		$rowsNum = $mysqli->affected_rows;
		
		//checks if rawsAffected is not equals to 1, if so this means that 0 rows affected or more than 1
		//if true handle result with suitable exception
		if($rowsNum !== 1)
		{
			if($rowsNum === 0)// ���� �� �� ���� ��� �� �� �� 0  �� ���� ���� ����
			{
				//write Exception class for this exception
				throw new Exception("ID does not exist!");
			}
			else if($rowsNum > 1)
			{
				// 				write to log
			}
		}
		else {printToTerminal( "OpeningHours Deleted successfuly!!<br/>");}
		
		$mysqli->close();
	
	}
	// ��� ���� �������� ���� ����� ��������� ������� ���� �� ���� ���� 
// 	static function getOpeningHoursByDay($day)// ������ �� �� �����  �� �� ��� ����� 
// 	{
// 		$mysqli = SQLConnection::getConnection();
	
// 		if (!($stmt = $mysqli->prepare("SELECT DAY_,FROM_HOUR1,TO_HOUR1,FROM_HOUR2,TO_HOUR2 FROM opening_hours WHERE  DAY_ = ?"))) {
// 			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
// 		}
	
// 		if (!$stmt->bind_param("s",$day)) {
// 			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
// 		}
	
// 		if (!$stmt->execute()) {
// 			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
// 		}
			
// 		if (!($result = $stmt->get_result())) {
// 			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
// 		}
	
	
// 		$row = $result->fetch_object();
	
	
// 		$openingHours =new OpeningHours( $row->DAY_,$row->FROM_HOUR1,$row->TO_HOUR1,$row->FROM_HOUR2,$row->TO_HOUR2,$row->ID);
	
	
// 		$mysqli->close();
	
// 		return $openingHours;
// 	}
	
	
}

