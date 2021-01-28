<?php

class managerActions
{

    //����� ������ ������ 25.5.2017
    /*
     * //�����//
     * ����� /����� ���� �����
     * �����/����� /����� �� ������ ������
     * ����� ���� ���-���������
     * ����� ����-���������

     //���� ����//
     * ����� ������
     * ����� ������
     * ���� ����� ����� -����� ��� ������� �������� ������
     *

     * //�����//
     * ����� ��� ������� ������ ,�������
     * ����� ��� ������� ������ ,�������
     * ����� /����� ����
     * ����� ��� ��� �� ���� ����� - ������ ���� ��� ����� ����
     * ����� /����� ������ ����� ������ ����������
     * ����� ���� ����� ����������
     */


    static function setOpeningHours(array $week)
    {
        if (!OpeningHoursDBDAO::getAllDaysOpeningHours() && count($week) === 7)
        {
            foreach ($week as $daySet)
                OpeningHoursDBDAO::createOpeningHours($daySet);
        }
        else
        {
// 			$week=OpeningHoursDBDAO::getAllDaysOpeningHours();
// 			var_dump($week);
// 			foreach ($week as $daySet)
// 			{

// 				$daySet->setFromHour1($fromHour1);
// 				$daySet->setToHour1($toHour1);
// 				$daySet->setFromHour2($fromHour2);
// 				$daySet->setToHour2($toHour2);
// 				OpeningHoursDBDAO::updateOpeningHours($daySet);
// 			}

            throw new Exception("OpeningHours is set Alredy!");
        }


    }
    static function updateOpeningHours(array $week)
    {
// 		$week1=OpeningHoursDBDAO::getAllDaysOpeningHours();
//         var_dump($week1);
        if (OpeningHoursDBDAO::getAllDaysOpeningHours()!=null)
        {

            foreach ($week as $daySet)
            {
// 				printToTerminal( "<br/>rrrrr".count($week)."rrrrr<br/>";
                //���� �� �� ������� ������ ����� ��� ������� ����
                /*
                $week=[];
                $week[6]=new  OpeningHours('SATURDAY',null, null, null, null);
                managerActions::updateOpeningHours($week);
                */
                $daySet->setFromHour1($daySet->getFromHour1());
                $daySet->setToHour1($daySet->getToHour1());
                $daySet->setFromHour2($daySet->getFromHour2());
                $daySet->setToHour2($daySet->getToHour2());

                OpeningHoursDBDAO::updateOpeningHours($daySet);
            }
            var_dump($week);
        }
        else throw new Exception("can't update- OpeningHours is not set !");

    }

    static function showOpeningHours()
    {

        try{
            return OpeningHoursDBDAO::getAllDaysOpeningHours();
        }catch(Exception $e)
        {
            throw new Exception("OpeningHours Does not Exists!");
        }

    }
    static function showCustomers()
    {

        try{
            return CustomerDBDAO::getAllCustomers();
        }catch(Exception $e)
        {
            throw new Exception("Customers Does not Exists!");
        }

    }

    static function getEmployeesNames($employeesIdList)
    {

        try{
            return EmployeeDBDAO::getEmployeesNames($employeesIdList);
        }catch(Exception $e)
        {
            throw new Exception("Customers Does not Exists!");
        }

    }

    static function getCustomersNames($customersIdList)
    {

        try{
            return CustomerDBDAO::getCustomersNames($customersIdList);
        }catch(Exception $e)
        {
            throw new Exception("Customers Does not Exists!");
        }

    }
    static function showEmployees()
    {


        try{
            return EmployeeDBDAO::getAllEmployees_Manager();
        }catch(Exception $e)
        {
            throw new Exception("no employees!");
        }
    }

    static function showEmployee($empId)
    {
        return EmployeeDBDAO::getEmployee($empId);
    }
    static function showCustomer($custId)
    {
        return CustomerDBDAO::getCustomer($custId);
    }
    static function blockAppointment(blockedAppointment $blockAppointment)
    {
        if (!BlockedAppointmentDBDAO::checkIfAppointmentIsBlocked($blockAppointment))
            BlockedAppointmentDBDAO::createBlockedAppointment($blockAppointment);
        else {      //����� �� �� ���� ����� ������ �� ������ ����
            throw new Exception('Appointment is blocked already!');
        }
    }
    static function unBlockAppointment($blockedappointmentId)
    {
        try {
            BlockedAppointmentDBDAO::deleteBlockedAppointment($blockedappointmentId);
        }
        catch(Exception $e)
        {
            throw new Exception("");
        }


    }
    static function setAppointment(Appointment $appointment)//**********�����
    {
        //����� ������ �� ���� ��� ����� ����� ����� �� ���� �����
        return commonActions::setAppointment($appointment);
    }
    static function cancelAppointment(Appointment $appointment, $comment=false)//**********�����
    {
        // ����� ������ �� ���� ��� ����� ����� ����� �� ���� �����
        // ����� �� �'���� �� ��� ���� �� ���� ���� ������ ������ ����� ����� �� ���������� ����� ����� ���� ������
        $message = "Dear " . CustomerDBDAO::getCustomerName ( $appointment->getCustomerId () ) .
            " your appointement to " . EmployeeDBDAO::getEmployeeName ( $appointment->getEmployeeId () ) .
            " at " . $appointment->getAppointmentDate () ." ". $appointment->getAppointmentTime () .
            " was canceled. We are sorry for the inconvenient";
        try {
            commonActions::cancelAppointment ( $appointment->getId() );

            if ($comment)
                self::notificationMessages ( $message, $comment );
            else
                self::notificationMessages ( $message );
        } catch ( Exception $e ) {
            throw new Exception ( $e->getMessage () );
        }
    }
    static function changeAppointment(Appointment $appointment)
    {

        try{
            AppointmentDBDAO::updateAppointment($appointment);
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    /* // 	static function changeAppointment(Appointment $appointment,$appointmentDate=false,$appointmentTime=false,$customerId=false,$employeeId=false,$comment=false)//����� ��� � ���� ���
    // 	{
    // // 		$app=AppointmentDBDAO::getAppointment($appointment->getId());

    // 		if ($appointmentDate)
    // 			$appointment->setAppointmentDate($appointmentDate);
    // 		if($appointmentTime)
    // 			$appointment->setAppointmentTime($appointmentTime);
    // 		if($customerId)
    // 			$appointment->setCustomerId($customerId);
    // 		if($employeeId)
    // 			$appointment->setEmployeeId($employeeId);
    // 		if($comment)
    // 			$appointment->setComment($comment);
    // 		return AppointmentDBDAO::updateAppointment($appointment);
    // 		//�����
    // 		// $app=AppointmentDBDAO::getAppointment(667);
    // 		// var_dump($app);
    // 		// managerActions::changeAppointment($app, time(), time()+2*60*60 );
    // 		// var_dump($app);
    // 	}
    // 	static function changeAppointment_2($appointmentId,$appointmentDate=false,$appointmentTime=false,$customerId=false,$employeeId=false,$comment=false)//����� ��� � ���� ���
    // 	{
    // 		$app=AppointmentDBDAO::getAppointment($appointmentId);
    // 		if ($appointmentDate)
    // 			$app->setAppointmentDate($appointmentDate);
    // 		if($appointmentTime)
    // 			$app->setAppointmentTime($appointmentTime);
    // 		if($customerId)
    // 			$app->setCustomerId($customerId);
    // 		if($employeeId)
    // 			$app->setEmployeeId($employeeId);
    // 		if($comment)
    // 			$app->setComment($comment);
    // 		return AppointmentDBDAO::updateAppointment($app);
    // 		//�����
    // // 		$app=AppointmentDBDAO::getAppointment(667);
    // // 		var_dump($app);
    // // 		managerActions::changeAppointment_2(667, time(), time()+4*60*60 );
    // // 		$app=AppointmentDBDAO::getAppointment(667);
    // // 		var_dump($app);
    // 	}*/

    static function deleteCustomer(Customer $customer)//�� ���� �� ����� ���� �� �� ������ ��� ???
    {
        //�� ���� �� ����� ���� �� �� ������ ��� ???
        //����� �� �� ������� �� � ��� �� �� �����
        CustomerDBDAO::deleteCustomer($customer->getId());
    }
    static function cancelAllAppointments(){}//? ����� �� �� ���� ����� �� ������
    static function notification_StartStop(){}

    //---------------�������� ������-------------------------
    static function setEmployeeAbsence(EmployeeAbsence $employeeAbsence,$deleteAppointmentConfirmation=false, $comment=false)
    {


        try{
            $appintmentToCancel=AppointmentDBDAO::getAllEmployeeAppointmentsInDay_fromHourToHour($employeeAbsence->getEmployeeId(), $employeeAbsence->getDate(), $employeeAbsence->getFromHour(), $employeeAbsence->getToHour());
            if ($appintmentToCancel){
                if($deleteAppointmentConfirmation){
                    foreach ($appintmentToCancel as $appiontment)
                    {

                        // commonActions::cancelAppointment($appiontment->getId());
                        managerActions::cancelAppointment($appiontment, $comment);

                    }
                }
                else
                {
                    throw new Exception("Need authorization to delete appointments!");
                }
            }
            EmployeeAbsenceDBDAO::createEmployeeAbsence($employeeAbsence);
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }

    }

    static function setFullDayEmployeeAbsence($date, $employeeId, $deleteAppointmentConfirmation=false ,$comment=false)
    {
        if(!EmployeeAbsenceDBDAO::checkIfEmployeeIsAbsentInThisDate($date, $employeeId) )//�� �� ��� ������ ����� ���� ����� ���� ����� ������ ��� ����� �� ������ �� ��� ���� ����� �� ������� ������ ������� ����� ������ �� �� ����
        {

            try
            {

                $appintmentsToCancel=AppointmentDBDAO::getAllEmployeeAppointments_byDate($date, $employeeId);
                if ($appintmentsToCancel)
                {


                    if($deleteAppointmentConfirmation){
                        foreach ($appintmentsToCancel as $appiontment)
                        {

                            // commonActions::cancelAppointment($appiontment->getId());
                            managerActions::cancelAppointment($appiontment, $comment);

                        }
                    }
                    else
                    {
                        throw new Exception("Need authorization to delete appointments!");
                    }



                }

                $day= date('l',$date);
                $workingHours = WorkHoursDBDAO::getEmployeeWorkHoursByDay($employeeId,$day);
                $fromHour = $workingHours->getFromHour1();
                $toHour = $workingHours->getFromHour2()==false?$workingHours->getToHour1():$workingHours->getToHour2();
                $employeeAbsence = new EmployeeAbsence($employeeId, $date, strtotime($fromHour), strtotime($toHour));
                EmployeeAbsenceDBDAO::createEmployeeAbsence($employeeAbsence);

                //��� ����� ����� ���� ����� ����� ����������




            }
            catch(Exception $e)
            {
                //���� ���� �����
                throw new Exception($e->getMessage());
                //���� ��� ������� ����� ��������� ����� ��� ���� ����_�����
            }
        }
        else
        {
            throw new Exception("values already exist in that day");
        }
    }
    /*deletAllEmployeeAbsenceInAdayWhile_setFullDayEmployeeAbsence()
     * ������� ����� �� �� ��������� �� ���� ���� ������ �� ��� ���� ������� ���� ���
     *����� �� ��� ������ �� ������ ����� ��� ��� ��� ���� ������� ����� ������� ���� ������ ��� ����
     */
    static function deletEmployeeAbsence($id)// ���� �� �� ������ ���� ����� ����� ����� ��� ��� ���� ����� ����� �� ���� �����
    {
        EmployeeAbsenceDBDAO::deleteEmployeeAbsence($id);
    }

    static function deletAllEmployeeAbsenceInAday($date, $employeeId)// ���� �� �� ������ ���� ����� ����� ����� ��� ��� ���� ����� ����� �� ���� �����
    {
        EmployeeAbsenceDBDAO::deleteEmployeeAbsence_AccordingToEmployeeAndDate( $employeeId,$date);
    }

    static function showFutureEmployeeAbsence($employeeId)//����� �� ���� �������� ����� ���� �������� ������� �����
    {
        try{
            return EmployeeAbsenceDBDAO::getEmployeeAbsenceByEmployeeId($employeeId);
        }
        catch (Exception $e){
            throw new Exception($e->getMessage());
        }

    }
    static function showAllFutureAbsences()//����� �� ���� �������� ����� ���� �������� ������� �����
    {
        return EmployeeAbsenceDBDAO::getAllEmployeesAbsence();
    }


    //*****************************����� ������ ������� ********************
    static function  setNewEmployee(Employee $employee)// replace setNewWorker
    {
        if (!EmployeeDBDAO::getEmployeeID($employee))//������ �� �������� ����
        {
//            try{
            EmployeeDBDAO::createEmployee($employee);
//            }
//            catch (Exception $e)
//            {
//                throw new Exception($e->getMessage());
//            }
        }
        else throw new Exception("this Employee is already exist!", 2321);

    }
    static function  setNewCustomer(Customer $customer)// replace setNewCustomer
    {

        if (!CustomerDBDAO::getCustomerID($customer))
        {
//            try{
            return CustomerDBDAO::createCustomer($customer);
//            }catch (Exception $e)
//            {
//                throw new Exception($e->getMessage());
//            }
        }
        else throw new Exception("this Customer is already exist !");
    }
    static function  updateCustomerDetails(Customer $customer)
    {
        //���� �� ������ �� ����� �������� ������� ���� ������� �� �����  ����� ���� ������� ����� �� ���� �� ��� ��� �������� ����� �� ���� ���� �� ����� ����
        $isActive = CustomerDBDAO::getCustomerIsActive($customer->getId());
        $customer->setIsActive($isActive);
        CustomerDBDAO::updateCustomer($customer);
    }
    static function  updateEmployeeDetails(Employee $employee)
    {
        //���� �� ������ �� ����� �������� ������� ���� ������� �� �����  ����� ���� ������� ����� �� ���� �� ��� ��� �������� ����� �� ���� ���� �� ����� ����

        $isActive = EmployeeDBDAO::getEmployeeIsActive($employee->getId());
        $employee->setIsActive($isActive);
        EmployeeDBDAO::updateEmployee($employee);
    }


    //-----------------------------�������� ����� �����-------------------------------------

    static function  showTodayAppointmentsList()
    {
// 		$date=time()+2*60*60;
        $date=time();
// 		$appointmentList;
// 		if ($appointmentList = AppointmentDBDAO::getAllAppointments_byDate($date))
// 			return $appointmentList;
// 		else printToTerminal( "there is no Appointment for today";
        try{
            return AppointmentDBDAO::getAllAppointments_byDate($date);
        }catch(Exception $e)
        {
            throw new AppointmentsDoesNotExistsException();
        }
    }

    static function showFutureAppointmentsList($date=false,$time=false,$limit=false)//������ �� ��������
    {
        if (!$date)
        {
            $date = time();
            $time = time();
        }
        try
        {
            return AppointmentDBDAO::getFutureAppointments_byStartingDate($date,$time,$limit);
            // limit=true ������ �� ����� ���� �������� ���� ������
        }
        catch(Exception $e)
        {
            throw new AppointmentsDoesNotExistsException();
        }
    }
    static function showAppointmentsHistory($date=false,$time=false, $limit=false)//������ �� ��������
    {
        if (!$date)
        {
            $date = time();
            $time = time();
        }

        try
        {
            return AppointmentDBDAO::getPastAppointments_byStartingDate($date,$time,$limit);
            // limit=true ������ �� ����� ���� �������� ���� ������

        }
        catch(Exception $e)
        {
            throw new AppointmentsDoesNotExistsException();
        }
    }

    static function showCustomerAppointments($customerId)//����� �� ��� �� ���� ��� �� ���� �����
    {
        //������ �� �� ������ ���� ����� ���� ����
        try
        {
            return AppointmentDBDAO::getAllAppointmentsOfCustomer($customerId);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    //  ��� ����� ���� ����� �������� ��� ����� ����� ���� ���� �� ����� ���� ���� UI �� ������ ����� ���� ��� ���� ���� ����� �������� ����� , ��� ������ �
    static function showEmployeeAppointments($employeeId,$sortingBy=null)
    {
        //������ �� �� ������ ���� ����� ���� ����
        $date=time();
// 		if (!$sortingBy)
// 			$sortingBy="day";//�� ����� �� ��� ���� ����� ����� ���� ���� ������ ���� ������
        if(!isset($employeeId)) throw new Exception("No Employee ID!");
        try
        {
            printToTerminal("sortingBy: " . $sortingBy);
            switch ($sortingBy)
            {//  ��� ����� ���� ����� �������� ��� ����� ����� ���� ���� �� ����� ���� ���� UI �� ������ ����� ���� ��� ���� ���� ����� �������� ����� , ��� ������ �
                case "day":return AppointmentDBDAO::getAllEmployeeAppointments_byDate($date, $employeeId);break;
                case "week":return AppointmentDBDAO::getAllEmployeeAppointments_fromDateToDate($date, $date+604800, $employeeId);break;
                case "month":return AppointmentDBDAO::getAllEmployeeAppointments_byMonth($date, $employeeId);break;
                default: return AppointmentDBDAO::getAllEmployeeAppointments_fromDateToDate($date, $date + 2592000, $employeeId);
            }
            //return AppointmentDBDAO::getAllAppointmentsOfEmployee($employeeId);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    static function getQuickAccessAppointments($sortingBy,$employeeId=false )
    {
        $date=time();//make sure that the time will be local!
//        if(!isset($employeeId)) throw new Exception("No Employee ID!");
        try
        {
            if($employeeId)
            {//if manager choose to show only one employee

                switch ($sortingBy)
                {//  ��� ����� ���� ����� �������� ��� ����� ����� ���� ���� �� ����� ���� ���� UI �� ������ ����� ���� ��� ���� ���� ����� �������� ����� , ��� ������ �
                    case "day":return AppointmentDBDAO::getAllEmployeeAppointments_byDate($date, $employeeId);break;
                    case "week":return AppointmentDBDAO::getAllEmployeeAppointments_fromDateToDate($date, $date + 604800, $employeeId);break;
                    case "month":return AppointmentDBDAO::getAllEmployeeAppointments_byMonth($date, $employeeId);break;
                }
            }
            else{//if manager choose to show all employees

                switch ($sortingBy)
                {
                    case "day":return AppointmentDBDAO::getAllAppointments_byDate($date);break;
                    case "week":return AppointmentDBDAO::getAllAppointments_fromDateToDate($date, $date + 604800);break;
                    case "month":return AppointmentDBDAO::getAllAppointments_byMonth($date);break;
                }
            }


        }
        catch(Exception $e)
        {
            return false;
        }
    }


    //--------------����� ���� ������ -----------------------



    static function getContactUs()
    {

        if ($contactUs = ContactUsDBDAO::getContactUs())
        {
            return $contactUs;
        }
        else
        {
            throw new Exception("there is nothing to show in cuntact us !");
        }


    }

    static function setContactUs(ContactUs $contactUs)
    {
        if (!ContactUsDBDAO::getContactUs())
        {
            ContactUsDBDAO::createContactUs($contactUs);
        }
        else
        {
            throw new Exception("cuntact us  is set Alredy!");
        }


    }
    static function updateContactUs(ContactUs $contactUs)
    {
        if (ContactUsDBDAO::getContactUs()!=null)
        {

            ContactUsDBDAO::updateContactUs($contactUs);

            var_dump($contactUs);
        }
        else throw new Exception("can't update- contact Us is not set !");

    }
    static function deleteContactUs()//rest �� ���� ����� ������ �������� ��� ���� ���� ����� ��
    {
        // ����� ����� ������ ����� ���� �����
        ContactUsDBDAO::deleteContactUs();
    }
    //-------------------------------------

    // ����� �����
    //����� �� �������� ������ �����
    static function ExportAppointmentByDateToPDF(array $emloyeeIDS,$date)//���� �� ������ ��� �����  ����� ��� ������
    {
        $eachEmployeeApointment=[];//�� ������ ������� ����� ��� ��� �� ���� ��� ���� ������ �� ������ ���
        foreach ($emloyeeIDS as $employeeId)
        {
            $eachEmployeeApointment[$employeeId]=AppointmentDBDAO::getAllEmployeeAppointments_byDate($date, $employeeId);

        }
        return $eachEmployeeApointment;//�� �� ������ ���� ����
    }

    //--------------------������ ������ ---------------------
    static function galleryLinks()//������� ������ �� �� ���� ������ �� ������� �� ����� ����
    {
        //http://php.net/manual/en/function.scandir.php
        //http://php.net/manual/en/function.dirname.php
        //http://www.html-form-guide.com/php-form/php-form-action-self.html
        //http://php.net/manual/en/function.dirname.php
        //http://stackoverflow.com/questions/4645082/get-absolute-path-of-current-script

        //new3/bla
        //bla

// 		$directory = "d:/Users/Harel/Desktop/7.12.2015";
        //uncomment
        //***************************************************************************************************
        $directory= 'Gallery';



//        $scanned_directory = array_diff(scandir($directory), array('..', '.'));

        $scanned_directory = array_diff(scandir($_SERVER['DOCUMENT_ROOT'].'/'.$directory), array('..', '.'));

        $arr=[];
        $rootFolder=$_SERVER['PHP_SELF'];
//        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].dirname($rootFolder)."/";
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/";
        foreach ($scanned_directory as $imageLink)
        {
            $data = getimagesize($directory."/".$imageLink);
            $width = $data[0];
            $height = $data[1];


            $object = new stdClass();
            $object->url = $actual_link.$directory."/".$imageLink;
            $object->title = $imageLink;
            $object->width = $width;
            $object->height = $height;

            $arr[] =  $object;

//            $arr[] =  $actual_link.$directory."/".$imageLink;

// 			printToTerminal(    $actual_link.$directory."/".$imageLink."<br/>";
            //לבדוק איך להדפיס את התמונות על המסך
        }



        return $arr;
        //***************************************************************************************************

//        return array_diff(scandir(dirname($_SERVER['DOCUMENT_ROOT']).'/Gallery'), array('..', '.'));

//        return ($_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF']);
//         $path = explode("/",$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);
//         return  "http://".$path[0]."/".$path[1];
    }
    static function deleteFromGallery(array $images)
    {
        $folderName = $_SERVER['DOCUMENT_ROOT'].'/Gallery/';
        foreach ($images as $imageToDelete)
        {
            if (file_exists($folderName.$imageToDelete))
                unlink($folderName.$imageToDelete);
            else throw new Exception ("path:".$folderName."----------------file $imageToDelete doesn't exist!");

        }

    }
    static function uploadImages()//����� ����� �� ��������
    {
        //����� �����
        if (isset($_FILES['filename']))
        {
// 			if($_FILES['filename']['error']!= 4)
// 			{
// 				$fname=$_FILES['filename']['name'];
// 				$type=$_FILES['filename']['type'];
// 				$size=$_FILES['filename']['size'];
// 				$tmp=$_FILES['filename']['tmp_name'];
// 				printToTerminal( "$fname <br/> $type <br/> $size <br/> $tmp <br/>";
// 				var_dump($_FILES);
// 				move_uploaded_file($tmp, $fname);
// 			}
// 			else
// 				printToTerminal( "no file uploaded!!!<br/>";
        }
    }

    static function filterAppointments($startDate,$endDate,$employeeId,$customerId)
    {
        return AppointmentDBDAO::getFilteredAppointments($startDate,$endDate,$employeeId,$customerId);
    }
    //----------------------�����-------------------------
    static function setCoordinates($Latitude, $Longitude)
    {
        try {
            $fname = $_SERVER['DOCUMENT_ROOT'] . "/Coordinates";
            $fhandle = fopen($fname, 'w+');

// 			fwrite($fhandle, $Latitude);
// 			fwrite($fhandle,"\n");
// 			fwrite($fhandle, $Longitude);
// // 			fwrite($fhandle, "\n");
// 			fclose($fhandle);

            $coordinates["Latitude"] = "" . $Latitude;
            $coordinates["Longitude"] = "" . $Longitude;

            fwrite($fhandle, json_encode($coordinates));
            fclose($fhandle);

        }catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }


    }

    static function showCoordinates()
    {
// 		$coordinates=[];
        $fname="Coordinates";
        if(file_exists($fname))
        {
// 			$fhandle=fopen($fname, 'r');
// 			while(!feof($fhandle))
// 			{

// 				$Latitude=fgets($fhandle);
// 				$Longitude=fgets($fhandle);
// 					printToTerminal( $Longitude;
// 				$coordinates["Latitude"]= "".$Latitude;
// 				$coordinates["Longitude"]= "".$Longitude;
// 				var_dump($coordinates);
// 			}
// 			fclose($fhandle);
// 		return json_encode($coordinates);
            return json_decode(file_get_contents($fname));
        }
        else
            throw new Exception ("no Coordinates available!");

    }


    //-------------------����� ��� ��� �� ��� --------------------------------
    //-------------------------------------------------------------------
    static function getAppointmentDuration()
    {
        $fname = "AppointmentDuration";
        printToTerminal($fname);
        if(file_exists($fname))
            return (int)file_get_contents($fname);

        else
            throw new Exception ("no Appointment Duration available!");

    }
    static function setAppointmentDuration($appointmentDuration)// ����� ������ ��� ��� ������ ����� ����� ����� ����� ���� ������ ���� �� ��� ���� ����� ���� 900 ���� //����� ��� ���� �� ��������� ��� ���� �� ����� ���� ��� ������
    {
        //����� ����� ����� ���� ���� ������ ���� ���� 040 ������ ���� ����� 32 ����� 0 ���� �� ����� ������ �� ���� ����� ������ ������ ����� �� �� ����� ���� ���� ������ ��� ���� ����� ����
        (is_string($appointmentDuration) ?  $appointmentDuration = intval($appointmentDuration) :  $appointmentDuration = 0);
        // 		if (0099)
        // 				printToTerminal( "true";
        // 		else printToTerminal( "flase";

        //         substr($number, 0, $number < 0 ? 3 : 2);
        if(is_int($appointmentDuration) && $appointmentDuration>0)//try ����� �� �� ���� �
        {
            $appointmentDuration=$appointmentDuration*60;//���� ����� ���� ������
            $fname="AppointmentDuration";
            $fhandle=fopen($fname, 'w+');
            fwrite($fhandle, $appointmentDuration);
            // 			fwrite($fhandle,"\n");//��� ���� ���� ����
            fclose($fhandle);
        }
        else throw new Exception ("you must put a valid number or bigger than 0");

    }
    //-------------------------------------------------------------------
    //-------------------------------------------------------------------


    //----------------------------����������� -------------------------------
    static function notificationMessages($message, $comment="")
    {
        //������ �� ������� ���� ���� ������ ���� ����� �� ��� �����
        // �� ���� ���� ���� ���� ������� ��� UI ����� ��������� ������� ������ �������� ����� �����

        printToTerminal( $message."--------------------".$comment);
    }
    //-------------------------------------------------------------------
    //-------------------------------------------------------------------


    //------------------------------����� ���� /����---------------------------
    //-------------------------------------------------------------------
    static function blockCustomer($custId)// ��� ������� ���� ��� ������ �� ����� ����� �� �� ����� ��� -�� ������ ����� ���� �� �����

    {
        CustomerDBDAO::deactivateCustomer($custId);
    }
    static function unBlockCustomer($custId)
    {
        CustomerDBDAO::activateCustomer($custId);
    }
    static function blockEmployee($empId)// ��� ������� ���� ��� ������ �� ����� ����� �� �� ����� ��� -�� ������ ����� ���� �� �����

    {
        EmployeeDBDAO::deactivateEmployee($empId);
    }
    static function unBlockEmployee($empId)
    {
        EmployeeDBDAO::activateEmployee($empId);
    }
}

