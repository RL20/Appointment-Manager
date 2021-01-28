<?php
class Employee implements JsonSerializable
{
	/*ID
		NAME
		PASSWORD_
		PHONE
		EMAIL*/
	private  $id;
	private  $name;
	private  $password;
	private  $phone;
	private  $email;
	private  $isActive;
	
	function __construct($name, $password,$phone,$email, $id=false,$isActive=null) 
	{
	
		$this->id = $id;
		$this->name = $name;
		$this->password = false;
		$this->phone = $phone;
		$this->email = $email;
		$this->isActive=$isActive;
	}

    public static function createObjectFromJson( $json)
    {
        $object = $json;
        return new self($object['name'], $object['password'], $object['phone'], $object['email'], $object['id'], $object['isActive']);
    }

    public static function createObjectsFromJsonArray( $jsonArray )
    {
        $objArray = [];
//        $array = json_decode( $jsonArray );
        foreach ($jsonArray as $object)
            $objArray[] = new self($object['name'], $object['password'], $object['phone'], $object['email'], $object['id'], $object['isActive']);

        return $objArray;
    }

	public function jsonSerialize()
	{
	    //don't return isActiv if customer asks for list of employees
	    if(isset($this->isActive))
		return [
				
				'id' => $this->id,
				'name' => $this->name,
				'password' => $this->password,
				'phone' => $this->phone,
				'email' => $this->email,
				'isActive' =>$this->isActive
	        
		];
	    else return [

                'id' => $this->id,
				'name' => $this->name,
				'password' => $this->password,
				'phone' => $this->phone,
				'email' => $this->email
		];
	}
	

function getId(){return $this->id;}
function setId($id){$this->id = $id;}

function getName(){return $this->name;}
function setName($name){$this->name=$name;}

function getEmail(){return $this->email;}
function setEmail($email){$this->email=$email;}

function getPhone(){return $this->phone;}
function setPhone($phone){$this->phone=$phone;}

function getPassword(){return $this->password;}
function setPassword($password){$this->password=$password;}

function getIsActive(){return $this->isActive;}
function setIsActive($isActive){$this->isActive=$isActive;}

}


