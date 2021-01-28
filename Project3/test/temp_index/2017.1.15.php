<?php


require_once 'requires.php';

function getFirst20AvalableApp($date,$EMP_ID=false)
{

	//if(workinghors.sunday1=)

}

// EmployeeWorkHours(2);// EmployeeWorkHours קריאה לפונקציה /בדיקה 


function appointmentHandle($EMP_ID,$date)// EMP_ID  פונקציה שבודקת התאמה בין תאריך ל
{
	
}

function checkEmployeeWorkHours($EMP_ID,$date,$hour)// פונקציה שבודקת שעות עבודה של עובד לפי יום  בשבוע ,התאריך שמתקבל בפרמטר מתורגם ליום בשבוע
{
	// לא סיימתי את הפונקציה ***************************************
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
// 	checkEmployeeWorkHours(2, '22-12-2016', '8:00'); //  checkEmployeeWorkHours בדיקה לפונקציה 
}


function getAvailableDaysInMonth($year,$month,$employeeId=false)//   פונקציה שמחזירה את הימים שבהם יש לפחות תור אחד פנוי בחודש הנבדק
{
// 	$dt = new DateTime();
// 	$m =  $dt->format('m');
// 	$y =  $dt->format('Y');
// 	print($m ."                    ".$y);
	$numberOfDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $month,$year);// כמה ימים יש בחודש הנבחר

	//$possibleAppointmentsList = [];
	
	if($employeeId !== false)
	{
		$allEmpWorkHours = WorkHoursDBDAO::getAllEmpWorkHours($employeeId);

		foreach ($allEmpWorkHours as $singleDay)
		{
			
// 			$day = $singleDay->getDay();

			$possibleAppointmentsList[$singleDay->getDay()] =  getPossibleAppointmentsList_ByDay($singleDay);
			
			
			
			
			
			// מחזיר לנו רשימה של כל התורים האפשריים של עובד ספיציפי באותו היום
			/*
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
				$timeFromStr += 900;// מסמל זמן של 15 דקות ונהפוך אותו בהמשך ל אובייקט 
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
			}*/
		}
		var_dump($possibleAppointmentsList);

	}
// 	else //$openingHours = OpeningHoursDBDAO::getAllOpeningkHours();
	$index = 1;
	// $i = היה שווה ליום הנוכחי במקרה שהחודש שהתקבל הוא החודש הנוכחי
		$presentDayinCurrentMonth=date('j',time());
	if($month==date('m',time())&&$year==date('Y',time()))
		$i=(int)$presentDayinCurrentMonth;
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
			if($j >= count($possibleAppointmentsList[$strDay]))
			{
				break;
			}
			
			$appointment = new Appointment(strtotime($strDate), $possibleAppointmentsList[$strDay][$j], "", $employeeId, "");
// 			print($possibleAppointmentsList[$strDay][$j]."</br>");
			if(AppointmentDBDAO::checkAppointmentAvailability($appointment))
			{
// 				echo '<script type="text/javascript">alert("Data has been submitted to ' . $i . '");</script>';
				$availableDaysList[] = $i;
				$isAppAvailable = true;
			}
			var_dump($appointment);
			print($index++);
		
			$j++;
		}
	}
	
	return $availableDaysList;


}




function getPossibleAppointmentsList_ByDay(WorkHours $singleDay)
{
	//$possibleAppointmentsList is the argument from the function's caller 
// 	$possibleAppointmentsList;
	
	//מקבל את הערכים מהאובייקט שהתקבל
	$day = $singleDay->getDay();
	// 			$possibleAppointmentsList[$day][];
	
	$start1= $singleDay->getFromHour1();
	$end1=$singleDay->getToHour1();
		
	$start2= $singleDay->getFromHour2();
	$end2=$singleDay->getToHour2();
	
	//set the first hour (the hour that the worker starts working)
	$currentRunHour = $start1;
	
// 	$possibleAppointmentsList[$day];  לבדוק שזה עובד במקרה שהיום שהתקבל הוא יום חופש
	
	//runs untill it gets to $end1 - which is the worker's end of the day or a lunch break
	while($currentRunHour !== $end1)
	{
		//insert $currentRunHour to the list a the specified day
		$possibleAppointmentsList[] = $currentRunHour;
		//convert the $currentRunHour which is a string to Long 
		$timeFromStr = strtotime($currentRunHour);
		//add 15 minutes
		$timeFromStr += 900;// מסמל זמן של 15 דקות ונהפוך אותו בהמשך ל אובייקט
		//sets the value back to $currentRunHour
		$currentRunHour = date ("H:i:s",$timeFromStr);// ממיר את זה חזרה למחרוזת
	}
	
// 		checks if $start2 is not null - which means worker has a lunch break or split working day
	if(isset($start2))
	{
		//the same as the whlie loop above^^
		$currentRunHour = $start2;
		while($currentRunHour !== $end2)
		{
			$possibleAppointmentsList[] = $currentRunHour;
			$timeFromStr = strtotime($currentRunHour);
			$timeFromStr += 900;
			$currentRunHour = date ("H:i:s",$timeFromStr);
		}
	}

//returns the list 
	return $possibleAppointmentsList;
}

// $singleday = WorkHoursDBDAO::getEmployeeWorkHoursByDay(3, "SUNDAY");
// $possibleAppointmentsListt = null;
// $possibleAppointmentsListt = getPossibleAppointmentsList_ByDay($possibleAppointmentsListt,$singleday);
// for($i = 0; $i<count($possibleAppointmentsListt["SUNDAY"]); $i++)
// {
// 	//echo '<script type="text/javascript">alert("Data has been submitted to ' . $possibleAppointmentsListt["SUNDAY"][$i] . '");</script>';
// 	$sqlTime = strtotime($possibleAppointmentsListt["SUNDAY"][$i]);
// 	$appointment = new Appointment(1484438400, $sqlTime, 68, 3, "jhgf");
//     AppointmentDBDAO::createAppointment($appointment);
// }





var_dump(getAvailableDaysInMonth("2017","01",2));


/*
$appointment = new Appointment(1484438400, "10:30:00", "", 3, "");
// 			print($possibleAppointmentsList[$strDay][$j]."</br>");
$bool = AppointmentDBDAO::checkAppointmentAvailability($appointment);

// echo '<script type="text/javascript">alert("' . $bool. '");</script>';

*/
 

 

// $appointment= new Appointment("2016-12-20","2016-12-20 09:30:00", 56, 4, 'bldfvdfibli');
// $result = AppointmentDBDAO::checkAppointmentAvailability($appointment);
// echo $result;


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////הפונקציה עובדת!    אם תכניס תור שקיים במערכת תקבל שגיאה שאומרת שהתור קיים אם התור לא קיים יודפס על המסך "1" שהוא שווה ערך ל"אמת" ת
////////////////////////////תור שקיים במערכת הוא תור שהתאריך השעה והאיי די של העובד קיימים בטבלה
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//*******************************************************************************************************************************************
$date=time();
function getFirst20AvailableAppointments($date,$employeeId=false)//   פונקציה שמחזירה את הימים שבהם יש לפחות תור אחד פנוי בחודש הנבדק
{

	if($employeeId !== false)
	{
		$allEmpWorkHours = WorkHoursDBDAO::getAllEmpWorkHours($employeeId);

		foreach ($allEmpWorkHours as $singleDay)
		{
			$possibleAppointmentsList[$singleDay->getDay()] =  getPossibleAppointmentsList_ByDay($singleDay);
		}
		var_dump($possibleAppointmentsList);

	}

	
	
	$mysqltime = date ("H:i:s", $date);
	$mysqldate = date ("Y-m-d", $date);
	$listIndex = 0;
	// 	var_dump($possibleAppointmentsList);
	while($listIndex !== 20)
	{
		//לא ברור לי איך לעשות את זה עדיין אבל כל הקוד המחוק הוא בעייתי וצריך להתאים אותו לפונקציה
// 		$strDate = $i.'-'.$month.'-'.$year;
// 		$strDay = strtoupper ( date('l', strtotime ($strDate)));
// 		//		print($strDay."<br/>");
// 		// 		$possibleAppointmentsList[$strDay][];
// 		$isAppAvailable = false;
// 		$j = 0;
// 		while(!$isAppAvailable)
// 		{
// 			if($j >= count($possibleAppointmentsList[$strDay]))
// 			{
// 				break;
// 			}
				
// 			$appointment = new Appointment(strtotime($strDate), $possibleAppointmentsList[$strDay][$j], "", $employeeId, "");
// 			// 			print($possibleAppointmentsList[$strDay][$j]."</br>");
// 			if(AppointmentDBDAO::checkAppointmentAvailability($appointment))
// 			{
// 				// 				echo '<script type="text/javascript">alert("Data has been submitted to ' . $i . '");</script>';
// 				$availableDaysList[] = $i;
// 				$listIndex++;//add 1 to listIndex if appointment available
// 			}
		

// 			$j++;
// 		}
	}

	return $availableDaysList;


}



?>