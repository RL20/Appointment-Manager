<?php
$wh= WorkHoursDBDAO::getEmployeeWorkHoursByDay(2, "SUNDAY");

// $possibleAppointmentsList  = commonActions::getPossibleAppointmentsList_ByDay ($wh); // ����� ��� ����� �� �� ������ �������� �� ���� ������� ����� ����

// //*****
// for($j = 0; $j < count ( $possibleAppointmentsList )-2; $j ++) // �� ��� ���� ��� ���� ���� �� ������ ��� ���� �� �� �������� ����
// {
// 	//*****//
// 		$possibleHourFromAppointmentList = $possibleAppointmentsList[$j];
// 		print ("J=No" . $j . "</br>") ;


// 		$appointment = new Appointment ( 1487462400 , strtotime("19:30:00"), 2, 2, "ftghr" );

// 		customerActions::setAppointment($appointment);


// }

$wh= WorkHoursDBDAO::getEmployeeWorkHoursByDay(2, "THURSDAY");

$possibleAppointmentsList  = commonActions::getPossibleAppointmentsList_ByDay ($wh); // ����� ��� ����� �� �� ������ �������� �� ���� ������� ����� ����

//*****
for($j = 0; $j < count ( $possibleAppointmentsList )-2; $j ++) // �� ��� ���� ��� ���� ���� �� ������ ��� ���� �� �� �������� ����
{
	//*****//
	$possibleHourFromAppointmentList = $possibleAppointmentsList[$j];
	print ("J=No" . $j . "</br>") ;


	$appointment = new Appointment ( 1492041600 , strtotime($possibleHourFromAppointmentList), 2, 2, "nowWow" );

	customerActions::setAppointment($appointment);


}


