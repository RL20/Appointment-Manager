<?php
/*
function testallemployees20app($date = false) {
	$allEmployeesList = EmployeeDBDAO::getAllEmployees ();
	
	$listIndex = 0;
	$first20availablAppList = [ ];
	while ( listIndex < 20 ) {//��� ����� - ���
		for($i = 0; $i < count ( $allEmployeesList ); $i ++) {//��� ����
			$employeeId = $allEmployeesList [$i]->getId ();
			$fullyBookedDate = new FullyBookedDate ( $date, $employeeId ); // long ���� � date ��������
			if (! FullyBookedDateDBDAO::checkIfFullyBooked ( $fullyBookedDate )) {
				$singleDay = WorkHoursDBDAO::getEmployeeWorkHoursByDay($employeeId, $day);
				$possibleAppointmentsList = commonActions::getPossibleAppointmentsList_ByDay ( $singleDay );
				for($j = 0; $j < count ( $possibleAppointmentsList ); $j ++) //��� ���� �������
                {
					
					$possibleHourFromAppointmentList = $possibleAppointmentsList [$j];
					print ("J=No" . $j . "</br>") ;
					if ($firstCall) {
						$hourFromList = date ( 'Hi', strtotime ( $possibleHourFromAppointmentList ) );
						$timeNow = date ( 'Hi', strtotime ( $strTime ) );
						echo intval ( $hourFromList ) . "       " . intval ( $timeNow ) . "</br>";
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
					} 
					else {
						
						// print("siudfhvsierfvhjslfirvghsldfiuhvsoiduhosiuhfsdf</br>");
						$appointment = new Appointment( strtotime ( $strDate), $possibleHourFromAppointmentList, "", $employeeId, "" );
						// print($possibleAppointmentsList[$strDay][$j]."</br>");
						// echo $listIndex."<br/>"; // ����� �� ������� ������
						// var_dump($appointment);
						// var_dump ( $appointment );
						if (AppointmentDBDAO::checkAppointmentAvailability ( $appointment )) {
							// echo '<script type="text/javascript">alert("Data has been submitted to ' . $i . '");</script>';
							$listStrKey = "". $appointment->getAppointmentDate().$appointment->getAppointmentTime();
							$list = $first20availablAppList [$listStrKey];
							if(!isset($list))
							{
							 $first20availablAppList [$listStrKey] = $appointment;
							}
							else
							{
								$first20availablAppList [$listStrKey] = [$first20availablAppList [$listStrKey]];
							}
							$listIndex ++; // add 1 to listIndex if appointment available
						}
						// var_dump($appointment);
						
						if ($listIndex >= 20)
							break;
					}
				}
			} 

			else 
			{
				$firstCall = false;
			}
			
			// �� ����� ���� ����� ������� ���� �����
			if ($listIndex < 20) // �� ���� ����� ����� �� ��� ���� �� ����� ����� ����� ��� ����� ��� ��� ���� �� ������ �����
            {
				$date += 24 * 60 * 60;
			}
		}
	}
}
//***************************************************************

$arr=[];

for($i = 0; $i<10; $i++)
{
	if(!isset($arr[0]))
	{
		$arr[0] = "bla";
		$first=true;

	}
	else
	{
		if ($first)
		{
			$arr[0]=[ $arr[0]];
			$first=false;
		}
		else $arr[0][]="bla";
		 
		 
		 
		 
	}

}

// $arr[1]=
// $arr[0][]=
//echo $arr[0][0];
var_dump($arr);

**/

//
//function($serviceTypeIdArr)
//{
//    "SELECT distinct service_type.SERVICE_NAME, service_type.DURATION, service_type.ID FROM service_type INNER JOIN employee_service_type ON employee_service_type.SERVICE_TYPE_ID=service_type.ID WHERE service_type.ID in (1,2) AND employee_service_type.EMP_ID IN (1,2,3)";
//}
//$sql = 'SELECT *
//          FROM `table`
//         WHERE `id` IN (' . implode(',', array_map('intval', $array)) . ')';
//
//
//$array1 = array(  "1", "2", "3");
//$array2 = array( "1", "4", "2");
//$result = array_intersect($array1, $array2);

//print_r(ServiceTypeDBDAO::getAllOverlappingServiceType([1]));