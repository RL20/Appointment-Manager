<?php
/**
 * Created by PhpStorm.
 * User: aviya
 * Date: 17/09/17
 * Time: 17:17
 */

use Silex\Application;
use Silex\WebTestCase;
use Pimple\Container;

use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\RoutingServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SecurityJWTServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use SimpleUser\JWT\UserProvider;
require_once __DIR__.'/CORS.php';


//use Exception;

$app = new Silex\Application();
//$app = new Pimple\Container();

//$app -> register(new RoutingServiceProvider());







//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpFoundation\Request;
//





// Useful to catch error and send them directly in JSON
//$app -> error(function(Exception $e, $code) use($app){
//    return $app -> json(['error' => $e -> getMessage(), 'type' => get_class($e)], $code);
//});





// Default options
$app['user.jwt.options'] = [
    'language' => 'SimpleUser\JWT\Languages\English', // This class contains messages constants, you can create your own with the same structure
    'controller' => 'SimpleUser\JWT\UserController', // User controller, you can rewrite it
    'class' => 'SimpleUser\JWT\User', // If you want your own class, extends 'SimpleUser\JWT\User'
    'registrations' => [
        'enabled' => true,
        'confirm' => false // Send a mail to the user before enable it
    ],
    'invite' => [
        'enabled' => false // Allow user to send invitations
    ],
    'forget' => [
        'enabled' => false // Enable the 'forget password' function
    ],
    'tables' => [ // SQL tables
        'users' => 'users',
        'customfields' => 'user_custom_fields'
    ],
    'mailer' => [
        'enabled' => false,
        'from' => [
            'email' => 'root@aviya.org'/*.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST']:gethostname())*/,
            'name' => 'aviya'
        ],
        // Email templates
        'templates' => [
            'register' => [
                'confirm' => 'confirm.twig',
                'welcome' => 'welcome.twig'
            ],
            'invite' => 'invite.twig',
            'forget' => 'forget.twig'
        ],
        // Routes name for email templates generation (optional if you don't want to use url in your email)
        'routes' => [
            'login' => 'user.jwt.login',
            'reset' => 'user.jwt.reset'
        ]
    ]
];



$app['security.jwt'] = [
    'secret_key' => 'YOUR_OWN_SECRET_KEY',
    'life_time' => 2592000,
    'algorithm' => ['HS256'],
    'options' => [
        'header_name' => 'Authorization',
        'username_claim' => 'email' // Needed for silex-simpleuser-jwt
    ]
];

/**
 * All this Roles are hardcoded in the library
 * ROLE_REGISTERED : Added to registered users
 * ROLE_INVITED : Added to invited users
 * ROLE_ALLOW_INVITE : Allow the user to invite friends
 * ROLE_ADMIN : Allow the user to update others users informations
 */

$app['security.role_hierarchy'] = [
    'ROLE_INVITED' => ['ROLE_USER'],
    'ROLE_REGISTERED' => ['ROLE_INVITED', 'ROLE_ALLOW_INVITE'],
    'ROLE_ADMIN' => ['ROLE_REGISTERED']
];

//$app -> register(new SecurityServiceProvider());
$app -> register(new SecurityJWTServiceProvider());

//$app['db.options'] = array(
//    'driver'   => 'pdo_mysql',
//    'dbname' => 'mydbname',
//    'host' => 'localhost',
//    'user' => 'root',
//    'password' => '010890aviya',
//);
//$app -> register(new DoctrineServiceProvider(), [
//    'db.options' => [
////        'driver' => 'pdo_sqlite',
////        'path' => __DIR__.'/app.db',
////        'charset' => 'UTF8'
//        'driver'   => 'pdo_mysql',
//        'dbname' => 'appointmentappdbnew',
//        'host' => 'localhost',
//        'user' => 'root',
//        'password' => '',
//    ]
//]);


require __DIR__.'/db.php';



//use Silex\Provider\DoctrineServiceProvider;




//use Silex\Provider\SecurityServiceProvider;
//use Silex\Provider\SecurityJWTServiceProvider;





//use Silex\Provider\SwiftmailerServiceProvider;

$app -> register(new SwiftmailerServiceProvider(), [
    'swiftmailer.options' => [
        'host' => 'aviya.org',
        'port' => '25'
    ]
]);


//$app -> register(new RoutingServiceProvider());

//use Silex\Provider\UrlGeneratorServiceProvider;
//use Silex\Provider\TwigServiceProvider;

$app -> register(new TwigServiceProvider(), [
    'twig.path' => __DIR__.'/../templates'
]);


$app -> register(new SecurityServiceProvider());




$up = new UserProvider();
//$app -> register(new UserProvider());
$app -> register($up);
$up->boot($app);
//$app -> mount('/', new UserProvider());
$app -> mount('/', $up);




$app['security.firewalls'] = [
    'login' => [
        'pattern' => 'register|login|forget|reset|socialLogin|socialRegister',
        'anonymous' => true
    ],
    'secured' => [
        'pattern' => '.*$',
        'users' => $app['user.manager'], // Array with the all the users
        'jwt' => [
            'use_forward' => true,
            'require_previous_session' => false,
            'stateless' => true
        ]
    ]
];

$app['dispatcher']->addSubscriber(new CorsListener());


return $app;