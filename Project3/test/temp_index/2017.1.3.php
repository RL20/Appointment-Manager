<?php

require_once 'requires.php';

function getFirst20AvalableApp($date,$EMP_ID=false)
{

	//if(workinghors.sunday1=)

}
function EmployeeWorkHours($EMP_ID)// ������ �� ��  ���� ������ �� ���� ��� ��� ����� 
{
	$r=WorkHoursDBDAO::getAllEmpWorkHours($EMP_ID);
	var_dump($r);
}
// EmployeeWorkHours(2);// EmployeeWorkHours ����� �������� /����� 
function checkAppointmentAvailability($EMP_ID,$dateTime)//  ������� ������ �� ���� ��� ���� �� �� - ��� ������� ������� �� ������� ���� ���� 
{
// AppointmentDBDAO::checkAppointmentAvailability($appointment) <-  �������� ���� ���� 
	$notAvailableDateTime=AppointmentDBDAO::getAppointmentOfEmployee($EMP_ID);
	$availability=true;
	foreach ($notAvailableDateTime as $value)
	{
		if($value->getAppointmentTime()==$dateTime)//dateTime ���� ��������� ���� ��� ���� 
		{
			echo $value->getAppointmentTime()."<br/>=<br/>".$dateTime;
			$availability=false;
		}
	}
// 	if($availability)
// 		echo "you have a turn mother fucker";
// 	else echo "We are sorry this appointment is not available..";
	return $availability;
	/*checkAppointmentAvailability(2, '2016-12-20 12:30:00');*/ //checkAppointmentAvailability ����� ��������
}


function appointmentHandle($EMP_ID,$date)// EMP_ID  ������� ������ ����� ��� ����� �
{
	
}

function checkEmployeeWorkHours($EMP_ID,$date,$hour)// ������� ����� ���� ����� ��� ��� ,������ ������ ������ ���� �����
{
	// �� ������ �� �������� 
	$dateCovert = date_create_from_format('d-m-Y', $date);
	$day=$dateCovert->getTimestamp();
	$dayTextual=strtoupper(date('l',$day)) ; 
	$employeeWorkingHours=WorkHoursDBDAO::getAllEmpWorkHours($EMP_ID);

	foreach ($employeeWorkingHours as $value)
	{
		
		if($value->getDay()==$dayTextual)
		{
			echo "$dayTextual it is day i am working<br/>";
			$start1= $value->getFromHour1();
			$end1=$value->getToHour1();
			
			$start2= $value->getFromHour2();
			$end2=$value->getToHour2();
			
			$hourCovert =strtotime($hour);
			echo $hourCovert;
			echo date('d-m-Y',$hourCovert);
// 			$hourTimeStamp=$hourCovert->getTimestamp();
			
	
		}
		
		
	}
// 	checkEmployeeWorkHours(2, '22-12-2016', '8:00'); //  checkEmployeeWorkHours ����� �������� 
}


function getAvailableDaysInMonth($year,$month,$employeeId=false)//   ������� ������� �� ����� ���� �� ����� ��� ��� ���� ����� �����
{
// 	$dt = new DateTime();
// 	$m =  $dt->format('m');
// 	$y =  $dt->format('Y');
// 	print($m ."                    ".$y);
	$numberOfDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $month,$year);// ��� ���� �� ����� �����

// 	$possibleAppointmentsList=[];
	if($employeeId !== false)
	{
		$allEmpWorkHours = WorkHoursDBDAO::getAllEmpWorkHours($employeeId);

		foreach ($allEmpWorkHours as $singleDay)
		{
			$day = $singleDay->getDay();
// 			$possibleAppointmentsList[$day][];
				
			$start1= $singleDay->getFromHour1();
			$end1=$singleDay->getToHour1();
			
			$start2= $singleDay->getFromHour2();
			$end2=$singleDay->getToHour2();
				
			$currentRunHour = $start1;
			while($currentRunHour !== $end1)
			{
				$possibleAppointmentsList[$day][] = $currentRunHour;
				$timeFromStr = strtotime($currentRunHour);
				$timeFromStr += 900;
				$currentRunHour = date ("H:i:s",$timeFromStr);// ���� �� �� ���� ������� 
			}
				
			
			if(isset($start2))
			{
				$currentRunHour = $start2;
				while($currentRunHour !== $end2)
				{
					$possibleAppointmentsList[$day][] = $currentRunHour;
					$timeFromStr = strtotime($currentRunHour);
					$timeFromStr += 900;
					$currentRunHour = date ("H:i:s",$timeFromStr);
				}
			}
		}

	}
// 	else //$openingHours = OpeningHoursDBDAO::getAllOpeningkHours();
	
	// $i = ��� ���� ���� ������ ����� ������ ������ ��� ����� ������
		$presentDayinCurrentMonth=date('j',time());
	if($month==date('m',time())&&$year==date('Y',time()))
		$i=$presentDayinCurrentMonth;
	else $i=1;
// 	var_dump($possibleAppointmentsList);
	for($i; $i <= $numberOfDaysInMonth; $i++)
	{
		$strDate = $i.'-'.$month.'-'.$year;
		$strDay = strtoupper ( date('l', strtotime ($strDate)));
 //		print($strDay."<br/>");
// 		$possibleAppointmentsList[$strDay][];
		$isAppAvailable = false;
		$j = 0;
		while(!$isAppAvailable)
		{
				
			$appointment = new Appointment($strDate, $possibleAppointmentsList[$strDay][$j], "", $employeeId, "");
// 			print($possibleAppointmentsList[$strDay][$j]."</br>");
			if(AppointmentDBDAO::checkAppointmentAvailability($appointment))
			{
				$availableDaysList[] = $i;
				$isAppAvailable = true;
			}
			$j++;
		}
	}
	
	return $availableDaysList;


}

//var_dump(getAvailableDaysInMonth("2017","01",3));


 

 

// $appointment= new Appointment("2016-12-20","2016-12-20 09:30:00", 56, 4, 'bldfvdfibli');
// $result = AppointmentDBDAO::checkAppointmentAvailability($appointment);
// echo $result;


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////�������� �����!    �� ����� ��� ����� ������ ���� ����� ������ ����� ���� �� ���� �� ���� ����� �� ���� "1" ���� ���� ��� �"���" �
////////////////////////////��� ����� ������ ��� ��� ������� ���� ����� �� �� ����� ������ �����
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////









?>