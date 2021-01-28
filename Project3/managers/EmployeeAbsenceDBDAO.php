<?php
require_once  __DIR__.'/../requires.php';

class EmployeeAbsenceDBDAO {
	// private static $employeeAbsenceDBDAO;
	
	// private function __construct(){}
	
	// public static function getInstance()
	// {
	// if(!isset(self::$employeeAbsenceDBDAO))
	// {
	// self::$employeeAbsenceDBDAO = new EmployeeAbsenceDBDAO;
	// }
	// return self::$employeeAbsenceDBDAO;
	// }
	static function getAllEmployeesAbsence() // ������� ������� �� �� ��������� �� ������� ��� ����� ���� ������� �����
{
		// $date=time();
		$AllAbsences = [ ];
		$mysqli = SQLConnection::getConnection ();
		// ���� ���������� ��� ���� ������ ����� �������� ��� ����� ���� ���� � �� ���� ����� �� ���� ���� ���� ������
		if (! ($result = $mysqli->query ( "SELECT ea.*, e.NAME_ FROM employee_absence as ea 
				JOIN employee as e ON e.ID=ea.EMP_ID 
				WHERE DATE(ea.DATE_) >= DATE(NOW()) 
				AND not(DATE(ea.DATE_) = DATE(NOW()) and TIME(ea.TO_HOUR) <= TIME(NOW())) 
				ORDER BY ea.DATE_ ASC , ea.FROM_HOUR ASC" ))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
		/*
		 *
		 * if (! ($result = $mysqli->query ( "SELECT * FROM employee_absence WHERE DATE(DATE_) >= DATE(NOW())
		 * AND not(DATE(DATE_) = DATE(NOW()) and TIME(TO_HOUR) <= TIME(NOW()))
		 * ORDER BY DATE_ ASC , FROM_HOUR ASC" ))) {
		 * printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		 * }
		 *
		 */
		
		// if (!($stmt = $mysqli->prepare("SELECT * FROM employee_absence WHERE DATE_ >= ? AND FROM_HOUR > ? ORDER BY DATE_ ASC , FROM_HOUR ASC"))) {
		// printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		// }
		// $mysqlStartdate = date ("Y-m-d", $date);
		// // $mysqlStartTime = date ("H:i:s", $date);
		// if (!$stmt->bind_param("s",$mysqlStartdate)) {
		// printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		// }
		
		// if (!$stmt->execute()) {
		// printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		// }
		
		// if (!($result = $stmt->get_result())) {
		// printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		// }
		
		// while ($row = $result->fetch_object())
		// {
		// $employeeAbsence = new EmployeeAbsence($row->EMP_ID, $row->DATE_,$row->FROM_HOUR,$row->TO_HOUR,$row->ID);
		// $name=EmployeeDBDAO::getEmployee($employeeAbsence->getEmployeeId());
		// $AllAbsences[]=$employeeAbsence;
		// }
		
		while ( $row = $result->fetch_array () ) {
			$AllAbsences [] = $row;
		}
		// printToTerminal( json_encode ( $AllAbsences );
		
		$mysqli->close ();
		
		// return $AllAbsences;
		return $AllAbsences;
	}
	static function getEmployeeAbsence($id) // �� ������ ����� ID ����� �� �
{
		$mysqli = SQLConnection::getConnection ();
		
		if (! ($stmt = $mysqli->prepare ( "SELECT ID,EMP_ID,DATE_,FROM_HOUR,TO_HOUR FROM employee_absence WHERE ID = ?" ))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
		
		if (! $stmt->bind_param ( "i", $id )) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		if (! $stmt->execute ()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		if (! ($result = $stmt->get_result ())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		$row = $result->fetch_object ();
		
		$employeeAbsence = new EmployeeAbsence ( $row->EMP_ID, $row->DATE_, $row->FROM_HOUR, $row->TO_HOUR, $row->ID );
		
		$mysqli->close ();
		
		return $employeeAbsence;
	}
	
	// //////////////////////
	static function getEmployeeAbsenceByEmployeeId($employeeId) // ������� ������� �� �� �������� �������� �� ����
{
		$date = time ();
		$mysqli = SQLConnection::getConnection ();
		
//		if (! ($stmt = $mysqli->prepare ( "SELECT * FROM employee_absence WHERE EMP_ID = ? AND DATE_ >= ? AND FROM_HOUR > ? ORDER BY DATE_ ASC , FROM_HOUR ASC" ))) {
		if (! ($stmt = $mysqli->prepare ( "SELECT * FROM employee_absence WHERE EMP_ID = ? AND DATE_ >= ? and not (DATE_ = ? AND TO_HOUR < ?) ORDER BY DATE_ ASC , FROM_HOUR ASC" ))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
		
		$mysqlStartdate = date ( "Y-m-d", $date );
		$mysqlStartTime = date ( "H:i:s", $date );
//		if (! $stmt->bind_param ( "iss", $employeeId, $mysqlStartdate, $mysqlStartTime )) {
		if (! $stmt->bind_param ( "isss", $employeeId, $mysqlStartdate,$mysqlStartdate, $mysqlStartTime )) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		if (! $stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		if (! ($result = $stmt->get_result ())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		$allEmployeeAbsences = [];
		try {
            while ($row = $result->fetch_object()) {
                $employeeAbsence = new EmployeeAbsence ($row->EMP_ID, $row->DATE_, $row->FROM_HOUR, $row->TO_HOUR, $row->ID);

                $allEmployeeAbsences [] = $employeeAbsence;
            }
        }catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
        finally
        {
            $mysqli->close ();
        }


		return $allEmployeeAbsences;
	}


	static function getEmployeeAbsenceByEmployeeIdAndDate($date, $employeeId) // 13-11-2017
{
//		$date = time ();
		$mysqli = SQLConnection::getConnection ();

//		if (! ($stmt = $mysqli->prepare ( "SELECT * FROM employee_absence WHERE EMP_ID = ? AND DATE_ >= ? AND FROM_HOUR > ? ORDER BY DATE_ ASC , FROM_HOUR ASC" ))) {
		if (! ($stmt = $mysqli->prepare ( "SELECT * FROM employee_absence WHERE EMP_ID=? AND DATE_=? ORDER BY FROM_HOUR" ))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}

		$mysqlDate = date ( "Y-m-d", $date );
//		$mysqlStartTime = date ( "H:i:s", $date );
//		if (! $stmt->bind_param ( "iss", $employeeId, $mysqlStartdate, $mysqlStartTime )) {
		if (! $stmt->bind_param ( "is", $employeeId, $mysqlDate)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}

		if (! $stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}

		if (! ($result = $stmt->get_result ())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}

		$allEmployeeAbsences = [];
		try {
            while ($row = $result->fetch_object()) {
                $employeeAbsence = new EmployeeAbsence ($row->EMP_ID, $row->DATE_, $row->FROM_HOUR, $row->TO_HOUR, $row->ID);

                $allEmployeeAbsences [] = $employeeAbsence;
            }
        }catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
        finally
        {
            $mysqli->close ();
        }


		return $allEmployeeAbsences;
	}

//20-11-2017
/*this function based on situation the the end of the working day is $toHour is a case $toHour is not the end of the day ,so it can missed  some appointments if there are appointmets after the $toHour and there is now enoug
time to set anew appointment*/
    static function getEmployeeAbsenceByDateAndFromHourToHour($employeeId, $date, $fromHour, $toHour)
    {
        $mysqli = SQLConnection::getConnection ();

        if (! ($stmt = $mysqli->prepare ( "SELECT * FROM employee_absence WHERE EMP_ID=? AND DATE_=? AND TO_HOUR BETWEEN ? AND ? ORDER BY FROM_HOUR
			" ))) {
            echo ("Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
        }

        $mysqldate = date ( "Y-m-d", $date );
        $mysqlFromHour = date ( "H:i:s", $fromHour );
        $mysqlToHour = date ( "H:i:s", $toHour );
        if (! $stmt->bind_param ( "isss", $employeeId, $mysqldate, $mysqlFromHour, $mysqlToHour )) {
            printToTerminal ( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error );
        }

        if (! $stmt->execute ()) {
            printToTerminal ( "Execute failed: (" . $stmt->errno . ") " . $stmt->error );
        }

        if (! ($result = $stmt->get_result ())) {
            printToTerminal ( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error );
        }

        $allEmployeeAbsences = [ ];
        try {
            while ( $row = $result->fetch_object () ) {
                $employeeAbsence = new EmployeeAbsence ( $row->EMP_ID, $row->DATE_, $row->FROM_HOUR, $row->TO_HOUR, $row->ID );

                $allEmployeeAbsences [] = $employeeAbsence;
            }
        } catch ( Exception $e ) {
            throw new Exception ( $e->getMessage () );
        } finally
        {
            $mysqli->close ();
        }

        return $allEmployeeAbsences;
    }
	
	/*
	 *
	 * static function getEmployeeAbsenceByEmployeeId($employeeId)//������ �� �� �������� �� ����� �� ��� ���� ����
	 * {
	 * $date=time();
	 * $mysqli = SQLConnection::getConnection();
	 *
	 * if (!($stmt = $mysqli->prepare("SELECT * FROM employee_absence WHERE EMP_ID = ? ORDER BY DATE_ ASC , FROM_HOUR ASC"))) {
	 * printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
	 * }
	 *
	 * // $mysqlStartdate = date ("Y-m-d", $date);
	 * // $mysqlStartTime = date ("H:i:s", $date);
	 * if (!$stmt->bind_param("i", $employeeId)) {
	 * printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
	 * }
	 *
	 * if (!$stmt->execute()) {
	 * printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
	 * }
	 *
	 * if (!($result = $stmt->get_result())) {
	 * printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
	 * }
	 *
	 *
	 * $allEmployeeAbsences=[];
	 * while ($row = $result->fetch_object())
	 * {
	 * $employeeAbsence = new EmployeeAbsence($row->EMP_ID, $row->DATE_,$row->FROM_HOUR,$row->TO_HOUR,$row->ID);
	 *
	 * $allEmployeeAbsences[]=$employeeAbsence;
	 * }
	 *
	 *
	 * $mysqli->close();
	 *
	 * return $allEmployeeAbsences;
	 * }
	 */
	static function createEmployeeAbsence(EmployeeAbsence $employeeAbsence) {
// 		// ������ ����� �� ���� ��� ����� ����� ������ (����� �� ���� ��� ���� "����" ������ �� ���� ����� "�� ���" ���� ����� ��� ���� ���� ����� ��� ���� ��� ����� �� ����� ���� 9 �� 10 ���� ����� ���� 10 �� 11 ��� ����� �� �10 ���� �� 11
// 		if (! EmployeeAbsenceDBDAO::checkIfEmployeeIsAbsent ( $employeeAbsence->getEmployeeId (), $employeeAbsence->getDate (), strtotime ( $employeeAbsence->getFromHour () ) + 1 ) && 
// 				! EmployeeAbsenceDBDAO::checkIfEmployeeIsAbsent ( $employeeAbsence->getEmployeeId (), $employeeAbsence->getDate (), strtotime ( $employeeAbsence->getToHour () ) )) // ****strtotime******************
		                                                                                                                                                                                                                                                                                                                                                    // !EmployeeAbsenceDBDAO::checkIfEmployeeIsAbsent($employeeAbsence->getEmployeeId(), $employeeAbsence->getDate(), strtotime($employeeAbsence->getToHour()) -1))//****strtotime******************
		// ������ ����� �� ���� ��� ����� ����� ������ (����� �� ���� ��� ���� "����" ������ �� ���� ����� "�� ���" ���� ����� ��� ���� ���� ����� ��� ���� ��� ����� �� ����� ���� 9 �� 10 ���� ����� ���� 10 �� 11 ��� ����� �� �10 ���� �� 11
		if (! EmployeeAbsenceDBDAO::checkIfEmployeeIsAbsent( $employeeAbsence->getEmployeeId (), $employeeAbsence->getDate (), strtotime ( $employeeAbsence->getFromHour () ) + 1, strtotime ( $employeeAbsence->getToHour()) - 1 ) )
			
				
				
		{
			$mysqli = SQLConnection::getConnection ();
			
			if (! ($stmt = $mysqli->prepare ( "INSERT INTO employee_absence (EMP_ID,DATE_,FROM_HOUR,TO_HOUR) VALUES (?,?,?,?)" ))) {
				printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
			}
			
			$employeeId = $employeeAbsence->getEmployeeId ();
			$date = date ( "Y-m-d", $employeeAbsence->getDate () );
			$fromHour = date ( "H:i:s",$employeeAbsence->getFromHour ()); // �� ��� ���� �� ���� ����� ���� ����� �� �� ����� ����� ������� ��������
			$toHour = date ( "H:i:s",$employeeAbsence->getToHour ());
			
			if (! $stmt->bind_param ( "isss", $employeeId, $date, $fromHour, $toHour )) {
				printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
			}
			
			if (! $stmt->execute ()) {
				printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			} else
				printToTerminal( "EmployeeAbsence created successfuly!!");
			$mysqli->close ();
		} else {
			throw new Exception ( "employee absence is already set with this hour" );
		}
	}
    static function createEmployeeAbsenceOnFullDay(EmployeeAbsence $employeeAbsence) //create EmployeeAbsence for employee on full day
    {
        $date=$employeeAbsence->getDate();
        $employeeId = $employeeAbsence->getEmployeeId ();
        $day = strtoupper(date("l", $date));
        $workhs = WorkHoursDBDAO::getEmployeeWorkHoursByDay($employeeId, $day);
        if (! EmployeeAbsenceDBDAO::checkIfEmployeeIsAbsent( $employeeAbsence->getEmployeeId (), $employeeAbsence->getDate (), strtotime ( $employeeAbsence->getFromHour () ) + 1, strtotime ( $employeeAbsence->getToHour()) - 1 ) )
        {
            $mysqli = SQLConnection::getConnection ();

            if (! ($stmt = $mysqli->prepare ( "INSERT INTO employee_absence (EMP_ID,DATE_,FROM_HOUR,TO_HOUR) VALUES (?,?,?,?)" ))) {
                printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
            }

            $dateSql = date ( "Y-m-d", $date );
            $fromHour = date ( "H:i:s",$workhs->getFromHour1());
            $toHour = date ( "H:i:s",$workhs->getFromHour2()?$workhs->getToHour2():$workhs->getToHour1());

            if (! $stmt->bind_param ( "isss", $employeeId, $dateSql, $fromHour, $toHour )) {
                printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
            }

            if (! $stmt->execute ()) {
                printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            } else
                printToTerminal( "EmployeeAbsence created successfuly!!");
            $mysqli->close ();
        } else {
            throw new Exception ( "employee absence is already set with this hour" );
        }
    }
	static function updateEmployeeAbsence(EmployeeAbsence $employeeAbsence) {
		$mysqli = SQLConnection::getConnection ();
		// �� ���� �� ���� �� ��� ������ ,�� �� ���� ���� ����� �� ������� ��� ,�� ����� ��� �� ������� emp_id ����� ������ �� ���� ���� �����
		if (! ($stmt = $mysqli->prepare ( "UPDATE employee_absence SET DATE_=? ,FROM_HOUR=?,TO_HOUR=? WHERE ID=?" ))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
		
		$id = $employeeAbsence->getId ();
		$date = date ( "Y-m-d", $employeeAbsence->getDate () );
		$fromHour = $employeeAbsence->getFromHour ();
		$toHour = $employeeAbsence->getToHour ();
		
		if (! $stmt->bind_param ( "sssi", $date, $fromHour, $toHour, $id )) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		if (! $stmt->execute ()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		printToTerminal( "EmployeeAbsence updated successfuly!!");
		$mysqli->close ();
	}
	static function deleteEmployeeAbsence($id) {
		$mysqli = SQLConnection::getConnection ();
		
		if (! ($stmt = $mysqli->prepare ( "DELETE FROM employee_absence WHERE ID=?" ))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
		
		if (! $stmt->bind_param ( "i", $id )) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		if (! $stmt->execute ()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		$rowsNum = $mysqli->affected_rows;
		
		// checks if rawsAffected is not equals to 1, if so this means that 0 rows affected or more than 1
		// if true handle result with suitable exception
		if ($rowsNum !== 1) {
			if ($rowsNum === 0) // ���� �� �� ���� ��� �� �� �� 0 �� ���� ���� ����
{
				// write Exception class for this exception
				throw new Exception ( "EmployeeAbsence does not exist!" );
			} else if ($rowsNum > 1) {
				// write to log
			}
		} else {
			printToTerminal( " <br/> EmployeeAbsence deleted successfuly!!");
		}
		
		$mysqli->close ();
	}
	static function deleteEmployeeAbsence_AccordingToEmployeeAndDate($employeeId, $date) // ���� �� �� ������ ���� ����� ����� ����� ��� ��� ���� ����� ����� �� ���� �����
{
		$mysqli = SQLConnection::getConnection ();
		
		if (! ($stmt = $mysqli->prepare ( "DELETE FROM employee_absence WHERE EMP_ID=? AND DATE_=?" ))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
		
		$mysqldate = date ( "Y-m-d", $date );
		
		if (! $stmt->bind_param ( "is", $employeeId, $mysqldate )) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		if (! $stmt->execute ()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		$rowsNum = $mysqli->affected_rows;
		
		// checks if rawsAffected is not equals to 1, if so this means that 0 rows affected or more than 1
		// if true handle result with suitable exception
		if ($rowsNum !== 1) {
			if ($rowsNum === 0) // ���� �� �� ���� ��� �� �� �� 0 �� ���� ���� ����
{
				// write Exception class for this exception
				throw new Exception ( "EmployeeAbsence does not exist!" );
			} else if ($rowsNum > 1) {
				// write to log
			}
		} else {
			printToTerminal( " <br/> EmployeeAbsence deleted successfuly!!");
		}
		
		$mysqli->close ();
	}
	static function checkIfEmployeeIsAbsent($employeeId, $date, $fromHour, $toHour) // ������� ������ �� ������� ��� ����� �� ��
{
		$isEmployeeAbsent = false;
		$mysqli = SQLConnection::getConnection ();
		
		if (! ($stmt = $mysqli->prepare ( "SELECT * FROM employee_absence WHERE ? AND ? BETWEEN FROM_HOUR AND TO_HOUR AND EMP_ID=? AND DATE_=?" ))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
		
		$mysqldate = date ( "Y-m-d", $date );
		$mysqlFromHour = date ( "H:i:s", $fromHour );
		$mysqlToHour = date ( "H:i:s", $toHour );
		
		if (! $stmt->bind_param ( "ssis", $mysqlFromHour, $mysqlToHour, $employeeId, $mysqldate )) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		if (! $stmt->execute ()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		if (! ($result = $stmt->get_result ())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		if ($result->num_rows !== 0) {
			$isEmployeeAbsent = true;
		}
		// var_dump($result);
		
		$mysqli->close ();
		
		return $isEmployeeAbsent;
	}
    static function checkIfEmployeeIsAbsentAllDay($employeeId, $date ) // check if employee are absent all day
    {
        $day = strtoupper(date("l", $date));
        $workhs = WorkHoursDBDAO::getEmployeeWorkHoursByDay($employeeId, $day);

        $isEmployeeAbsent = false;
        $mysqli = SQLConnection::getConnection ();

        if (! ($stmt = $mysqli->prepare ( "SELECT * FROM employee_absence WHERE ? AND ? BETWEEN FROM_HOUR AND TO_HOUR AND EMP_ID=? AND DATE_=?" ))) {
            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
        }

        $mysqldate = date ( "Y-m-d", $date );
//        $mysqlFromHour = date ( "H:i:s", $fromHour );
//        $mysqlToHour = date ( "H:i:s", $toHour );
        $mysqlFromHour = $workhs->getFromHour1();
        $mysqlToHour = $workhs->getToHour2()?$workhs->getToHour2():$workhs->getToHour1();

        if (! $stmt->bind_param ( "ssis", $mysqlFromHour, $mysqlToHour, $employeeId, $mysqldate )) {
            printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        if (! $stmt->execute ()) {
            printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        if (! ($result = $stmt->get_result ())) {
            printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        if ($result->num_rows !== 0) {
            $isEmployeeAbsent = true;
        }
        // var_dump($result);

        $mysqli->close ();

        return $isEmployeeAbsent;
    }
	static function checkIfEmployeeIsAbsentInThisDate($date, $employeeId) // ������� ������ �� ������� ����� ������ ���� ����� �� �� ���� �� ������ ����� �� ����� ���� �����
{ // ������ ����� ��� ���� �� ����� ������ ����� ����� ������� ������� ����� ������ ���� ��� ���� ���� ��� ������ ����� ���� ������
		$isEmployeeAbsent = false;
		$mysqli = SQLConnection::getConnection ();
		
		if (! ($stmt = $mysqli->prepare ( "SELECT * FROM employee_absence WHERE EMP_ID=? AND DATE_=?" ))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
		
		$mysqldate = date ( "Y-m-d", $date );
		
		if (! $stmt->bind_param ( "is", $employeeId, $mysqldate )) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		if (! $stmt->execute ()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		if (! ($result = $stmt->get_result ())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		// printToTerminal( $result->num_rows;
		if ($result->num_rows !== 0) {
			$isEmployeeAbsent = true;
		}
		// var_dump($result);
		
		$mysqli->close ();
		
		return $isEmployeeAbsent;
	}
}
