<?php

date_default_timezone_set('Asia/Jerusalem');

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();

$app['debug'] = true;



$app->register(new Silex\Provider\SessionServiceProvider(), array(
    'session.storage.save_path' => __DIR__.'/../vendor/sessions',
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'    => 'pdo_mysql',
        'host'      => 'localhost',
        'dbname'    => 'facebooklogin',
        'user'      => 'root',
        'password'  => '010890aviya',
        'charset'   => 'utf8',
    ),
));



$app['security.encoder.digest'] = $app->share(function ($app) {
    return new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder('sha1', false, 1);
});


$app['security.firewalls'] = array(
    'acceso' => array(
        'pattern' => '^/',
        'form' => array('login_path' => '/acceso', 'check_path' => '/auth/comprobar_acceso'),
        'logout' => array('logout_path' => '/auth/salir'),
        'users' => $app->share(function() use ($app) {
            return new Project3\Silex\OAuth\Security\User\Provider\UserProvider($app['db']);
        }),
    ),
);


$app->register(new Silex\Provider\SecurityServiceProvider(array(
    'security.firewalls' => $app['security.firewalls'],
    'security.access_rules' => array(
        array('^/auth', 'ROLE_USER'),
    ),
)));



$app->match('/acceso', function(Request $request) use ($app) {

    $username = $request->get('_username');
    $password = $request->get('_password');

    if ('POST' == $request->getMethod())
    {
        $user = new Project3\Silex\OAuth\Security\User\Provider\UserProvider($app['db']);
        $encoder = $app['security.encoder_factory']->getEncoder($user);
        // compute the encoded password
        $encodedPassword = $encoder->encodePassword($password, $user->getSalt());

        // compare passwords
        if ($user->password == $encodedPassword)
        {
            // set security token into security
            $token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken($user, $password, '', array('ROLE_USER'));
            $app['security']->setToken($token);
            //return $app->redirect('/jander');
            // redirect or give response here
        } else {
            // error feedback
        }

    }


    return $app['twig']->render('login.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})
    ->bind('acceso');

require __DIR__.'/../app/controllers.php';

$app->run();

