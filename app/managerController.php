<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
//require_once "controllers.php";
/**
 * Created by PhpStorm.
 * User: Harel
 * Date: 6/7/2017
 * Time: 8:10 PM
 */
//function printToTerminal($string)
//{
//    $f = fopen('php://stderr', 'w');
//    fputs($f, $string ."\n");
//}
//Employees
$app->post('/api/getEmployee', function (Request $request) use ($app) {

//    $id = $request->getContent();
    $id = $request->request->get('employeeId');

    printToTerminal($request);
    printToTerminal("id: ".$id);

    $responsr = managerActions::showEmployee($id);
//    $post['id'] = $post;

    return $app->json($responsr, 201);
});

$app->post('/api/getEmployeesNames', function (Request $request) use ($app) {

//    $id = $request->getContent();
    $employeesIdList = $request->request->get('employeesIdList');

    printToTerminal($request);
//    printToTerminal("employeesIdList: ".$employeesIdList);

    $responsr = managerActions::getEmployeesNames($employeesIdList);
//    $post['id'] = $post;

    return $app->json($responsr, 201);
});

$app->post('/api/getCustomersNames', function (Request $request) use ($app) {

//    $id = $request->getContent();
    $customersIdList = $request->request->get('customersIdList');

    printToTerminal($request);
//    printToTerminal("customersIdList: ".$customersIdList);

    $responsr = managerActions::getCustomersNames($customersIdList);
//    $post['id'] = $post;

    return $app->json($responsr, 201);
});

$app->get('/api/showEmployees', function () use ($app) {

//    $id = $request->request->get('employeeId');

//    VarDumper::dump("hgwevdwhebdwkjendowieoim");
    $response = managerActions::showEmployees();
//    $responsr = EmployeeDBDAO::getAllEmployees();
//    VarDumper::dump($responsr);
//    $post['id'] = $post;
//    printToTerminal(json_encode($responsr));

    return $app->json($response, 200);
});

//Customers


$app->get("/api/showCustomers",function()use ($app){
    $response = managerActions::showCustomers();
//    printToTerminal($response);
    return $app->json($response, 200);
});


//Appointments
$app->get('/api/showFutureAppointments',function() use ($app){
    $response = managerActions::showFutureAppointmentsList();
//    printToTerminal($response);
    return $app->json($response,200);
});

$app->get('/api/showAppointmentsHistory',function() use ($app){
    $response = managerActions::showAppointmentsHistory();
//    printToTerminal($response);
    return $app->json($response,200);
});


//Absence
//for a scpecific employee
$app->post('/api/showFutureEmployeeAbsence',function(Request $request) use ($app){
//    printToTerminal("jgdgtjkhjgffxvgjhgf");
try{
    $id = $request->request->get('employeeId');
    printToTerminal($id);
   if(!$id) throw new Exception('invalid id');

    $response = managerActions::showFutureEmployeeAbsence($id);
    printToTerminal($response);
}
catch (Exception $e){
    printToTerminal($e->getMessage());
    throw new Exception($e->getMessage());

}
    return $app->json($response,200);
});
//for all employees
$app->get('/api/showAllFutureAbsences',function() use ($app){
    $response = managerActions::showAllFutureAbsences();
//    printToTerminal($response);
    return $app->json($response,200);
});

$app->post('/api/upload', function (Request $request) use ($app)
{
    printToTerminal($request);
    $file = $request->files->get('uploadedFile');
    if ($file == NULL)
    {
        $send = json_encode(array("status" => "Fail"));
        return $app->json($send, 500);
    }
    else
    {
        $file->move('./Gallery', $file->getClientOriginalName());
        $send = json_encode(array("status" => "Ok"));
        return $app->json($send, 200);
    }
});
//*******************************************************************************************************************************************************************************
//*******************************************************************************************************************************************************************************
$app->get('/api/showOpeningHours', function () use ($app) {

    $response = managerActions::showOpeningHours();
    return $app->json($response, 200);
});

$app->post('/api/setOpeningHours',function(Request $request) use ($app){
    $weekArr = $request->request->get('OpeningHours');
//    $weekArr1 = json_encode($weekArr);
//    $rew = OpeningHours::createObjectsFromJsonArray($weekArr);
    printToTerminal($weekArr);
    $response=managerActions::setOpeningHours(OpeningHours::createObjectsFromJsonArray($weekArr));
    return $app->json($response, 200);
});

$app->post('/api/updateOpeningHours',function(Request $request) use ($app){
    $weekArr = $request->request->get('OpeningHours');
//    $weekArr1 = json_encode($weekArr);
//    $rew = OpeningHours::createObjectsFromJsonArray($weekArr);
    printToTerminal($weekArr);
    $response=managerActions::updateOpeningHours(OpeningHours::createObjectsFromJsonArray($weekArr));
    return $app->json($response, 200);
});

$app->get('/api/showCustomers', function () use ($app) {
    $response = managerActions::showCustomers();
    return $app->json($response, 200);
});

$app->get('/api/showEmployees', function () use ($app) {

    $response = managerActions::showEmployees();
    return $app->json($response, 200);
});

$app->post('/api/showEmployee',function(Request $request) use ($app){
    $id = $request->request->get('employeeId');
    $response = managerActions::showEmployee($id);
    return $app->json($response,200);
});

$app->post('/api/showCustomer',function(Request $request) use ($app){
    $id = $request->request->get('customerId');
    $response = managerActions::showCustomer($id);
    return $app->json($response,200);
});

$app->post('/api/blockAppointment',function(Request $request) use ($app){
    $appointmentToBlock = $request->request->get('BlockedAppointment');
    printToTerminal("object: ".json_encode($appointmentToBlock));
    printToTerminal("is set: ". isset($appointmentToBlock));
    $response=managerActions::blockAppointment(BlockedAppointment::createObjectFromJson($appointmentToBlock));
    return $app->json($response,200);
});

$app->post('/api/unBlockAppointment',function(Request $request) use ($app){
    $id = $request->request->get('blockAppointmentId');
    $response=managerActions::unBlockAppointment($id);
    return $app->json($response,200);

});
$app->post('/api/setAppointment',function(Request $request) use ($app){
    $appointment = $request->request->get('Appointment');
    printToTerminal("object: ".json_encode($appointment));
    $response =managerActions::setAppointment(Appointment::createObjectFromJson($appointment));
    return $app->json($response,200);

});

$app->post('/api/cancelAppointment',function(Request $request) use ($app){
    $appointment = $request->request->get('Appointment');
    $comment = $request->request->get('comment');
    $response =managerActions::cancelAppointment(Appointment::createObjectFromJson($appointment),$comment);
    return $app->json($response,200);
});

$app->post('/api/changeAppointment',function(Request $request) use ($app){
    $appointment = $request->request->get('Appointment');
    $response =managerActions::changeAppointment(Appointment::createObjectFromJson($appointment));
    return $app->json($response,200);
});

$app->post('/api/setEmployeeAbsence',function(Request $request) use ($app){
    $employeeAbsence = $request->request->get('EmployeeAbsence');
    $deleteAppointmentConfirmation=$request->request->get('deleteAppointmentConfirmation');
    $comment = $request->request->get('comment');
    $response =managerActions::setEmployeeAbsence(EmployeeAbsence::createObjectFromJson($employeeAbsence),$deleteAppointmentConfirmation,$comment);
    return $app->json($response,200);
});
//
$app->post('/api/setFullDayEmployeeAbsence',function(Request $request) use ($app){
    $date = $request->request->get('date');
    $employeeId = $request->request->get('employeeId');
    $deleteAppointmentConfirmation=$request->request->get('deleteAppointmentConfirmation');
    $comment = $request->request->get('comment');
//TODO: should change the createEmployeeAbsence function to accept timestamp instead of string to match all the other functions in DBDAO
    $response = managerActions::setFullDayEmployeeAbsence($date,$employeeId, $deleteAppointmentConfirmation,$comment);
    return $app->json($response,200);
});

$app->post('/api/deleteAllEmployeeAbsenceInAday',function(Request $request) use ($app){

    $date = $request->request->get('date');
    $employeeId = $request->request->get('employeeId');
    $response = managerActions::deletAllEmployeeAbsenceInAday(strtotime($date), $employeeId);
    return $app->json($response,200);
});

$app->post('/api/deleteEmployeeAbsence',function(Request $request) use ($app){
    $id = $request->request->get('id');
    $response =managerActions::deletEmployeeAbsence($id);
    return $app->json($response,200);
});

$app->post('/api/showFutureEmployeeAbsence',function(Request $request) use ($app){
    $response = null;
    try {
    $employeeId = $request->request->get('employeeId');

    $response = managerActions::showFutureEmployeeAbsence($employeeId);
    return $app->json($response,200);
}
    catch(Exception $e){
        printToTerminal($e->getMessage());
        $response->setStatusCode(500);
        throw new Exception($e->getMessage());
    }
//    return $response;
});

$app->get('/api/showAllFutureAbsences', function () use ($app) {
    $response = managerActions::showAllFutureAbsences();
    return $app->json($response,200);
});

$app->get('/mail', function () use ($app) {

//    require("class.PHPMailer.php");


    $mail = new PHPMailer();

    $mail->SMTPDebug = 5;

    $mail->IsSMTP();                                      // set mailer to use SMTP
    $mail->Host = "localhost";  // specify main and backup server
//    $mail->SMTPAuth = true;     // turn on SMTP authentication
//    $mail->Username = "jswan";  // SMTP username
//    $mail->Password = "secret"; // SMTP password
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->From = "aviya@aviya.org";
    $mail->FromName = "Mailer";
    $mail->AddAddress("aviyaomesi@gmail.com", "Josh Adams");
//    $mail->AddAddress("ellen@example.com");                  // name is optional
    $mail->AddReplyTo("info@example.com", "Information");

//    $mail->WordWrap = 50;                                 // set word wrap to 50 characters
//    $mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
//    $mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
    $mail->IsHTML(true);                                  // set email format to HTML

    $mail->Subject = "Here is the subject";
    $mail->Body    = "This is the HTML message body <b>in bold!</b>";
    $mail->AltBody = "This is the body in plain text for non-HTML mail clients";

    if(!$mail->Send())
    {
        echo "Message could not be sent. <p>";
        echo "Mailer Error: " . $mail->ErrorInfo;
        exit;
    }

    echo "Message has been sent";
    return 200;
});

//Exception handler
$app->error(function (Exception $e, Request $request, $code) use ($app) {
    printToTerminal("CODE: " . $code);
    printToTerminal("MESSAGE: " . $e->getMessage());
    printToTerminal("TRACE: " . $e->getTraceAsString());

    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:

            $message['code'] = $e->getCode();
            $message['message'] = $e->getMessage();
    }
     return $app->json($message, 500);
});


$app->post('/api/setNewEmployee',function(Request $request) use ($app){
    $response = new Response();
    $employee = $request->request->get('Employee');
//    $appointmentToBlock = $request->getContent();
//    $appToBlock = json_encode($appointmentToBlock);
//    $rew = OpeningHours::createObjectsFromJsonArray($weekArr);

    printToTerminal("object: ".json_encode($employee));
//    printToTerminal("is set: ". isset($appointment));

//    try{
        managerActions::setNewEmployee(Employee::createObjectFromJson($employee));
        $response->setStatusCode(200);
        return $response;
//    }
//    catch(Exception $e){
//
//        printToTerminal("Exception!");
////        printToTerminal($e->getMessage());
////        $app->abort(500, $e->getMessage());
//        $response->setStatusCode(500);
//    }

//    return "jyg";
});

$app->post('/api/setNewCustomer',function(Request $request) use ($app){
    $customer = $request->request->get('Customer');
//    $appointmentToBlock = $request->getContent();
//    $appToBlock = json_encode($appointmentToBlock);
//    $rew = OpeningHours::createObjectsFromJsonArray($weekArr);

    printToTerminal("object: ".json_encode($customer));
//    printToTerminal("is set: ". isset($appointment));

//    try{

        $id = managerActions::setNewCustomer(Customer::createObjectFromJson($customer));
//        $q =
//        $response->setStatusCode(200);
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//    }

    return $app->json($id,200);
});

$app->post('/api/updateCustomerDetails',function(Request $request) use ($app){
    $customer = $request->request->get('Customer');
    printToTerminal($customer);
    $response =managerActions::updateCustomerDetails(Customer::createObjectFromJson($customer));
    return $app->json($response,200);
});

$app->post('/api/updateEmployeeDetails',function(Request $request) use ($app){
    $employee = $request->request->get('Employee');
    printToTerminal($employee);
    $response =managerActions::updateEmployeeDetails(Employee::createObjectFromJson($employee));
    return $app->json($response,200);
});

$app->get('/api/showTodayAppointmentsList', function () use ($app) {

    $response = managerActions::showTodayAppointmentsList();
    return $app->json($response, 200);
});

$app->post('/api/showFutureAppointmentsList',function(Request $request) use ($app){

    $date = $request->request->get('date');
    $time = $request->request->get('time');
    $limit = $request->request->get('limit');
    $response = managerActions::showFutureAppointmentsList($date=false,$time=false,$limit=false);
    return $app->json($response,200);
});

$app->post('/api/showAppointmentsHistory',function(Request $request) use ($app){

    $date = $request->request->get('date');
    $time = $request->request->get('time');
    $limit = $request->request->get('limit');
    $response = managerActions::showAppointmentsHistory($date=false,$time=false,$limit=false);
    return $app->json($response,200);

});

$app->post('/api/showCustomerAppointments',function(Request $request) use ($app){

    $id = $request->request->get('customerId');

    $response = managerActions::showCustomerAppointments($id);
    return $app->json($response,200);
});

$app->post('/api/showEmployeeAppointments',function(Request $request) use ($app){

    $employeeId= $request->request->get('employeeId');
    $sortingBy= $request->request->get('sortingBy');

    printToTerminal("employeeId: " . $employeeId);
    if(isset($sortingBy))
    $response = managerActions::showEmployeeAppointments($employeeId,$sortingBy);
    else{
        printToTerminal("no SortingBy");
        $response = managerActions::showEmployeeAppointments($employeeId);
        printToTerminal($response);
    }
    return $app->json($response,200);
});

$app->post('/api/getQuickAccessAppointments',function(Request $request) use ($app){

    $employeeId= $request->request->get('employeeId');
    $sortingBy= $request->request->get('sortingBy');

//    printToTerminal("employeeId: " . $employeeId);
//    if($sortingBy)
    $response = managerActions::getQuickAccessAppointments($sortingBy,$employeeId);
//    else{
//        printToTerminal("no SortingBy");
//        $response = managerActions::getQuickAccessAppointments($employeeId);
//        printToTerminal($response);
//    }
    return $app->json($response,200);
});

$app->post('/api/filterAppointments',function(Request $request) use ($app){

    $startDate=$request->request->get('minDate');
    $endDate=$request->request->get('maxDate');
    $employeeId= $request->request->get('employeeId');
    $customerId= $request->request->get('customerId');

    $response = managerActions::filterAppointments($startDate,$endDate,$employeeId,$customerId);

    return $app->json($response,200);
});
//88888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888
$app->post('/api/setContactUs',function(Request $request) use ($app){
    $ContactUs = $request->request->get('ContactUs');
    printToTerminal("object: ".json_encode($ContactUs));
    $response = managerActions::setContactUs(ContactUs::createObjectFromJson($ContactUs));
    return $app->json($response,200);
});
//
$app->post('/api/updateContactUs',function(Request $request) use ($app){
    $ContactUs = $request->request->get('ContactUs');
    $response=managerActions::updateContactUs(ContactUs::createObjectFromJson($ContactUs));
    return $app->json($response,200);
});

$app->get('/api/getContactUs', function () use ($app) {

    $response = managerActions::getContactUs();
    return $app->json($response, 200);
});

$app->get('/api/galleryLinks', function () use ($app) {

    $response = managerActions::galleryLinks();
    return $app->json($response, 200);
});

$app->post('/api/deleteFromGallery',function(Request $request) use ($app){

    $images = $request->request->get('images');
    $response = managerActions::deleteFromGallery($images);
    return $app->json($response, 200);
});

$app->post('/api/setCoordinates',function(Request $request) use ($app){

    $Latitude = $request->request->get('Latitude');
    $Longitude= $request->request->get('Longitude');
    printToTerminal($Longitude ."     ". $Latitude);
    $response=managerActions::setCoordinates($Latitude,$Longitude);
    return $app->json($response, 200);
});
$app->get('/api/showCoordinates', function () use ($app) {
    $response = managerActions::showCoordinates();
    $response ->address = managerActions::getContactUs()->getAddress();
    return $app->json($response, 200);
});

$app->post('/api/setAppointmentDuration',function(Request $request) use ($app){
    $AppointmentDuration = $request->request->get('AppointmentDuration');
    $response=managerActions::setAppointmentDuration($AppointmentDuration);
    return $app->json($response, 200);
});
$app->get('/api/getAppointmentDuration', function () use ($app) {
    $response = managerActions::getAppointmentDuration();
    return $app->json($response, 200);
});
$app->post('/api/notificationMessages',function(Request $request) use ($app){

    $message=$request->request->get('message');
    $comment=$request->request->get('comment');

    $response = managerActions::notificationMessages($message,$comment);
    return $app->json($response,200);
});

$app->post('/api/blockCustomer',function(Request $request) use ($app){
    $Id = $request->request->get('customerId');
    $response=managerActions::blockCustomer($Id);
    return $app->json($response,200);
});

$app->post('/api/unBlockCustomer',function(Request $request) use ($app){
    $id = $request->request->get('customerId');
    $response=managerActions::unBlockCustomer($id);
    return $app->json($response,200);
});

$app->post('/api/blockEmployee',function(Request $request) use ($app){
    $id = $request->request->get('employeeId');
    $response=managerActions::blockEmployee($id);
    return $app->json($response,200);

});


$app->post('/api/unBlockEmployee',function(Request $request) use ($app){
    $id = $request->request->get('employeeId');
    $response=managerActions::unBlockEmployee($id);
    return $app->json($response,200);
});


$app->get('/api/get', function () use ($app) {
    $status = 200;
    $response = null;

    $response = EmployeeDBDAO::getEmployee(2) ;
//    printToTerminal($response);


    return $app->json($response, $status);
});

///functions for commonActions


$app->post('/api/getAvailableDaysInMonthForAllEmployees',function(Request $request) use ($app){

    $year= $request->request->get('year');
    $month=$request->request->get('month');

    $response = commonActions::getAvailableDaysInMonthForAllEmployees($year, $month);
    return $app->json($response,200);
});

$app->post('/api/getAvailableDaysInMonthByEmployeeId',function(Request $request) use ($app){

    $year= $request->request->get('year');
    $month=$request->request->get('month');
    $employeeId=$request->request->get('employeeId');


    $response = commonActions::getAvailableDaysInMonthByEmployeeId($year, $month, $employeeId );
    return $app->json($response,200);
});
// new edited 23-11-2017
$app->post('/api/getFirst20AvailableAppointments',function(Request $request) use ($app){

    $employeeId=$request->request->get('employeeId');
    $serviceTypeIds=$request->request->get('serviceTypeIds');
    $date = $request->request->get('date');

    printToTerminal($serviceTypeIds);
    $response = commonActions::getFirst20AvailableAppointments($employeeId,$serviceTypeIds, $date);
    return $app->json($response,200);
});
//$app->post('/api/getFirst20AvailableAppointments',function(Request $request) use ($app){
//
//    $employeeId=$request->request->get('employeeId');
//    $date = $request->request->get('date');
//
//    printToTerminal($request);
//    $response = commonActions::getFirst20AvailableAppointments($employeeId, $date);
////    $response ="kjm";
//    return $app->json($response,200);
//});
$app->post('/api/getFirst20AvailableAppointmentsFromAllEmployees',function(Request $request) use ($app){

    $serviceTypeIds = $request->request->get('serviceTypeIds');
    $date = $request->request->get('date');
    printToTerminal($request);

    $response = commonActions::getFirst20AvailableAppointmentsFromAllEmployees($serviceTypeIds, $date);

    return $app->json($response,200);
});

$app->post('/api/allEmployeeAvailableHoursInDay',function(Request $request) use ($app){

    $date=$request->request->get('date');
    $employeeId=$request->request->get('employeeId');

    $response = commonActions::allEmployeeAvailableHoursInDay($date,$employeeId );
    printToTerminal('response:' . json_encode($response));
    return $app->json($response,200);
//    return $app->json('sdfugshdfilugvsheoiruhfsoeiurhfvourseliv',200);
});

$app->post('/api/getAllEmployeesAvailableHoursInDay',function(Request $request) use ($app){

    $serviceTypeIds = $request->request->get('serviceTypeIds');
    $date = $request->request->get('date');
//    printToTerminal($response[0]);
    $response = commonActions::getAllEmployeesAvailableHoursInDay($serviceTypeIds, $date,0);
//    printToTerminal($response[0]);
    return $app->json([$response],200);
});

//**************************************************************************************
$app->post('/api/getAllOverlappingServiceTypes',function(Request $request) use ($app){

    $serviceTypeIds = $request->request->get('serviceTypeIds');
    printToTerminal(json_encode($serviceTypeIds));
    $response = commonActions::getAllOverlappingServiceType($serviceTypeIds);
//    printToTerminal($response[0]);
    return $app->json($response, 200);
});


$app->post('/api/getServiceType',function(Request $request) use ($app){
    $serviceTypeId = $request->request->get('serviceTypeId');
    $response= commonActions::getServiceType($serviceTypeId);
    return $app->json($response, 200);
});

$app->get('/api/getAllServiceTypes', function () use ($app) {
    $response = commonActions::getAllServicesType();
    return $app->json($response, 200);
});

$app->post('/api/getAllServiceTypeEmployees',function(Request $request) use ($app){

    $serviceTypeId = $request->request->get('serviceTypeId');
    $response=commonActions::getAllServiceTypeEmployees($serviceTypeId);
    return $app->json($response, 200);
});

$app->post('/api/createServiceType',function(Request $request) use ($app){
    $serviceType = $request->request->get('ServiceType');
    $response=managerActions::createServiceType( ServiceType::createObjectFromJson($serviceType));
    return $app->json( 200);
});

$app->post('/api/updateServiceType',function(Request $request) use ($app){
    $serviceType = $request->request->get('ServiceType');
    $response=managerActions::updateServiceType( ServiceType::createObjectFromJson($serviceType));
    return $app->json($response, 200);
});

$app->post('/api/deleteServiceType',function(Request $request) use ($app){
    $serviceTypeId = $request->request->get('serviceTypeId');
    $response=managerActions::deleteServiceType( $serviceTypeId);
    return $app->json($response, 200);
});

//***************************************************************************************************************************************
//todo this function is only for testing , to be deleted after testing
$app->post('/api/getPossibleAppointmentsList_ByDay',function(Request $request) use ($app){
    $singleDay = $request->request->get('singleDay');
    $response=commonActions::getPossibleAppointmentsList_ByDay(WorkHours::createObjectFromJson($singleDay));
    return $app->json($response, 200);
});


//todo check where to move this function or let it stay in ServiceTypeDBDAO
$app->post('/api/sumServicesTypeTime',function(Request $request) use ($app){
    $servicesTypeIds = $request->request->get('servicesTypeIds');
    $response=ServiceTypeDBDAO::sumServicesTypeTime($servicesTypeIds);
    return $app->json($response, 200);
});

$app->post('/api/getServiceTypesDurationSum',function(Request $request) use ($app){
    $servicesTypeIds = $request->request->get('servicesTypeIds');
    $response = ServiceTypeDBDAO::getServiceTypesDurationSum($servicesTypeIds);
    return $app->json($response, 200);
});

$app->post('/api/getServicesTypeList',function(Request $request) use ($app){
    $servicesTypeIds = $request->request->get('servicesTypeIds');
    $response=ServiceTypeDBDAO::getServicesTypeList($servicesTypeIds);
    return $app->json($response, 200);
});
//$app->post('/api/getServicesTypeList',function(Request $request) use ($app){
//    $servicesType = $request->request->get('servicesType');
//    $response=ServiceTypeDBDAO::getServicesTypeList($servicesType);
//    return $app->json($response, 200);
//});






$app->post('/api/getAllWindowTimeBetwinAppointment',function(Request $request) use ($app){
    $employeeId=$request->request->get('employeeId');
    $necessaryDuration=$request->request->get('duration');
    $date = $request->request->get('date');
    $response = AppointmentDBDAO::getAllWindowTimeBetwinAppointmentA($employeeId,$date,$necessaryDuration);
    return $app->json($response, 200);
});

//$app->post('/api/getAllWindowTimeBetwinAppointment',function(Request $request) use ($app){
////    $singleDay = $request->request->get('date');
//    $response = AppointmentDBDAO::getAllWindowTimeBetwinAppointmentA(2,1511827200,400);
//    return $app->json($response, 200);
//});
/*
 * check run time
$app->post('/api/getAllWindowTimeBetwinAppointment',function(Request $request) use ($app){
//    $singleDay = $request->request->get('date');
    //place this before any script you want to calculate time
    $time_start = microtime(true);

//sample script

    $response = AppointmentDBDAO::getAllWindowTimeBetwinAppointmentH(2,1511827200,400);
    $time_end = microtime(true);

//dividing with 60 will give the execution time in minutes other wise seconds
    $execution_time = ($time_end - $time_start)/60;


//execution time of the script
    printToTerminal( 'Total Execution Time: '.$execution_time.' Mins');

//    $response = AppointmentDBDAO::getAllWindowTimeBetwinAppointmentA(2,1511827200,400);
    return $app->json($response, 200);
});
*/
//***************************************************************************************************************************************
/* -----------all exeptions remove from the function below , this is a copy of the function before edit on 8-11-2017---
//$app->post('/api/setOpeningHours',function(Request $request) use ($app){
//    $response = new Response();
//    $weekArr = $request->request->get('OpeningHours');
////    $weekArr1 = json_encode($weekArr);
////    $rew = OpeningHours::createObjectsFromJsonArray($weekArr);
//    printToTerminal($weekArr);
//    try{
//        managerActions::setOpeningHours(OpeningHours::createObjectsFromJsonArray($weekArr));
//        $response->setStatusCode(200);
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//    }
//
//    return $response;
//});

//$app->post('/api/updateOpeningHours',function(Request $request) use ($app){
//    $response = new Response();
//    $weekArr = $request->request->get('OpeningHours');
////    $weekArr1 = json_encode($weekArr);
////    $rew = OpeningHours::createObjectsFromJsonArray($weekArr);
//    printToTerminal($weekArr);
//    try{
//        managerActions::updateOpeningHours(OpeningHours::createObjectsFromJsonArray($weekArr));
//        $response->setStatusCode(200);
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//    }
//
//    return $response;
//});

//$app->post('/api/blockAppointment',function(Request $request) use ($app){
//    $response = new Response();
//    $appointmentToBlock = $request->request->get('BlockedAppointment');
////    $appointmentToBlock = $request->getContent();
////    $appToBlock = json_encode($appointmentToBlock);
////    $rew = OpeningHours::createObjectsFromJsonArray($weekArr);
//
//    printToTerminal("object: ".json_encode($appointmentToBlock));
//    printToTerminal("is set: ". isset($appointmentToBlock));
//
//    try{
//
//        managerActions::blockAppointment(BlockedAppointment::createObjectFromJson($appointmentToBlock));
//        $response->setStatusCode(200);
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//    }
//
//    return $response;
//});

//$app->post('/api/unBlockAppointment',function(Request $request) use ($app){
//    $response = new Response();
//
//    try
//    {
//        $id = $request->request->get('blockAppointmentId');
//        managerActions::unBlockAppointment($id);
//        $response->setStatusCode(200);
//    }catch (Exception $e)
//    {
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//    }
//
//    return $response;
//});
//$app->post('/api/setAppointment',function(Request $request) use ($app){
//    $response = new Response();
//    $appointment = $request->request->get('Appointment');
////    $appointmentToBlock = $request->getContent();
////    $appToBlock = json_encode($appointmentToBlock);
////    $rew = OpeningHours::createObjectsFromJsonArray($weekArr);
//
//    printToTerminal("object: ".json_encode($appointment));
////    printToTerminal("is set: ". isset($appointment));
//
////    try{
//
//    managerActions::setAppointment(Appointment::createObjectFromJson($appointment));
//    $response->setStatusCode(200);
////    }
////    catch(Exception $e){
////        printToTerminal($e->getMessage());
////        $response->setStatusCode(500);
////    }
//
//    return $response;
//});
//
//$app->post('/api/cancelAppointment',function(Request $request) use ($app){
//    $response = new Response();
//    $appointment = $request->request->get('Appointment');
//    $comment = $request->request->get('comment');
//
//    printToTerminal($appointment);
//    try{
//        managerActions::cancelAppointment(Appointment::createObjectFromJson($appointment),$comment);
//        $response->setStatusCode(200);
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//    }
//
//    return $response;
//});
//
//$app->post('/api/changeAppointment',function(Request $request) use ($app){
//    $response = new Response();
//    $appointment = $request->request->get('Appointment');
////    $appointmentToBlock = $request->getContent();
////    $appToBlock = json_encode($appointmentToBlock);
////    $rew = OpeningHours::createObjectsFromJsonArray($weekArr);
//
//    printToTerminal("object: ".json_encode($appointment));
////    printToTerminal("is set: ". isset($appointment));
//
//    try{
//
//        managerActions::changeAppointment(Appointment::createObjectFromJson($appointment));
//        $response->setStatusCode(200);
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//    }
//
//    return $response;
//});
//
//$app->post('/api/setEmployeeAbsence',function(Request $request) use ($app){
//    $response = new Response();
//    $employeeAbsence = $request->request->get('EmployeeAbsence');
//    $deleteAppointmentConfirmation=$request->request->get('deleteAppointmentConfirmation');
//    $comment = $request->request->get('comment');
//
//
//    try{
//        managerActions::setEmployeeAbsence(EmployeeAbsence::createObjectFromJson($employeeAbsence),$deleteAppointmentConfirmation,$comment);
//        $response->setStatusCode(200);
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//    }
//
//    return $response;
//});
////
//$app->post('/api/setFullDayEmployeeAbsence',function(Request $request) use ($app){
//    $response = new Response();
//
//    $date = $request->request->get('date');
//    $employeeId = $request->request->get('employeeId');
//    $deleteAppointmentConfirmation=$request->request->get('deleteAppointmentConfirmation');
//    $comment = $request->request->get('comment');
//
//
//
////TODO: should change the createEmployeeAbsence function to accept timestamp instead of string to match all the other functions in DBDAO
//    try{
//        managerActions::setFullDayEmployeeAbsence($date,$employeeId, $deleteAppointmentConfirmation,$comment);
//        $response->setStatusCode(200);
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//    }
//
//    return $response;
//});
//
//
//$app->post('/api/deleteAllEmployeeAbsenceInAday',function(Request $request) use ($app){
//    $response = new Response();
//    try {
//        $date = $request->request->get('date');
//        $employeeId = $request->request->get('employeeId');
//
//        managerActions::deletAllEmployeeAbsenceInAday(strtotime($date), $employeeId);
//
//        $response->setStatusCode(200);
//
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//        throw new Exception($e->getMessage());
//    }
//    return $response;
//});
//$app->post('/api/deleteEmployeeAbsence',function(Request $request) use ($app){
//    $response = new Response();
//    try {
//        $id = $request->request->get('id');
//
//        managerActions::deletEmployeeAbsence($id);
//
//        $response->setStatusCode(200);
//
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//        throw new Exception($e->getMessage());
//    }
//    return $response;
//});
//
//$app->post('/api/showFutureEmployeeAbsence',function(Request $request) use ($app){
//    $response = null;
//    try {
//        $employeeId = $request->request->get('employeeId');
//
//        $response = managerActions::showFutureEmployeeAbsence($employeeId);
//        return $app->json($response,200);
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//        throw new Exception($e->getMessage());
//    }
////    return $response;
//});
//
//
//
////
//$app->get('/api/showAllFutureAbsences', function () use ($app) {
//    try {
//        $response = managerActions::showAllFutureAbsences();
//        return $app->json($response, 200);
//    }
//    catch(Exception $e) {
//        printToTerminal($e->getMessage());
//        $response = new Response();
//        return $response->setStatusCode(500);
//
//    }
//});
//
//$app->post('/api/updateCustomerDetails',function(Request $request) use ($app){
//    $response = new Response();
//    $customer = $request->request->get('Customer');
////    $weekArr1 = json_encode($weekArr);
////    $rew = OpeningHours::createObjectsFromJsonArray($weekArr);
//    printToTerminal($customer);
//    try{
//        managerActions::updateCustomerDetails(Customer::createObjectFromJson($customer));
//        $response->setStatusCode(200);
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//    }
//
//    return $response;
//});
//
//$app->post('/api/updateEmployeeDetails',function(Request $request) use ($app){
//    $response = new Response();
//    $employee = $request->request->get('Employee');
////    $weekArr1 = json_encode($weekArr);
////    $rew = OpeningHours::createObjectsFromJsonArray($weekArr);
//    printToTerminal($employee);
//    try{
//        managerActions::updateEmployeeDetails(Employee::createObjectFromJson($employee));
//        $response->setStatusCode(200);
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//    }
//
//    return $response;
//});
//$app->post('/api/setContactUs',function(Request $request) use ($app){
//    $response = new Response();
//    $ContactUs = $request->request->get('ContactUs');
////    $appointmentToBlock = $request->getContent();
////    $appToBlock = json_encode($appointmentToBlock);
////    $rew = OpeningHours::createObjectsFromJsonArray($weekArr);
//
//    printToTerminal("object: ".json_encode($ContactUs));
////    printToTerminal("is set: ". isset($appointment));
//
//    try{
//
//        managerActions::setContactUs(ContactUs::createObjectFromJson($ContactUs));
//        $response->setStatusCode(200);
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//    }
//
//    return $response;
//});
//
//$app->post('/api/updateContactUs',function(Request $request) use ($app){
//    $response = new Response();
//    $ContactUs = $request->request->get('ContactUs');
////    $appointmentToBlock = $request->getContent();
////    $appToBlock = json_encode($appointmentToBlock);
////    $rew = OpeningHours::createObjectsFromJsonArray($weekArr);
//
//    printToTerminal("object: ".json_encode($ContactUs));
////    printToTerminal("is set: ". isset($appointment));
//
//    try{
//
//        managerActions::updateContactUs(ContactUs::createObjectFromJson($ContactUs));
//        $response->setStatusCode(200);
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//    }
//
//    return $response;
//});
//
//$app->post('/api/deleteFromGallery',function(Request $request) use ($app){
//
//    //call the function json example--> {"images":["xnxx.jpg"]}
//    $response = new Response();
//    $images = $request->request->get('images');
//
//    printToTerminal($images);
//    try{
//        managerActions::deleteFromGallery($images);
//        $response->setStatusCode(200);
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//    }
//    return $response;
//});
//
//$app->post('/api/setCoordinates',function(Request $request) use ($app){
//
//    $response = new Response();
//    $Latitude = $request->request->get('Latitude');
//    $Longitude= $request->request->get('Longitude');
//    printToTerminal($Longitude ."     ". $Latitude);
//    try{
//        managerActions::setCoordinates($Latitude,$Longitude);
//        $response->setStatusCode(200);
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//    }
//    return $response;
//});
//$app->get('/api/showCoordinates', function () use ($app) {
//    $status = 200;
//    $response = null;
//    try{
//        $response = managerActions::showCoordinates();
//        $response ->address = managerActions::getContactUs()->getAddress();
////    printToTerminal($response);
//
//
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $status = 500;
//    }
//
//    return $app->json($response, $status);
//});
//
//$app->post('/api/setAppointmentDuration',function(Request $request) use ($app){
//
//    $response = new Response();
//    $AppointmentDuration = $request->request->get('AppointmentDuration');
//
//    try{
//        managerActions::setAppointmentDuration($AppointmentDuration);
//        $response->setStatusCode(200);
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//    }
//    return $response;
//});
//
//$app->get('/api/getAppointmentDuration', function () use ($app) {
//    $status = 200;
//    $response = null;
//    try{
//        $response = managerActions::getAppointmentDuration();
////    printToTerminal($response);
//
//
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $status = 500;
//    }
//
//    return $app->json($response, $status);
//});
//
//$app->post('/api/blockCustomer',function(Request $request) use ($app){
//    $response = new Response();
//    try
//    {
//        $Id = $request->request->get('customerId');
//        managerActions::blockCustomer($Id);
//        $response->setStatusCode(200);
//    }catch (Exception $e)
//    {
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//    }
//
//    return $response;
//});
//
//$app->post('/api/unBlockCustomer',function(Request $request) use ($app){
//    $response = new Response();
//    try
//    {
//        $id = $request->request->get('customerId');
//        managerActions::unBlockCustomer($id);
//        $response->setStatusCode(200);
//    }catch (Exception $e)
//    {
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//    }
//
//    return $response;
//});
//
//$app->post('/api/blockEmployee',function(Request $request) use ($app){
//    $response = new Response();
//    $id = $request->request->get('employeeId');
//    try{
//        managerActions::blockEmployee($id);
//        $response->setStatusCode(200);
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//    }
//    return $response;
//});
//
//
//$app->post('/api/unBlockEmployee',function(Request $request) use ($app){
//    $response = new Response();
//    $id = $request->request->get('employeeId');
//    try{
//        managerActions::unBlockEmployee($id);
//        $response->setStatusCode(200);
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $response->setStatusCode(500);
//    }
//    return $response;
//});

//$app->get('/api/showCoordinates', function () use ($app) {
//    $status = 200;
//    $response = null;
//    try{
//        $response = managerActions::showCoordinates();
//        $response ->address = managerActions::getContactUs()->getAddress();
////    printToTerminal($response);
//
//
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $status = 500;
//    }
//
//    return $app->json($response, $status);
//});

//$app->get('/api/getAppointmentDuration', function () use ($app) {
//    $status = 200;
//    $response = null;
//    try{
//        $response = managerActions::getAppointmentDuration();
////    printToTerminal($response);
//
//
//    }
//    catch(Exception $e){
//        printToTerminal($e->getMessage());
//        $status = 500;
//    }
//
//    return $app->json($response, $status);
//});
this is the end of {all exeptions remove from the function below , this is a copy of the function before edit on 8-11-2017}---*/