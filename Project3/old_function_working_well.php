<?php
// ************************************************************************************************************************************************
class general {
	static function getFirst20AvailableAppointments($employeeId, $date = false) // SELF ������ ������� getPossibleAppointmentsList_ByDay ����� ����� �� ������ �������� ��
{
		$firstCall = false;
		
		if ($date == false) // �� �� ����� ����� ��� ����� ������ ��� ���� �� ������ �������� ��� ���� �� ���� ���� ����
{
			$date = time (); // ����� ����� �� �� ������ ���� ������
			                // print date('H:i:s',$date);
			
			$firstCall = true;
		} else if ($date < time ()) {
			throw new Exception ( "FUCK YOU HACKER!" );
		}
		
		$allEmpWorkHours = WorkHoursDBDAO::getAllEmpWorkHours ( $employeeId );
		
		foreach ( $allEmpWorkHours as $singleDay ) {
			$possibleAppointmentsList [$singleDay->getDay ()] = self::getPossibleAppointmentsList_ByDay ( $singleDay ); // ����� ��� ����� �� �� ������ �������� �� ���� ������� ����� ����
		}
		
		// else //$openingHours = OpeningHoursDBDAO::getAllOpeningkHours();
		
		$listIndex = 0;
		$first20availablAppList = [ ];
		while ( $listIndex < 20 ) {
			
			$strTime = date ( 'H:i:s', $date );
			$strDate = date ( 'd-m-Y', $date );
			$strDay = strtoupper ( date ( 'l', strtotime ( $strDate ) ) ); // ���� �� ������ ���� ����� ��� ���� �� ����� ���
			
			$FullyBooked = new FullyBookedDate ( $date, $employeeId );
			if (! FullyBookedDateDBDAO::checkIfFullyBooked ( $FullyBooked )) {
				
				for($j = 0; $j < count ( $possibleAppointmentsList [$strDay] ); $j ++) // �� ��� ���� ��� ���� ���� �� ������ ��� ���� �� �� �������� ����
{
					
					$possibleHourFromAppointmentList = $possibleAppointmentsList [$strDay] [$j];
					print ("J=No" . $j . "</br>") ;
					if ($firstCall) {
						$hourFromList = date ( 'Hi', strtotime ( $possibleHourFromAppointmentList ) );
						$timeNow = date ( 'Hi', strtotime ( $strTime ) );
						// echo intval ( $hourFromList ) . " " . intval ( $timeNow ) . "</br>";
						if (intval ( $hourFromList ) < intval ( $timeNow )) {
							print ("Time has already passed-" . $possibleHourFromAppointmentList . "</br>") ;
							// $j++;
							// break ;
						} else {
							$firstCall = false;
							$message = "it's the current hour   " . $hourFromList;
							echo "<script type='text/javascript'>alert('$message');</script>";
							$j --;
						}
					} else {
						
						// print("siudfhvsierfvhjslfirvghsldfiuhvsoiduhosiuhfsdf</br>");
						$appointment = new Appointment ( strtotime ( $strDate ), $possibleHourFromAppointmentList, "", $employeeId, "" );
						// print($possibleAppointmentsList[$strDay][$j]."</br>");
						// echo $listIndex."<br/>"; // ����� �� ������� ������
						// var_dump($appointment);
						// var_dump ( $appointment );
						if (AppointmentDBDAO::checkAppointmentAvailability ( $appointment )) {
							// echo '<script type="text/javascript">alert("Data has been submitted to ' . $i . '");</script>';
							$first20availablAppList [] = $appointment;
							
							$listIndex ++; // add 1 to listIndex if appointment available
						}
						// var_dump($appointment);
						
						if ($listIndex >= 20)
							break;
					}
				}
			}
			
			// �� ����� ���� ����� ������� ���� �����
			if ($listIndex < 20) // �� ���� ����� ����� �� ��� ���� �� ����� ����� ����� ��� ����� ��� ��� ���� �� ������ �����
{
				$date += 24 * 60 * 60;
			}
			// ���� ����� ������� ������ ���� ����� ������ ������ ����� ���,����� ������� ���� �� ���� ������
			// , ��� ������ ����� ������ ������ �� ������ ����, false���� firstCall ����� ���� ��� ����� �
			// ���� ��� ����� ����� ��� ����� ��� �� ���� �� ��� ���� ���� ������
			// ����� �� ���� listIndex ��� ����� ����� ������ ��� ����� �� ���� ���� ������ ���� ������� ��� ������� ��������
			if (date ( 'j', $date ) != date ( 'j', time () ))
				$firstCall = false;
		}
		
		return $first20availablAppList;
	}
	// 13.4.2017
	// �������� ������ ����� ������� �� ����� ����� ���� ����� ��� ������ 20 ����� ������ ���� ��� ����� �������
	// old_function_working_well.php ������� ������ ����� ����� ������ �
	static function getFirst20AvailableAppointments1($employeeId, $date = false) // SELF ������ ������� getPossibleAppointmentsList_ByDay ����� ����� �� ������ �������� ��
{
		$firstCall = false;
		
		if ($date == false) // �� �� ����� ����� ��� ����� ������ ��� ���� �� ������ �������� ��� ���� �� ���� ���� ����
{
			$date = time (); // ����� ����� �� �� ������ ���� ������
			$firstCall = true;
		} else if ($date < time ()) {
			throw new Exception ( "FUCK YOU HACKER!" );
		}
		
		$allEmpWorkHours = WorkHoursDBDAO::getAllEmpWorkHours ( $employeeId );
		
		foreach ( $allEmpWorkHours as $singleDay )
			$possibleAppointmentsList [$singleDay->getDay ()] = self::getPossibleAppointmentsList_ByDay ( $singleDay ); // ����� ��� ����� �� �� ������ �������� �� ���� ������� ����� ����
		
		$listIndex = 0;
		$first20availablAppList = [ ];
		while ( $listIndex < 20 ) {
			
			$strTime = date ( 'H:i:s', $date );
			$strDate = date ( 'd-m-Y', $date );
			$strDay = strtoupper ( date ( 'l', $date ) ); // ���� �� ������ ���� ����� ��� ���� �� ����� ���
			
			$FullyBooked = new FullyBookedDate ( $date, $employeeId );
			if (! FullyBookedDateDBDAO::checkIfEmplooyeeDayIsFullyBooked ( $FullyBooked )) {
				for($j = 0; $j < count ( $possibleAppointmentsList [$strDay] ); $j ++) // �� ��� ���� ��� ���� ���� �� ������ ��� ���� �� �� �������� ����
{
					$Hour_FromPossibleAppointmentList = $possibleAppointmentsList [$strDay] [$j];
					print ("J=No" . $j . "---------" . $Hour_FromPossibleAppointmentList . "</br>") ;
					if ($firstCall) {
						if (strtotime ( $Hour_FromPossibleAppointmentList ) < time ())
							print ("Time has already passed-" . $Hour_FromPossibleAppointmentList . "</br>") ;
						else {
							$firstCall = false;
							$j --;
						}
					} else { // $appointment = new Appointment ($date, $Hour_FromPossibleAppointmentList, "", $employeeId, "" );
						$appointment = new Appointment ( $date, strtotime ( ABSOLUTE_HOUR . $Hour_FromPossibleAppointmentList ), "", $employeeId, "" );
						if (AppointmentDBDAO::checkAppointmentAvailability ( $appointment )) {
							$first20availablAppList [] = $appointment;
							$listIndex ++; // add 1 to listIndex if appointment available
						}
						
						if ($listIndex >= 20)
							break;
					}
				}
			}
			
			// �� ����� ���� ����� ������� ���� �����
			if ($listIndex < 20) // �� ���� ����� ����� �� ��� ���� �� ����� ����� ����� ��� ����� ��� ��� ���� �� ������ �����
				$date += 24 * 60 * 60;
				
				// ���� ����� ������� ������ ���� ����� ������ ������ ����� ���,����� ������� ���� �� ���� ������
				// , ��� ������ ����� ������ ������ �� ������ ����, false���� firstCall ����� ���� ��� ����� �
				// ���� ��� ����� ����� ��� ����� ��� �� ���� �� ��� ���� ���� ������
				// ����� �� ���� listIndex ��� ����� ����� ������ ��� ����� �� ���� ���� ������ ���� ������� ��� ������� ��������
			if (date ( 'j', $date ) != date ( 'j', time () ))
				$firstCall = false;
		}
		$newDate = date ( 'y-m-d H:i:s', $date );
		return $first20availablAppList;
	}
	// //////////////////////////////////������ 13.4.2017 commonAction ����� � ///////////////////////////
	static function getFirst20AvailableAppointmentsFromAllEmployees() // $sort='random'//or priority)
{
		// ����� �������� ������ ������ ������ �� ������ ��� ��� ����� ��� �� ���� �����
		$priority = 0; // ������ �� ������
		$allAppointments = [ ]; // �� ������ �� �� �������
		$employeesArr = EmployeeDBDAO::getAllEmployees ();
		for($i = 0; $i < count ( $employeesArr ); $i ++) {
			$allAppointments [$employeesArr [$i]->getId ()] = self::getFirst20AvailableAppointments ( $employeesArr [$i]->getId () );
			// $allAppointments[]=self::getFirst20AvailableAppointments($employeesArr[$i]->getId());
		}
		foreach ( $allAppointments as $value ) // ����� ���� ���� ��� �� ������� �� ������� ��� �������
			foreach ( $value as $innerValue )
				$allAppointments2 [] = $innerValue;
		
		$arr = [ ];
		$arr2 = [ ];
		sort ( $allAppointments2 );
		foreach ( $allAppointments2 as $appintment ) {
			
			$arr [$appintment->getAppointmentDate ()] [] = $appintment;
			$arr2 [$appintment->getAppointmentDate ()] [$appintment->getAppointmentTime ()] [] = $appintment;
		}
		// var_dump($arr2);
		// echo "<br/><br/><br/><br/> arr finnish";
		foreach ( $arr2 as $value )
			var_dump ( $value );
			
			// if ($sort==='priority')
			// {
			
		// }
			// $priority=[3,2,4];
		
		$arr3 = [ ];
		
		// foreach ($arr2 as $value)
		// {
		
		// foreach ($value as $innerValue )
		// {
		
		// foreach ($innerValue as $innerinner)
		// {
		// switch ($innerinner->getEmployeeId())
		// {
		// case :
		// }
		// // if ($innerinner->getEmployeeId()==4)
		// // $arr3[]=$innerinner;
		
		// //var_dump($innerinner);
		// }
		// }
		
		// }
		
		return 'end ';
	}
	static function getFirst20AvailableAppointmentsFromAllEmployees_2() // $sort='random'//or priority)
{
		$date = time ();
		// ����� �������� ������ ������ ������ �� ������ ��� ��� ����� ��� �� ���� �����
		$priority = 0; // ������ �� ������
		$allAppointments = [ ]; // �� ������ �� �� �������
		$employeesArr = EmployeeDBDAO::getAllEmployees ();
		for($i = 0; $i < count ( $employeesArr ); $i ++) {
			$allAppointments [$employeesArr [$i]->getId ()] = self::getAllEmployeesAvailableHoursInDay ( $date );
			// $allAppointments[]=self::getFirst20AvailableAppointments($employeesArr[$i]->getId());
		}
		foreach ( $allAppointments as $value ) // ����� ���� ���� ��� �� ������� �� ������� ��� �������
			foreach ( $value as $innerValue )
				$allAppointments2 [] = $innerValue;
		
		$arr = [ ];
		$arr2 = [ ];
		sort ( $allAppointments2 );
		foreach ( $allAppointments2 as $appintment ) {
			
			$arr [$appintment->getAppointmentDate ()] [] = $appintment;
			$arr2 [$appintment->getAppointmentDate ()] [$appintment->getAppointmentTime ()] [] = $appintment;
		}
		// var_dump($arr2);
		// echo "<br/><br/><br/><br/> arr finnish";
		foreach ( $arr2 as $value )
			var_dump ( $value );
			
			// if ($sort==='priority')
			// {
			
		// }
			// $priority=[3,2,4];
		
		$arr3 = [ ];
		
		// foreach ($arr2 as $value)
		// {
		
		// foreach ($value as $innerValue )
		// {
		
		// foreach ($innerValue as $innerinner)
		// {
		// switch ($innerinner->getEmployeeId())
		// {
		// case :
		// }
		// // if ($innerinner->getEmployeeId()==4)
		// // $arr3[]=$innerinner;
		
		// //var_dump($innerinner);
		// }
		// }
		
		// }
		
		return $allAppointments;
	}
	static function getFirst20AvailableAppointmentsFromAllEmployees_3() // $sort='random'//or priority)
{
		// ����� �������� ������ ������ ������ �� ������ ��� ��� ����� ��� �� ���� �����
		$priority = 0; // ������ �� ������
		$allAppointments = [ ]; // �� ������ �� �� �������
		$employeesArr = EmployeeDBDAO::getAllEmployees ();
		for($i = 0; $i < count ( $employeesArr ); $i ++) {
			$allAppointments [$employeesArr [$i]->getId ()] = self::getFirst20AvailableAppointments ( $employeesArr [$i]->getId () );
			// $allAppointments[]=self::getFirst20AvailableAppointments($employeesArr[$i]->getId());
		}
		foreach ( $allAppointments as $value ) // ����� ���� ���� ��� �� ������� �� ������� ��� �������
			foreach ( $value as $innerValue )
				$allAppointments2 [] = $innerValue;
		
		$arr = [ ];
		$arr2 = [ ];
		sort ( $allAppointments2 );
		foreach ( $allAppointments2 as $appintment ) {
			
			$arr [$appintment->getAppointmentDate ()] [] = $appintment;
			$arr2 [$appintment->getAppointmentDate ()] [$appintment->getAppointmentTime ()] [] = $appintment;
		}
		// var_dump($arr2);
		// echo "<br/><br/><br/><br/> arr finnish";
		// foreach ($arr2 as $value)
		// var_dump($value);
		
		// if ($sort==='priority')
		// {
		
		// }
		// $priority=[3,2,4];
		
		// $arr3=[];
		
		foreach ( $arr2 as $value ) {
			
			foreach ( $value as $innerValue ) {
				
				foreach ( $innerValue as $innerinner ) {
					// switch ($innerinner->getEmployeeId())
					// {
					// case :
					// }
					if ($innerinner->getEmployeeId () == 4)
						$arr3 [] = $innerinner;
					
					// var_dump($innerinner);
				}
			}
		}
		
		return $arr2;
	}
	
	// /////////////////////////////////////////////////////////////////////////////////////////////////
	static function getAllEmployeesAbsence() // ������ ����� �� ������� ���� ���� �� �����
{ // �� ���� ����� ��� �� ���� ��� ���� ��� ��� �� ������� �����
		$AllAbsences = [ ];
		$employeesList = EmployeeDBDAO::getAllEmployees ();
		// var_dump($employeesList);
		foreach ( $employeesList as $employee ) {
			$employeeId = $employee->getId ();
			$AllAbsences [$employee->getName ()] = self::getEmployeeAbsenceByEmployeeId ( $employeeId );
		}
		
		return $AllAbsences;
	}
	// //////////////////////////////////////////////////////////////////////
	
	//mangerAction
	static function setFullDayEmployeeAbsence($date, $employeeId, $deleteAppointmentConfirmation=false ,$comment=false)
	{
		if(!EmployeeAbsenceDBDAO::checkIfEmployeeIsAbsentInThisDate($date, $employeeId))//�� �� ��� ������ ����� ���� ����� ���� ����� ������ ��� ����� �� ������ �� ��� ���� ����� �� ������� ������ ������� ����� ������ �� �� ����
		{
	
			try
			{
				$day= date('l',$date);
				$workingHours=WorkHoursDBDAO::getEmployeeWorkHoursByDay($employeeId,$day);
				var_dump($workingHours);
				$fromHour=$workingHours->getFromHour1();
				$toHour=$workingHours->getFromHour2()==false?$workingHours->getToHour1():$workingHours->getToHour2();
				echo $toHour;
				$employeeAbsence=new EmployeeAbsence($employeeId, $date, $fromHour, $toHour);
				EmployeeAbsenceDBDAO::createEmployeeAbsence($employeeAbsence);
				//��� ����� ����� ���� ����� ����� ����������
				$appintmentToCancel=AppointmentDBDAO::getAllEmployeeAppointments_byDate($date, $employeeId);
				if ($appintmentToCancel)
				{
					if($deleteAppointmentConfirmation){
						foreach ($appintmentToCancel as $appiontment)
						{
	
							// 						commonActions::cancelAppointment($appiontment->getId());
							managerActions::cancelAppointment($appiontment, $comment);
	
						}
					}
					else {
	
						throw new Exception("ikwegfausdyfgosiufhifhsiduf");
					}
				}
	
					
	
			}
			catch(Exception $e)
			{
				//���� ��� ������� ����� ��������� ����� ��� ���� ����_�����
			}
		}
		else
		{
			throw new Exception("values already exist in that day");
		}
	}
	
	
}
