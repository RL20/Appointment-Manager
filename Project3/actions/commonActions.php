<?php

class commonActions
{

    static function getPossibleAppointmentsList_ByDay(WorkHours $singleDay) // ����� ��� ����� �� �� ������ �������� �� ���� ������� ����� ����
    {
        $appointmentDuration=managerActions::GetAppointmentDuration();
        $possibleAppointmentsList=[];//����� �� ����� ����� ��� ��� ��� ��� ����� ��� �� ������
        // $possibleAppointmentsList is the argument from the function's caller
        // $possibleAppointmentsList;

        // ���� �� ������ ��������� ������
        $day = $singleDay->getDay ();
        // $possibleAppointmentsList[$day][];

        $start1 = $singleDay->getFromHour1 ();
        $end1 = $singleDay->getToHour1 ();

        $start2 = $singleDay->getFromHour2 ();
        $end2 = $singleDay->getToHour2 ();
        if (isset ( $start1 ))
        {
            // set the first hour (the hour that the worker starts working)
            $currentRunHour = $start1;

            // $possibleAppointmentsList[$day]; ����� ��� ���� ����� ����� ������ ��� ��� ����

            // runs untill it gets to $end1 - which is the worker's end of the day or a lunch break
            while ( $currentRunHour !== $end1 )
            {
                // insert $currentRunHour to the list a the specified day
                $possibleAppointmentsList [] = $currentRunHour;
                // convert the $currentRunHour which is a string to Long
                $timeFromStr = strtotime ( $currentRunHour );
                // add 15 minutes
                $timeFromStr += $appointmentDuration; //���� �������� ������ �� ��� ���� /���� ��� �� 15 ���� ������ ���� ����� � �������
                // sets the value back to $currentRunHour
                $currentRunHour = date ( "H:i:s", $timeFromStr ); // ���� �� �� ���� �������
            }
        }


        // checks if $start2 is not null - which means worker has a lunch break or split working day
        if (isset ( $start2 ))
        {
            // the same as the whlie loop above^^
            $currentRunHour = $start2;
            while ( $currentRunHour !== $end2 ) {
                $possibleAppointmentsList [] = $currentRunHour;
                $timeFromStr = strtotime ( $currentRunHour );
                $timeFromStr += $appointmentDuration; //���� �������� ������ �� ��� ���� /���� ��� �� 15 ���� ������ ���� ����� � �������
                $currentRunHour = date ( "H:i:s", $timeFromStr );
            }
        }

        // returns the list
        return $possibleAppointmentsList;
    }

    //************************************************************************************************************************************************

    static function getAvailableDaysInMonthForAllEmployees($year, $month) // ������� ������� �� ����� ���� �� ����� ��� ��� ���� ����� ����� ����� ����� ���
    {
        $availableDaysList = [];
        $numberOfDaysInMonth = cal_days_in_month ( CAL_GREGORIAN, $month, $year ); // ��� ���� �� ����� �����

        //	$availableDaysList = null;



        // $i = ���� ���� ���� ������ ����� ������ ������ ��� ����� ������
        $presentDayinCurrentMonth = date ( 'j', time () );
        if ($month == date ( 'm', time () ) && $year == date ( 'Y', time () ))
            $i = ( int ) $presentDayinCurrentMonth;
        else
            $i = 1;


        for($i; $i <= $numberOfDaysInMonth; $i++) // ������ �� ����� ����� $i
        {
            $strDate = $i . '-' . $month . '-' . $year;
            $date = strtotime($strDate); // ���� �� ������ ���� ����� ��� ���� �� ����� ���
            // 		DateTime $DTdate = strtotime(date ("Y-m-d", $date));

            if (!FullyBookedDateDBDAO::checkIfDayIsFullyBooked($date)) {
                // printToTerminal( '<script type="text/javascript">alert("Data has been submitted to ' . $i . '");</script>';
                $availableDaysList [] = $i;
            }


        }

        return $availableDaysList;
    }


    //************************************************************************************************************************************************



    static function getAvailableDaysInMonthByEmployeeId($year, $month, $employeeId ) // ������� ������� �� ����� ���� �� ����� ��� ��� ���� ����� �����  ����� ������
    {
        $numberOfDaysInMonth = cal_days_in_month ( CAL_GREGORIAN, $month, $year ); // ��� ���� �� ����� �����

        //	$availableDaysList = null;



        // $i = ���� ���� ���� ������ ����� ������ ������ ��� ����� ������
        $presentDayinCurrentMonth = date ( 'j', time () );
        if ($month == date ( 'm', time () ) && $year == date ( 'Y', time () ))
            $i = ( int ) $presentDayinCurrentMonth;
        else
            $i = 1;


        for($i; $i <= $numberOfDaysInMonth; $i ++) // ������ �� ����� ����� $i
        {
            $strDate = $i . '-' . $month . '-' . $year;
            $date = strtotime($strDate); // ���� �� ������ ���� ����� ��� ���� �� ����� ���

            $fullyBookedDate = new FullyBookedDate($date, $employeeId);
            if (!FullyBookedDateDBDAO::checkIfFullyBooked($fullyBookedDate)) {
                // printToTerminal( '<script type="text/javascript">alert("Data has been submitted to ' . $i . '");</script>';
                $availableDaysList [] = $i;
            }


        }

        return $availableDaysList;
    }


    //************************************************************************************************************************************************
    static function getFirst20AvailableAppointments($employeeId,$serviceTypeIds, $date = false)
    {
        printToTerminal('getFirst20AvailableAppointments serviceTypeIds: ' . json_encode($serviceTypeIds));

        $necessaryDuration = ServiceTypeDBDAO::getServiceTypesDurationSum($serviceTypeIds);
        printToTerminal('getFirst20AvailableAppointments necessaryDuration: ' . $necessaryDuration);
        if(!isset($employeeId)) throw new Exception('you didnt entered ID!');
        $newDate1 = $date;//added
        $newDateTime = date('H:i:s',$newDate1);
        $firstCall = false;


        if ($date == false)
        {
            $date = time();
            $firstCall = true;
            $newDateTime = date('H:i:s',$date);
            printToTerminal('getFirst20AvailableAppointments date if: '. $date);
        }
        else if($date < time() && date('Ymd') !== date('Ymd', $date))
        {
            printToTerminal(time() - $date );
            //TODO check whats wrong with this else if (if its a diffrence of only couple of hours this should not throw exception)
            throw new Exception("FUCK YOU HACKER!");
        }

        $listIndex = 0;
//        $first20availablAppList = [];
        $availableAppointments = [];
        while ( $listIndex < 20 )
        {

            //array list
            $first20availablAppList  = AppointmentDBDAO::getAllWindowTimeBetwinAppointmentA($employeeId, $date, $necessaryDuration);
            $availableAppointments = array_merge($availableAppointments, $first20availablAppList);

            $listIndex  += count($first20availablAppList);
            if ($listIndex >= 20)
                break;

            if ($listIndex < 20)
                $date += 24 * 60 * 60;

            if (date ( 'j', $date ) != date ( 'j', time () ))
                $firstCall = false;
        }
        return $availableAppointments;




    }
    //************************************************************************************************************************************************
    /*
    //������� ������ ������� 20 ����� �� ���� ������� ������ ���� ������� �� ������
    static function getFirst20AvailableAppointments($employeeId, $date = false) // SELF ������ �������  getPossibleAppointmentsList_ByDay  ����� ����� �� ������ �������� ��
    {
        if(!isset($employeeId)) throw new Exception('you didnt entered ID!');
        $newDate1 = $date;//added
        $newDateTime = date('H:i:s',$newDate1);

        $firstCall = false;

        if ($date == false) //�� �� ����� ����� ��� ����� ������ ��� ���� �� ������ �������� ��� ���� �� ���� ���� ����
        {
            $date = time();// ����� ����� �� �� ������ ���� ������
            $firstCall = true;
            $newDateTime = date('H:i:s',$date);
// 			printToTerminal( "<br/>newDate:  ".$newDateTime."<br/>".$date."<br/>";
        }
//		else if(time() - $date > 100)
        //check if $date has passed and avoid returning old available appointments
        else if($date < time() && date('Ymd') !== date('Ymd', $date))
        {
            printToTerminal(time() - $date );
            //TODO check whats wrong with this else if (if its a diffrence of only couple of hours this should not throw exception)
            throw new Exception("FUCK YOU HACKER!");
        }

        $allEmpWorkHours = WorkHoursDBDAO::getAllEmpWorkHours ( $employeeId );

        $possibleAppointmentsList = [];
        foreach ( $allEmpWorkHours as $singleDay )
            $possibleAppointmentsList [$singleDay->getDay()] = self::getPossibleAppointmentsList_ByDay ( $singleDay ); // ����� ��� ����� �� �� ������ �������� �� ���� ������� ����� ����

        $listIndex = 0;
        $first20availablAppList = [];
        while ( $listIndex < 20 )
        {

            $strTime = date ( 'H:i:s', $date );
            $strDate = date ( 'd-m-Y', $date );
            $strDay = strtoupper ( date ( 'l', $date ) ); // ���� �� ������ ���� ����� ��� ���� �� ����� ���

            $FullyBooked = new FullyBookedDate ( $date, $employeeId );
            if (! FullyBookedDateDBDAO::checkIfEmplooyeeDayIsFullyBooked( $FullyBooked ))
            {
                for($j = 0; $j < count ( $possibleAppointmentsList [$strDay] ); $j ++) // �� ��� ���� ��� ���� ���� �� ������ ��� ���� �� �� �������� ����
                {
                    $Hour_FromPossibleAppointmentList = $possibleAppointmentsList [$strDay] [$j];
// 					print ("J=No" . $j ."---------".$Hour_FromPossibleAppointmentList. "</br>") ;


                    // 					printToTerminal( "<br/>".$Hour_FromPossibleAppointmentList."<br/>";
                    // 					printToTerminal( "<br/>".date('H:i:s',$newDate1)."<br/>";
                    // 					printToTerminal( "<br/>".$Hour_FromPossibleAppointmentList > date('H:i:s',$newDate1)."<br/>";


                    if ($firstCall || (date('ymd',$date) == date('ymd',$newDate1)))
                    {
                        if ($Hour_FromPossibleAppointmentList < $newDateTime){
// 							print ("Time has already passed-" . $Hour_FromPossibleAppointmentList . "</br>") ;
                        }
                        else
                        {
                            $firstCall = false;
                            // 							$j--;
                            goto a;
                        }
                    }
                    //******************************************************************************************************************************
                    //******************************************************************************************************************************
                    //******************************************************************************************************************************
                    //******************************************************************************************************************************
                    //******************************************************************************************************************************
                    //******************************************************************************************************************************
                    //******************************************************************************************************************************
                    //******************************************************************************************************************************
                    //******************************************************************************************************************************
                    //******************************************************************************************************************************
                    //******************************************************************************************************************************
                    //******************************************************************************************************************************
                    //******************************************************************************************************************************
                    //******************************************************************************************************************************
                    //�������� ����� ������ �� �� �������� ����� ������� ����� �� ����� �"� ������ ������ ELSE������ �� �� �
                    // firstcall �����  ��� ����� ��� ��
                    //�� NEWDATE
                    //��� ���� ������ ������ ���� ����� �� ��� ������ �������� �����
                    else
                    {
                        a:
                        //$appointment = new Appointment ($date, $Hour_FromPossibleAppointmentList, "", $employeeId, "" );

                        // 						if(!(date('ymd',$date) == date('ymd',$newDate1)) || $Hour_FromPossibleAppointmentList > date('H:i:s',$newDate1))//added
                        // 						{
                        // 							print ("J=No" . $j ."---------".$Hour_FromPossibleAppointmentList. "</br>") ;
                        // 							print (date('ymd',$date). "</br>") ;
                        // 							print (date('ymd',$newDate1). "</br>") ;

                        $appointment = new Appointment ($date, strtotime(ABSOLUTE_HOUR.$Hour_FromPossibleAppointmentList), "", $employeeId, "" );
                        if (AppointmentDBDAO::checkAppointmentAvailability ( $appointment ))
                        {
                            $first20availablAppList [] = $appointment;
                            $listIndex ++; // add 1 to listIndex if appointment available
                        }
                        // 						}else 	print ("Time has already passed-" . $Hour_FromPossibleAppointmentList . "</br>") ;//added
                        if ($listIndex >= 20)
                            break;
                    }

                }

            }

            // �� ����� ���� ����� ������� ���� �����
            if ($listIndex < 20) //  �� ���� ����� ����� �� ��� ���� �� ����� ����� ����� ��� ����� ��� ��� ���� �� ������ �����
                $date += 24 * 60 * 60;


            //                  ���� ����� ������� ������ ���� ����� ������ ������ ����� ���,����� ������� ���� �� ���� ������
            //             , ��� ������ ����� ������ ������ �� ������ ����, false���� firstCall ����� ���� ��� ����� �
            //                                      ���� ��� ����� ����� ��� ����� ��� �� ���� �� ��� ���� ���� ������
            //    ����� �� ���� listIndex ��� ����� ����� ������ ��� ����� �� ���� ���� ������ ���� ������� ��� ������� ��������
            if (date ( 'j', $date ) != date ( 'j', time () ))
                $firstCall = false;
        }
        // 		$newDate=date('y-m-d H:i:s',$date);
        return $first20availablAppList;




    }

*/

    //************************************************************************************************************************************************

    //************************************************************************************************************************************************
    //************************************************************************************************************************************************
    static function setAppointment(Appointment $appointment)//**********�����
    {
        // 		$date=strtotime($appointment->getAppointmentDate());
        $date=$appointment->getAppointmentDate();
        $employeeId=$appointment->getEmployeeId();
        $fb=new FullyBookedDate($date, $employeeId);
//		var_dump($fb);

        if(!FullyBookedDateDBDAO::checkIfEmplooyeeDayIsFullyBooked($fb) && AppointmentDBDAO::checkAppointmentAvailability($appointment))
        {
            try{
                AppointmentDBDAO::createAppointment($appointment);

                //����� ��� ����� �� �� ������
                FullyBookedDateDBDAO::checkAndWrite_FullyBooked($date, $employeeId);
                return true;
            }
            catch(Exception $e)
            {
                //write to log
                return false;
            }
            //****
            // 			$isFullyBooked=true;
            // 			$day=strtoupper(date('l',$date));//�� ����
            // 			$possibleHourtList =WorkHoursDBDAO::getEmployeeWorkHoursByDay($employeeId, $day);//���� ������� �� �� ���� ������ �� ����� ����� ����
            // 			$arr=commonActions::getPossibleAppointmentsList_ByDay($possibleHourtList);// ���� ����� �� ������ �������� ���� ������
            // 				//****
            // 			for ($i=0;$i<count($arr);$i++)
            // 			{
            // 				if (!(strtotime( $arr[$i])< time()))//���� ������ ������� �� ���� ��� ���� ����� �� ��� ���� ����� �� ��� ����� �� �� ����� ���� �� ����� �������
            // 				{
            // 					$app= new Appointment($date, $arr[$i], null, $employeeId, null);
            // 					if (AppointmentDBDAO::checkAppointmentAvailability($app))
            // 						$isFullyBooked=false;
            // 				}

            // 			}
            // 			if ($isFullyBooked)
            // 				FullyBookedDateDBDAO::createFullyBookedDate($fb);

        }
        else
        {
            throw new Exception("Appointment already exists!");
        }
    }
    //************************************************************************************************************************************************
    static function cancelAppointment($appointmentId)//�����
    {
        try{
            $appointment = AppointmentDBDAO::getAppointment($appointmentId);
// 			var_dump($appointment);
            AppointmentDBDAO::deleteAppointment($appointmentId);

// 			var_dump($appointment);
            $date=strtotime($appointment->getAppointmentDate());
            $employeeId=$appointment->getEmployeeId();

            $fb=new FullyBookedDate($date, $employeeId);

            $FBId = FullyBookedDateDBDAO::checkIfEmplooyeeDayIsFullyBooked($fb);
            if ($FBId)
                FullyBookedDateDBDAO::deleteFullyBookedDate($FBId);

            return true;
        }
        catch(Exception $e)
        {
            //write to log
// 			return false;
            throw new Exception($e->getMessage());
        }






// 		$appointment = AppointmentDBDAO::getAppointment($appointmentId);
// 		$date=strtotime($appointment->getAppointmentDate());
// 		// 		printToTerminal( $date."<br/>";
// 		$employeeId=$appointment->getEmployeeId();
// 		// 		printToTerminal( $employeeId."<br/>";

// 		// 		printToTerminal( $appointmentId."<br/>";
// 		$fb=new FullyBookedDate($date, $employeeId);
// 		if(!AppointmentDBDAO::deleteAppointment($appointmentId))
// 			printToTerminal( "<br/>The appointment was canceled successfully ";
// 		var_dump($fb);
// 		$FBId = FullyBookedDateDBDAO::checkIfEmplooyeeDayIsFullyBooked($fb);
// 		if ($FBId)
// 			FullyBookedDateDBDAO::deleteFullyBookedDate($FBId);

    }


    //������ �����  ������ �� ��� ��� ����� �� �� ����� ������ ������ ����� ������� ��� ��� ����-�� ��� ����

    static function allEmployeeAvailableHoursInDay($date,$employeeId )//������� ������� �� �� ������ ������� �� ���� ������ ������
    {
        $isDateCurrentDate = date('ymd' ,$date) === date('ymd' ,time());


        $availableAppointment=[];
        $FullyBooked = new FullyBookedDate ( $date, $employeeId );
        if (! FullyBookedDateDBDAO::checkIfEmplooyeeDayIsFullyBooked ( $FullyBooked ))
        {
            $day=strtoupper(date('l',$date));
//			printToTerminal('');
//			printToTerminal('');
//			printToTerminal($day);
//			printToTerminal('');
//			printToTerminal('');
            $possibleHourtList = WorkHoursDBDAO::getEmployeeWorkHoursByDay($employeeId, $day);//���� ������� �� �� ���� ������ �� ����� ����� ����
            $arr=self::getPossibleAppointmentsList_ByDay($possibleHourtList);// ���� ����� �� ������ �������� ���� ������

// 			var_dump($arr);
            for ($i=0;$i<count($arr);$i++)
            {

                $possibleHour = strtotime( $arr[$i]);//���� ������� ����� ����� ����� ����
// 				printToTerminal( $possibleHour. " v ". time()."<br/>";

                // 			printToTerminal( $i."<br/>";


                //if (!($possibleHour< time()))//���� ������ ������� �� ���� ��� ���� ����� �� ��� ���� ����� �� ��� ����� �� �� ����� ����� �� ����� �������
                if (!$isDateCurrentDate || !($possibleHour < time()))//  ��� ��� ����� ������� ��� ����� ����� �� ���� �������� if ����� ����� ����� ������� ����� ��� ����� �� ���� �
                {
                    // ���� ������ �����  ��� ���� ������ �������� ��� ���� ������ - �� �� ��� ���� ����� �� ������ ������ ������ �� ���� ������� �� ���� ���
// 					printToTerminal( $i."." .strtotime( $arr[$i])."<br/>";
//					$app= new Appointment(strtotime($date), $possibleHour, null, $employeeId, null);
                    $app= new Appointment($date, $possibleHour, null, $employeeId, null);
                    if (AppointmentDBDAO::checkAppointmentAvailability($app))
                        $availableAppointment[] = $app;
                }


            }
        }
        else return $availableAppointment;


        return $availableAppointment;// false �� ����� ��� �����

    }
    ///////////////////////////////�����//////////////////////////


    // 	 old_function_working_well.php ������� ������ ����� ����� ������ �
    static function getAllEmployeesAvailableHoursInDay($duration, $date, $index)//������� ������� �� �� ������ ������� �� �� ������� ������ ������- ������ ������� ���� ����� ��� ��� �������� ��� �� ������� ���������� �� �������
    {

//	    printToTerminal('getAllEmployeesAvailableHoursInDay');
        $allEmployeesList = EmployeeDBDAO::getAllEmployees_Customer();


        $arrAllAppointment=[];
        $arrAppointmentTimeKey=[];
        foreach ($allEmployeesList as $employee)
        {

            $employeeId = $employee->getId();
//            $appointmentObjs=self::allEmployeeAvailableHoursInDay($date, $employeeId);
            $appointmentObjs = AppointmentDBDAO::getAllWindowTimeBetwinAppointmentA($employeeId, $date, $duration);
            printToTerminal('getAllEmployeesAvailableHoursInDay: ' . json_encode($appointmentObjs));
            foreach ($appointmentObjs as $appointmentObj)
            {
// 				if (isset($arrAppointmentTimeKey[$appointmentObj->getAppointmentTime()]))
// 				{
                //checks if index is 0 that means that its the first time this func called, if so, compare given date to $appointmentObj date and then compare appTime to given time
//                if(!($index == 0 && (date('ymd' ,$date) === date('ymd' ,$appointmentObj->getAppointmentDate()) && date('His' ,$date) >= date('His' ,$appointmentObj->getAppointmentTime()))))
//                {
                    $arrAppointmentTimeKey[date('H:i:s',$appointmentObj->getAppointmentTime())][]=$appointmentObj;
//                }

// 				}
// 				else $arrAppointmentTimeKey[$appointmentObj->getAppointmentTime()][]=$appointmentObj;

            }

        }

        if(isset($arrAppointmentTimeKey))
        {

            ksort($arrAppointmentTimeKey);//����� �� ����� ��� ���� �� ���� ������� ����� ��� ������� �����
//		    printToTerminal("arrAppointmentTimeKey:" . $arrAppointmentTimeKey);
            return $arrAppointmentTimeKey;
        }

        return null;

    }
    static function getAllEmployeesAvailableHoursInDayBBBBBBBBBBBBBBBackup ($date, $index)//������� ������� �� �� ������ ������� �� �� ������� ������ ������- ������ ������� ���� ����� ��� ��� �������� ��� �� ������� ���������� �� �������
    {

//	    printToTerminal('getAllEmployeesAvailableHoursInDay');
        $allEmployeesList = EmployeeDBDAO::getAllEmployees_Customer();


        $arrAllAppointment=[];
        $arrAppointmentTimeKey=[];
        foreach ($allEmployeesList as $employee)
        {

            $employeeId = $employee->getId();
            $appointmentObjs=self::allEmployeeAvailableHoursInDay($date, $employeeId);
            foreach ($appointmentObjs as $appointmentObj)
            {
// 				if (isset($arrAppointmentTimeKey[$appointmentObj->getAppointmentTime()]))
// 				{
                //checks if index is 0 that means that its the first time this func called, if so, compare given date to $appointmentObj date and then compare appTime to given time
                if(!($index == 0 && (date('ymd' ,$date) === date('ymd' ,$appointmentObj->getAppointmentDate()) && date('His' ,$date) >= date('His' ,$appointmentObj->getAppointmentTime()))))
                {
                    $arrAppointmentTimeKey[date('H:i:s',$appointmentObj->getAppointmentTime())][]=$appointmentObj;
                }

// 				}
// 				else $arrAppointmentTimeKey[$appointmentObj->getAppointmentTime()][]=$appointmentObj;

            }

        }

        if(isset($arrAppointmentTimeKey))
        {

            ksort($arrAppointmentTimeKey);//����� �� ����� ��� ���� �� ���� ������� ����� ��� ������� �����
//		    printToTerminal("arrAppointmentTimeKey:" . $arrAppointmentTimeKey);
            return $arrAppointmentTimeKey;
        }

        return null;

    }

//************************************************************************************************************************************************************
    // 	 old_function_working_well.php ������� ������ ����� ����� ������ �
    static function getFirst20AvailableAppointmentsFromAllEmployees($serviceTypeIds, $date = false) {
//        $duration = ServiceTypeDBDAO::getServiceTypesDurationSum($serviceTypeIds);
//	    printToTerminal('getFirst20AvailableAppointmentsFromAllEmployees');
        if ($date == false) //�� �� ����� ����� ��� ����� ������ ��� ���� �� ������ �������� ��� ���� �� ���� ���� ����
        {
            $date = time();
        }

        $allAppointments = [ ]; // �� ������ �� �� �������
        $appointmentsCount = 0;
        $i = 0;
        while ( $appointmentsCount < 20 ) {

            $AllEmployeesAvailableHoursInDay = self::getAllEmployeesAvailableHoursInDay($serviceTypeIds, $date, $i);
//            printToTerminal("I: " . $i);
//			printToTerminal("AllEmployeesAvailableHoursInDay:   " . json_encode($AllEmployeesAvailableHoursInDay));
            if($AllEmployeesAvailableHoursInDay !== null)//��� �� ������ ��� ��� �����- �� ����� ����� ����� �UI
            {
                $allAppointments[] = $AllEmployeesAvailableHoursInDay;
                $appointmentsCount += count($AllEmployeesAvailableHoursInDay);
            }

// 			print("<br/>".$appointmentsCount);

            $date += 60 * 60 * 24;
            $i++;
        }
//		printToTerminal($allAppointments);
        return $allAppointments;
    }


//    static function showEmployees()
//    {
//
//
//        try{
//            return EmployeeDBDAO::getAllEmployees();
//        }catch(Exception $e)
//        {
//            throw new Exception("no employees!");
//        }
//    }
//*************************************************************8-11-2017-----------------------------------------------------------------------------------------


    static function getServiceType($serviceTypeId)
    {
        return ServiceTypeDBDAO::getServiceType($serviceTypeId);
    }

    static function getAllServicesType()
    {
        return ServiceTypeDBDAO::getAllServicesType();
    }

    static function getAllServiceTypeEmployees($serviceTypeId)
    {
        return ServiceTypeDBDAO::getAllServiceTypeEmployees( $serviceTypeId);
    }

    static function getAllOverlappingServiceType($serviceTypeIds)
    {
        return ServiceTypeDBDAO::getAllOverlappingServiceType($serviceTypeIds);
    }




    static function getServiceTypeTime($serviceTypeId)
    {
        $duration= ServiceTypeDBDAO::getServiceType($serviceTypeId);
        return $duration->getDuration();
    }

}






