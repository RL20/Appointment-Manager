<?php

require_once 'requires.php';

/*function checkAppointmentAvailability($EMP_ID,$dateTime)// פונקציה שבודקת אם התור כבר נקבע או לא - זאת פונקציה בזבזנית יש פונקציה טובה יותר 
{
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
}

function firstt20AvalableApp($date,$EMP_ID=false)
{

	//if(workinghors.sunday1=)
	
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
//echo AppointmentDBDAO::getAppointment(2)->getAppointmentDate();
// $arr=AppointmentDBDAO::getAppointmentOfEmployee(2);
// foreach ($arr as $value)
// 	var_dump($value);
 
/*checkAppointmentAvailability(2, '2016-12-20 12:30:00');*/ //checkAppointmentAvailability בדיקה לפונקציה
// checkEmployeeWorkHours(2, '22-12-2016', '8:00');

$appointment= new Appointment("2016-12-20","2016-12-20 09:30:00", 56, 4, 'bldfvdfibli');
$result = AppointmentDBDAO::checkAppointmentAvailability($appointment);
echo $result;


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////הפונקציה עובדת!    אם תכניס תור שקיים במערכת תקבל שגיאה שאומרת שהתור קיים אם התור לא קיים יודפס על המסך "1" שהוא שווה ערך ל"אמת" ת
////////////////////////////תור שקיים במערכת הוא תור שהתאריך השעה והאיי די של העובד קיימים בטבלה
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////










?>