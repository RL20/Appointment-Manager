<?php

use Symfony\Component\HttpFoundation\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\SuParameterBag;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\File\UploadedFile;

require_once "../Project3/requires.php";
require_once "managerController.php";
//require_once "../web/providers/loginController.php";
//require_once "customerController.php";

$app->get('/api/serere', function () use ($app) {

//    $id = $request->request->get('employeeId');

//    VarDumper::dump("hgwevdwhebdwkjendowieoim");
//    $response = managerActions::showEmployees();
//    $responsr = EmployeeDBDAO::getAllEmployees();
//    VarDumper::dump($responsr);
//    $post['id'] = $post;
//    printToTerminal(json_encode($responsr));

    return $app->json("sdcsdcssssssssssssssssssssssssssssss", 200);
});

//$app->post('/api/showFutureEmployeeAbsence',function(Request $request) use ($app){
//    printToTerminal("jgdgtjkhjgffxvgjhgf");
//
//    $id = $request->request->get('employeeId');
//
//    $response = managerActions::showFutureEmployeeAbsence($id);
//    printToTerminal($response);
//    return $app->json($response,200);
//});
//
//$app->post('/api/getCustomer', function (Request $request) use ($app) {
//
////    $id = $request->getContent();
//    $id = $request->request->get('customerId');
//
//    printToTerminal($request);
//    printToTerminal("id: ".$id);
//
//    $responsr = managerActions::showCustomer($id);
////    $post['id'] = $post;
//
//    return $app->json($responsr, 201);
//});




//
//$app->get('/', function(){
//
//return "welcome to the site";
//});
//
//$app->get('/manager/', function(){
//
//    return "i know that your'e calling from ajax";
//});


$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

//$app->after(function (Request $request, Response $response) {
//    $response->headers->set('Access-Control-Allow-Origin', '*');
//    $response->headers->set('Access-Control-Allow-Headers', 'Authorization');
//});







$app->after(function (Request $request, Response $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, X-Access-Token');
});
//
$app->options("{anything}", function () {
    return new \Symfony\Component\HttpFoundation\JsonResponse(null, 204);
})->assert("anything", ".*");








//$app->post('/get20apps', function (Request $request) use ($app) {
//
//    $id = $request->request->get('employeeId');
//
//    $responsr = commonActions::getFirst20AvailableAppointments($id);
////    $post['id'] = $post;
//
//    $harta = $app->json($responsr, 201);
//    return $harta;
//});


//for every request that arrives the content data is converted from json to an array (not stdClass array)
// to get parameters of this array see example:  $arr['parameter']     not( $arr->parameter)
//$app->before(function (Request $request) {
//    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
//        $data = json_decode($request->getContent(), true);
//        $request->request->replace(is_array($data) ? $data : array());
//    }
//});

//$app->post('/api/getEmployee', function (Request $request) use ($app) {
//
////    $id = $request->getContent();
//    $id = $request->request->get('employeeId');
//
//    printToTerminal($request);
//    printToTerminal("id: ".$id);
//
//    $responsr = managerActions::getEmployee($id);
////    $post['id'] = $post;
//
//    return $app->json($responsr, 201);
//});

function printToTerminal($string)
{
    if(is_array($string)) $string = json_encode($string);
    $f = fopen('php://stderr', 'w');
    fputs($f, $string ."\n");
}

//$app->get('/api/getAllEmployees', function () use ($app) {
//
////    $id = $request->request->get('employeeId');
//
////    VarDumper::dump("hgwevdwhebdwkjendowieoim");
//     $responsr = managerActions::showCustomers();
////    $responsr = EmployeeDBDAO::getAllEmployees();
////    VarDumper::dump($responsr);
////    $post['id'] = $post;
////    printToTerminal(json_encode($responsr));
//
//    return $app->json($responsr, 200);
//});




//$app->post('/upload', function (Request $request) use ($app)
//{
//    $file = $request->files->get('uploadedFile');
//    if ($file == NULL)
//    {
//        $send = json_encode(array("status" => "Fail"));
//        return $app->json($send, 500);
//    }
//    else
//    {
//        $file->move('../files', $file->getClientOriginalName());
//        $send = json_encode(array("status" => "Ok"));
//    return $app->json($send, 200);
//}
//});

//$app->get("/users/{id}", function($id){
//    return "User - {$id}";
//})
//    ->value("id", 0) //set a default value
//    ->assert("id", "\d+");// make sure the id is numeric
//

//$app->get("/users/{user}", function($user){
//    // return the user profile
//
//    return "User {$user}";
//})->convert("user", function($id){
//    $userRepo = new User();
//    $user = $userRepo->find($id);
//
//    if(!$user){
//        return new Response("User #{$id} not found.", 404);
//    }
//
//    return $user;
//});


//$app->get("/api/showCustomers",function()use ($app){
//   $response = managerActions::showCustomers();
////    printToTerminal($response);
//    return $app->json($response, 200);
//});
