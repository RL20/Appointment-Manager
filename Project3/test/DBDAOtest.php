<?php
require_once 'requires.php';

//CustomerDBDAO-----------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------

//CustomerDBDAO::deleteCustomer(1);

// $c =new  Customer('AVI', 'a@', '0526', '12345678', 'tel aviv');
// CustomerDBDAO::createCustomer($c);


// $c=CustomerDBDAO::getCustomer(3);
// $c->setPassword('987654321');
// CustomerDBDAO::updateCustomer($c);
//--------------------------------------------קריאות קודמות---------------------------------------
/*$c = Customer::withoutID('HAREL', 'harel@', '0526', '12345678', 'Hadera');
CustomerDBDAO::createCustomer($c);*/


/*$c=CustomerDBDAO::getCustomer(2);
$c->setPassword('987654321');
CustomerDBDAO::updateCustomer($c);*/




//AppointmentDBDAO-----------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
// $d= new Appointment(null, date('Y-m-d',time()),date('H:i:s',time()+60*60*2), 1, 1, 'blibli');
// AppointmentDBDAO::createAppointment($d)
 
// $BLA=AppointmentDBDAO::getAppointment(7);
// echo $BLA->getId() ."<br/>".$BLA->getAppointmentDate()."<br/>".$BLA->getAppointmentTime().
// "<br/>".$BLA->getCustomerId()."<br/>".$BLA->getEmployeeId()."<br/>".$BLA->getComment()."<br/>";

// $d=new Appointment(1482222600, 1482222600, '68', '2', 'aviya');
// var_dump($d);
// print($d->getId());



// $app = AppointmentDBDAO::getAppointment(5);
// $app->setAppointmentDate(time());
// $app->setAppointmentTime(time());
// $app->setComment("harel");
// // $app->setCustomerId($customerId);
// // $app->setEmployeeId($employeeId);


// AppointmentDBDAO::updateAppointment($app);
// try {
// AppointmentDBDAO::deleteAppointment(9);
// }
// catch (Exception $e)
// {
// 	echo "wrong ID..";
// }


//General Check-----------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
// for($i = 1;$i<100000;$i++)
	// {
	// 	$c = Customer::withoutID("nahshon".$i, $i."hjbgfhgjh@h", "76576".$i, "12786".$i, "bmjykuyjgi".$i);
	// 	$custDBDAO = CustomerDBDAO::getInstance();
	// 	$custDBDAO->createCustomer($c);
	// 	var_dump($custDBDAO->getCustomer($i));

	// }

// $c = Customer::withoutID("nahshon", "hjbgfhgjh@h", "76576", "12786", "bmjykuyjgi");
// $custDBDAO = CustomerDBDAO::getInstance();
// $custDBDAO->createCustomer($c);

// $c = Customer::withID(1 ,"harel", "harel@h", "76576", "12786", "cool");
// $custDBDAO->updateCustomer($c);

//CustomerDBDAO::updateCustomer($c);

// $c = new EmployeeAbsence(1, time());
// EployeeAbsenceDBDAO::createEployeeAbsence($c);


// var_dump($app);
// AppointmentDBDAO::createAppointment($d);

// '2016-12-20', '2016-12-20 08:30:00', '68', '2', 'aviya '

// AppointmentDBDAO::createAppointment($d);

// $datenow=time()+365*24*60*60;


// $date = new DateTime("2016-12-20 08:30:00")->g;
// "-2209078800"
// echo $date->format("U");
// false
// echo $date->getTimestamp();
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------


//WorkHoursDBDAO-----------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------

// $e = new WorkHours(2, 'monday', '08:30','12:30' , '15:30', '19:30');
// WorkHoursDBDAO::createWorkHours($e);


// $e = WorkHoursDBDAO::getWorkHours(3);
// var_dump($e);
// $e->setDay('sunday');
// $e->setFromHour1('10:30');
// WorkHoursDBDAO::updateWorkHours($e);


//WorkHoursDBDAO::deleteWorkHours(3)


//--------------------------------------------------------------------------------------------
// $e = WorkHoursDBDAO::getWorkHours(1);
// var_dump($e);

// $e = WorkHoursDBDAO::getWorkHours(1);

// $e->
// WorkHoursDBDAO::updateWorkHours($e);




//EmployeeDBDAO-----------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
// $emploee= new Employee('avi', '12345678', '058', 'a@zub');
// EmployeeDBDAO::createEmployee($emploee);

// $e=EmployeeDBDAO::getEmployee(1);
// $e->setName('hkhku');
// $e->setEmail('gtrs@hgf');
// $e->setPassword('8976756');
// EmployeeDBDAO::updateEmployee($e);

//EmployeeDBDAO::deleteEmployee(1);


//EmployeeAbsenceDBDAO-----------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------

// $ea= new EmployeeAbsence(2, 1482222600, '08:30', '12:45');
// EmployeeAbsenceDBDAO::createEmployeeAbsence($ea);

// $ea = EmployeeAbsenceDBDAO::getEmployeeAbsence(4);
// var_dump($ea);
// $ea->setDate(time()+45*24*60*60);
// EmployeeAbsenceDBDAO::updateEmployeeAbsence($ea);

//EmployeeAbsenceDBDAO::deleteEmployeeAbsence(4);

//OpeningHoursDBDAO-----------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------

// $OP= new OpeningHours('SUNDAY', '08:00', '20:00', NULL, NULL);
// OpeningHoursDBDAO::createOpeningHours($OP);

// var_dump(OpeningHoursDBDAO::getOpeningHours('SUNDAY'));

// $OP=OpeningHoursDBDAO::getOpeningHours('SUNDAY');
// $OP->setToHour1('21:00');
// OpeningHoursDBDAO::updateOpeningHours($OP);


// OpeningHoursDBDAO::deleteOpeningHours('SUNDAY');

// var_dump(OpeningHoursDBDAO::getAllDaysOpeningHours());




//FullyBookedDBDAO-----------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------


 // $FullyBooked=new FullyBookedDate(1485129600, 3);
 // $FullyBooked=new FullyBookedDate(1485216000, 3);

 // var_dump(FullyBookedDateDBDAO::checkIfFullyBooked($FullyBooked));

 // $FB=new FullyBookedDate(1485302400,2);
 // //FullyBookedDateDBDAO::createFullyBookedDate($FB);

 // // FullyBookedDateDBDAO::deleteFullyBookedDate(7);
 // $FB=new FullyBookedDate(1485302400,3,5);
 // FullyBookedDateDBDAO::updateFullyBookedDate($FB)

 // var_dump(FullyBookedDateDBDAO::getFullyBookedDate(3));
 // var_dump(FullyBookedDateDBDAO::getFullyBookedDatesOfEmployee(2));
 
// *********************************

/*
 * $dt=new DateTime();
 * //$dtPlus1Day=$dt->getTimestamp()+24*60*60;
 * var_dump($dt);
 * if (FullyBookedDateDBDAO::checkIfDayIsFullyBooked($dt))
 	* echo "this date is already full ,please try a different date";
 	* else echo "this date is available";
 	*/
 // *********************************
?>