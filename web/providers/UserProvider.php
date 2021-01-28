<?php



namespace Project3\Silex\OAuth\Security\User\Provider;

include __DIR__.'/../../vendor/symfony/security/Core/User/UserProviderInterface.php';
include __DIR__.'/../../vendor/gigablah/silex-oauth/src/Security/User/Provider/OAuthUserProviderInterface.php';
include __DIR__.'/../../web/providers/User.php';


use Gigablah\Silex\OAuth\Security\User\Provider\OAuthUserProviderInterface;
//use Gigablah\Silex\OAuth\Security\User\StubUser;
use Project3\Silex\OAuth\Security\User\User;
//use Symfony\Component\Security\Core\User\User;
use Gigablah\Silex\OAuth\Security\Authentication\Token\OAuthTokenInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
//use Doctrine\DBAL\Connection;


/**
 * OAuth in-memory stub user provider.
 *
 * @author Chris Heng <bigblah@gmail.com>
 */
class UserProvider implements UserProviderInterface, OAuthUserProviderInterface
{
    private $users;
    private $credentials;

    private $conn;
//    private $oauth;

    public function __construct()
    {
        global $app;
//        if($oauth) { $this->oauth = new ; }
        $this->conn = $app['db'];
    }


    public function loadUserByOAuthCredentials(OAuthTokenInterface $token)
    {

            printToTerminal("loadUserByOAuthCredentials");
            printToTerminal($token);
//            printToTerminal($token->getAccessToken());
//        if($token->getService() == 'Facebook')
        switch($token->getService())
        {
            case 'Facebook':
            $user = $this->loadUserByEmail($token->getEmail());
            break;
            case 'Google':
            $user = $this->loadUserByEmail($token->getEmail());
            break;
            case 'my_service':
            $user = $this->loadUserByEmail($token->getEmail());
            break;

            default:
            throw new \Exception('Not Supported Service!');
        }

//            $providerToken = $user->getProviderToken($token->getService());
//            if (!is_null($providerToken) && $providerToken->getUid() == $token->getUid()) {
//                return $user;
//            }

        return $user;
    }

    public function loadUserByEmail($email)
    {
//        if ($this->loadUserByUsername($username)) {
//            return $this->loadUserByUsername($username);
//        } else {
            $stmt = $this->conn->executeQuery('SELECT * FROM users WHERE email = ?', array(strtolower($email)));
            if (!$user = $stmt->fetch()) {
                throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $email));
            }


            return new User($user['username'], $user['password'], $user['email'], explode(',', $user['roles']), true, true, true, true);
//        }
    }

    public function loadUserByUsername($username)
    {
//        if ($this->loadUserByUsername($username)) {
//            return $this->loadUserByUsername($username);
//        } else {
            $stmt = $this->conn->executeQuery('SELECT * FROM users WHERE username = ?', array(strtolower($username)));
            if (!$user = $stmt->fetch()) {
                throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
            }


            return new User($user['username'], $user['password'], $user['email'], explode(',', $user['roles']), true, true, true, true);
//        }
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

//    public function supportsClass($class)
//    {
//        return $class === 'Symfony\Component\Security\Core\User\User';
//    }

//    public function loadUserByUsername($username)
//    {
//        $stmt = $this->conn->executeQuery('SELECT * FROM users WHERE username = ?', array(strtolower($username)));
//        if (!$user = $stmt->fetch()) {
//            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
//        }
//
//        return new User($user['username'], $user['password'], explode(',', $user['roles']), true, true, true, true);
//    }

//    public function refreshUser(UserInterface $user)
//    {
//        if (!$user instanceof User) {
//            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
//        }
//        $userObj = $this->loadUserByUsername($user->getUsername());
//        printToTerminal("user exists in db");
//        return $userObj;
//    }

//    public function createUser(UserInterface $user)
//    {
//        printToTerminal("createUser");
//
//        if (isset($this->users[strtolower($user->getUsername())])) {
//            throw new \LogicException('Another user with the same username already exist.');
//        }
//
//        $this->users[strtolower($user->getUsername())] = $user;
//
//    }



    /**
     * {@inheritdoc}
//     */
//    public function loadUserByOAuthCredentials(OAuthTokenInterface $token)
//    {
////        printToTerminal("loadUserByOAuthCredentials");
////        foreach ($this->credentials as $username => $credentials) {
////            foreach ($credentials as $credential) {
////                if ($credential['service'] == $token->getService() && $credential['uid'] == $token->getUid()) {
////                    return $this->loadUserByUsername($username);
////                }
////            }
////        }
////
////
////        $user = new User($token->getUsername(), '', $token->getEmail(), array('ROLE_USER'), true, true, true, true);
////        $this->createUser($user);
////
////        return $user;
//        return $this->oauth->loadUserByOAuthCredentials($token);
//    }


    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        printToTerminal("supportsClass");

        return $class === User::class;
    }



}
function printToTerminal($string)
{
    if(is_array($string)) $string = json_encode($string);
    $f = fopen('php://stderr', 'w');
    fputs($f, $string ."\n");
}