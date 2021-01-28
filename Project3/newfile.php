<?php

class check 
{
	
	static function getFullyBookedDate_ID($date,$employeeId)// FullyBooked �� ����� ����� ID �������� ������
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT ID FROM fully_booked_date WHERE EMP_ID = ? AND DATE_=?"))) {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
	
		$mysqldate = date ("Y-m-d", $date);
	
		if (!$stmt->bind_param("is", $employeeId,$mysqldate)) {
			echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}
	
		if (!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		}
	
		if (!($result = $stmt->get_result())) {
			echo "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error;
		}
	
	
		$row = $result->fetch_object();
	
	
		// 		$fullyBookedDate = new FullyBookedDate($row->DATE_,$row->EMP_ID,$row->ID);
		$fullyBookedDateID = $row->ID;
	
		$mysqli->close();
	
		// 		return $fullyBookedDate->getId();
	
		return $fullyBookedDateID;
	}
	
	
	//*****************************************************************************************************************
	//�� ����� ������ ������� �� ���� ��� ���� ����� �� ��� ���� ����� �� ��� ����� �� �� ����� ���� �� ����� �������
	function allEmployeeAvailableHoursInDay_2($date,$employeeId )//������� ������� �� �� ������ ������� �� ���� ������ ������
	{
		$currentDateIsChecked=date ( 'j m y', $date ) == date ( 'j m y', time () );
		$availableAppointment=[];
		$FullyBooked = new FullyBookedDate ( $date, $employeeId );
		if (! FullyBookedDateDBDAO::checkIfFullyBooked ( $FullyBooked ))
		{
			$day=strtoupper(date('l',$date));
			$possibleHourtList =WorkHoursDBDAO::getEmployeeWorkHoursByDay($employeeId, $day);//���� ������� �� �� ���� ������ �� ����� ����� ����
			$arr=commonActions::getPossibleAppointmentsList_ByDay($possibleHourtList);// ���� ����� �� ������ �������� ���� ������
	
			for ($i=0;$i<count($arr);$i++)
			{
				$app= new Appointment($date, $arr[$i], null, $employeeId, null);
				if (AppointmentDBDAO::checkAppointmentAvailability($app))
					$availableAppointment[]=$app;
	
			}
		}
		else return $availableAppointment;
	
	
		return $availableAppointment;// false �� ����� ��� �����
	
	}
}


