<?php
// Data Access Object commiunicating with DB
require_once  __DIR__.'/../requires.php';


//sinlgeton class

class AppointmentDBDAO 
{
	// 	private static $AppointmentDBDAO;
	

	
	// 	private function __construct(){}
	
	// 	public static function getInstance()// SQL ����� �������� ������ ��
	// 	{
	// 		if(!isset(self::$AppointmentDBDAO))
		// 		{
		// 			self::$AppointmentDBDAO = new AppointmentDBDAO;
		// 		}
	// 		return self::$AppointmentDBDAO;
	// 	}

//todo  check with Aviya how the manager will know which kind of appointment list he got , for exaple , if is haircut or some other services ? according to appointment list he get
	
	
	static function getAppointment($appointmentId)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT ID, APP_DATE,APP_TIME,APP_DURATION,CUST_ID,EMP_ID,COMMENT_ FROM appointment WHERE ID = ?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		if (!$stmt->bind_param("i", $appointmentId)) {
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
			if(!$row) throw new IdDoesNotExistsException(false, 23);

			$appointment = new Appointment($row->APP_DATE,$row->APP_TIME,$row->APP_DURATION,$row->CUST_ID,$row->EMP_ID,$row->COMMENT_,$row->ID);
		}
		catch (Exception $e)
		{
// 			throw new Exception("djfkygvhudhgfvbjdfhvbjdfhbvjdfhb");
			throw new IdDoesNotExistsException(false,$e->getCode());
		}
	    finally {
		   $mysqli->close();
	    }
	 
		return $appointment;
	}
	//����� // �������� ������ ���� �� ��������� -����� ������ ����� ������ 
	static function getAllAppointmentsOfEmployee( $EMP_ID) // �������� ������ ���� �� ��������� - �� ������ ������ ����� ������
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT ID, APP_DATE,APP_TIME,APP_DURATION,CUST_ID,EMP_ID,COMMENT_ FROM appointment WHERE EMP_ID = ?"))) {
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
	
	
		$appointments=[];
		while ($row = $result->fetch_object())
		{
			$appointment = new Appointment($row->APP_DATE,$row->APP_TIME,$row->CUST_ID,$row->EMP_ID,$row->COMMENT_,$row->ID);
			$appointments[]=$appointment;
		}
		
		$mysqli->close();
	
		return $appointments;
	}
	
	static function createAppointment(Appointment $appointment)
	{
		$mysqli = SQLConnection::getConnection();
	
// 		if (!($stmt = $mysqli->prepare("INSERT INTO 'appointment' ( 'APP_DATE', 'APP_TIME', 'CUST_ID', 'EMP_ID', 'COMMENT_') VALUES (?,?,?,?,?)"))) {
			
// 		if (!($stmt = $mysqli->prepare("INSERT INTO `appointment` (`ID`, `APP_DATE`, `APP_TIME`, `CUST_ID`, `EMP_ID`, `COMMENT_`) VALUES (NULL, ?, ?, ?, ?, ?)"))) {
			
		
		if (!($stmt = $mysqli->prepare("INSERT INTO appointment (ID, APP_DATE, APP_TIME,APP_DURATION, CUST_ID, EMP_ID, COMMENT_) VALUES (NULL, ?,?,?,?,?,?) WHERE NOT EXISTS() "))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
			
		}
	
// 		$Id=$appointment->getId();      �� ����� ������� ID ����� ����� ������
		$appointmentDate=$appointment->getAppointmentDate();
		$appointmentTime=$appointment->getAppointmentTime();
        $durationTime=$appointment->getDurationTime();
		$customerId=$appointment->getCustomerId();
		$employeeId=$appointment->getEmployeeId();
		$comment=$appointment->getComment();
	
// 		$mysqltime = date ("Y-m-d H:i:s", $appointmentTime);
		$mysqltime = date ("H:i:s", $appointmentTime);
		$mysqldate = date ("Y-m-d", $appointmentDate);
		
	
		
		if (!$stmt->bind_param("ssiiis", $mysqldate, $mysqltime,$durationTime, $customerId, $employeeId, $comment)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		else printToTerminal( " <br/>appointment created successfuly!!");
		
		$mysqli->close();
		
		//FullyBookDBDAO::check_If_FullyBooked($employeeId,$appointmentDate);
	
	}
	
	static function updateAppointment(Appointment $appointment)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("UPDATE appointment SET APP_DATE=?,APP_TIME=?,APP_DURATION=?,CUST_ID=?,EMP_ID=?,COMMENT_=? WHERE ID=?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
	
	
		$id=$appointment->getId();
	    $appointmentDate=$appointment->getAppointmentDate();
		$appointmentTime=$appointment->getAppointmentTime();
        $durationTime=$appointment->getDurationTime();
		$customerId=$appointment->getCustomerId();
		$employeeId=$appointment->getEmployeeId();
		$comment=$appointment->getComment();
		
	
	
// 		����� ����� ����� ����� datetime �-mysql
// 		$mysqltime = date ("Y-m-d H:i:s", $phptime);
	
		$mysqltime = date ("H:i:s", $appointmentTime);
		$mysqldate = date ("Y-m-d", $appointmentDate);
		
		if (!$stmt->bind_param("ssiiisi", $mysqldate,$mysqltime,$durationTime, $customerId,  $employeeId,$comment,$id)) {
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
                throw new Exception("appointment ID does not exist!");
            }
            else if($rowsNum > 1)
            {
// 				write to log
            }
        }
        else
        {
            printToTerminal( " <br/> appointment updated successfuly!!");
        }


		$mysqli->close();
	
	}
	//////////////////////////////////////////////
	static function deleteAppointment( $appointmentId)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("DELETE FROM appointment WHERE ID=?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
	
	
		if (!$stmt->bind_param("i", $appointmentId)) {
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
				throw new Exception("appointment ID does not exist!");
			}
			else if($rowsNum > 1)
			{
// 				write to log 
			}
		}
		else
		{
			printToTerminal( " <br/> appointment  deleted successfuly!!");
		}
		
	
		$mysqli->close();
	}

	
	static function checkAppointmentAvailability(Appointment $appointment)//������� ������ �� ���� ��� ���� �� �� �� ����� ��� ����� ����� 
	{ //todo : check if needed $durationTime?
		$available = true;
		$mysqli = SQLConnection::getConnection();
		
		if (!($stmt = $mysqli->prepare("SELECT ID FROM appointment WHERE EMP_ID = ? AND APP_DATE=? AND APP_TIME=?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
		
		$employeeId = $appointment->getEmployeeId();
		$appDate = $appointment->getAppointmentDate();
		$appHour = $appointment->getAppointmentTime();
		
		
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
// 		$appointment = new Appointment($row->APP_DATE,$row->APP_TIME,$row->CUST_ID,$row->EMP_ID,$row->COMMENT_,$row->ID);
// 		 var_dump($result);
		if( $result->num_rows !== 0){
// 		printToTerminal( '<script type="text/javascript">alert("Data has been submitted to ' . 'false'. '");</script>';
		$available = false;
		}
// 		if($rowsNum === 1)
// 		{
// 				//throw new Exception("Appointement Exist!");
// 				$available = false;
			
// 		}
		
		$mysqli->close();
		
		//*******************************************************************************
		//************����� �� ���� ���� �"� ����� ��� ���� ���� �����***********************************************
		$blockedAppointment= new BlockedAppointment($appDate, $appHour,$employeeId);
	
		if(BlockedAppointmentDBDAO::checkIfAppointmentIsBlocked($blockedAppointment)||EmployeeAbsenceDBDAO::checkIfEmployeeIsAbsent($employeeId, $appDate, $appHour, $appHour + 900))
			$available = false;
		
		//*******************************************************************************
		
		
		return $available;
	}
	
	
	static function getAllAppointmentsOfCustomer( $CUST_ID) // �������� ������ ���� �� ��������� - �� ������ ������ ������ ������
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT ID, APP_DATE,APP_TIME,APP_DURATION,CUST_ID,EMP_ID,COMMENT_ FROM appointment WHERE CUST_ID = ?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		if (!$stmt->bind_param("i", $CUST_ID)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		$appointments=[];
		while ($row = $result->fetch_object())
		{
			$appointment = new Appointment($row->APP_DATE,$row->APP_TIME,$row->APP_DURATION,$row->CUST_ID,$row->EMP_ID,$row->COMMENT_,$row->ID);
			$appointments[]=$appointment;
		}
	
		$mysqli->close();
	
		return $appointments;
	}
    static function getAllCustomerAppointments_fromDateToDate($startDate,$endDate,$CUST_ID) // הפונקציה מחזירה מערך של אובייקטים - כל התורים שנקבעו ללקוח בין תאריכים שהתקבלו
    {
        //todo check if neede some changes becuse of the DURATION
        $mysqli = SQLConnection::getConnection();

        if (!($stmt = $mysqli->prepare("SELECT * FROM appointment WHERE  CUST_ID =? AND APP_DATE BETWEEN ? AND ? ORDER BY APP_DATE , APP_TIME ASC"))) {
            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
        }

        $mysqlStartdate = date ("Y-m-d", $startDate);
        $mysqlEnddate = date ("Y-m-d", $endDate);


        if (!$stmt->bind_param("iss",$CUST_ID,$mysqlStartdate,$mysqlEnddate)) {
            printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        if (!$stmt->execute()) {
            printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        if (!($result = $stmt->get_result())) {
            printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
        }


        $appointments=[];
        while ($row = $result->fetch_object())
        {
            $appointment = new Appointment($row->APP_DATE,$row->APP_TIME,$row->APP_DURATION,$row->CUST_ID,$row->EMP_ID,$row->COMMENT_,$row->ID);
            $appointments[]=$appointment;
        }

        $mysqli->close();

        return $appointments;
    }
    //////////////

	static function getAllAppointments_byDate($date) // �������� ������ ���� �� ��������� - �� ������ ������ ���� ������
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT * FROM appointment WHERE APP_DATE=? ORDER BY APP_DATE, APP_TIME ASC"))) {
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
	
	
		$appointments=[];
		while ($row = $result->fetch_object())
		{
			$appointment = new Appointment($row->APP_DATE,$row->APP_TIME,$row->APP_DURATION,$row->CUST_ID,$row->EMP_ID,$row->COMMENT_,$row->ID);
			$appointments[]=$appointment;
		}
	
		$mysqli->close();
	
		return $appointments;
	}
	static function getAllAppointments_byMonth($date) // �������� ������ ���� �� ��������� - �� ������ ������ ����� ������
	{
	//http://php.net/manual/en/datetime.construct.php
		/*����� ��������
		 $d= new DateTime('6-2-2017');
         var_dump(AppointmentDBDAO::getAllAppointments_byMonth($d));
         */

		$date1 = new DateTime();// �� ���� ����� ����� �� ����� ������� ���� �������� �� ����� DateTime ���� ���� ����� ��� (����) ������ ���� ���� �������� ��  $date ����� �� ������
		
		$date1->setTimestamp($date);
		
		$month= $date1->format('m');// ��� 02
		$year= $date1->format('Y');// ��� 2017
		$numberOfDaysInMonth = cal_days_in_month ( CAL_GREGORIAN, $month, $year ); // ��� ���� �� ����� �����
		//***
// 		$appointments1=[];//���� �� ����� �� ��� ��� ���� ����� ����� ���� ����� ����� -����� ��� ������ ������ ���� ����� ���� 
		$appointments=[];//�� ���� ����� ������ ��� ��� ���� ����� ����� ���� �����
		for($i=1; $i <= $numberOfDaysInMonth; $i ++) // ������ �� ����� ����� $i
		{
			$strDate = $year.'-' . $month .'-'.$i ;

			$mysqli = SQLConnection::getConnection();
			
			if (!($stmt = $mysqli->prepare("SELECT * FROM appointment WHERE APP_DATE=? ORDER BY APP_DATE, APP_TIME ASC"))) {
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
			
			
// 			$appointments=[];//���� �� ����� �� ��� ��� ���� ����� ����� ���� ����� ����� -����� ��� ������ ������ ���� ����� ����
			while ($row = $result->fetch_object())
			{
				$appointment = new Appointment($row->APP_DATE,$row->APP_TIME,$row->APP_DURATION,$row->CUST_ID,$row->EMP_ID,$row->COMMENT_,$row->ID);
				$appointments[]=$appointment;
// 				$appointments1[$i]=$appointments;//���� �� ����� �� ��� ��� ���� ����� ����� ���� ����� ����� -����� ��� ������ ������ ���� ����� ����
			}
			
			$mysqli->close();
			
		}
			//****
	
		return $appointments;
// 		return $appointments1;//���� �� ����� �� ��� ��� ���� ����� ����� ���� ����� ����� -����� ��� ������ ������ ���� ����� ����
	}
	static function getAllAppointments_fromDateToDate($startDate,$endDate) // �������� ������ ���� �� ��������� - �� ������ ������ ��� ������� ������� 
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT * FROM appointment WHERE  APP_DATE BETWEEN ? AND ? ORDER BY APP_DATE,APP_TIME ASC "))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		$mysqlStartdate = date ("Y-m-d", $startDate);
		$mysqlEnddate = date ("Y-m-d", $endDate);
        printToTerminal( "mysqlStartdate: " . $mysqlStartdate);
        printToTerminal( "mysqlEnddate: " . $mysqlEnddate);

		if (!$stmt->bind_param("ss", $mysqlStartdate,$mysqlEnddate)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		$appointments=[];
		while ($row = $result->fetch_object())
		{
			$appointment = new Appointment($row->APP_DATE,$row->APP_TIME,$row->APP_DURATION,$row->CUST_ID,$row->EMP_ID,$row->COMMENT_,$row->ID);
			$appointments[]=$appointment;
		}
	
		$mysqli->close();
	
		return $appointments;
	}
	static function getFutureAppointments_byStartingDate($startDate ,$startTime ,$limit = false) // �������� ������ ���� �� ��������� - �� ������ ������ ���� ������
	{
		if(!$limit)
			$limit = "LIMIT 10";
		else if($limit)//������ �� ������  ��� ����� ����� �� ��� ������� �� �� ����� ��� ����� ������� �10 ������ ���� 
			$limit = "";
		
		$mysqli = SQLConnection::getConnection();
	    
		if (!($stmt = $mysqli->prepare("SELECT * FROM appointment WHERE APP_DATE >= ? AND not (APP_DATE = ? AND APP_TIME <  ?) ORDER BY APP_DATE,APP_TIME ASC ". $limit))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		$mysqlStartdate = date ("Y-m-d", $startDate);
		$mysqlStartTime = date ("H:i:s", $startTime);
	
		
		if (!$stmt->bind_param("sss", $mysqlStartdate,$mysqlStartdate, $mysqlStartTime)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		$appointments=[];
		while ($row = $result->fetch_object())
		{
			$appointment = new Appointment($row->APP_DATE,$row->APP_TIME,$row->APP_DURATION,$row->CUST_ID,$row->EMP_ID,$row->COMMENT_,$row->ID);
			$appointments[]=$appointment;
		}
	
		$mysqli->close();
	
		return $appointments;
	}
	static function getPastAppointments_byStartingDate($startDate,$startTime, $limit = false) // �������� ������ ���� �� ��������� - �� ������ ������ ���� ������
	{
		if(!$limit)
			$limit = "LIMIT 10";
		else if($limit)
			$limit = "";
	
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT * FROM appointment WHERE APP_DATE <=? AND  not (APP_DATE = ? AND APP_TIME >  ?) ORDER BY APP_DATE DESC,APP_TIME DESC ". $limit))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		$mysqlStartdate = date ("Y-m-d", $startDate);
// 		$mysqlEndDate = date ("Y-m-d", $startDate);
		$mysqlStartTime = date ("H:i:s", $startTime);
	
		if (!$stmt->bind_param("sss", $mysqlStartdate,$mysqlStartdate,$mysqlStartTime)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		$appointments=[];
		while ($row = $result->fetch_object())
		{
			$appointment = new Appointment($row->APP_DATE,$row->APP_TIME,$row->APP_DURATION,$row->CUST_ID,$row->EMP_ID,$row->COMMENT_,$row->ID);
			$appointments[]=$appointment;
		}
	
		$mysqli->close();
	
		return $appointments;
	}
	
	static function getPastAppointments_byStartingDate_2($startDate, $limit = false) // �������� ������ ���� �� ��������� - �� ������ ������ ���� ������
	{
		//�������� ���� ����� ��� ������ �� ������ �� ����� ��� �������
		if(!$limit)
			$limit = "LIMIT 10";
		else if($limit)
			$limit = "";
	
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT * FROM appointment WHERE APP_DATE BETWEEN ?  AND ? ORDER BY APP_DATE DESC ". $limit))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		$mysqlStartdate = date ("Y-m-d", $startDate);
		$mysqlEndDate = date ("Y-m-d", $startDate);
	
		if (!$stmt->bind_param("ss", $mysqlStartdate,  $mysqlEndDate)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		$appointments=[];
		while ($row = $result->fetch_object())
		{
			$appointment = new Appointment($row->APP_DATE,$row->APP_TIME,$row->APP_DURATION,$row->CUST_ID,$row->EMP_ID,$row->COMMENT_,$row->ID);
			$appointments[]=$appointment;
		}
	
		$mysqli->close();
	
		return $appointments;
	}
	//******************************************************************************
	
	static function getAllEmployeeAppointments_fromDateToDate($startDate,$endDate,$employeeId) // �������� ������ ���� �� ��������� - �� ������ ������ ��� ������� �������
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT * FROM appointment WHERE  EMP_ID=? AND APP_DATE BETWEEN ? AND ? ORDER BY APP_DATE, APP_TIME ASC"))) {
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
	
	
		$appointments=[];
		while ($row = $result->fetch_object())
		{
			$appointment = new Appointment($row->APP_DATE,$row->APP_TIME,$row->APP_DURATION,$row->CUST_ID,$row->EMP_ID,$row->COMMENT_,$row->ID);
			$appointments[]=$appointment;
		}
	
		$mysqli->close();
	
		return $appointments;
	}
	static function getAllEmployeeAppointments_byDate($date,$employeeId) // �������� ������ ���� �� ��������� - �� ������ ������ ���� ������
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT * FROM appointment WHERE EMP_ID=? AND APP_DATE=? ORDER BY APP_DATE, APP_TIME ASC"))) {
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
	
	
		$appointments=[];
		while ($row = $result->fetch_object())
		{
			$appointment = new Appointment($row->APP_DATE,$row->APP_TIME,$row->APP_DURATION,$row->CUST_ID,$row->EMP_ID,$row->COMMENT_,$row->ID);
			$appointments[]=$appointment;
		}
	
		$mysqli->close();
	
		return $appointments;
	}
	static function getAllEmployeeAppointments_byMonth($date,$employeeId) // �������� ������ ���� �� ��������� - �� ������ ������ ����� ������ ������
	{
		//http://php.net/manual/en/datetime.construct.php
		/*����� ��������
		 $d= new DateTime('6-2-2017');
		var_dump(AppointmentDBDAO::getAllAppointments_byMonth($d));
		*/
// 	    $date = date('m/d/Y', $date);
	
		
		$date1 = new DateTime();// �� ���� ����� ����� �� ����� ������� ���� �������� �� ����� DateTime ���� ���� ����� ��� (����) ������ ���� ���� �������� ��  $date ����� �� ������ 
		
		$date1->setTimestamp($date);
		
		
		$month= $date1->format('m');// ��� 02
		$year= $date1->format('Y');// ��� 2017

		$numberOfDaysInMonth = cal_days_in_month ( CAL_GREGORIAN, $month, $year ); //    year �� month � int ��� ���� �� ����� �����- �������� �����  
		//***
		// 		$appointments1=[];//���� �� ����� �� ��� ��� ���� ����� ����� ���� ����� ����� -����� ��� ������ ������ ���� ����� ����
		$appointments=[];//�� ���� ����� ������ ��� ��� ���� ����� ����� ���� �����
// 		printToTerminal( $month . " " . $year . " <br/>";
		for($i=1; $i <= $numberOfDaysInMonth; $i++) // ������ �� ����� ����� $i
		{
			$strDate = $year.'-' . $month .'-'.$i ;
	
// 			printToTerminal( $strDate . " <br/>";
			$mysqli = SQLConnection::getConnection();
				
			if (!($stmt = $mysqli->prepare("SELECT * FROM appointment WHERE EMP_ID=? AND  APP_DATE=? ORDER BY APP_DATE, APP_TIME ASC"))) {
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
				
				
			// 			$appointments=[];//���� �� ����� �� ��� ��� ���� ����� ����� ���� ����� ����� -����� ��� ������ ������ ���� ����� ����
			while ($row = $result->fetch_object())
			{
				$appointment = new Appointment($row->APP_DATE,$row->APP_TIME,$row->APP_DURATION,$row->CUST_ID,$row->EMP_ID,$row->COMMENT_,$row->ID);
				$appointments[]=$appointment;
				// 				$appointments1[$i]=$appointments;//���� �� ����� �� ��� ��� ���� ����� ����� ���� ����� ����� -����� ��� ������ ������ ���� ����� ����
			}
				
			$mysqli->close();
				
		}
		//****
	
		return $appointments;
		// 		return $appointments1;//���� �� ����� �� ��� ��� ���� ����� ����� ���� ����� ����� -����� ��� ������ ������ ���� ����� ����
	}
	

	static function getAllEmployeeAppointmentsInDay_fromHourToHour($employeeId, $date, $fromHour, $toHour) // �������� ������ ���� �� ��������� - �� ������ ������ ��� ������� �������
	{

	    //todo check relevance of this function, there is a need to check the appointment between from hour to hour


		$mysqli = SQLConnection::getConnection();
	
//		if (!($stmt = $mysqli->prepare("SELECT * FROM appointment WHERE  EMP_ID=? AND APP_DATE=? AND APP_TIME BETWEEN ? AND ? ORDER BY APP_TIME")))
        if (!($stmt = $mysqli->prepare("SELECT * FROM appointment WHERE  EMP_ID=? AND APP_DATE=? AND  AddTime(APP_TIME, APP_DURATION) BETWEEN ? AND ? ORDER BY APP_TIME"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		$mysqlDate = date ("Y-m-d", $date);
	    //
		$toHourMinusOneSecond =  date('H:i:s',strtotime($toHour));// todo check if the -1 is necessary here espacely with create absance $toHourMinusOneSecond =  date('H:i:s',strtotime($toHour)-1);
	
		if (!$stmt->bind_param("isss",$employeeId,$mysqlDate,$fromHour, $toHourMinusOneSecond)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		$appointments=[];
		while ($row = $result->fetch_object())
		{
			$appointment = new Appointment($row->APP_DATE,$row->APP_TIME,$row->APP_DURATION,$row->CUST_ID,$row->EMP_ID,$row->COMMENT_,$row->ID);
			$appointments[]=$appointment;
		}
	
		$mysqli->close();
	
		return $appointments;
	}
	/*
	static function getAllEmployeeAppointmentsInDay_fromHourToHour($employeeId, $date, $fromHour, $toHour) // �������� ������ ���� �� ��������� - �� ������ ������ ��� ������� �������
	{

	    //todo check relevance of this function, there is a need to check the appointment betwin from hour to hour


		$mysqli = SQLConnection::getConnection();

		if (!($stmt = $mysqli->prepare("SELECT * FROM appointment WHERE  EMP_ID=? AND APP_DATE=? AND APP_TIME BETWEEN ? AND ? ORDER BY APP_TIME"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}

		$mysqlDate = date ("Y-m-d", $date);
	    //
		$toHourMinusOneSecond =  date('H:i:s',strtotime($toHour)-1);// todo check if the -1 is necessary here

		if (!$stmt->bind_param("isss",$employeeId,$mysqlDate,$fromHour, $toHourMinusOneSecond)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}

		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}

		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}


		$appointments=[];
		while ($row = $result->fetch_object())
		{
			$appointment = new Appointment($row->APP_DATE,$row->APP_TIME,$row->APP_DURATION,$row->CUST_ID,$row->EMP_ID,$row->COMMENT_,$row->ID);
			$appointments[]=$appointment;
		}

		$mysqli->close();

		return $appointments;
	}
*/
    static function getAllEmployeeAppointmentsWithCustomer_fromDateToDate($startDate,$endDate,$employeeId,$CUST_ID) // הפונקציה מחזירה מערך של אובייקטים - כל התורים שנקבעו לעובד עם לקוח מסויים בין תאריכים שהתקבלו
    {
        $mysqli = SQLConnection::getConnection();

        if (!($stmt = $mysqli->prepare("SELECT * FROM appointment WHERE  EMP_ID=? AND CUST_ID =? AND APP_DATE BETWEEN ? AND ? ORDER BY APP_DATE , APP_TIME ASC"))) {
            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
        }

        $mysqlStartdate = date ("Y-m-d", $startDate);
        $mysqlEnddate = date ("Y-m-d", $endDate);


        if (!$stmt->bind_param("iiss",$employeeId,$CUST_ID,$mysqlStartdate,$mysqlEnddate)) {
            printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        if (!$stmt->execute()) {
            printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        if (!($result = $stmt->get_result())) {
            printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
        }


        $appointments=[];
        while ($row = $result->fetch_object())
        {
            $appointment = new Appointment($row->APP_DATE,$row->APP_TIME,$row->APP_DURATION,$row->CUST_ID,$row->EMP_ID,$row->COMMENT_,$row->ID);
            $appointments[]=$appointment;
        }

        $mysqli->close();

        return $appointments;
    }

//****************************************************************************************************************************************
    static function getFilteredAppointments($startDate,$endDate,$employeeId=false,$customerId=false)
    {
        printToTerminal( "Startdate: " . $startDate);
        printToTerminal( "Enddate: " . $endDate);

        $a=0;
        if($employeeId)
        {
            $a++;
        }
        if ($customerId)
        {
            $a=$a+2;
        }

        switch ($a)
        {
            //employeeId
            case  1 :return  self::getAllEmployeeAppointments_fromDateToDate($startDate,$endDate,$employeeId); break;

            //cutomer
            case  2:  return self::getAllCustomerAppointments_fromDateToDate($startDate,$endDate,$customerId);break;

            //employeeId & customerId
            case  3:return self::getAllEmployeeAppointmentsWithCustomer_fromDateToDate($startDate,$endDate,$employeeId,$customerId);break;

            //all without filtering
            default:return self::getAllAppointments_fromDateToDate($startDate,$endDate); break;
        }


    }
//--------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
//------------------------------------------------14-11-2017--------------------------------------------------------------------
    static function cmp($a, $b)
    {
        return strcmp($a->getAppointmentTime(), $b->getAppointmentTime());
    }
    static function getAllWindowTimeBetwinAppointmentH($employeeId, $date,$necessaryDuration)
    {

        printToTerminal('date: ');
        printToTerminal('date: ' . $date);
        $isDateCurrentDate = null;
        $fromHour = null;
        //check if date given pass already or if the date given is current date so we won't run on date or hours that pass already
        if(($currDate = date('Y-m-d')) >= ($strDate = date('Y-m-d', $date))) {
            printToTerminal('isDateCurrentDate');
            if($currDate > $strDate) throw new Exception('Day has passed!');
            $isDateCurrentDate = true;
            $fromHour = time();
        }
//        $isDateCurrentDate = date('ymd' ,$date) === date('ymd' ,time());

        $availableAppointments = [];
        $fb= new FullyBookedDate($date,$employeeId);

        //in acase the date is fully booked or the employee are absance so no need to check and just return empty
        if(!FullyBookedDateDBDAO::checkIfEmplooyeeDayIsFullyBooked($fb)&&!EmployeeAbsenceDBDAO::checkIfEmployeeIsAbsentAllDay($employeeId, $date ))
        {

            $day= strtoupper(date("l",$date));
            $workhs=WorkHoursDBDAO::getEmployeeWorkHoursByDay($employeeId,$day);
            $toHr=$workhs->getFromHour2()?strtotime($workhs->getToHour2()):strtotime($workhs->getToHour1());
            $fromHour = $fromHour == null ? strtotime($workhs->getFromHour1()) : $fromHour;
            // in a case we are checking a current date but the working day  finish so there is no resons to check
//            if($isDateCurrentDate && time() >= $toHr){
//                throw new Exception('working hours Finished for today!');
//            }
            $unAvailbleAppointments = self::getAllEmployeeAppointmentsInDay_fromHourToHour($employeeId, $date, $fromHour, $toHr );

            $absencesAsAppointment=[];//treat  to the absences as appointment
            //if date givem is current date so we want to check only from the current hour
            $absences=$isDateCurrentDate?EmployeeAbsenceDBDAO::getEmployeeAbsenceByDateAndFromHourToHour($employeeId, $date, $fromHour, $toHr):EmployeeAbsenceDBDAO::getEmployeeAbsenceByEmployeeIdAndDate($date,$employeeId);
            if($absences)
            {
                foreach ($absences as $absence)
                {
                    $durationTimeAbsence= strtotime($absence-> getToHour())-strtotime($absence->getFromHour());//long in secound
                    $absenceAsApp= new Appointment($absence->getDate(), $absence->getFromHour() ,date('H:i:s' ,$durationTimeAbsence),null, $employeeId,null);
                    $absencesAsAppointment[]=$absenceAsApp;
                }
            }

            //todo check if there is a function can naturalu add array2 to  array1 from the last index of array1
            if($absencesAsAppointment)//if there are absances and we threat them as an appointment so we want to add them to the list of the unavailable appointment
            {
//                for($i=0;$i<count($absencesAsAppointment);$i++)
//                    array_push($unAvailbleAppointments, $absencesAsAppointment[$i]);

                array_merge($unAvailbleAppointments, $absencesAsAppointment);
//                $unAvailbleAppointments=sort($unAvailbleAppointments);
            }
            if($workhs->getFromHour2())//if the day is split so we threat the break time as an appointment and push this appointment to the unavailable appointment
            {
                $durationTimeBreackTime= (strtotime($workhs->getFromHour2()) - strtotime($workhs->getToHour1()));
                $breackTimeAsApp= new Appointment(date('Y-m-d',$date),$workhs->getToHour1(),date('H:i:s' ,$durationTimeBreackTime),null, $employeeId,null);
                $lastAppointmentBorderTime = strtotime($workhs->getToHour2());

                // we check all the free wondow (time) between the appointment so we need to creat a fake appointment that will make appointment from the end of the day
                $lastAppointmentBorder= new Appointment(date('Y-m-d',$date),date('H:i:s',$lastAppointmentBorderTime),date('H:i:s' ,1),null, $employeeId,null);
                array_push($unAvailbleAppointments,$breackTimeAsApp);
                array_push($unAvailbleAppointments,$lastAppointmentBorder);

            }
            else{
                $lastAppointmentBorderTime = strtotime($workhs->getToHour1());
                $lastAppointmentBorder= new Appointment(date('y-m-d',$date),date('H:i:s',$lastAppointmentBorderTime),date('H:i:s' ,1),null, $employeeId,null);
                array_push($unAvailbleAppointments,$lastAppointmentBorder);
            }

            usort($unAvailbleAppointments,  array('AppointmentDBDAO', 'cmp'));
            $availableAppointments=[];

            $currentRunHour = $fromHour;

//            $currentRunHourUnixTime=strtotime($currentRunHour);
            $currentRunHourUnixTime = $currentRunHour;
            printToTerminal('currentRunHourUnixTime: ' . $currentRunHourUnixTime);
//            if($isDateCurrentDate)//todo for aviya
//                $currentRunHourUnixTime=time();

            $dt = new DateTime;
            $dt->setTime(0, 0);
            for($i=0;$i<count($unAvailbleAppointments);$i++)
            {


                $currentAppointment = $unAvailbleAppointments[$i];
                if($i === 0 && $currentRunHourUnixTime===strtotime($currentAppointment->getAppointmentTime()))
                    $currentRunHourUnixTime=strtotime($currentAppointment->getAppointmentTime()) + (strtotime($currentAppointment->getDurationTime()) - $dt->getTimestamp());



                elseif ($currentRunHourUnixTime<strtotime($unAvailbleAppointments[$i]->getAppointmentTime()))
                {
//                    printToTerminal('currentRunHourUnixTime < getAppointmentTime:' .date('H:i:s', $currentRunHourUnixTime));

                    $windowTime=strtotime($unAvailbleAppointments[$i]->getAppointmentTime())-$currentRunHourUnixTime;
                    if($windowTime >= $necessaryDuration)//todo i put =
                    {
                        $appntsNum = floor($windowTime/$necessaryDuration);//make the number int in a case it is float

                        for($appnts=0;$appnts<$appntsNum;$appnts++)
                        {
                            printToTerminal('appntsNum: ' . $appntsNum);
                            $appointmentTime=$currentRunHourUnixTime;
                            $appointment= new Appointment(date('y-m-d',$date), date('H:i:s' , $appointmentTime) ,$necessaryDuration,null, $employeeId,null);
                            $availableAppointments[]=$appointment;
                            $currentRunHourUnixTime+=$necessaryDuration;
                        }
                        $currentRunHourUnixTime=$currentRunHourUnixTime=strtotime($currentAppointment->getAppointmentTime()) + (strtotime($currentAppointment->getDurationTime()) - $dt->getTimestamp());

//                        $currentRunHourUnixTime+=strtotime($unAvailbleAppointments[$i]->getDurationTime())- $dt->getTimestamp();
//                        printToTerminal('currentRunHourUnixTime < getAppointmentTime after loop:' .date('H:i:s', $currentRunHourUnixTime));

                    }else {
                        $currentRunHourUnixTime=$currentRunHourUnixTime=strtotime($currentAppointment->getAppointmentTime()) + (strtotime($currentAppointment->getDurationTime()) - $dt->getTimestamp());
//                        printToTerminal('else currentRunHourUnixTime:' .$currentRunHourUnixTime);
                    }
                    //todo כאשר החלון קטן מהדורשיין נוצר מצב שאומנם נכנסנו אבל אין מה שיקדם את הזמן הנוכחי כיוון שהוא לא מקודם בתוך האיף
                }
//                else $currentRunHourUnixTime=strtotime($currentAppointment->getAppointmentTime()) + (strtotime($currentAppointment->getDurationTime()) - $dt->getTimestamp());
            }
        }
        return $availableAppointments;
    }

//----------------------------AVIYA---------13-11-2017---------------

    static function isAbsencesFull($absences,$workhs)
    {
        // checks if absence is on full day or not by verifying that $absences length is only 1 and equating it to work hours
        if(count($absences) == 1){
            if($absences[0]->getFromHour() ===  $workhs->getFromHour1() &&
                $absences[0]->getToHour() ===  ($workhs->getToHour2() ?  $workhs->getToHour2() :  $workhs->getToHour1())){
                return true;
            }
        }

        return false;


    }

    static function isAbsenceOverlap($currentRunHour, $absences, $necessaryDuration)
    {
//        printToTerminal('isAbsenceOverlap');

        //loops over  $absences array and check if $currentRunHour is between getFromHour() and getToHour()
       for($i = 0; $i < count($absences); $i++)
       {
           $currentHourEnding = strtotime(date('H:i:s' ,$currentRunHour + $necessaryDuration));
//           printToTerminal('currentRunHour: '. date('H:i:s' ,$currentRunHour));
//           todo check when ui is ready if hours set in the correct format i.e 12h/24h DB otherwise this func may return wrong result
           if ((($currentHourEnding >= strtotime($absences[$i]->getFromHour()) &&  $currentRunHour < ($overlapAbsence = strtotime( $absences[$i]->getToHour()))) )  )
           {
//               printToTerminal('isAbsenceOverlap: true');
               return $overlapAbsence;
           }
       }

//        printToTerminal('isAbsenceOverlap: false');

      return false;
    }


    static function getAllWindowTimeBetwinAppointmentA($employeeId, $date,$necessaryDuration)// $date is long
    {
        printToTerminal('getAllWindowTimeBetwinAppointmentA date: '. $date);
        printToTerminal('getAllWindowTimeBetwinAppointmentA necessaryDuration: '. $necessaryDuration);

        $isDateCurrentDate = false;
        $day = strtoupper(date("l", $date));
        $workhs = WorkHoursDBDAO::getEmployeeWorkHoursByDay($employeeId, $day);

        //check if given date is today if so sets $currentRunHour to current time
        //throw Exception if date has passed
        if(($currDate = date('Y-m-d')) >= ($strDate = date('Y-m-d', $date))) {
            if($currDate > $strDate) throw new Exception('Day has passed!');
            $currTime = time();
            $fromHour1 = strtotime($workhs->getFromHour1());
            $currentRunHour = $fromHour1 <= $currTime ? $currTime : $fromHour1;
            $isDateCurrentDate = true;
        }
        else $currentRunHour = strtotime($workhs->getFromHour1());

        $firstAppEndTime = null;

        $lastHour = $workhs->getToHour2() ? strtotime($workhs->getToHour2()) : strtotime($workhs->getToHour1());

        //checks if $absences is not empty and sets $isAbsences accordingly
        if($absences = $isDateCurrentDate ? EmployeeAbsenceDBDAO::getEmployeeAbsenceByDateAndFromHourToHour($employeeId, $date, $currentRunHour, $lastHour):EmployeeAbsenceDBDAO::getEmployeeAbsenceByEmployeeIdAndDate($date,$employeeId)) $isAbsences = true;
        else $isAbsences = false;





        $availableAppointments = [];
        $fb= new FullyBookedDate($date,$employeeId);
        //check if fully booked and if absence is a full day
        if(!FullyBookedDateDBDAO::checkIfEmplooyeeDayIsFullyBooked($fb) && ($isAbsences ? !self::isAbsencesFull($absences, $workhs, $employeeId, $day): true)) {


            $unAvailbleAppointments = $isDateCurrentDate ? self::getAllEmployeeAppointmentsInDay_fromHourToHour($employeeId, $date, $currentRunHour, $lastHour ) : self::getAllEmployeeAppointments_byDate($date, $employeeId);

//            printToTerminal('$unAvailbleAppointments: ' . json_encode($unAvailbleAppointments));


//            //check if given date is today if so sets $currentRunHour to current time
//            //throw Exception if date has passed
//            if(($currDate = date('Y-m-d')) >= ($strDate = date('Y-m-d', $date))) {
//                if($currDate > $strDate) throw new Exception('Day has passed!');
//                $currTime = time();
//                $fromHour1 = strtotime($workhs->getFromHour1());
//                $currentRunHour = $fromHour1 <= $currTime ? $currTime : $fromHour1;
//            }
//            else $currentRunHour = strtotime($workhs->getFromHour1());

//            $firstAppEndTime = null;
//
//            $lastHour = $workhs->getToHour2() ? strtotime($workhs->getToHour2()) : strtotime($workhs->getToHour1());

            //if array is empty then run only once so that it'll go from $workhs->getFromHour1() till the end of the day
            //todo check if for loop run till equals
            $unAvailbleAppointmentsCount = !empty($unAvailbleAppointments) ? count($unAvailbleAppointments) : 0;

            for ($i = 0; $i <= $unAvailbleAppointmentsCount; $i++) {
                //will be true if there is a free window available
                $isFreeWindow = false;

                $dt = new DateTime();
                $dt->setTime(0, 0);
//                $currentRunHourUnixTime=strtotime($unAvailbleAppointments[$i]->getAppointmentTime()) + (strtotime($unAvailbleAppointments[$i]->getDurationTime()) - $dt->getTimestamp());



                // will throw Exception look  at $firstAppEndTime
                //checks if it's the last loop then assign value to $freeWindow & $currentRunHour and sets $isFreeWindow = true;
                if (!empty($unAvailbleAppointments) && ($i == $unAvailbleAppointmentsCount  )) {
//                if (isset($unAvailbleAppointments) && ($i == $unAvailbleAppointmentsCount - 1) && ($freeWindow = $lastHour - ($currentRunHour = strtotime($unAvailbleAppointments[$i]->getAppointmentTime()) + (date('i', strtotime($unAvailbleAppointments[$i]->getDurationTime())) * 60))) > $necessaryDuration) {

                    ($currentRunHour1 = strtotime($unAvailbleAppointments[$i-1]->getAppointmentTime()) + (strtotime($unAvailbleAppointments[$i-1]->getDurationTime()) - $dt->getTimestamp()));
                    ($freeWindow1 = $lastHour - $currentRunHour1);
                    if($freeWindow1 > $necessaryDuration){
                    $currentRunHour = $currentRunHour1;
                    $freeWindow = $freeWindow1;
                    $secontAppTime = $lastHour;
                    $isFreeWindow = true;
//                    printToTerminal('ifffffffffffffffffffffffffffffffff!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');
                    }
                } else {
//                    printToTerminal('else!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');
                    //checks if this is the first time
                    if ($i == 0) {
                        //if array is empty assign $freeWindow to the time between  $workhs->getFromHour1() to $workhs->getToHour1() or $workhs->getToHour2() if exists and sets $isFreeWindow = true;
                        if (empty($unAvailbleAppointments) ) {
                            $freeWindow = $lastHour - $currentRunHour;
                            $secontAppTime = $lastHour;
                            $isFreeWindow = true;
                        }
                        //todo check if currentRunHour is set to today's date or not if not should change it to time only without date and also $unAvailbleAppointments[$i]->getAppointmentTime()
                        //if first time assign $freeWindow to the time between  $workhs->getFromHour1() to the first Appointment and sets $isFreeWindow = true;
                        elseif (($freeWindow = strtotime($unAvailbleAppointments[$i]->getAppointmentTime()) - $currentRunHour) > $necessaryDuration) {
//                            printToTerminal('first cell');
                            $secontAppTime = strtotime($unAvailbleAppointments[$i]->getAppointmentTime());
                            $isFreeWindow = true;
                        }
                    } else {

                        //if it's not the last or first loop check between current index to the next index
                        $firstAppEndTime = strtotime($unAvailbleAppointments[$i-1]->getAppointmentTime()) + (strtotime($unAvailbleAppointments[$i-1]->getDurationTime()) - $dt->getTimestamp());
//                        $firstAppEndTime = strtotime($unAvailbleAppointments[$i - 1]->getAppointmentTime()) + (date('i', strtotime($unAvailbleAppointments[$i - 1]->getDurationTime())) * 60);
                        $secontAppTime = strtotime($unAvailbleAppointments[$i]->getAppointmentTime());
                        ($currentRunHour < $firstAppEndTime ? $currentRunHour = $firstAppEndTime : false);
                        $freeWindow = $secontAppTime - $currentRunHour;


                        //todo check if i took everything under consideration about the worker down time
                        if ($freeWindow >= $necessaryDuration) {
                            $isFreeWindow = true;
                        }
                    }

                }

//                printToTerminal('currentRunHour inside: '. date('H:i:s' ,$currentRunHour));
//                printToTerminal('current app inside: '. $unAvailbleAppointments[$i]->getAppointmentTime());
//                printToTerminal('isfreewindow: '. $isFreeWindow);


                //runs last if $isFreeWindow=true;
                if ($isFreeWindow) {
//                    printToTerminal('isfreewindow: if statement');
                    $appntmntsSum = floor($freeWindow / $necessaryDuration);

                    for ($j = 0; $j < $appntmntsSum; $j++) {
//                        printToTerminal('isfreewindow: for loop');
//                        printToTerminal('currentRunHour inside: '. date('H:i:s' ,$currentRunHour));
                        //checks that $currentRunHour is not between $workhs->getToHour1() and $workhs->getFromHour2() which is worker's down time
                        if (($secontAppTime >= $currentRunHour + $necessaryDuration) &&  (($currentRunHour >= strtotime($workhs->getFromHour1()) && $currentRunHour + $necessaryDuration < (strtotime($workhs->getToHour1()) )) ||
                                                                                                                                 ($currentRunHour >= strtotime($workhs->getFromHour2()) && $currentRunHour + $necessaryDuration < (strtotime($workhs->getToHour2()) ))) &&
                                                                                                                                                             ($isAbsences ? !($overlapAbsence = self::isAbsenceOverlap($currentRunHour, $absences, $necessaryDuration)) : true) ) {


//                            $availableAppointments[] = new Appointment( $date,  $currentRunHour, $necessaryDuration, null, $employeeId, null);
                            $availableAppointments[]= new Appointment(date('y-m-d',$date), date('H:i:s' , $currentRunHour) ,$necessaryDuration,null, $employeeId,null);


                        }
                        //TODO might effect performance drastically!
                        if($isAbsences &&  $overlapAbsence){
                            $currentRunHour = $overlapAbsence;
                                if (($secontAppTime >= $currentRunHour + $necessaryDuration) &&  (($currentRunHour >= strtotime($workhs->getFromHour1()) && $currentRunHour + $necessaryDuration < (strtotime($workhs->getToHour1()) )) ||
                                        ($currentRunHour >= strtotime($workhs->getFromHour2()) && $currentRunHour + $necessaryDuration < (strtotime($workhs->getToHour2()) ))) &&
                                    ($isAbsences ? !self::isAbsenceOverlap($currentRunHour, $absences, $necessaryDuration) : true) ) {

//TODO change the object below to the other one without the string date
//                            $availableAppointments[] = new Appointment( $date,  $currentRunHour, $necessaryDuration, null, $employeeId, null);
                                    $availableAppointments[]= new Appointment(date('y-m-d',$date), date('H:i:s' , $currentRunHour) ,$necessaryDuration,null, $employeeId,null);


                                }
                            $overlapAbsence = false;
                        }
                        $currentRunHour += $necessaryDuration;
                    }
                }

//                printToTerminal('currentRunHour in the end: '. date('H:i:s' ,$currentRunHour));
            }

        }

        return $availableAppointments;

    }

    //---------------------END-------AVIYA---------13-11-2017---------------














//    static function getAllWindowTimeBetwinAppointment($employeeId, $date,$necessaryDuration)// $date is long
//    {
//        if(!) FullyBookedDate()
//        $day= strtoupper(date("l",$date));
//        $workhs=WorkHoursDBDAO::getEmployeeWorkHoursByDay($employeeId,$day);
//
//        $unAvailbleAppointments=self::getAllEmployeeAppointmentsInDay_fromHourToHour($employeeId, $date, $workhs->getFromHour1(), $workhs->getToHour1());
//
//        $availableAppointments=[];
//
//        $currentRunHour = $workhs->getFromHour1();
//
//        $currentRunHourUnixTime=strtotime($currentRunHour);
//
//        for($i=0;count($unAvailbleAppointments-1);$i++)
//        {
//            if($currentRunHourUnixTime===$unAvailbleAppointments[$i]->getAppointmentTime())
//            {
//                $currentRunHourUnixTime=$unAvailbleAppointments[$i]->getAppointmentTime()+getDurationTime();
//            }
//            elseif ($currentRunHourUnixTime<$unAvailbleAppointments[$i]->getAppointmentTime())
//            {
//                $windowTime=$unAvailbleAppointments[$i]->getAppointmentTime()-$currentRunHourUnixTime;
//                if($windowTime>$necessaryDuration)
//                {
//                    $appntsNum=floor($windowTime/$necessaryDuration);//make the number int in a case it is float
//                    for($appnts=0;$appnts<$appntsNum;$$appnts++)
//                    {
//                        $appointmentTime=$currentRunHourUnixTime+$necessaryDuration;
//                        $currentRunHourUnixTime=$appointmentTime;//new $currentRunHourUnixTime with additional $necessaryDuration
//
//                        $appointment= new Appointment($date, $appointmentTime ,$necessaryDuration,null, $employeeId,null);
//                        $availableAppointments[]=$appointment;
//                    }
//                }
//            }
//        }
//        if($workhs->getFromHour2())  //checking if it is split day
//        {
//            $unAvailbleAppointments=self::getAllEmployeeAppointmentsInDay_fromHourToHour($employeeId, $date, $workhs->getFromHour2(), $workhs->getToHour2());
//
//            for($i=0;count($unAvailbleAppointments-1);$i++)
//            {
//
//                if($currentRunHourUnixTime===$unAvailbleAppointments[$i]->getAppointmentTime())
//                {
//                    $currentRunHourUnixTime=$unAvailbleAppointments[$i]->getAppointmentTime()+getDurationTime();
//                }
//                elseif ($currentRunHourUnixTime<$unAvailbleAppointments[$i]->getAppointmentTime())
//                {
//                    $windowTime=$unAvailbleAppointments[$i]->getAppointmentTime()-$currentRunHourUnixTime;
//                    if($windowTime>$necessaryDuration)
//                    {
//                        $appntsNum=floor($windowTime/$necessaryDuration);//make the number int in a case it is float
//                        for($appnts=0;$appnts<$appntsNum;$$appnts++)
//                        {
//                            $appointmentTime=$currentRunHourUnixTime+$necessaryDuration;
//                            $currentRunHourUnixTime=$appointmentTime;//new $currentRunHourUnixTime with additional $necessaryDuration
//
//                            $appointment= new Appointment($date, $appointmentTime ,$necessaryDuration,null, $employeeId,null);
//                            $availableAppointments[]=$appointment;
//                        }
//                    }
//                }
//            }
//        }
//
//        return $availableAppointments;
//
//    }
//
//


    ///////////////////////////////////////////////////////////////////////////////////
//    static function getAllWindowTimeBetwinAppointment($employeeId, $date,$necessaryDuration)// $date is long
//    {
//        $day= strtoupper(date("l",$date));
//        $workhs=WorkHoursDBDAO::getEmployeeWorkHoursByDay($employeeId,$day);
//        //todo run also on the secound part of the day formhour2 and tohour2
//        if($workhs->getFromHour2())        //checking if it is split day
//            $unAvailbleAppointments=self::getAllEmployeeAppointmentsInDay_fromHourToHour($employeeId, $date, $workhs->getFromHour1(), $workhs->getToHour2());
//        else $unAvailbleAppointments=self::getAllEmployeeAppointmentsInDay_fromHourToHour($employeeId, $date, $workhs->getFromHour1(), $workhs->getToHour1());
//
//        $availableAppointments=[];
//
//        $currentRunHour = $workhs->getFromHour1();
//
//        $currentRunHourUnixTime=strtotime($currentRunHour);
//
//        for($i=0;count($unAvailbleAppointments-1);$i++)
//        {
//
//            if($currentRunHourUnixTime===$unAvailbleAppointments[$i]->getAppointmentTime())
//            {
//                $currentRunHourUnixTime=$unAvailbleAppointments[$i]->getAppointmentTime()+getDurationTime();
//            }
//            elseif ($currentRunHourUnixTime<$unAvailbleAppointments[$i]->getAppointmentTime())
//            {
//                $windowTime=$unAvailbleAppointments[$i]->getAppointmentTime()-$currentRunHourUnixTime;
//                if($windowTime>$necessaryDuration)
//                {
//                    $appntsNum=floor($windowTime/$necessaryDuration);//make the number int in a case it is float
//                    for($appnts=0;$appnts<$appntsNum;$$appnts++)
//                    {
//                        $appointmentTime=$currentRunHourUnixTime+$necessaryDuration;
//                        $currentRunHourUnixTime=$appointmentTime;//new $currentRunHourUnixTime with additional $necessaryDuration
//
//                        $appointment= new Appointment($date, $appointmentTime ,$necessaryDuration,null, $employeeId,null);
//                        $availableAppointments[]=$appointment;
//                    }
//
//                }
//            }
//
//
////           if(1200-1000>$d)
////           {
////            1200-1000/$d=4
////            for(4)
////                $availableAppointments[] = new Appointment()
////
////           }
////            strtotime($unAvailbleAppointments[$i]->getAppointmentTime())+getDurationTime();1200+200
////
////
////        1600-1400 > $d
////            strtotime($unAvailbleAppointments[$i+1]->getAppointmentTime())+getDurationTime();1600
//
//
//
//        }
//        if($workhs->getFromHour2())
//        {
//            for($i=0;count($unAvailbleAppointments-1);$i++)
//            {
//
//                if($currentRunHourUnixTime===$unAvailbleAppointments[$i]->getAppointmentTime())
//                {
//                    $currentRunHourUnixTime=$unAvailbleAppointments[$i]->getAppointmentTime()+getDurationTime();
//                }
//                elseif ($currentRunHourUnixTime<$unAvailbleAppointments[$i]->getAppointmentTime())
//                {
//                    $windowTime=$unAvailbleAppointments[$i]->getAppointmentTime()-$currentRunHourUnixTime;
//                    if($windowTime>$necessaryDuration)
//                    {
//                        $appntsNum=floor($windowTime/$necessaryDuration);//make the number int in a case it is float
//                        for($appnts=0;$appnts<$appntsNum;$$appnts++)
//                        {
//                            $appointmentTime=$currentRunHourUnixTime+$necessaryDuration;
//                            $currentRunHourUnixTime=$appointmentTime;//new $currentRunHourUnixTime with additional $necessaryDuration
//
//                            $appointment= new Appointment($date, $appointmentTime ,$necessaryDuration,null, $employeeId,null);
//                            $availableAppointments[]=$appointment;
//                        }
//
//                    }
//                }
//
//            }
//        }
//
//
//        return $availableAppointments;
//
//    }
    /// ///////////////////////////////////////////////////////////////////////////////////
}
 

