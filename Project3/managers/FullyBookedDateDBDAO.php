<?php
// Data Access Object commiunicating with DB
require_once  __DIR__.'/../requires.php';

//sinlgeton class

class FullyBookedDateDBDAO 
{
	
	
	
	
	
	static function getFullyBookedDate($FullyBookedDateId)// FullyBooked  �� ����� ����� ID �������� ������ ������� �� ����� ���  ��� ���� �
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT ID, DATE_,EMP_ID FROM fully_booked_date WHERE ID = ?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		if (!$stmt->bind_param("i", $FullyBookedDateId)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		$row = $result->fetch_object();
	
	
		$fullyBookedDate = new FullyBookedDate($row->DATE_,$row->EMP_ID,$row->ID);
		
		$mysqli->close();
	
		return $fullyBookedDate;
	}
//************************************************************************************************************************************************
	static function getFullyBookedDateRowID($date,$employeeId)// FullyBooked �� ����� ����� ID �������� ������ 
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT ID, DATE_,EMP_ID FROM fully_booked_date WHERE EMP_ID = ? AND DATE_=?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		$mysqldate = date ("Y-m-d", $date);
		
		if (!$stmt->bind_param("is", $employeeId,$mysqldate)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		$row = $result->fetch_object();
	
	
		$fullyBookedDate = new FullyBookedDate($row->DATE_,$row->EMP_ID,$row->ID);
	
		$mysqli->close();
	
		return $fullyBookedDate->getId();
	}
	//************************************************************************************************************************************************
	
	//����� // �������� ������ ���� �� ��������� -����� ������ ����� ������ 
	static function getFullyBookedDatesOfEmployee($EMP_ID) // �������� ������ ���� �� ��������� - �� �������� ������  ��� ����� ������
	{
		//����� ��� ������� �� ���� ��� ���� ���� ���� 
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT ID, DATE_,EMP_ID FROM fully_booked_date WHERE EMP_ID = ?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		if (!$stmt->bind_param("i", $EMP_ID)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		$FullyBookedDates=[];//���� �� �������
		while ($row = $result->fetch_object())
		{
			$fullyBookedDate = new FullyBookedDate($row->DATE_,$row->EMP_ID,$row->ID);
			$FullyBookedDates[]=$fullyBookedDate;
		}
		
		$mysqli->close();
	
		return $FullyBookedDates;
	}
	
//************************************************************************************************************************************************	
	static function createFullyBookedDate(FullyBookedDate $fullyBookedDate)
	{
		$mysqli = SQLConnection::getConnection();
	
		
		if (!($stmt = $mysqli->prepare("INSERT INTO fully_booked_date (ID, DATE_,EMP_ID) VALUES (NULL, ?,?)"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
// 		$Id=$appointment->getId();      �� ����� ������� ID ����� ����� ������
		$FBdate=$fullyBookedDate->getDate();
		$employeeId= $fullyBookedDate->getEmployeeId();
		
		$mysqldate = date ("Y-m-d", $FBdate);
		
	
		
		if (!$stmt->bind_param("si", $mysqldate,$employeeId)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		else
		{
			printToTerminal( " <br/>fully booked date created successfuly!!");
		}
	
	
		
		$mysqli->close();
		
	
	}
	
//************************************************************************************************************************************************	
	/*
	 * static function updateFullyBookedDate(FullyBookedDate $fullyBookedDate) // FullyBooked ���� ��� ���� �������� ������� �� 
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("UPDATE fully_booked_date SET DATE_=?,EMP_ID=? WHERE ID=?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
	
	
		$id=$fullyBookedDate->getId();
	    $fullyBookedDate=$fullyBookedDate->getDate();
		$employeeId=$appointment->getEmployeeId();
	
	
		$mysqldate = date ("Y-m-d", $appointmentDate);
		
		if (!$stmt->bind_param("sii", $mysqldate,$employeeId,$id)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		else
		{
			printToTerminal( " <br/>fully booked date updated successfuly!!";
		}
	
	
		
		$mysqli->close();
	
	}
	  
	 */
	
//************************************************************************************************************************************************
	static function deleteFullyBookedDate( $fullyBookedDateId)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("DELETE FROM fully_booked_date WHERE ID=?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
	
	
		if (!$stmt->bind_param("i", $fullyBookedDateId)) {
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
		else
		{
			printToTerminal( " <br/>fully booked date deleted successfuly!!");
		}
	
		$mysqli->close();
	}

	//*******************************************************
	//  FB id  �� ���� ������  false ����� �� �����(���) ������ ���� ��� ���� ��  ���� ������  
	static function checkIfEmplooyeeDayIsFullyBooked(FullyBookedDate $fullyBookedDate)//������� ������ �� ������ �� ���� ������ ������ ����  
	{
		$fullyBooked = false;
		$mysqli = SQLConnection::getConnection();
		
		if (!($stmt = $mysqli->prepare("SELECT ID FROM fully_booked_date WHERE EMP_ID = ? AND DATE_=?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
		
		$employeeId = $fullyBookedDate->getEmployeeId();
		$date = $fullyBookedDate->getDate();
		
		
		$mysqldate = date ("Y-m-d", $date);
		
		if (!$stmt->bind_param("is", $employeeId,$mysqldate)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		

		if($result->num_rows !== 0){
// 		printToTerminal( '<script type="text/javascript">alert("Data has been submitted to ' . 'false'. '");</script>';
			$row = $result->fetch_object();
			$fullyBooked = $row->ID;
		}
// 		if($rowsNum === 1)
// 		{
// 				//throw new Exception("Appointement Exist!");
// 				$avialable = false;
			
// 		}
		
		$mysqli->close();
		
		return $fullyBooked;
	}
	
	
	
	
	static function checkIfDayIsFullyBooked($date)//������� ������ �� ������ ������ ����
	{
	
		$allEmployeesList = EmployeeDBDAO::getAllEmployees_Manager();
		
		for($i = 0; $i < count($allEmployeesList); $i++)
		{
			$employeeId = $allEmployeesList[$i] ->getId();
			$fullyBookedDate = new FullyBookedDate($date, $employeeId);//  long ���� � date ��������
	        if(!self::checkIfEmplooyeeDayIsFullyBooked($fullyBookedDate))
	        {
	        	return false;
	        }
		}
		
		return true;
	}
	

//*******************************************************************************************

	static function checkAndWrite_FullyBooked($date,$employeeId)//������� ������ �� �� ������ ������ ������ ������ ���� ,�� �� ����� �� ������ ����� ������� ����
	{
		$dateIsFull=true;
		$currentDateIsChecked=date ( 'j m y', $date ) == date ( 'j m y', time () );
		$day=strtoupper(date('l',$date));// ���� �� ������ ���� ����� ��� ���� �� ����� ���
		$wh= WorkHoursDBDAO::getEmployeeWorkHoursByDay($employeeId, $day);
	
		$possibleAppointmentsList  = commonActions::getPossibleAppointmentsList_ByDay ($wh); // ����� ��� ����� �� �� ������ �������� �� ���� ������� ����� ����
	
		//*****
// 		var_dump($possibleAppointmentsList);
		for($j = 0; $j < count ( $possibleAppointmentsList )&&$dateIsFull; $j++) // �� ��� ���� ��� ���� ���� �� ������ ��� ���� �� �� �������� ����
		{
			if ($j==0)printToTerminal( count ( $possibleAppointmentsList)." 1.<br/>");
			$possibleHourFromAppointmentList = $possibleAppointmentsList[$j];
			if ($currentDateIsChecked)
			{
				printToTerminal( "currentDateIsChecked : true<br/>");
				$hourFromList = date ( 'Hi', strtotime ($possibleHourFromAppointmentList));
				$timeNow = date ( 'Hi', time() );
					
				if (!(intval ( $hourFromList ) < intval ( $timeNow )))//�� ���� ������� �� ���� ����� ������� -�� ����� ��� ���� ������ ���� �� ������ ����� 
				{
					$currentDateIsChecked=false;
					$j--;
				}
				
			}
			else
			{
				
				printToTerminal( "currentDateIsChecked : false <br/> ");
				//*****//
// 				$possibleHourFromAppointmentList = $possibleAppointmentsList[$j];
				print ("J=No" . $j . "</br>") ;
	
	
				$appointment = new Appointment($date , strtotime($possibleHourFromAppointmentList), "", $employeeId, "");
	
				if (AppointmentDBDAO::checkAppointmentAvailability ( $appointment ))
				{	
//					var_dump($appointment);
				    $dateIsFull=false;
				}
			}
	
		}
		//********
		if($dateIsFull)
		{
			$fb=new FullyBookedDate($date, $employeeId);
			self::createFullyBookedDate($fb);
		}
		else printToTerminal( "This Date is not fully booked");
	}
	//************************************************************************************************************************************************
	static function deleteFullyBookedDate_byObject(FullyBookedDate $fullyBookedDate)//  fullybooked ������ �� ������� fullybooked �����  
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("DELETE FROM fully_booked_date WHERE EMP_ID = ? AND DATE_=?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
		
		$employeeId = $fullyBookedDate->getEmployeeId();
		$date = $fullyBookedDate->getDate();
		
		
		$mysqldate = date ("Y-m-d", $date);
		
		if (!$stmt->bind_param("is", $employeeId,$mysqldate)) {
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
				throw new Exception("FullyBookedDate EMP_ID or  DATE_ does not exist!");
			}
			else if($rowsNum > 1)
			{
				// 				write to log
			}
		}
		else
		{
			printToTerminal( " <br/>fully booked date deleted successfuly!!");
		}
	
		$mysqli->close();
	}
	
	//*******************************************************************************************
	
}
