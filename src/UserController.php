<?php

  namespace SimpleUser\JWT;

  use Facebook\Exceptions\FacebookResponseException;
  use Facebook\Exceptions\FacebookSDKException;
  use Facebook\Facebook;
  use Silex\Application;
  use Symfony\Component\HttpFoundation\Request;

  use Exception;
  use InvalidArgumentException;
  use SimpleUser\JWT\Exceptions\AuthorizationException;
  use SimpleUser\JWT\Exceptions\UnknownException;
  use SimpleUser\JWT\Exceptions\DisabledException;
  use SimpleUser\JWT\Exceptions\MismatchException;
  use SimpleUser\JWT\Exceptions\ConfigException;
  use SimpleUser\JWT\Exceptions\ExpiredException;
  use SimpleUser\JWT\Exceptions\UsedException;

  class UserController{

    /**
     * Register a user (email & password only)
     * @method register
     * @param  string         $email    Email of the future user
     * @param  string         $password Password of the future user
     * @return json|Exception
     */
    public function register(Application $app, Request $request){
      printToTerminal('registerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr');

      $email = $request -> request -> get('email');
      $password = $request -> request -> get('password');
      $address = $request -> request -> get('address');
      $phone = $request -> request -> get('phone');
      $name = $request -> request -> get('first_name'). ' ' . $request -> request -> get('last_name');

      if(!$app['user.jwt.options']['registrations']['enabled']){
        throw new Exception($app['user.jwt.options']['language']::REGISTRATIONS_DISABLED);
      }

      if(!$email OR !$password){
        throw new InvalidArgumentException($app['user.jwt.options']['language']::EMAIL_OR_PASSWORD_MISSING);
      }

      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        throw new InvalidArgumentException($app['user.jwt.options']['language']::EMAIL_INVALID);
      }

      if($app['user.manager'] -> findOneBy(['email' => $email])){
        throw new UsedException($app['user.jwt.options']['language']::EMAIL_USED);
      }

      $user = $app['user.manager'] -> createUser($email, $password);
      $user -> addRole('ROLE_REGISTERED');

      printToTerminal(json_encode($user));
      $answer = ['message' => $app['user.jwt.options']['language']::REGISTER_SUCCESS];

//      if(true){
      try{
        printToTerminal('send mail');
      if($app['user.jwt.options']['registrations']['confirm'] && false){
        $user -> setEnabled(false);
        $user -> setTimePasswordResetRequested(time());
        $user -> setConfirmationToken($app['user.tokenGenerator'] -> generateToken());
        $app['user.jwt.mailer'] -> send(
          $app['user.jwt.options']['mailer']['templates']['register']['confirm'],
            'http://192.168.1.10:8888' . $app['user.jwt.options']['mailer']['routes']['reset'],
          $user,
          ['token' => $user -> getConfirmationToken()]
        );
      } else{
        $answer['token'] = $app['security.jwt.encoder'] -> encode($user -> serialize());
        if($app['user.jwt.options']['mailer']['templates']['register']['welcome']){
          $app['user.jwt.mailer'] -> send(
            $app['user.jwt.options']['mailer']['templates']['register']['welcome'],
            'http://192.168.1.10:8888' . $app['user.jwt.options']['mailer']['routes']['login'],
            $user
          );
        }
      }}catch(Exception $e){}
//      }

//      $app['user.manager'] -> insert($user);

//TODO need to add ROLE_EMPLOYEE to the Register function
      if($user->hasRole("ROLE_USER"))
      {
        $customer = new \Customer($name, $email , $phone, false, $address);
//        \CustomerDBDAO::createCustomer($customer);
      }
      elseif ($user->hasRole("ROLE_EMPLOYEE"))
      {

      }

      printToTerminal('end of function');
      return $app -> json($answer,200);

    }

    /**
     * Register a user (email & password only)
     * @method register
     * @param  string         $email    Email of the future user
     * @param  string         $password Password of the future user
     * @return json|Exception
     */
    public function socialRegister(Application $app, Request $request){
      printToTerminal('social registerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr');

      $email = $request -> request -> get('email');
      $address = $request -> request -> get('address');
      $phone = $request -> request -> get('phone');
      $name = $request -> request -> get('first_name'). ' ' . $request -> request -> get('last_name');


      if(!$app['user.jwt.options']['registrations']['enabled']){
        throw new Exception($app['user.jwt.options']['language']::REGISTRATIONS_DISABLED);
      }

      if(!$email){
        throw new InvalidArgumentException($app['user.jwt.options']['language']::EMAIL_OR_PASSWORD_MISSING);
      }

      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        throw new InvalidArgumentException($app['user.jwt.options']['language']::EMAIL_INVALID);
      }

      if($app['user.manager'] -> findOneBy(['email' => $email])){
        throw new UsedException($app['user.jwt.options']['language']::EMAIL_USED);
      }

      $user = $app['user.manager'] -> createUser($email, '1');
      $user -> addRole('ROLE_REGISTERED');

      printToTerminal(json_encode($user));
      $answer = ['message' => $app['user.jwt.options']['language']::REGISTER_SUCCESS];

//      if(true){
      try{
        printToTerminal('send mail');
      if($app['user.jwt.options']['registrations']['confirm'] && false){
        $user -> setEnabled(false);
        $user -> setTimePasswordResetRequested(time());
        $user -> setConfirmationToken($app['user.tokenGenerator'] -> generateToken());
        $app['user.jwt.mailer'] -> send(
          $app['user.jwt.options']['mailer']['templates']['register']['confirm'],
            'http://192.168.1.10:8888' . $app['user.jwt.options']['mailer']['routes']['reset'],
          $user,
          ['token' => $user -> getConfirmationToken()]
        );
      } else{
        $answer['token'] = $app['security.jwt.encoder'] -> encode($user -> serialize());
        if($app['user.jwt.options']['mailer']['templates']['register']['welcome']){
          $app['user.jwt.mailer'] -> send(
            $app['user.jwt.options']['mailer']['templates']['register']['welcome'],
            'http://192.168.1.10:8888' . $app['user.jwt.options']['mailer']['routes']['login'],
            $user
          );
        }
      }}catch(Exception $e){}
//      }

      $app['user.manager'] -> insert($user);

      printToTerminal('userrrrrrrrrr:   ' . $user);

//TODO need to add ROLE_EMPLOYEE to the Register function
      if($user->hasRole("ROLE_USER"))
      {
        $customer = new \Customer($name, $email , $phone, false, $address);
        \CustomerDBDAO::createCustomer($customer);
      }
      elseif ($user->hasRole("ROLE_EMPLOYEE"))
      {

      }

      printToTerminal('end of function');
      return $app -> json($answer,200);

    }

    /**
     * userInfo
     * @method userInfo
     * @return json|Exception
     */
    public function userInfo(Application $app, Request $request){


        $user = $app['security.token_storage'] -> getToken() -> getUser() ;

        if($user->hasRole("ROLE_USER"))
        {
          $userObj = [];

            $userObj['user'] =  \CustomerDBDAO::getCustomerByEmail($user -> getEmail());
            $userObj['user1'] =  $app['user.manager'] -> findOneBy(['email' => $user -> getEmail()]);
            $userObj['role'] = "ROLE_USER";
        }
        elseif ($user->hasRole("ROLE_EMPLOYEE"))
        {

        }


        printToTerminal('USER:');
        printToTerminal(json_encode($userObj));

        return $app->json($userObj, 200);
    }

      /**
       * Register a user (email & password only)
       * @method socialLogin
       * @param  string         $socialToken    Email of the future user
       * @return json|Exception
       */
      public function socialLogin(Application $app, Request $request){

          $email = '';
          $socialToken = $request -> request -> get('socialToken');
          $network = $request -> request -> get('network');
          printToTerminal('socialLogin');
          printToTerminal($request);

          if($network == "facebook"){$fb = new Facebook([
            'app_id' => '1608771039167400',
            'app_secret' => '747bf2ff3985ae05bc65339d540ab505',
            'default_graph_version' => 'v2.8',
        ]);

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get('/me?fields=id,email', $socialToken);
        } catch(FacebookResponseException $e) {
            printToTerminal( 'Graph returned an error: ' . $e->getMessage());
            exit;
        } catch(FacebookSDKException $e) {
            printToTerminal( 'Facebook SDK returned an error: ' . $e->getMessage());
            exit;
        }

        $FBuser = $response->getGraphUser();

//        echo 'Name: ' . $FBuser['email'];
        $email = $FBuser['email'];
        printToTerminal('FACEBOOK');
        printToTerminal($FBuser);
      }
      elseif ($network == 'google')
      {


          $client = new \Google_Client();
//          $client->setAuthConfig('/path/to/client_credentials.json');
          $client->setClientId('339582927777-7r3a123o6btq5ojqpoho4nghgi9bg2q7.apps.googleusercontent.com');
          $client->setClientSecret('kYX9rmoTcPLuy_kwd8vn11T9');
          $client->setRedirectUri('postmessage');
          $client->setScopes(array('email'));
//          $client->setScopes(array(\Google_Service_Plus::PLUS_LOGIN,\Google_Service_Plus::USERINFO_PROFILE,\Google_Service_Plus::PLUS_ME,\Google_Service_Plus::USERINFO_EMAIL));
          $client->setAccessToken($socialToken);
          $plus = new \Google_Service_Plus($client);

//          $oauth2 = new \apiOauth2Service($client);

//          $FIELDS  = 'id,name,image';
          $FIELDS  = 'emails,image,name';
          printToTerminal('gggggggggggggggggggggggggggggggggggg');
//          $me = $plus->people->get('me', array('fields' => $FIELDS));
          $me = $plus->people->get('me');
//          $oauth2 = new \Google_Service_Oauth2($client);
//          $emails = $me->getEmails();
          $oauth2 = new \Google_Service_Oauth2($client);
          $userInfo = $oauth2->userinfo->get();

          printToTerminal('');
          printToTerminal('');
          printToTerminal('');
          printToTerminal('');
          printToTerminal('');
          printToTerminal('');
          printToTerminal('');
          printToTerminal('');
          printToTerminal('');
          printToTerminal('');
          printToTerminal('');
          printToTerminal(json_encode($userInfo,true));
          printToTerminal(json_encode($me,true));
//          printToTerminal('emails: ' . json_encode($emails));
          printToTerminal('');
          printToTerminal('');
          printToTerminal('');
          printToTerminal('');
          printToTerminal('');
          printToTerminal('');
          printToTerminal('');
          printToTerminal('');

        $email = 'aviya_am@walla.co.il';
        throw new Exception('asdasd');
      }

//        $email = $request -> request -> get('socialToken');
//        $password = $request -> request -> get('password');

//        if(!$email OR !$password){
//            throw new InvalidArgumentException($app['user.jwt.options']['language']::EMAIL_OR_PASSWORD_MISSING);
//        }
//
//        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
//            throw new InvalidArgumentException($app['user.jwt.options']['language']::EMAIL_INVALID);
//        }

        $user = $app['user.manager'] -> findOneBy(['email' => $email]);

        if(!$user){
            printToTerminal($user);
            printToTerminal('UnknownException:  email does not exist');
            throw new UnknownException($app['user.jwt.options']['language']::EMAIL_UNKNOWN, 1);
        }
//
////        if(!$app['security.encoder.digest'] -> isPasswordValid($user -> getPassword(), $password, $user -> getSalt())){
////            throw new MismatchException($app['user.jwt.options']['language']::PASSWORD_INVALID);
////        }
//
//        if(!$user -> isEnabled()){
//            printToTerminal($user);
//            throw new DisabledException($app['user.jwt.options']['language']::ACCOUNT_DISABLED);
//        }

//        $response1 = json_encode(['token' => $app['security.jwt.encoder'] -> encode($user -> serialize())]);
        $response1 = $app -> json(['token' => $app['security.jwt.encoder'] -> encode($user -> serialize())]);

        printToTerminal('response: ');
        printToTerminal($response1);
//        return $app -> json(['token' => $app['security.jwt.encoder'] -> encode($user -> serialize())]);
        return $response1;


//      return $response;
    }

    /**
     * Authenticate a user by his email & password
     * @method login
     * @param  string         $email    Email of the user
     * @param  string         $password Clear password of the user
     * @return json|Exception
     */
    public function login(Application $app, Request $request){
      printToTerminal('loginnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn');
      printToTerminal($request -> request-> get('email'));
      $email = $request -> request -> get('email');
      $password = $request -> request -> get('password');

      if(!$email OR !$password){
        throw new InvalidArgumentException($app['user.jwt.options']['language']::EMAIL_OR_PASSWORD_MISSING);
      }

      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        throw new InvalidArgumentException($app['user.jwt.options']['language']::EMAIL_INVALID);
      }

      $user = $app['user.manager'] -> findOneBy(['email' => $email]);

      if(!$user){
        throw new UnknownException($app['user.jwt.options']['language']::EMAIL_UNKNOWN);
      }

      if(!$app['security.encoder.digest'] -> isPasswordValid($user -> getPassword(), $password, $user -> getSalt())){
//        throw new MismatchException($app['user.jwt.options']['language']::PASSWORD_INVALID);
      }

      if(!$user -> isEnabled()){
        throw new DisabledException($app['user.jwt.options']['language']::ACCOUNT_DISABLED);
      }

      $response = $app -> json(['token' => $app['security.jwt.encoder'] -> encode($user -> serialize())]);
      printToTerminal('response:');
      printToTerminal($response);

      return $response;
    }

    /**
     * Create a user with a temp password and send him an email
     * @method invite
     * @param  string         $email            Email of the invited user
     * @return json|Exception
     */
    public function invite(Application $app, Request $request){
      $email = $request -> request -> get('email');

      if(!$app['user.jwt.options']['invite']['enabled']){
        throw new Exception($app['user.jwt.options']['language']::INVITATIONS_DISABLED);
      }

      if(!$app['security.authorization_checker'] -> isGranted('ROLE_ALLOW_INVITE')){
        throw new AuthorizationException($app['user.jwt.options']['language']::INVITATIONS_FORBIDDEN);
      }

      if(!$email){
        throw new InvalidArgumentException($app['user.jwt.options']['language']::EMAIL_MISSING);
      }

      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        throw new InvalidArgumentException($app['user.jwt.options']['language']::EMAIL_INVALID);
      }

      if($app['user.manager'] -> findOneBy(['email' => $email])){
        throw new UsedException($app['user.jwt.options']['language']::EMAIL_USED);
      }

      $user = $app['user.manager'] -> createUser($email, $app['user.tokenGenerator'] -> generateToken());
      $user -> setCustomField('invited_by', $app['security'] -> getToken() -> getUser() -> getId());
      $user -> addRole('ROLE_INVITED');

      $user -> setEnabled(false);
      $user -> setTimePasswordResetRequested(time());
      $user -> setConfirmationToken($app['user.tokenGenerator'] -> generateToken());

      $app['user.manager'] -> insert($user);

      $app['user.jwt.mailer'] -> send(
        $app['user.jwt.options']['mailer']['templates']['invite'],
        $app['user.jwt.options']['mailer']['routes']['reset'],
        $user,
        ['token' => $user -> getConfirmationToken()]
      );

      $answer = ['message' => $app['user.jwt.options']['language']::INVITATIONS_SUCCESS];

      if(isset($app['dev']) && $app['dev']){
        $answer['token'] = $user -> getConfirmationToken();
      }

      return $app -> json($answer);
    }

    /**
     * Return invited users by the logged user
     * @method friends
     * @return json|Exception
     */
    public function friends(Application $app, Request $request){
      $user = $app['security'] -> getToken() -> getUser();

      $friends = $app['user.manager'] -> findby(['customFields' => ['invited_by' => $user -> getId()]]);

      return $app -> json(['friends' => $friends]);
    }

    /**
     * Set a reset password token and send an email to the user
     * @method forget
     * @param  string         $email Email of the user who forget his password
     * @return json|Exception
     */
    public function forget(Application $app, Request $request){
      $email = $request -> request -> get('email');

      if(!$app['user.jwt.options']['forget']['enabled']){
        throw new Exception($app['user.jwt.options']['language']::FORGET_DISABLED);
      }

      if(!$email){
        throw new InvalidArgumentException($app['user.jwt.options']['language']::EMAIL_MISSING);
      }

      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        throw new InvalidArgumentException($app['user.jwt.options']['language']::EMAIL_INVALID);
      }

      $user = $app['user.manager'] -> findOneBy(['email' => $email]);

      if(!$user){
        throw new UnknownException($app['user.jwt.options']['language']::EMAIL_UNKNOWN);
      }

      $user -> setTimePasswordResetRequested(time());
      $user -> setConfirmationToken($app['user.tokenGenerator'] -> generateToken());
      $app['user.manager'] -> update($user);

      $app['user.jwt.mailer'] -> send(
        $app['user.jwt.options']['mailer']['templates']['forget'],
        $app['user.jwt.options']['mailer']['routes']['reset'],
        $user,
        ['token' => $user -> getConfirmationToken()]
      );

      $answer = ['message' => $app['user.jwt.options']['language']::FORGET_SUCCESS];

      if(isset($app['dev']) && $app['dev']){
        $answer['token'] = $user -> getConfirmationToken();
      }

      return $app -> json($answer);
    }

    /**
     * Reset a password for a given reset password token linked to an user
     * @method invite
     * @param  string         $token    Reset password token
     * @param  string         $password New password
     * @return json|Exception
     */
    public function reset(Application $app, Request $request, $token){
      $password = $request -> request -> get('password');

      if(!$app['user.jwt.options']['forget']['enabled']){
        throw new Exception($app['user.jwt.options']['language']::RESET_DISABLED);
      }

      $user = $app['user.manager'] -> findOneBy(['confirmationToken' => $token]);

      if(!$user){
        throw new InvalidArgumentException($app['user.jwt.options']['language']::TOKEN_INVALID);
      }

      if($user -> isPasswordResetRequestExpired($app['user.options']['passwordReset']['tokenTTL'])){
        throw new ExpiredException($app['user.jwt.options']['language']::TOKEN_EXPIRED);
      }

      $user -> setEnabled(true);
      $user -> setTimePasswordResetRequested(null);
      $user -> setConfirmationToken(null);
      $app['user.manager'] -> setUserPassword($user, $password);
      $app['user.manager'] -> update($user);

      return $app -> json(['message' => $app['user.jwt.options']['language']::RESET_SUCCESS, 'token' => $app['security.jwt.encoder'] -> encode($user -> serialize())]);
    }

    /**
     * Update the profil of the current logged user
     * @method update
     * @param  int            $id (optional)           ID of the user we want to update
     * @param  string         $email (optional)        New email
     * @param  string         $password (optional)     New password
     * @param  string         $name (optional)         New name
     * @param  string         $username (optional)     New username
     * @param  array          $customFields (optional) New custom fields
     * @return json|Exception
     */
    public function update(Application $app, Request $request, $id){
      $email = $request -> request -> get('email');
      $password = $request -> request -> get('password');
      $name = $request -> request -> get('name');
      $username = $request -> request -> get('username');
      $customFields = $request -> request -> get('customFields');

      if(!$id){
        $user = $app['security'] -> getToken() -> getUser();
      } else if($app['security.authorization_checker'] -> isGranted('ROLE_ADMIN')){
        $user = $app['user.manager'] -> findOneBy(['id' => $id]);
      } else{
        throw new AuthorizationException($app['user.jwt.options']['language']::UNAUTHORIZED);
      }

      if($email && filter_var($email, FILTER_VALIDATE_EMAIL)){
        if($app['user.manager'] -> findOneBy(['email' => $email])){
          throw new UsedException($app['user.jwt.options']['language']::EMAIL_USED);
        }
        $user -> setEmail($email);
      }

      if($password){
        $app['user.manager'] -> setUserPassword($user, $password);
      }

      if($username && $app['user.manager'] -> getUsernameRequired()){
        $user -> setUsername($username);
      }

      if($name){
        $user -> setName($name);
      }

      if($customFields){
        $user -> setCustomFields($customFields);
      }

      $app['user.manager'] -> update($user);

      return $app -> json(['token' => $app['security.jwt.encoder'] -> encode($user -> serialize())]);
    }

  }

?>
