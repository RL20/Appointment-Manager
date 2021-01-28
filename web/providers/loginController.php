<?php
/**
 * Created by PhpStorm.
 * User: aviya
 * Date: 08/08/17
 * Time: 14:52
 */
include __DIR__ . '/../../vendor/lusitanian/oauth/src/OAuth/bootstrap.php';


use OAuth\OAuth2\Service\AbstractService;
use OAuth\OAuth2\Token\StdOAuth2Token;
use OAuth\Common\Http\Exception\TokenResponseException;
use OAuth\Common\Http\Uri\Uri;
use OAuth\Common\Consumer\CredentialsInterface;
use OAuth\Common\Http\Client\ClientInterface;
use OAuth\Common\Storage\TokenStorageInterface;
use OAuth\Common\Http\Uri\UriInterface;
use Symfony\Component\HttpFoundation\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\SuParameterBag;
use OAuth\Common\Http\Client\CurlClient;

$app->post('/oauth/login',function(Request $request) use ($app){

    printToTerminal($request->getContent());

    printToTerminal("my made up login auth");

    file_put_contents('loginCredencials', '{"email":"'.$request->request->get('email').'","password":"'.$request->request->get('password').'"}');

//    $app['qqwweerr'] = "ila'an abuk! ya kalb!";

    return true;
});

$app->get('/oauth/userinfo',function(Request $request) use ($app){


        $httpClient = new CurlClient();

    $responseBody = $httpClient->retrieveResponse(
        new Uri('http://localhost:8080/lockdin/userinfo'),
        null,
        array('host:'.$request->headers->get('host'),'user-agent:'.$request->headers->get('user-agent'),'accept:'.$request->headers->get('accept'),'authorization:'.$request->headers->get('authorization'),'connection:'.$request->headers->get('connection'),'x-php-ob-level:'.$request->headers->get('x-php-ob-level')),
        'GET'
    );

//    printToTerminal($request->headers->all());
//    $curl = curl_init();
//// Set some options - we are passing in a useragent too here
//    curl_setopt_array($curl, array(
//        CURLOPT_RETURNTRANSFER => 1,
//        CURLOPT_URL => 'http://localhost:8080/lockdin/userinfo',
////        CURLOPT_URL => 'http://localhost:8080/lockdin/authorize?client_id='. $request->query->get('client_id') .'&redirect_uri='.$request->query->get('redirect_uri').'&response_type=code&scope=&state='.$request->query->get('state').'&type=web_server',
//        CURLOPT_HTTPHEADER => array('host:'.$request->headers->get('host'),'user-agent:'.$request->headers->get('user-agent'),'accept:'.$request->headers->get('accept'),'authorization:'.$request->headers->get('authorization'),'connection:'.$request->headers->get('connection'),'x-php-ob-level:'.$request->headers->get('x-php-ob-level')),
//        CURLOPT_HEADER => true,
//    ));
//// Send the request & save response to $resp
//    $resp = curl_exec($curl);
//
//    $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
//    $header = substr($resp, 0, $header_size);
//    $body = substr($resp, $header_size);
////    curl_setopt($ch, CURLOPT_HEADER, true);
//// Close request to clear up some resources
//    curl_close($curl);
//
//
//    $resp = str_replace('localhost:8080', 'localhost:8899', $resp);
//    printToTerminal("response userinfo:         " . $resp);

//    printToTerminal('');
//    printToTerminal('');
//    printToTerminal('');
//    printToTerminal($header);
//    printToTerminal('');
//    printToTerminal('');
//    printToTerminal('');
//
//    $headers = get_headers_from_curl_response($resp);
//
//    printToTerminal("headers userinfo:         " . json_encode($headers));
//
    $response = new Response($responseBody);
//    $response->headers->remove('Cache-Control');
//    $response->headers->set('Cache-Control','no-cache');

      printToTerminal("response userinfo:         " . $response);


//    return $resp;
    return $response;
});



function get_headers_from_curl_response($response)
{
    $headers = array();

    $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));

    foreach (explode("\r\n", $header_text) as $i => $line)
        if ($i === 0)
            $headers['http_code'] = $line;
        else
        {
            list ($key, $value) = explode(': ', $line);

            $headers[$key] = $value;
        }

    return $headers;
}

function redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);

    exit();
}
//$app->post('/oauth/request_token',function(Request $request) use ($app){
//    $response = "h379wcawe98cuwe98c0w9e8uf30498r09w8cru0w938ru83";
//    printToTerminal( $request->headers->all());
//
//    printToTerminal("tfthgh");
//
//    return '/auth/my_service/callback?code=AQBWemJJzhYnYCWPdR1KL8zg5cMEBIfzgZrPjdCgT-C5z35ffU7yiwsVwYVwmqBMkfOPAA3s7XKXikWh7vZdgA-nM57ZdrYh-1i4FAn23uRGx32rHnE9jt-A3Id--Skqns50xXQUsnNa9p3RP1FVr9-utrJ5S2YE5ksTu0AI0Tbu_P99IEvU77NJVsB9YNdv1nxGFTLzkK8ysZWZVb3YrPm6lwEiqLqxK7YJpPBB5IEJSF44RPojui4q2cgH3dIrvvTRY5wP9XlenEeO53m0LaEhK7iKTHVkpS-mkQeHEsBkhlfqyATX9aWzCNCy8W8eNTaMUptazlLn_bS39rwhAQTx&state=4a44904b78e36fd0cace90b87b0f0b33#_=_';
//});

//$app->post('/oauth/access_token',function() use ($app){
//    $response = "/oauth/access_token";
//    printToTerminal($response);
//    return $app->json($response,200);
//});

$app->get('/oauth/authorize',function(Request $request) use ($app){

    printToTerminal('/oauth/authorize');
    printToTerminal('/oauth/authorize');
    printToTerminal('/oauth/authorize');
    printToTerminal('/oauth/authorize');
    printToTerminal('/oauth/authorize');
    printToTerminal('/oauth/authorize');
    printToTerminal('/oauth/authorize');
    printToTerminal('/oauth/authorize');
    printToTerminal(__DIR__.'../loginCredencials');
//    $q = readfile(__DIR__.'../loginCredencials');
//    $fh = fopen('loginCredencials','r');
//    $r = json_decode($q);

//    $array = json_decode(file_get_contents('loginCredencials'),true);
//    printToTerminal($array);
////    printToTerminal($q);
//    printToTerminal($request->query->all());


//    $httpClient = new CurlClient();
//
//    $responseBody = $httpClient->retrieveResponse(
//        new Uri('http://localhost:8080/lockdin/authorize?client_id='. $request->query->get('client_id') .'&redirect_uri=http%3A%2F%2Flocalhost%3A8899%2Fauth%2Fmy_service%2Fcallback&response_type=code&scope=&state='.$request->query->get('state').'&type=web_server'),
//        null,
//        array('referer:jadbhcasjhbcjascbhjascbhajcb'),
//        'GET'
//    );

////
//    $curl = curl_init();
//// Set some options - we are passing in a useragent too here
//    curl_setopt_array($curl, array(
//        CURLOPT_RETURNTRANSFER => 1,
//        CURLOPT_URL => 'http://localhost:8080/lockdin/authorize?client_id='. $request->query->get('client_id') .'&redirect_uri=http://localhost:8899/auth/my_service/callback&response_type=code&scope=&state='.$request->query->get('state').'&type=web_server',
////        CURLOPT_URL => 'http://localhost:8080/lockdin/authorize?client_id='. $request->query->get('client_id') .'&redirect_uri='.$request->query->get('redirect_uri').'&response_type=code&scope=&state='.$request->query->get('state').'&type=web_server',
//        CURLOPT_HTTPHEADER => array('host:'.$request->headers->get('host'),'user-agent:'.$request->headers->get('user-agent'),'accept:'.$request->headers->get('accept'),'authorization:'.$request->headers->get('authorization'),'connection:'.$request->headers->get('connection'),'x-php-ob-level:'.$request->headers->get('x-php-ob-level')),
//        CURLOPT_HEADER => true,
//    ));
//// Send the request & save response to $resp
//    $resp = curl_exec($curl);
//
////    curl_setopt($ch, CURLOPT_HEADER, true);
//// Close request to clear up some resources
//    curl_close($curl);
////
////
////
////    $headers=array();
////
//    $data=explode("\n",$resp);
//printToTerminal('DATA: '.preg_split('/\s+/', $data[9])[1]);
//    $headers['status']=$data[0];
//
//    array_shift($data);
//
//    foreach($data as $part){
//        $middle=preg_split('/\s+/', $part);
//        $headers[trim($middle[0])] = trim($middle[1]);
//
////            printToTerminal('qwertytrqwr                       '.$part);
//
//    }

//    printToTerminal('*');
//    printToTerminal('*');
//    printToTerminal('*');
//    printToTerminal('*');
//    printToTerminal('*');
//    printToTerminal('*');
//    printToTerminal('*');
//    printToTerminal('*');
//    printToTerminal($headers['location']);


//
////    $response = "/oauth/authenticate";
//    $ch = curl_init('http://localhost:8080');
//    curl_setopt($ch, CURLOPT_URL, '/lockdin/authorize');
//    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/x-www-form-urlencoded'));
//    curl_setopt($ch, CURLOPT_HEADER, 0);
//
//    $body = '{}';
//    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
//    curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//
//
//// execute!
//    $response = curl_exec($ch);
//
//
//// close the connection, release resources used
//    curl_close($ch);

// do anything you want with your response
//    printToTerminal("response:         " . json_encode($resp));
    printToTerminal('');
    printToTerminal('');
    printToTerminal('');
    printToTerminal('');
//    printToTerminal(json_encode($headers['Location']));
    printToTerminal('');
    printToTerminal('');
    printToTerminal('');

//    printToTerminal("response:         " . json_encode($responseBody));

//    printToTerminal($request);
//    printToTerminal($app['qqwweerr']);


//     redirect(preg_split('/\s+/', $data[9])[1], false);
     redirect('http://localhost:8899/auth/my_service/callback?code=jsdhbjcsdbhclasdjkaclksjdbc', false);
//    return redirect(preg_split('/\s+/', $data[9])[1], false);
//    return new Response(null,302);
//    redirect($responseBody->headers->get('Location'), false);
    return  new Response(null,302);
//    return true;
});


$app->post('/oauth/token',function(Request $request) use ($app){
//    printToTerminal('/oauth/token n\ /oauth/token \n/oauth/token \n/oauth/token \n/oauth/token \n/oauth/token \n/oauth/token \n/oauth/token \n/oauth/token \n/oauth/token \n');





//    $httpClient = new CurlClient();
//
//    $responseBody = $httpClient->retrieveResponse(
//        new Uri('http://localhost:8080/lockdin/token'),
//        'grant_type=password&client_id=demoapp&client_secret=demopass&username=demouser&password=testpass',
//        array('host:'.$request->headers->get('host'),'user-agent:'.$request->headers->get('user-agent'),'accept:'.$request->headers->get('accept'),'authorization:'.$request->headers->get('authorization'),'connection:'.$request->headers->get('connection'),'x-php-ob-level:'.$request->headers->get('x-php-ob-level'))
//    );

//    printToTerminal(__DIR__.'../loginCredencials');
//    $q = readfile(__DIR__.'../loginCredencials');
//    $fh = fopen('loginCredencials','r');
//    $r = json_decode($q);

//    $array = json_decode(file_get_contents('loginCredencials'),true);
//    printToTerminal($array);
////    printToTerminal($q);
//    printToTerminal('');
//    printToTerminal('');
//    printToTerminal('');
//    printToTerminal('');
//    printToTerminal($request);
//    printToTerminal('');
//    printToTerminal('');
//    printToTerminal('code='. $request->request->get('code') .'&client_id=demoapp&client_secret=demopass&redirect_uri=http%3A%2F%2Flocalhost%3A8899%2Fauth%2Fmy_service%2Fcallback&grant_type=password&username=demouser&password=testpass');
//    printToTerminal('');
//    printToTerminal('');



//    $curl = curl_init();
//// Set some options - we are passing in a useragent too here
//    curl_setopt_array($curl, array(
//        CURLOPT_RETURNTRANSFER => 1,
//        CURLOPT_URL => 'http://localhost:8080/lockdin/token',
////        CURLOPT_URL => 'http://localhost:8080/lockdin/authorize?client_id='. $request->query->get('client_id') .'&redirect_uri='.$request->query->get('redirect_uri').'&response_type=code&scope=&state='.$request->query->get('state').'&type=web_server',
//        CURLOPT_HTTPHEADER => array('host:'.$request->headers->get('host'),'user-agent:'.$request->headers->get('user-agent'),'accept:'.$request->headers->get('accept'),'authorization:'.$request->headers->get('authorization'),'connection:'.$request->headers->get('connection'),'x-php-ob-level:'.$request->headers->get('x-php-ob-level')),        CURLOPT_HEADER => true,
//        CURLOPT_POST => 1,
//        CURLOPT_POSTFIELDS =>'grant_type=password&client_id=demoapp&client_secret=demopass&username=demouser&password=testpass',
////        CURLOPT_POSTFIELDS =>'code='. $request->request->get('code') .'&client_id=demoapp&client_secret=demopass&redirect_uri=http%3A%2F%2Flocalhost%3A8899%2Fauth%2Fmy_service%2Fcallback&grant_type=password&username=demouser&password=testpass',
//    ));
//    printToTerminal('before curl execute');
//// Send the request & save response to $resp
//    $resp = curl_exec($curl);
//    printToTerminal('after curl execute');
//
////    curl_setopt($ch, CURLOPT_HEADER, true);
//// Close request to clear up some resources
//    curl_close($curl);

/*
    Accept:         *//*
Connection:     close
Content-Length: 190
Content-Type:   application/x-www-form-urlencoded
Host:           localhost
User-Agent:     PHPoAuthLib
X-Php-Ob-Level: 1
    */
//    $httpClient = new CurlClient();
//
//    $responseBody = $httpClient->retrieveResponse(
//        new Uri('http://localhost:8080/lockdin/token'),
//        'code='. $request->request->get('code') .'&client_id=demoapp&client_secret=demopass&redirect_uri=http%3A%2F%2Flocalhost%3A8899%2Fauth%2Fmy_service%2Fcallback&grant_type=password&username=demouser&password=testpass'
//    );

//    $curl = curl_init();
//// Set some options - we are passing in a useragent too here
////    code=3cf2cd266ee6cbddc2c815b9f1538be4e2217c4a&client_id=demoapp&client_secret=demopass&redirect_uri=http%3A%2F%2Flocalhost%3A8899%2Fauth%2Fmy_service%2Fcallback&grant_type=authorization_code
//
//    curl_setopt_array($curl, array(
//        CURLOPT_RETURNTRANSFER => 1,
//        CURLOPT_URL => 'http://localhost:8080/lockdin/token',
//        CURLOPT_HTTPHEADER => array('Connection:     close',
//'Content-Length: 190',
//'Content-Type:   application/x-www-form-urlencoded',
//'Host:localhost',
//'User-Agent:PHPoAuthLib',
//'X-Php-Ob-Level:1'),
//        CURLOPT_POST => 1,
////        CURLOPT_POSTFIELDS => 'grant_type=password&client_id=demoapp&client_secret=demopass&username=demouser&password=testpass',
//        CURLOPT_POSTFIELDS => 'code='. $request->query->get('code') .'&client_id=demoapp&client_secret=demopass&redirect_uri=http%3A%2F%2Flocalhost%3A8899%2Fauth%2Fmy_service%2Fcallback&grant_type=password&username=demouser&password=testpass',
//    ));
//// Send the request & save response to $resp
//    $resp = curl_exec($curl);
//
//// Close request to clear up some resources
//    curl_close($curl);



//    $headers=array();
//
//    $data=explode("\n",$resp);
//
//    $headers['status']=$data[0];
//
//    array_shift($data);
//
//    foreach($data as $part){
//        $middle=explode(":",$part);
//        $headers[trim($middle[0])] = trim($middle[1]);
////            printToTerminal('qwertytrqwr                       '.$part);
//
//    }

//    printToTerminal('*');
//    printToTerminal('*');
//    printToTerminal('*');
//    printToTerminal('*');
//    printToTerminal('*');
//    printToTerminal('*');
//    printToTerminal('*');
//    printToTerminal('*');
//    printToTerminal($headers['location']);

//
//
////    $response = "/oauth/authenticate";
//    $ch = curl_init('http://localhost:8080');
//    curl_setopt($ch, CURLOPT_URL, '/lockdin/authorize');
//    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/x-www-form-urlencoded'));
//    curl_setopt($ch, CURLOPT_HEADER, 0);
//
//    $body = '{}';
//    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
//    curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//
//
//// execute!
//    $response = curl_exec($ch);
//
//// close the connection, release resources used
//    curl_close($ch);

// do anything you want with your response
////    printToTerminal("response token:         " . $resp);
//    $resp = str_replace('localhost:8080', 'localhost:8899', $resp);
//    printToTerminal("response token:         " . $resp);
//
//
////    printToTerminal($request);
////    printToTerminal($app['qqwweerr']);
//
//
////    return $resp;
////    'HTTP/1.0 200 OK
////Cache-Control: no-store, private
////Content-Type:  application/json
////Date:          Thu, 17 Aug 2017 12:19:16 GMT
////Pragma:        no-cache \n';
//
////    $res = $app->json(json_decode($responseBody),200);
//    $res = $resp;
////    $res->headers->set('Pragma', 'no-cache');
////    printToTerminal($res);
//    return $res;

//    $response = new Response($responseBody);
    $response = new Response('{"access_token":"8a24522cdeb22d905d9c550f4a93866e96d2daa7","expires_in":3600,"token_type":"Bearer","scope":null,"refresh_token":"f079b8cb8e17845bb7a67a4143954d2a2ffecb44"}');
//    $response->headers->remove('Cache-Control');
//    $response->headers->set('Cache-Control','no-cache');

    printToTerminal("response userinfo:         " . $response);


//    return $resp;
    return $response;
});