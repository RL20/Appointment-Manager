<?php
require_once  __DIR__.'/../requires.php';


/**
 * Created by PhpStorm.
 * User: Harel
 * Date: 11/6/2017
 * Time: 9:26 PM
 */
class ServiceTypeDBDAO
{
//return one service type
    static function getServiceType($serviceTypeId)
    {
        $mysqli = SQLConnection::getConnection();

        if (!($stmt = $mysqli->prepare("SELECT * FROM service_type WHERE ID = ?"))) {
            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
        }

        if (!$stmt->bind_param("i", $serviceTypeId)) {
            printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        if (!$stmt->execute()) {
            printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        if (!($result = $stmt->get_result())) {
            printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
        }


        $row = $result->fetch_object();

        try {
            if(!$row)
            {
                throw new Exception("row is null");
            }
            $serviceType = new ServiceType($row->ID,$row->SERVICE_NAME,$row->DURATION);        }
        catch (Exception $e)
        {
// 			throw new Exception("djfkygvhudhgfvbjdfhvbjdfhbvjdfhb");
            throw new IdDoesNotExistsException();
        }
        finally {
            $mysqli->close();
        }

        return $serviceType;
    }
//return all services type
    static function getAllServicesType()
    {
        $mysqli = SQLConnection::getConnection();

        if (!($result = $mysqli->query("SELECT * FROM service_type"))) {
            printToTerminal( "Getting result set failed: (" . $mysqli->errno . ") " . $mysqli->error);
        }

        $servicesType=[];

        try{
            //todo check if raw is empty instaed this  if(!$row)
//            $row = $result->fetch_object();
//            if(!$row)
//            {
//                throw new Exception("Contact Us is empty!");
//            }
            while ($row = $result->fetch_object())//while ($row $row = $result->fetch_object())
            {
                $serviceType = new ServiceType($row->ID,$row->SERVICE_NAME,$row->DURATION);
                $allServicesType[]=$serviceType;
            }

        }
        catch (Exception $e)
        {
            throw new Exception("there is no services!");

        }
        finally {
            $mysqli->close();
        }


        return $allServicesType;
    }

    static function createServiceType(ServiceType  $serviceType)
    {
        $mysqli = SQLConnection::getConnection();


        if (!($stmt = $mysqli->prepare("INSERT INTO service_type (ID, SERVICE_NAME, DURATION ) VALUES (NULL,?,?)"))) {
            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);

        }

//        $id=$serviceType->getId();
        $serviceName=$serviceType->getServiceName();
        $duration=$serviceType->getDuration();



        if (!$stmt->bind_param("si", $serviceName, $duration)) {
            printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        }


        if (!$stmt->execute()) {
            printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }
        else printToTerminal( " <br/>service type created successfuly!!");

        $mysqli->close();

    }

    static function updateServiceType(ServiceType  $serviceType)
    {
        $mysqli = SQLConnection::getConnection();

        if (!($stmt = $mysqli->prepare("UPDATE service_type SET SERVICE_NAME=?,DURATION=? WHERE ID=?"))) {
            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
        }

        $id=$serviceType->getId();
        $serviceName=$serviceType->getServiceName();
        $duration=$serviceType->getDuration();

        if (!$stmt->bind_param("sii",$serviceName,$duration,$id)) {
            printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        if (!$stmt->execute()) {
            printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        $rowsNum = $mysqli->affected_rows;

        //checks if rawsAffected is not equals to 1, if so this means that 0 rows affected or more than 1
        //if true handle result with suitable exception
        if($rowsNum !== 1)
        {
            if($rowsNum === 0)// ���� �� �� ���� ��� �� �� �� 0  �� ���� ���� ����
            {
                //write Exception class for this exception
                throw new Exception("service type  ID does not exist!");
            }
            else if($rowsNum > 1)
            {
// 				write to log
            }
        }
        else
        {
            printToTerminal( " <br/> service type updated successfuly!!");
        }


        $mysqli->close();

    }

    static function deleteServiceType( $serviceTypeId)
    {
        $mysqli = SQLConnection::getConnection();

        if (!($stmt = $mysqli->prepare("DELETE FROM service_type WHERE ID=?"))) {
            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
        }

        if (!$stmt->bind_param("i", $serviceTypeId)) {
            printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        if (!$stmt->execute()) {
            printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        $rowsNum = $mysqli->affected_rows;

        //checks if rawsAffected is not equals to 1, if so this means that 0 rows affected or more than 1
        //if true handle result with suitable exception
        if($rowsNum !== 1)
        {
            if($rowsNum === 0)// ���� �� �� ���� ��� �� �� �� 0  �� ���� ���� ����
            {
                //write Exception class for this exception
                throw new Exception("service type ID does not exist!");
            }
            else if($rowsNum > 1)
            {
// 				write to log
            }
        }
        else
        {
            printToTerminal( " <br/> service type  deleted successfuly!!");
        }


        $mysqli->close();
    }
//*******************************************************************************************************************************************************
//*******************************************************************************************************************************************************
//*******************************************************************************************************************************************************

//return all employees with service type we are looking for
    static function getAllServiceTypeEmployees( $serviceTypeId)
    {
        $mysqli = SQLConnection::getConnection();

        if (!($stmt = $mysqli->prepare("SELECT employee.ID ,employee.NAME_, employee.PASSWORD_, employee.PHONE,employee.EMAIL FROM employee INNER JOIN employee_service_type ON employee_service_type.EMP_ID=employee.ID WHERE employee_service_type.SERVICE_TYPE_ID=?"))) {
            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
            throw new Exception($mysqli->errno);
        }

        if (!$stmt->bind_param("i", $serviceTypeId)) {
            printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        if (!$stmt->execute()) {
            printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        if (!($result = $stmt->get_result())) {
            printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
        }


        $employeesList=[];
        while ($row = $result->fetch_object())
        {


            $employee = new Employee($row->NAME_, $row->PASSWORD_,$row->PHONE,$row->EMAIL);
            $employeesList[]=$employee;
        }

        $mysqli->close();

        return $employeesList;
    }

    static function getAllOverlappingServiceType($serviceTypeIds)
    {
//        $mysqli = SQLConnection::getConnection();
        $mysqli = new PDO('mysql:host=localhost;dbname=appointmentappdbnew', 'admin', '12345678');
        $mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $mysqli->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

//        if (!($stmt = $mysqli->prepare('SELECT DISTINCT service_type.SERVICE_NAME, service_type.DURATION, service_type.ID FROM service_type INNER JOIN employee_service_type ON employee_service_type.SERVICE_TYPE_ID=service_type.ID WHERE service_type.ID in (' . str_repeat('?,', count($serviceTypeIds) - 1) . '?' . ') AND employee_service_type.EMP_ID IN (' . str_repeat('?,', count($empIds) - 1) . '?' . ')'))) {
//            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
//        }
        $statement = 'SELECT DISTINCT service_type.SERVICE_NAME,service_type.DURATION, service_type.ID FROM service_type  INNER JOIN employee_service_type ON employee_service_type.SERVICE_TYPE_ID=service_type.ID WHERE employee_service_type.EMP_ID in (SELECT DISTINCT employee_service_type.EMP_ID FROM service_type INNER JOIN employee_service_type ON employee_service_type.SERVICE_TYPE_ID=service_type.ID WHERE service_type.ID in (' . str_repeat('?,', count($serviceTypeIds) - 1) . '?' . '))';
        printToTerminal($statement);
        try {
            $stmt = $mysqli->prepare($statement);


            $stmt->execute($serviceTypeIds);
//            printToTerminal($stmt);

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

         foreach( $result as $row){
             $st = new ServiceType($row['ID'], $row['SERVICE_NAME'],$row['DURATION']);
            $stList[] = $st;
         }

//        while ($row = $result->fetch_object())
//        {
//
//
//            $st = new ServiceType($row->ID, $row->SERVICE_NAME,$row->DURATION);
//            $stList[] = $st;
//        }
        }
        catch(Exception $e)
        {
            printToTerminal($e->getMessage());
            printToTerminal($e->getTraceAsString());
        }


        return $stList ;
    }

    static function getServiceTypesDurationSum($serviceTypeIds)
    {
        $duration = 0;
//        $mysqli = SQLConnection::getConnection();
        $mysqli = new PDO('mysql:host=localhost;dbname=appointmentappdbnew', 'admin', '12345678');
        $mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $mysqli->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

//        if (!($stmt = $mysqli->prepare('SELECT DISTINCT service_type.SERVICE_NAME, service_type.DURATION, service_type.ID FROM service_type INNER JOIN employee_service_type ON employee_service_type.SERVICE_TYPE_ID=service_type.ID WHERE service_type.ID in (' . str_repeat('?,', count($serviceTypeIds) - 1) . '?' . ') AND employee_service_type.EMP_ID IN (' . str_repeat('?,', count($empIds) - 1) . '?' . ')'))) {
//            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
//        }
        $statement = 'SELECT  DURATION FROM service_type WHERE ID in (' . str_repeat('?,', count($serviceTypeIds) - 1) . '?' . ')';
        printToTerminal($statement);
        try {
            $stmt = $mysqli->prepare($statement);


            $stmt->execute($serviceTypeIds);

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            printToTerminal($result);


            foreach( $result as $row)
            {
                $qwe = new DateTime(ABSOLUTE_HOUR.' '.$row['DURATION'], new DateTimeZone('UTC'));
                $duration += $qwe->getTimestamp();
            }

        }
        catch(Exception $e)
        {
            printToTerminal($e->getMessage());
            printToTerminal($e->getTraceAsString());
        }


        return $duration;
    }
    //22-11-2017
// sum the services type duration time needed from  array given from the ui
    static function sumServicesTypeTime(array $servicesTypeIds)// return duration time in second
    {
        $servicesTypeDurationTime=0;
        foreach ($servicesTypeIds as $serviceTypeId)
            $servicesTypeDurationTime+=self::getServiceType($serviceTypeId)->getDuration();
        return $servicesTypeDurationTime*60;
    }


    static function getServicesTypeList(array $servicesType)
    {
        $ServicesTypeList=[];
        foreach ($servicesType as $servicType)
            $ServicesTypeList[]=self::getServiceType($servicType);
        return $ServicesTypeList;
    }

//    static function getServicesTypeList(array $servicesType)
//    {
////        $stList=[];
////        $mysqli = SQLConnection::getConnection();
//        $mysqli = new PDO('mysql:host=localhost;dbname=appointmentappdbnew', 'admin', '12345678');
//        $mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        $mysqli->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
//
//
//        $statement = 'SELECT DISTINCT service_type.SERVICE_NAME,service_type.DURATION, service_type.ID FROM service_type   WHERE ID in (' . implode(',', array_map('intval', $servicesType)) . '))';
//        printToTerminal($statement);
//        try {
//            $stmt = $mysqli->prepare($statement);
//
//            $stmt->execute($servicesType);
//            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//
//            foreach( $result as $row){
//                $st = new ServiceType($row['ID'], $row['SERVICE_NAME'],$row['DURATION']);
//                $stList[] = $st;
//            }
//
//        }
//        catch(Exception $e)
//        {
//            printToTerminal($e->getMessage());
//            printToTerminal($e->getTraceAsString());
//        }
//
//
//        return $stList ;
//    }

}



// 888888888888888888888888888888888888888888888888
/*

static function getAllOverlappingServiceType($serviceTypeIds)
{
//        $mysqli = SQLConnection::getConnection();
$mysqli = new PDO('mysql:host=localhost;dbname=appointmentappdbnew', 'admin', '12345678');
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$mysqli->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

//        if (!($stmt = $mysqli->prepare('SELECT DISTINCT service_type.SERVICE_NAME, service_type.DURATION, service_type.ID FROM service_type INNER JOIN employee_service_type ON employee_service_type.SERVICE_TYPE_ID=service_type.ID WHERE service_type.ID in (' . str_repeat('?,', count($serviceTypeIds) - 1) . '?' . ') AND employee_service_type.EMP_ID IN (' . str_repeat('?,', count($empIds) - 1) . '?' . ')'))) {
//            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
//        }
$statement = 'SELECT DISTINCT service_type.SERVICE_NAME,service_type.DURATION, service_type.ID FROM service_type  INNER JOIN employee_service_type ON employee_service_type.SERVICE_TYPE_ID=service_type.ID WHERE employee_service_type.EMP_ID in (SELECT DISTINCT employee_service_type.EMP_ID FROM service_type INNER JOIN employee_service_type ON employee_service_type.SERVICE_TYPE_ID=service_type.ID WHERE service_type.ID in (' . str_repeat('?,', count($serviceTypeIds) - 1) . '?' . '))';
printToTerminal($statement);
try {
$stmt = $mysqli->prepare($statement);


$stmt->execute($serviceTypeIds);
//            printToTerminal($stmt);

$result = $stmt->fetchAll(PDO::FETCH_CLASS, "ServiceType");
}
catch(Exception $e)
        {
            printToTerminal($e->getMessage());
            printToTerminal($e->getTraceAsString());
        }
//        if (!()) {
//        printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
//    }


//        $stList=[];
//        while ($row = $result->fetch_object())
//        {
//
//
//            $st = new ServiceType($row->ID, $row->SERVICE_NAME,$row->DURATION);
//            $stList[] = $st;
//        }

//        $mysqli->close();

        return $result;
    }



   */









//
//
//
//
//
//
//
//
//
////****************************************************************************************************************************************
//    static function getFilteredAppointments($startDate,$endDate,$employeeId=false,$customerId=false)
//    {
//        printToTerminal( "Startdate: " . $startDate);
//        printToTerminal( "Enddate: " . $endDate);
//
//        $a=0;
//        if($employeeId)
//        {
//            $a++;
//        }
//        if ($customerId)
//        {
//            $a=$a+2;
//        }
//
//        switch ($a)
//        {
//            //employeeId
//            case  1 :return  self::getAllEmployeeAppointments_fromDateToDate($startDate,$endDate,$employeeId); break;
//
//            //cutomer
//            case  2:  return self::getAllCustomerAppointments_fromDateToDate($startDate,$endDate,$customerId);break;
//
//            //employeeId & customerId
//            case  3:return self::getAllEmployeeAppointmentsWithCustomer_fromDateToDate($startDate,$endDate,$employeeId,$customerId);break;
//
//            //all without filtering
//            default:return self::getAllAppointments_fromDateToDate($startDate,$endDate); break;
//        }
//
//
//    }
//
//
//
//}
//

//SELECT DISTINCT service_type.SERVICE_NAME, service_type.DURATION, service_type.ID
// FROM service_type
// INNER JOIN employee_service_type
// ON employee_service_type.SERVICE_TYPE_ID=service_type.ID
// WHERE service_type.ID in (' . str_repeat('?,', count($serviceTypeIds) - 1) . '?' . ')
// AND employee_service_type.EMP_ID IN (' . str_repeat('?,', count($empIds) - 1) . '?' . ')'))) {
