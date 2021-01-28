<?php

require_once 'requires.php';

function getFirst20AvalableApp($date,$EMP_ID=false)
{

	//if(workinghors.sunday1=)

}
function EmployeeWorkHours($EMP_ID)// מחזירה את כל  שעות העבודה של עובד בכל ימי השבוע 
{
	$r=WorkHoursDBDAO::getAllEmpWorkHours($EMP_ID);
	var_dump($r);
}
// EmployeeWorkHours(2);// EmployeeWorkHours קריאה לפונקציה /בדיקה 
/*function checkAppointmentAvailability($EMP_ID,$dateTime)//  פונקציה שבודקת אם התור כבר נקבע או לא - זאת פונקציה בזבזנית יש פונקציה טובה יותר 
{
// AppointmentDBDAO::checkAppointmentAvailability($appointment) <-  הפונקציה טובה יותר 
	$notAvailableDateTime=AppointmentDBDAO::getAppointmentOfEmployee($EMP_ID);
	$availability=true;
	foreach ($notAvailableDateTime as $value)
	{
		if($value->getAppointmentTime()==$dateTime)
		{
			echo $value->getAppointmentTime()."<br/>=<br/>".$dateTime;
			$availability=false;
		}
	}
// 	if($availability)
// 		echo "you have a turn mother fucker";
// 	else echo "We are sorry this appointment is not available..";
	return $availability;
}*/


function appointmentHandle($EMP_ID,$date)// EMP_ID  פונקציה שבודקת התאמה בין תאריך ל
{
	
}

function checkEmployeeWorkHours($EMP_ID,$date,$hour)
{
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
}


// function getAvailableDaysInMonth($year,$month,$employeeId=false)//   פונקציה שמחזירה את הימים שבהם יש לפחות תור אחד פנוי בחודש הנבדק  
// {
// // 	$weekDays = ["sunday","monday","tuesday","wednesday","thursday","friday","satureday"];
// 	$dt = new DateTime();
// 	$m =  $dt->format('m');
// 	$y =  $dt->format('Y');
// 	$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $m,$y);// כמה ימים יש בחודש הנבחר 
	
// // 	$openingHours;
	
// 	if($employeeId !== false){
// 		$allEmpWorkHours = WorkHoursDBDAO::getAllEmpWorkHours($employeeId);
		
// 		foreach ($allEmpWorkHours as $singleDay)
// 		{
// 			//$possibleAppointmentsList=[];
			
// 			$start1= $singleDay->getFromHour1();
// 			$end1=$singleDay->getToHour1();
			
// 			$currentHour = $start1;
// 			while($currentHour !== $end1)
// 			{
// 				$possibleAppointmentsList[] = $currentHour;
// 				$currentHour += 15;
// 			}
			
			
// 			if(isset($singleDay->getFromHour2())){
// 				$start2= $singleDay->getFromHour2();
// 				$end2=$singleDay->getToHour2();
				
// 				$currentHour = $start2;
// 			    while($currentHour !== $end2)
// 		    	{
// 			    	$possibleAppointmentsList[] = $currentHour;
// 				    $currentHour += 15;
// 			    }
// 			}	
// 		}
		
// 	}
// 	else{
// 		$openingHours = OpeningHoursDBDAO::getAllOpeningkHours();
// 	}
	
// 	// $i = יהיה שווה ליום הנוכחי במקרה שהחודש שהתקבל הוא החודש הנוכחי
// 	for($i = 1; $i <= $daysInMonth; $i++)
// 	{
// 		$j = 0;
// 		$isAppAvailable = false;
// 		while(!$isAppAvailable)
// 		{
			
// 			$appointment = new Appointment($appointmentDate, $possibleAppointmentsList[$j], $customerId, $employeeId, $comment);
// 			if(AppointmentDBDAO::checkAppointmentAvailability($appointment))
// 			{
// 				$availableDaysList[] = $i;
// 				$isAppAvailable = true;
// 			}
// 			$j++;
// 		}
//  	}
	
	
// }
function getAvailableDaysInMonth($year,$month,$employeeId=false)//   פונקציה שמחזירה את הימים שבהם יש לפחות תור אחד פנוי בחודש הנבדק
{
// 	$dt = new DateTime();
// 	$m =  $dt->format('m');
// 	$y =  $dt->format('Y');
// 	print($m ."                    ".$y);
	$numberOfDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $month,$year);// כמה ימים יש בחודש הנבחר

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
				$currentRunHour = date ("H:i:s",$timeFromStr);// ממיר את זה חזרה למחרוזת 
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
	
	// $i = היה שווה ליום הנוכחי במקרה שהחודש שהתקבל הוא החודש הנוכחי
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

var_dump(getAvailableDaysInMonth("2017","01",3))
//echo AppointmentDBDAO::getAppointment(2)->getAppointmentDate();
// $arr=AppointmentDBDAO::getAppointmentOfEmployee(2);
// foreach ($arr as $value)
// 	var_dump($value);
 
/*checkAppointmentAvailability(2, '2016-12-20 12:30:00');*/ //checkAppointmentAvailability בדיקה לפונקציה
// checkEmployeeWorkHours(2, '22-12-2016', '8:00');

// $appointment= new Appointment("2016-12-20","2016-12-20 09:30:00", 56, 4, 'bldfvdfibli');
// $result = AppointmentDBDAO::checkAppointmentAvailability($appointment);
// echo $result;


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////הפונקציה עובדת!    אם תכניס תור שקיים במערכת תקבל שגיאה שאומרת שהתור קיים אם התור לא קיים יודפס על המסך "1" שהוא שווה ערך ל"אמת" ת
////////////////////////////תור שקיים במערכת הוא תור שהתאריך השעה והאיי די של העובד קיימים בטבלה
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// $dt = new DateTime();
// $m =  $dt->format('m');
// $y =  $dt->format('Y');
// echo cal_days_in_month (CAL_GREGORIAN, $m,$y);








?>