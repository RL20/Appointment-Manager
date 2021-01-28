<?php

date_default_timezone_set('Asia/Jerusalem');
//date_default_timezone_set('UTC');

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

//$app = new Silex\Application();
$app = require __DIR__.'/qwer.php';

$app['debug'] = true;


//require __DIR__.'/../app/controllers.php';

$app->run();

function printToTerminal($string)
{
    if(is_array($string)) $string = json_encode($string);
    $f = fopen('php://stderr', 'w');
    fputs($f, $string ."\n");
}













//**************************************************************************************************************8
//require_once '../vendor/autoload.php';
//
//// Create the Transport
//$transport = (new Swift_SmtpTransport('aviya.org', 25))
////    ->setUsername('your username')
////    ->setPassword('your password')
//;
//
//// Create the Mailer using your created Transport
//$mailer = new Swift_Mailer($transport);
//
//$mailLogger = new \Swift_Plugins_Loggers_ArrayLogger();
//
//// Create a message
//$message = (new Swift_Message('Wonderful Subject'))
//    ->setFrom(['contact@aviya.org' => 'John Doe'])
//    ->setTo(['aviyaomesi@gmail.com'])
//    ->setBody('Here is the message itself')
//;
//
//// Send the message
//$result = $mailer->send($message);
//    if (!$mailer->send($message, $errors))
//    {
//        echo "Error:";
//        print_r($errors);
//    }
//    else{
//        echo "message:";
//        print_r($result);
//        echo $mailLogger->dump();
//    }
//
//?>