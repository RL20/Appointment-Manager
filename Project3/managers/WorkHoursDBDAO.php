<?php
require_once  __DIR__.'/../requires.php';
class WorkHoursDBDAO {
// 	private static $workHoursDBDAO;
	
	
// 	private function __construct(){}
	
// 	public static function getInstance()
// 	{
// 		if(!isset(self::$workHoursDBDAO))
// 		{
// 			self::$workHoursDBDAO = new WorkHoursDBDAO;
// 		}
// 		return self::$workHoursDBDAO;
// 	}
	

// 	static function getWorkHours($id)//  �� ���� ���� �������� ���� ����� ���� ������ ������� ��� ��� ���� �� �� ����� �� ����� ���� ��� �� ������� ���� ������� ���� �� �� ����� ������ �� �����
// 	{
// 		$mysqli = SQLConnection::getConnection();
	
// 		if (!($stmt = $mysqli->prepare("SELECT ID,EMP_ID, DAY_,FROM_HOUR1,TO_HOUR1,FROM_HOUR2,TO_HOUR2 FROM work_hours WHERE ID = ?"))) {
// 			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
// 		}
	
// 		if (!$stmt->bind_param("i", $id)) {
// 			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
// 		}
	
// 		if (!$stmt->execute()) {
// 			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
// 		}
		 
// 		if (!($result = $stmt->get_result())) {
// 			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
// 		}
	
	
// 		$row = $result->fetch_object();
	
	
// 		$workHours =new WorkHours($row->EMP_ID, $row->DAY_,$row->FROM_HOUR1,$row->TO_HOUR1,$row->FROM_HOUR2,$row->TO_HOUR2,$row->ID);
	
		
// 		$mysqli->close();
		
// 		return $workHours;
// 	}
	//����� // �������� ������ ���� �� ��������� -�� ����� ����� ������ ����� ������
	static function getAllEmpWorkHours($employeeId)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT ID,EMP_ID, DAY_,FROM_HOUR1,TO_HOUR1,FROM_HOUR2,TO_HOUR2 FROM work_hours WHERE EMP_ID = ?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		if (!$stmt->bind_param("i", $employeeId)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		$allDaysWorkHours=[];
		while ($row = $result->fetch_object())
		{
			$workHours =new WorkHours($row->EMP_ID, $row->DAY_,$row->FROM_HOUR1,$row->TO_HOUR1,$row->FROM_HOUR2,$row->TO_HOUR2,$row->ID);
			$allDaysWorkHours[]=$workHours;
		}
	
		$mysqli->close();
	
		return $allDaysWorkHours;
	}
	
	
	
	static function createWorkHours(WorkHours $workHours)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("INSERT INTO work_hours (EMP_ID, DAY_,FROM_HOUR1,TO_HOUR1,FROM_HOUR2,TO_HOUR2) VALUES (?,?,?,?,?,?)"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		 $employeeId=$workHours->getemployeeId();
		 $day=$workHours->getDay();
		 $fromHour1=$workHours->getFromHour1();
		 $toHour1=$workHours->getToHour1();
		 $fromHour2=$workHours->getFromHour2();
		 $toHour2=$workHours->getToHour2();
		
		/*$employeeId=$workHours->getemployeeId();
		$day=$workHours->getDay();
		$fromHour1=date ("Y-m-d H:i:s",$workHours->getFromHour1());
		$toHour1=date ("Y-m-d H:i:s",$workHours->getToHour1());
		$fromHour2=date ("Y-m-d H:i:s",$workHours->getFromHour2());
		$toHour2=date ("Y-m-d H:i:s",$workHours->getToHour2());*/
		
	
		//�� ����� ������� ��������
		if (!$stmt->bind_param("isssss", $employeeId,$day, $fromHour1, $toHour1, $fromHour2,$toHour2)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		printToTerminal( "WorkHours created successfuly!!");
		$mysqli->close();
	
	}
	
	static function updateWorkHours(WorkHours $workHours)
	{
		$mysqli = SQLConnection::getConnection();
	
		
		if (!($stmt = $mysqli->prepare("UPDATE work_hours SET EMP_ID=?, DAY_=?,FROM_HOUR1=?,TO_HOUR1=?,FROM_HOUR2=?,TO_HOUR2=? WHERE ID=?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
	    $id=$workHours->getId();
		$employeeId=$workHours->getemployeeId();
		$day=$workHours->getDay();
		$fromHour1=$workHours->getFromHour1();
		$toHour1=$workHours->getToHour1();
		$fromHour2=$workHours->getFromHour2();
		$toHour2=$workHours->getToHour2();
		if (!$stmt->bind_param("isssssi",$employeeId, $day, $fromHour1, $toHour1, $fromHour2,$toHour2,$id)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		printToTerminal( "WorkHours updated successfuly!!");
		$mysqli->close();
	
	}
	
	static function deleteWorkHours( $id)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("DELETE FROM work_hours WHERE ID=?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
	
		
		if (!$stmt->bind_param("i", $id)) {
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
		$mysqli->close();
	
	}
	
	static function getEmployeeWorkHoursByDay($EmployeeId,$day)// ������ �� �� ����� �� ���� �� �� ��� ����� 
	{
//	    printToTerminal("emp id: " . $EmployeeId . "   " . $day);
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT ID,EMP_ID, DAY_,FROM_HOUR1,TO_HOUR1,FROM_HOUR2,TO_HOUR2 FROM work_hours WHERE EMP_ID=? AND DAY_ = ?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		if (!$stmt->bind_param("is", $EmployeeId, $day)) {
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
            $workHours = new WorkHours($row->EMP_ID, $row->DAY_,$row->FROM_HOUR1,$row->TO_HOUR1,$row->FROM_HOUR2,$row->TO_HOUR2,$row->ID);
        }
        catch (Exception $e)
        {
// 			throw new Exception("djfkygvhudhgfvbjdfhvbjdfhbvjdfhb");
            throw new Exception('WorkHours deos not exists for employee');
        }
        finally {
            $mysqli->close();
        }
	

	
	
//		$mysqli->close();
	
		return $workHours;
	}
	
	
}

