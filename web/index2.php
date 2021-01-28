<?php

//use Gigablah\Silex;
ini_set('display_errors', 1);
error_reporting(-1);

date_default_timezone_set('Asia/Jerusalem');
include 'providers/UserProvider.php';
include 'providers/myOauthService.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ .'/../vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

//*****************************************
define('FACEBOOK_API_KEY',    '1608771039167400');
define('FACEBOOK_API_SECRET', '747bf2ff3985ae05bc65339d540ab505');
define('TWITTER_API_KEY',     '872364823746');
define('TWITTER_API_SECRET',  '234g35g56h456h546');
define('GOOGLE_API_KEY',      '339582927777-7r3a123o6btq5ojqpoho4nghgi9bg2q7.apps.googleusercontent.com');
define('GOOGLE_API_SECRET',   'kYX9rmoTcPLuy_kwd8vn11T9');
define('MY_API_KEY',          'demoapp');
define('MY_API_SECRET',       'demopass');

$app = new Silex\Application();
$app['debug'] = true;
$app['debug'] = true;

include 'providers/loginController.php';

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'dbhost' => 'localhost',
        'dbname' => 'facebooklogin',
        'user' => 'root',
        'password' => '010890aviya',
    ),
));

//$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new Gigablah\Silex\OAuth\OAuthServiceProvider(), array(
    'oauth.services' => array(
        'Facebook' => array(
            'key' => FACEBOOK_API_KEY,
            'secret' => FACEBOOK_API_SECRET,
            'scope' => array('email'),
            'user_endpoint' => 'https://graph.facebook.com/me?fields=id,name,email'
        ),
        'Google' => array(
            'key' => GOOGLE_API_KEY,
            'secret' => GOOGLE_API_SECRET,
            'scope' => array(
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/userinfo.profile'
            ),
            'user_endpoint' => 'https://www.googleapis.com/oauth2/v1/userinfo'
        ),
        'my_service' => array(
            'class' => 'Project3\\OAuth\\Service\\MyOauthService',
            'key' => MY_API_KEY,
            'secret' => MY_API_SECRET,
            'scope' => array(),
            'user_endpoint' => 'http://localhost:8899/oauth/userinfo',
//            'user_endpoint' => 'http://localhost:8080/lockdin/userinfo',
//            'user_callback' => function ($token, $userInfo, $service) {
//                $token->setUser($userInfo['name']);
//                $token->setEmail($userInfo['email']);
//                $token->setUid($userInfo['id']);
//            }
//            'user_callback' => function ($token, $userInfo, $service) {
//                printToTerminal('user_callback');
//                printToTerminal('token: '.$token.'userinfo: '.$userInfo.'service: '.$service);
//            }
        ),
    )
));


//$app->register(new Project3\Silex\OAuth\Security\User\Provider\UserProvider());
$app->register(new Silex\Provider\FormServiceProvider());

// Provides session storage
$app->register(new Silex\Provider\SessionServiceProvider(), array(
    'session.storage.save_path' => '/tmp'
));

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'acceso' => array(
            'pattern' => '^/confirmar',
            'form' => array('login_path' => '/acceso', 'check_path' => '/confirmar/comprobar_acceso'),
            'logout' => array('logout_path' => '/confirmar/salir'),
            'users' => function() use ($app) {
                return new Project3\Silex\OAuth\Security\User\Provider\UserProvider($app['db']);
            },
            ),
        'default' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'oauth' => array(
                //'login_path' => '/auth/{service}',
                //'callback_path' => '/auth/{service}/callback',
                //'callback_path' => '/callback',
//                'check_path' => '/auth/{service}/check',
                'failure_path' => '/login',
                'with_csrf' => true
            ),
            'logout' => array(
                'logout_path' => '/logout',
                'with_csrf' => true
            ),
            // OAuthInMemoryUserProvider returns a StubUser and is intended only for testing.
            // Replace this with your own UserProvider and User class.
//            'users' => new Gigablah\Silex\OAuth\Security\User\Provider\OAuthInMemoryUserProvider()
            'users' => new Project3\Silex\OAuth\Security\User\Provider\UserProvider(),
        ),

    ),
    'security.access_rules' => array(
        array('^/auth', 'ROLE_USER')
    )
));

// Provides Twig template engine
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views'
));

$app->before(function (Symfony\Component\HttpFoundation\Request $request) use ($app)
{

//    if (404 === $code) {
//        return $app->redirect($app['url_generator']->generate('home'));
//    }

    printToTerminal( $request->headers->all());
    printToTerminal( $request->get('_route'));
    printToTerminal( $request->getUri());
//    if(!isset($app['user'])){
//    if (isset($app['security.token_storage'])){
//        printToTerminal("security.token_storage isset true");
//        $token = $app['security.token_storage']->getToken();
//        printToTerminal($token);
//    } else {
//        printToTerminal("security.token_storage isset false");
//        $token = $app['security']->getToken();
//    }
//
//    $app['user'] = null;
//
//    if ($token && !$app['security.trust_resolver']->isAnonymous($token)) {
//        printToTerminal("get user");
//        $app['user'] = $token->getUser();
//    }
//    else
//        {
//            return $app->redirect('/login');
//        }
//    }
//    else
//    {
//        if($request->get('_route') == 'GET_login'  && !isset($app['user'])) {
////            return $app->redirect('/login');
//            return true;
//        }
//        else return $app->redirect('/');
//    }
});

$app->get('/login', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {
//    $services = array_keys($app['oauth.services']);

    return $app['twig']->render('index.twig', array(
        'login_paths' => $app['oauth.login_paths'],
        'logout_path' => $app['url_generator']->generate('logout', array(
            '_csrf_token' => $app['oauth.csrf_token']('logout')
        )),
        'error' => $app['security.last_error']($request)
    ));
});

$app->get('/callback', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {


//    return $request->getContent();
//    oauth.services.Facebook.user_endpoint
    return $app->json($request, 200);

});

$app->get('/getLoginHref', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {



    return $app->json($app['oauth.login_paths'], 200);

});
$app->get('/', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {


    return $app['twig']->render('index.twig', array(
        'login_paths' => $app['oauth.login_paths'],
        'logout_path' => $app['url_generator']->generate('logout', array(
            '_csrf_token' => $app['oauth.csrf_token']('logout')
        )),
        'error' => $app['security.last_error']($request)
    ));

});

$app->match('/logout', function () {})->bind('logout');

//*****************************
//
//$app->get('/', function () use ($app)
//{
//
//    return $app['twig']->render('qwe.twig');
//});

require __DIR__.'/../app/controllers.php';

$app->run();
?>


