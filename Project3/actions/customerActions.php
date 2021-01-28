<?php

class customerActions
{
	/*
	 *  ����� ���
	 *  ����� ���
	 *  ���� �����
	 *  ��� ���
	 *  �����
	 *  ������ ������
	 *  �����
	 *  ������ ���������� �� ��� ���
	 */
	//static function 
	static function setAppointment(Appointment $appointment)//**********�����
	{
		return commonActions::setAppointment($appointment);
	}
	static function cancelAppointment($appointmentId)//*******�����
	{	//������ ����� ������ ��� ����� ���� ����� ���� �� ���� 
		return commonActions::cancelAppointment($appointmentId);
	}
	static function showAppointments($customerId)//����� �����
	{
		//����� ����� ��������� ����� �� ����� ���� �� ����
		// ����� ��� ��  �� ���� ������� ����� �� �� ������ �� ���� ����
		return AppointmentDBDAO::getAllAppointmentsOfCustomer($customerId);
	}
	static function showOpeningHours()//�����
	{
		return OpeningHoursDBDAO::getAllDaysOpeningHours();
	}
	static function comunicateWithManager(){}
	static function nevigate(){}//�����
	static function showGalery(){}//�����
	static function about(){}//�� ���� �����
	
	
	static function getAvailableDaysInMonthForAllEmployees($year, $month) // ������� ������� �� ����� ���� �� ����� ��� ��� ���� ����� ����� ����� ����� ���
	{
		commonActions::getAvailableDaysInMonthForAllEmployees($year, $month);
	}
	static function getAvailableDaysInMonthByEmployeeId($year, $month, $employeeId )// // ������� ������� �� ����� ���� �� ����� ��� ��� ���� ����� �����  ����� ������
	{
		commonActions::getAvailableDaysInMonthByEmployeeId($year, $month, $employeeId );
	}

	static function getFirst20AvailableAppointments($employeeId, $date = false) // SELF ������ �������  getPossibleAppointmentsList_ByDay  ����� ����� �� ������ �������� ��
	{
		commonActions::getFirst20AvailableAppointments($employeeId);
	}


    static function showEmployees()
    {


        try{
            return EmployeeDBDAO::getAllEmployees_Customer();
        }catch(Exception $e)
        {
            throw new Exception("no employees!");
        }
    }


// 	**********************************************************************************************************************************************************



}
