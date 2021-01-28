<?php

  namespace SimpleUser\JWT;

  require_once __DIR__.'/../jasongrimes/src/SimpleUser/User.php';

  use JsonSerializable;
  use SimpleUser\User as SimpleUser;

  class User extends SimpleUser implements JsonSerializable{

    /**
     * Serialize user properties
     * @method serialize
     * @return array     Serialized user
     */
    public function serialize(){
			$array = [];

			foreach(get_class_methods(__CLASS__) as $method){
//			    printToTerminal("class methods");
//			    printToTerminal("class methods");
//			    printToTerminal("class methods");
//                printToTerminal(json_encode($method));
//                printToTerminal("class methods");
//                printToTerminal("class methods");
//                printToTerminal("class methods");
//                printToTerminal("class methods");
//                printToTerminal("class methods");
//				if(substr($method, 0, 3) == 'get' && in_array($method, ['getId', 'getRoles', 'getEmail'])){
				if(substr($method, 0, 3) == 'get' && in_array($method, ['getCustomFields','getId','getRoles','getEmail','getName'])){
						$array[lcfirst(substr($method, 3))] = $this -> $method();
				} else if(substr($method, 0, 2) == 'is' && in_array($method, ['isEnabled'])){
  				$array[lcfirst(substr($method, 2))] = $this -> $method();
				}
			}

			return $array;
    }

    /**
     * Unserialize serialized user
     * @method unserialize
     * @param  string      $json JSON serialized user
     * @return void
     */
    public function unserialize($json){
      $array = json_decode($json, true);
      $this -> id = $json['id'];
    }

    /**
     * Serialize the object when it's encoded in JSON
     * @method jsonSerialize
     * @return array         Serialized object
     */
    public function jsonSerialize(){
      return $this -> serialize();
    }

  }

?>
