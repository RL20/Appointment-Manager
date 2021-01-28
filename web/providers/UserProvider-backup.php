<?php



namespace Project3\Silex\OAuth\Security\User\Provider;

include __DIR__.'/../../vendor/symfony/security/Core/User/UserProviderInterface.php';
include __DIR__.'/../../vendor/gigablah/silex-oauth/src/Security/User/Provider/OAuthUserProviderInterface.php';
include __DIR__.'/../../web/providers/User.php';


use Gigablah\Silex\OAuth\Security\User\Provider\OAuthUserProviderInterface;
use Gigablah\Silex\OAuth\Security\User\StubUser;
use Project3\Silex\OAuth\Security\User\User;
use Gigablah\Silex\OAuth\Security\Authentication\Token\OAuthTokenInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * OAuth in-memory stub user provider.
 *
 * @author Chris Heng <bigblah@gmail.com>
 */
class UserProvider implements UserProviderInterface, OAuthUserProviderInterface
{
    private $users;
    private $credentials;

    /**
     * Constructor.
     *
     * @param array $users       An array of users
     * @param array $credentials A map of usernames with service credentials (service name and uid)
     */
    public function __construct(array $users = array(), array $credentials = array())
    {
        printToTerminal("__construct");

        foreach ($users as $username => $attributes) {
            $password = isset($attributes['password']) ? $attributes['password'] : null;
            $email = isset($attributes['email']) ? $attributes['email'] : null;
            $enabled = isset($attributes['enabled']) ? $attributes['enabled'] : true;
            $roles = isset($attributes['roles']) ? (array) $attributes['roles'] : array();
            $user = new User($username, $password, $email, $roles, $enabled, true, true, true);
            $this->createUser($user);
        }

        $this->credentials = $credentials;
    }

    public function createUser(UserInterface $user)
    {
        printToTerminal("createUser");

        if (isset($this->users[strtolower($user->getUsername())])) {
            throw new \LogicException('Another user with the same username already exist.');
        }

        $this->users[strtolower($user->getUsername())] = $user;

    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        printToTerminal("loadUserByUsername");

        if (isset($this->users[strtolower($username)])) {
            $user = $this->users[strtolower($username)];
        } else {
            $user = new User($username, '', $username . '@example.org', array('ROLE_USER'), true, true, true, true);
            $this->createUser($user);
        }

        return new User($user->getUsername(), $user->getPassword(), $user->getEmail(), $user->getRoles(), $user->isEnabled(), $user->isAccountNonExpired(), $user->isCredentialsNonExpired(), $user->isAccountNonLocked());
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthCredentials(OAuthTokenInterface $token)
    {
        printToTerminal("loadUserByOAuthCredentials");
        foreach ($this->credentials as $username => $credentials) {
            foreach ($credentials as $credential) {
                if ($credential['service'] == $token->getService() && $credential['uid'] == $token->getUid()) {
                    return $this->loadUserByUsername($username);
                }
            }
        }


        $user = new User($token->getUsername(), '', $token->getEmail(), array('ROLE_USER'), true, true, true, true);
        $this->createUser($user);

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        printToTerminal("refreshUser");

        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        printToTerminal("username:" .$user->getUsername(). " password: ". $user->getPassword(). " email: ". $user->getEmail() ." roles: ".$user->getRoles()[0]. " enabled: ".$user->isEnabled());
        return $user;
    }

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