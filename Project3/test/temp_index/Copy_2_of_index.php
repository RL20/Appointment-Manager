<?php
// // ����� �� ��� ������ �� ��
require_once 'requires.php';
function getFirst20AvalableApp($date, $EMP_ID = false) {
	
	// if(workinghors.sunday1=)
}

// EmployeeWorkHours(2);// EmployeeWorkHours ����� �������� /�����
function appointmentHandle($EMP_ID, $date) // EMP_ID ������� ������ ����� ��� ����� �
{
}
function checkEmployeeWorkHours($EMP_ID, $date, $hour) // ������� ������ ���� ����� �� ���� ��� ��� ����� ,������ ������ ������ ������ ���� �����
{
	// �� ������ �� �������� ***************************************
	$dateCovert = date_create_from_format ( 'd-m-Y', $date );
	$day = $dateCovert->getTimestamp ();
	$dayTextual = strtoupper ( date ( 'l', $day ) );
	$employeeWorkingHours = WorkHoursDBDAO::getAllEmpWorkHours ( $EMP_ID );
	
	foreach ( $employeeWorkingHours as $value ) {
		
		if ($value->getDay () == $dayTextual) {
			echo "$dayTextual it is day i am working<br/>";
			$start1 = $value->getFromHour1 ();
			$end1 = $value->getToHour1 ();
			
			$start2 = $value->getFromHour2 ();
			$end2 = $value->getToHour2 ();
			
			$hourCovert = strtotime ( $hour );
			echo $hourCovert;
			echo date ( 'd-m-Y', $hourCovert );
			// $hourTimeStamp=$hourCovert->getTimestamp();
		}
	}
	// checkEmployeeWorkHours(2, '22-12-2016', '8:00'); // checkEmployeeWorkHours ����� ��������
}
function getAvailableDaysInMonth($year, $month, $employeeId = false) // ������� ������� �� ����� ���� �� ����� ��� ��� ���� ����� �����
{
	$numberOfDaysInMonth = cal_days_in_month ( CAL_GREGORIAN, $month, $year ); // ��� ���� �� ����� �����
	                                                                           
	// $possibleAppointmentsList = [];
	
	if ($employeeId !== false) {
		$allEmpWorkHours = WorkHoursDBDAO::getAllEmpWorkHours ( $employeeId );
		
		foreach ( $allEmpWorkHours as $singleDay ) {
			
			// $day = $singleDay->getDay();
			
			$possibleAppointmentsList [$singleDay->getDay ()] = getPossibleAppointmentsList_ByDay ( $singleDay ); // ����� ��� ����� �� �� ������ �������� �� ���� ������� ����� ����
		}
		// var_dump($possibleAppointmentsList);
	}
	// else //$openingHours = OpeningHoursDBDAO::getAllOpeningkHours();
	$index = 1;
	// $i = ���� ���� ���� ������ ����� ������ ������ ��� ����� ������
	$presentDayinCurrentMonth = date ( 'j', time () );
	if ($month == date ( 'm', time () ) && $year == date ( 'Y', time () ))
		$i = ( int ) $presentDayinCurrentMonth;
	else
		$i = 1;
		// var_dump($possibleAppointmentsList);
	for($i; $i <= $numberOfDaysInMonth; $i ++) // ������ �� ����� ����� $i
{
		$strDate = $i . '-' . $month . '-' . $year;
		$strDay = strtoupper ( date ( 'l', strtotime ( $strDate ) ) ); // ���� �� ������ ���� ����� ��� ���� �� ����� ���
		                                                               // print($strDay."<br/>");
		                                                               // $possibleAppointmentsList[$strDay][];
		$isAppAvailable = false;
		$j = 0;
		while ( ! $isAppAvailable ) // �� ��� ���� ��� ���� ���� �� ������ ��� ���� �� �� �������� ����
{
			if ($j >= count ( $possibleAppointmentsList [$strDay] )) // ���� �� ������� ������ �������� ����� ���� ������ ���� ���� ��� �������
{
				break;
			}
			
			$appointment = new Appointment ( strtotime ( $strDate ), $possibleAppointmentsList [$strDay] [$j], "", $employeeId, "" );
			// print($possibleAppointmentsList[$strDay][$j]."</br>");
			if (AppointmentDBDAO::checkAppointmentAvailability ( $appointment )) {
				// echo '<script type="text/javascript">alert("Data has been submitted to ' . $i . '");</script>';
				$availableDaysList [] = $i;
				$isAppAvailable = true;
			}
			print ($index ++) ;
			var_dump ( $appointment );
			
			$j ++;
		}
	}
	
	return $availableDaysList;
}
function getPossibleAppointmentsList_ByDay(WorkHours $singleDay) // ����� ��� ����� �� �� ������ �������� �� ���� ������� ����� ����
{
	// $possibleAppointmentsList is the argument from the function's caller
	// $possibleAppointmentsList;
	
	// ���� �� ������ ��������� ������
	$day = $singleDay->getDay ();
	// $possibleAppointmentsList[$day][];
	
	$start1 = $singleDay->getFromHour1 ();
	$end1 = $singleDay->getToHour1 ();
	
	$start2 = $singleDay->getFromHour2 ();
	$end2 = $singleDay->getToHour2 ();
	
	// set the first hour (the hour that the worker starts working)
	$currentRunHour = $start1;
	
	// $possibleAppointmentsList[$day]; ����� ��� ���� ����� ����� ������ ��� ��� ����
	
	// runs untill it gets to $end1 - which is the worker's end of the day or a lunch break
	while ( $currentRunHour !== $end1 ) {
		// insert $currentRunHour to the list a the specified day
		$possibleAppointmentsList [] = $currentRunHour;
		// convert the $currentRunHour which is a string to Long
		$timeFromStr = strtotime ( $currentRunHour );
		// add 15 minutes
		$timeFromStr += 900; // ���� ��� �� 15 ���� ������ ���� ����� � �������
		                     // sets the value back to $currentRunHour
		$currentRunHour = date ( "H:i:s", $timeFromStr ); // ���� �� �� ���� �������
	}
	
	// checks if $start2 is not null - which means worker has a lunch break or split working day
	if (isset ( $start2 )) {
		// the same as the whlie loop above^^
		$currentRunHour = $start2;
		while ( $currentRunHour !== $end2 ) {
			$possibleAppointmentsList [] = $currentRunHour;
			$timeFromStr = strtotime ( $currentRunHour );
			$timeFromStr += 900;
			$currentRunHour = date ( "H:i:s", $timeFromStr );
		}
	}
	
	// returns the list
	return $possibleAppointmentsList;
}

// $singleday = WorkHoursDBDAO::getEmployeeWorkHoursByDay(3, "SUNDAY");
// $possibleAppointmentsListt = null;
// $possibleAppointmentsListt = getPossibleAppointmentsList_ByDay($possibleAppointmentsListt,$singleday);
// for($i = 0; $i<count($possibleAppointmentsListt["SUNDAY"]); $i++)
// {
// //echo '<script type="text/javascript">alert("Data has been submitted to ' . $possibleAppointmentsListt["SUNDAY"][$i] . '");</script>';
// $sqlTime = strtotime($possibleAppointmentsListt["SUNDAY"][$i]);
// $appointment = new Appointment(1484438400, $sqlTime, 68, 3, "jhgf");
// AppointmentDBDAO::createAppointment($appointment);
// }

/* var_dump(getAvailableDaysInMonth("2017","01",2)); */

/*
 * $appointment = new Appointment(1484438400, "10:30:00", "", 3, "");
 * // print($possibleAppointmentsList[$strDay][$j]."</br>");
 * $bool = AppointmentDBDAO::checkAppointmentAvailability($appointment);
 *
 * // echo '<script type="text/javascript">alert("' . $bool. '");</script>';
 *
 */

// $appointment= new Appointment("2016-12-20","2016-12-20 09:30:00", 56, 4, 'bldfvdfibli');
// $result = AppointmentDBDAO::checkAppointmentAvailability($appointment);
// echo $result;

// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// /////////////////////////�������� �����! �� ����� ��� ����� ������ ���� ����� ������ ����� ���� �� ���� �� ���� ����� �� ���� "1" ���� ���� ��� �"���" �
// //////////////////////////��� ����� ������ ��� ��� ������� ���� ����� �� �� ����� ������ �����
// /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// *******************************************************************************************************************************************
function getFirst20AvailableAppointments($date = false, $employeeId = false) 
{
	
	$firstCall = false;
	
	
	if ($date == false) {
		$date = time ();
		$firstCall = true;
		// print($date);
	}
	
	// $month=(int)date('j',$date);
	// $year=(int)date('y',$date);
	// $numberOfDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $month,$year);// ��� ���� �� ����� �����
	
	if ($employeeId !== false) {
		$allEmpWorkHours = WorkHoursDBDAO::getAllEmpWorkHours ( $employeeId );
		
		foreach ( $allEmpWorkHours as $singleDay ) {
			$possibleAppointmentsList [$singleDay->getDay ()] = getPossibleAppointmentsList_ByDay ( $singleDay ); // ����� ��� ����� �� �� ������ �������� �� ���� ������� ����� ����
		}
		
		// else //$openingHours = OpeningHoursDBDAO::getAllOpeningkHours();
		
		$listIndex = 0;
		$first20availablAppList = [ ];
		while ( $listIndex < 20 ) {
			
			$strTime = date ( 'H:i:s', $date );
			$strDate = date ( 'd-m-Y', $date );
			$strDay = strtoupper ( date ( 'l', strtotime ( $strDate ) ) ); // ���� �� ������ ���� ����� ��� ���� �� ����� ���
			
			for($j = 0; $j < count ( $possibleAppointmentsList [$strDay] ); $j ++) // �� ��� ���� ��� ���� ���� �� ������ ��� ���� �� �� �������� ����
{
	           
				
				$appointment = new Appointment( strtotime ( $strDate ), $possibleAppointmentsList [$strDay] [$j], "", $employeeId, "" );
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
			
			if ($listIndex < 20) {
				$date += 24 * 60 * 60;
			}
		}
		
		return $first20availablAppList;
	}
}
// $wed = getFirst20AvailableAppointments ( false, 3 );
// getFirst20AvailableAppointments ( $wed [20]->getAppointmentDate (), $wed [20]->getEmployeeId () );
// getFirst20AvailableAppointments ( $wed [20]->getAppointmentDate (), $wed [20]->getEmployeeId () );

var_dump ( getFirst20AvailableAppointments ( false, 3 ) );

// var_dump(getAvailableDaysInMonth("2017","01",2));

// $strDate = date ("Y-m-d", time()+(24*60*60)*2);
// $strDay = strtoupper ( date('l', strtotime ($strDate)));

// $singleDay = WorkHoursDBDAO::getEmployeeWorkHoursByDay(3, $strDay);
// $list = getPossibleAppointmentsList_ByDay($singleDay);
// var_dump($list);
// $i = 0;

// while(count($list) !== $i)
// {
// print($list[$i]);
// $d= new Appointment(strtotime($strDate) ,strtotime($strDate . $list[$i]), 55, 3, 'blibli');
// AppointmentDBDAO::createAppointment($d);
// $i++;
// }
?>