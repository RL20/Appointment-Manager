<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


//*******************************************************************************************************************************************************************************
//*******************************************************************************************************************************************************************************
$app->get('/api/showOpeningHours', function () use ($app) {

    $response = managerActions::showOpeningHours();
    return $app->json($response, 200);
});




$app->get('/api/showEmployees', function () use ($app) {

    $response = customerActions::showEmployees();
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




$app->post('/api/setAppointment',function(Request $request) use ($app){
    $response = new Response();
    $appointment = $request->request->get('Appointment');
//    $appointmentToBlock = $request->getContent();
//    $appToBlock = json_encode($appointmentToBlock);
//    $rew = OpeningHours::createObjectsFromJsonArray($weekArr);

    printToTerminal("object: ".json_encode($appointment));
//    printToTerminal("is set: ". isset($appointment));

    try{

        managerActions::setAppointment(Appointment::createObjectFromJson($appointment));
        $response->setStatusCode(200);
    }
    catch(Exception $e){
        printToTerminal($e->getMessage());
        $response->setStatusCode(500);
    }

    return $response;
});

$app->post('/api/cancelAppointment',function(Request $request) use ($app){
    $response = new Response();
    $appointment = $request->request->get('Appointment');
    $comment = $request->request->get('comment');

    printToTerminal($appointment);
    try{
        managerActions::cancelAppointment(Appointment::createObjectFromJson($appointment),$comment);
        $response->setStatusCode(200);
    }
    catch(Exception $e){
        printToTerminal($e->getMessage());
        $response->setStatusCode(500);
    }

    return $response;
});





$app->post('/api/setNewCustomer',function(Request $request) use ($app){
    $response = new Response();
    $customer = $request->request->get('Customer');
//    $appointmentToBlock = $request->getContent();
//    $appToBlock = json_encode($appointmentToBlock);
//    $rew = OpeningHours::createObjectsFromJsonArray($weekArr);

    printToTerminal("object: ".json_encode($customer));
//    printToTerminal("is set: ". isset($appointment));

    try{

        managerActions::setNewCustomer(Customer::createObjectFromJson($customer));
        $response->setStatusCode(200);
    }
    catch(Exception $e){
        printToTerminal($e->getMessage());
        $response->setStatusCode(500);
    }

    return $response;
});

$app->post('/api/updateCustomerDetails',function(Request $request) use ($app){
    $response = new Response();
    $customer = $request->request->get('Customer');
//    $weekArr1 = json_encode($weekArr);
//    $rew = OpeningHours::createObjectsFromJsonArray($weekArr);
    printToTerminal($customer);
    try{
        managerActions::updateCustomerDetails(Customer::createObjectFromJson($customer));
        $response->setStatusCode(200);
    }
    catch(Exception $e){
        printToTerminal($e->getMessage());
        $response->setStatusCode(500);
    }

    return $response;
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



$app->post('/api/showCustomerAppointments',function(Request $request) use ($app){

    $id = $request->request->get('customerId');

    $response = managerActions::showCustomerAppointments($id);
    return $app->json($response,200);
});


//


$app->get('/api/galleryLinks', function () use ($app) {

    $response = managerActions::galleryLinks();
    return $app->json($response, 200);
});


$app->get('/api/showCoordinates', function () use ($app) {
    $status = 200;
    $response = null;
    try{
        $response = managerActions::showCoordinates();
//    printToTerminal($response);


    }
    catch(Exception $e){
        printToTerminal($e->getMessage());
        $status = 500;
    }

    return $app->json($response, $status);
});















