<?php
// Data Access Object commiunicating with DB
require_once  __DIR__.'/../requires.php';
//sinlgeton class
// bla bla bla
class BlockedAppointmentDBDAO 
{
	// 	private static BlockedAppointmentDBDAO;
	
	
	
	// 	private function __construct(){}
	
	// 	public static function getInstance()// SQL ????? ???????? ?????? ??
	// 	{
	// 		if(!isset(self::BlockedAppointmentDBDAO))
		// 		{
		// 			self::BlockedAppointmentDBDAO = new BlockedAppointmentDBDAO;
		// 		}
	// 		return self::BlockedAppointmentDBDAO;
	// 	}

	
	
	
	// strtotime ???? ?? ?????? ???????? ?????? ???? ????? ?????? ?"?
	
	static function getBlockedAppointment( $blockedappointmentId)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT ID, APP_DATE,APP_TIME,EMP_ID FROM blockedappointment WHERE ID = ?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		if (!$stmt->bind_param("i", $blockedappointmentId)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		$row = $result->fetch_object();
	
		try {
			if(!$row)
			{
				throw new Exception("row is null");
			}
			$blockedappointment = new blockedAppointment(strtotime($row->APP_DATE),strtotime($row->APP_TIME),$row->EMP_ID,$row->ID);
		}
		catch (Exception $e)
		{
// 			throw new Exception("djfkygvhudhgfvbjdfhvbjdfhbvjdfhb");
			throw new IdDoesNotExistsException();
		}
	    finally {
		   $mysqli->close();
	    }
	 
		return $blockedappointment;
	}
	//????? // ???????? ?????? ???? ?? ????????? -????? ?????? ????? ?????? 
	static function getAllBlockedAppointmentsOfEmployee( $EMP_ID) // ???????? ?????? ???? ?? ????????? - ?? ?????? ?????? ????? ??????
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT ID, APP_DATE,APP_TIME,EMP_ID FROM blockedappointment WHERE EMP_ID = ?"))) {
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
	
	
		$blockedappointments=[];
		while ($row = $result->fetch_object())
		{
			$blockedappointment = new blockedappointment($row->APP_DATE,$row->APP_TIME,$row->EMP_ID,$row->ID);
			$blockedappointments[]=$blockedappointment;
		}
		
		$mysqli->close();
	
		return $blockedappointments;
	}
	
	static function createBlockedAppointment(blockedappointment $blockedappointment)
	{
	    printToTerminal( "blockedappointment" . $blockedappointment->getEmployeeId());
		$mysqli = SQLConnection::getConnection();
	
						
		
		if (!($stmt = $mysqli->prepare("INSERT INTO blockedappointment (ID, APP_DATE, APP_TIME, EMP_ID ) VALUES (NULL, ?,?,?)"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
			
		}
	
// 		$Id=$blockedappointment->getId();      ?? ????? ??????? ID ????? ????? ??????
		$blockedappointmentDate=$blockedappointment->getBlockedappointmentDate();
		$blockedappointmentTime=$blockedappointment->getBlockedappointmentTime();
		$employeeId=$blockedappointment->getEmployeeId();
	
// 		$mysqltime = date ("Y-m-d H:i:s", $blockedappointmentTime);
		$mysqltime = date ("H:i:s", $blockedappointmentTime);
		$mysqldate = date ("Y-m-d", $blockedappointmentDate);
		
	
		
		if (!$stmt->bind_param("ssi", $mysqldate, $mysqltime,$employeeId )) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		else printToTerminal( " <br/>blockedappointment created successfuly!!");
		
		$mysqli->close();
		
		//FullyBookDBDAO::check_If_FullyBooked($employeeId,$blockedappointmentDate);
	
	}
	
	static function updateBlockedAppointment(blockedappointment $blockedappointment)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("UPDATE blockedappointment SET APP_DATE=?,APP_TIME=?,EMP_ID=? WHERE ID=?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
	
	
		$id=$blockedappointment->getId();
	    $blockedappointmentDate=$blockedappointment->getBlockedappointmentDate();
		$blockedappointmentTime=$blockedappointment->getBlockedappointmentTime();
		$employeeId=$blockedappointment->getEmployeeId();
		
	
	
// 		????? ????? ????? ????? datetime ?-mysql
// 		$mysqltime = date ("Y-m-d H:i:s", $phptime);
	
		$mysqltime = date ("H:i:s", $blockedappointmentTime);
		$mysqldate = date ("Y-m-d", $blockedappointmentDate);
		
		if (!$stmt->bind_param("ssii", $mysqldate,$mysqltime,$employeeId,$id)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		else printToTerminal( "blockedappointment updated successfuly!!");
		
		$mysqli->close();
	
	}
	
	static function deleteBlockedAppointment( $blockedappointmentId)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("DELETE FROM blockedappointment WHERE ID=?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
	
	
		if (!$stmt->bind_param("i", $blockedappointmentId)) {
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
			if($rowsNum === 0)// ???? ?? ?? ???? ??? ?? ?? ?? 0  ?? ???? ???? ???? 
			{
				//write Exception class for this exception
				throw new Exception("blockedappointment ID does not exist!");
			}
			else if($rowsNum > 1)
			{
// 				write to log 
			}
		}
		else
		{
			printToTerminal( " <br/> blockedappointment  deleted successfuly!!");
		}
		
	
		$mysqli->close();
	}

	
	static function checkIfAppointmentIsBlocked(blockedappointment $blockedappointment)//??????? ?????? ?? ???? ??? ???? ?? ?? ?? ????? ??? ????? ????? 
	{
		$blocked = false;
		$mysqli = SQLConnection::getConnection();
		
		if (!($stmt = $mysqli->prepare("SELECT ID FROM blockedappointment WHERE EMP_ID = ? AND APP_DATE=? AND APP_TIME=?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
		
		$employeeId = $blockedappointment->getEmployeeId();
		$appDate = $blockedappointment->getBlockedappointmentDate();
		$appHour = $blockedappointment->getBlockedappointmentTime();
		
		
		$mysqldate = date ("Y-m-d", $appDate);
		$mysqlTime = date ("H:i:s", $appHour);
		
		if (!$stmt->bind_param("iss", $employeeId,$mysqldate,$mysqlTime)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
// 		$idResult;
// 		while ($row = $result->fetch_object())
// 		{
// 			$idResult =  $row->ID;
			
// 		}
// 		$row = $result->fetch_object();
		
		
// 		$rowsNum = $mysqli->affected_rows;
// 		$blockedappointment = new blockedappointment($row->APP_DATE,$row->APP_TIME,$row->CUST_ID,$row->EMP_ID,$row->COMMENT_,$row->ID);
// 		 var_dump($result);
		if( $result->num_rows !== 0)
		{
// 		printToTerminal( '<script type="text/javascript">alert("Data has been submitted to ' . 'false'. '");</script>';
		$blocked = true;
		}
// 		if($rowsNum === 1)
// 		{
// 				//throw new Exception("Appointement Exist!");
// 				$avialable = false;
			
// 		}
		
		$mysqli->close();
		
		return $blocked;
	}
	
	
	
	static function getAllBlockedAppointments_byDate($date) // ???????? ?????? ???? ?? ????????? - ?? ?????? ?????? ???? ??????
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT * FROM blockedappointment WHERE APP_DATE=?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		$mysqldate = date ("Y-m-d", $date);
		
		if (!$stmt->bind_param("s", $mysqldate)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		$blockedappointments=[];
		while ($row = $result->fetch_object())
		{
			$blockedappointment = new blockedAppointment($row->APP_DATE,$row->APP_TIME,$row->EMP_ID,$row->ID);
			$blockedappointments[]=$blockedappointment;
		}
	
		$mysqli->close();
	
		return $blockedappointments;
	}
	static function getAllblockedappointments_byMonth($date) // ???????? ?????? ???? ?? ????????? - ?? ?????? ?????? ????? ??????
	{
	//http://php.net/manual/en/datetime.construct.php
		/*????? ????????
		 $d= new DateTime('6-2-2017');
         var_dump(BlockblockedappointmentDBDAO::getAllblockedappointments_byMonth($d));
         */

		$date1 = new DateTime();// ?? ???? ????? ????? ?? ????? ??????? ???? ???????? ?? ????? DateTime ???? ???? ????? ??? (????) ?????? ???? ???? ???????? ??  $date ????? ?? ??????
		
		$date1->setTimestamp($date);
		
		$month= $date1->format('m');// ??? 02
		$year= $date1->format('Y');// ??? 2017
		$numberOfDaysInMonth = cal_days_in_month ( CAL_GREGORIAN, $month, $year ); // ??? ???? ?? ????? ?????
		//***
// 		$blockedappointments1=[];//???? ?? ????? ?? ??? ??? ???? ????? ????? ???? ????? ????? -????? ??? ?????? ?????? ???? ????? ???? 
		$blockedappointments=[];//?? ???? ????? ?????? ??? ??? ???? ????? ????? ???? ?????
		for($i=1; $i <= $numberOfDaysInMonth; $i ++) // ?????? ?? ????? ????? $i
		{
			$strDate = $year.'-' . $month .'-'.$i ;

			$mysqli = SQLConnection::getConnection();
			
			if (!($stmt = $mysqli->prepare("SELECT * FROM blockedappointment WHERE APP_DATE=?"))) {
				printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
			}
			
			if (!$stmt->bind_param("s", $strDate)) {
				printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			
			if (!$stmt->execute()) {
				printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
				
			if (!($result = $stmt->get_result())) {
				printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			
			
// 			$blockedappointments=[];//???? ?? ????? ?? ??? ??? ???? ????? ????? ???? ????? ????? -????? ??? ?????? ?????? ???? ????? ????
			while ($row = $result->fetch_object())
			{
				$blockedappointment = new blockedAppointment($row->APP_DATE,$row->APP_TIME,$row->EMP_ID,$row->ID);
				$blockedappointments[]=$blockedappointment;
// 				$blockedappointments1[$i]=$blockedappointments;//???? ?? ????? ?? ??? ??? ???? ????? ????? ???? ????? ????? -????? ??? ?????? ?????? ???? ????? ????
			}
			
			$mysqli->close();
			
		}
			//****
	
		return $blockedappointments;
// 		return $blockedappointments1;//???? ?? ????? ?? ??? ??? ???? ????? ????? ???? ????? ????? -????? ??? ?????? ?????? ???? ????? ????
	}
	static function getAllblockedappointments_fromDateToDate($startDate,$endDate) // ???????? ?????? ???? ?? ????????? - ?? ?????? ?????? ??? ??????? ??????? 
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT * FROM blockedappointment WHERE  APP_DATE BETWEEN ? AND ? ORDER BY APP_DATE"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		$mysqlStartdate = date ("Y-m-d", $startDate);
		$mysqlEnddate = date ("Y-m-d", $endDate);
	
		
		if (!$stmt->bind_param("ss", $mysqlStartdate,$mysqlEnddate)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		$blockedappointments=[];
		while ($row = $result->fetch_object())
		{
			$blockedappointment = new blockedAppointment($row->APP_DATE,$row->APP_TIME,$row->EMP_ID,$row->ID);
			$blockedappointments[]=$blockedappointment;
		}
	
		$mysqli->close();
	
		return $blockedappointments;
	}
	static function getfutureblockedappointments_byStartingDate($startDate ,$startTime ,$limit = false) // ???????? ?????? ???? ?? ????????? - ?? ?????? ?????? ???? ??????
	{
		if(!$limit)
			$limit = "LIMIT 10";
		else if($limit)//?????? ?? ??????  ??? ????? ????? ?? ??? ??????? ?? ?? ????? ??? ????? ??????? ?10 ?????? ???? 
			$limit = "";
		
		$mysqli = SQLConnection::getConnection();
	    
		if (!($stmt = $mysqli->prepare("SELECT * FROM blockedappointment WHERE APP_DATE >= ? AND APP_TIME > ? ORDER BY APP_DATE ASC ". $limit))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		$mysqlStartdate = date ("Y-m-d", $startDate);
		$mysqlStartTime = date ("H:i:s", $startTime);
	
		
		if (!$stmt->bind_param("ss", $mysqlStartdate, $mysqlStartTime)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		$blockedappointments=[];
		while ($row = $result->fetch_object())
		{
			$blockedappointment = new blockedAppointment ($row->APP_DATE,$row->APP_TIME,$row->EMP_ID,$row->ID);
			$blockedappointments[]=$blockedappointment;
		}
	
		$mysqli->close();
	
		return $blockedappointments;
	}
	
	
	
	//******************************************************************************
	
	static function getAllEmployeeblockedappointments_fromDateToDate($startDate,$endDate,$employeeId) // ???????? ?????? ???? ?? ????????? - ?? ?????? ?????? ??? ??????? ???????
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT * FROM blockedappointment WHERE  EMP_ID=? AND APP_DATE BETWEEN ? AND ? ORDER BY APP_DATE"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		$mysqlStartdate = date ("Y-m-d", $startDate);
		$mysqlEnddate = date ("Y-m-d", $endDate);
	
	
		if (!$stmt->bind_param("iss",$employeeId,$mysqlStartdate,$mysqlEnddate)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		$blockedappointments=[];
		while ($row = $result->fetch_object())
		{
			$blockedappointment =new blockedAppointment ($row->APP_DATE,$row->APP_TIME,$row->EMP_ID,$row->ID);
			$blockedappointments[]=$blockedappointment;
		}
	
		$mysqli->close();
	
		return $blockedappointments;
	}
	static function getAllEmployeeblockedappointments_byDate($date,$employeeId) // ???????? ?????? ???? ?? ????????? - ?? ?????? ?????? ???? ??????
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT * FROM blockedappointment WHERE EMP_ID=? AND APP_DATE=?  "))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		$mysqldate = date ("Y-m-d", $date);
	
		if (!$stmt->bind_param("is",$employeeId, $mysqldate)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		$blockedappointments=[];
		while ($row = $result->fetch_object())
		{
			$blockedappointment = new blockedAppointment ($row->APP_DATE,$row->APP_TIME,$row->EMP_ID,$row->ID);
			$blockedappointments[]=$blockedappointment;
		}
	
		$mysqli->close();
	
		return $blockedappointments;
	}
	static function getAllEmployeeblockedappointments_byMonth($date,$employeeId) // ???????? ?????? ???? ?? ????????? - ?? ?????? ?????? ????? ?????? ??????
	{
		//http://php.net/manual/en/datetime.construct.php
		/*????? ????????
		 $d= new DateTime('6-2-2017');
		var_dump(BlockblockedappointmentDBDAO::getAllblockedappointments_byMonth($d));
		*/
// 	    $date = date('m/d/Y', $date);
	
		
		$date1 = new DateTime();// ?? ???? ????? ????? ?? ????? ??????? ???? ???????? ?? ????? DateTime ???? ???? ????? ??? (????) ?????? ???? ???? ???????? ??  $date ????? ?? ?????? 
		
		$date1->setTimestamp($date);
		
		
		$month= $date1->format('m');// ??? 02
		$year= $date1->format('Y');// ??? 2017

		$numberOfDaysInMonth = cal_days_in_month ( CAL_GREGORIAN, $month, $year ); //    year ?? month ? int ??? ???? ?? ????? ?????- ???????? ?????  
		//***
		// 		$blockedappointments1=[];//???? ?? ????? ?? ??? ??? ???? ????? ????? ???? ????? ????? -????? ??? ?????? ?????? ???? ????? ????
		$blockedappointments=[];//?? ???? ????? ?????? ??? ??? ???? ????? ????? ???? ?????
// 		printToTerminal( $month . " " . $year . " <br/>";
		for($i=1; $i <= $numberOfDaysInMonth; $i++) // ?????? ?? ????? ????? $i
		{
			$strDate = $year.'-' . $month .'-'.$i ;
	
// 			printToTerminal( $strDate . " <br/>";
			$mysqli = SQLConnection::getConnection();
				
			if (!($stmt = $mysqli->prepare("SELECT * FROM blockedappointment WHERE EMP_ID=? AND  APP_DATE=?"))) {
				printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
			}
				
			if (!$stmt->bind_param("is",$employeeId, $strDate)) {
				printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
				
			if (!$stmt->execute()) {
				printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			}
	
			if (!($result = $stmt->get_result())) {
				printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
			}
				
				
			// 			$blockedappointments=[];//???? ?? ????? ?? ??? ??? ???? ????? ????? ???? ????? ????? -????? ??? ?????? ?????? ???? ????? ????
			while ($row = $result->fetch_object())
			{
				$blockedappointment =new blockedAppointment ($row->APP_DATE,$row->APP_TIME,$row->EMP_ID,$row->ID);
				$blockedappointments[]=$blockedappointment;
				// 				$blockedappointments1[$i]=$blockedappointments;//???? ?? ????? ?? ??? ??? ???? ????? ????? ???? ????? ????? -????? ??? ?????? ?????? ???? ????? ????
			}
				
			$mysqli->close();
				
		}
		//****
	
		return $blockedappointments;
		// 		return $blockedappointments1;//???? ?? ????? ?? ??? ??? ???? ????? ????? ???? ????? ????? -????? ??? ?????? ?????? ???? ????? ????
	}
   }
 

