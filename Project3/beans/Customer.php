<?php
class Customer implements JsonSerializable
{
	private  $id;
	private  $name;
	private  $address;
	private  $password;
	private  $email;
	private  $phone;
	private  $isActive;
	
	
	public function __construct($name, $email ,$phone, $password,$address,$id=false,$isActive=null) {
		// allocate your stuff
		$this->address = $address;
		$this->email = $email;
		$this->id = $id;
		$this->name = $name;
		$this->password = $password;
		$this->phone = $phone;
		$this->isActive=$isActive;
	}
    public static function createObjectFromJson( $json)
    {
        $object = $json;
        return new self ($object['name'], $object['email'], $object['phone'], $object['password'], $object['address'], $object['id'],$object['isActive']);

    }

    public static function createObjectsFromJsonArray( $jsonArray )
    {
        $objArray = [];
//        $array = json_decode( $jsonArray );
        foreach ($jsonArray as $object)
            $objArray[] = new self($object['name'], $object['email'], $object['phone'], $object['password'], $object['address'], $object['id'],$object['isActive']);


        return $objArray;
    }
	//ID ���� ����� ����� �� ����� ���� ��� 
	/*public static function withID( $id, $name, $email ,$phone, $password,$address ) {
		$instance = new self(); //new Customer;  Customer::whithID();
		$instance->setAddress($address);
		$instance->setEmail($email);
		$instance->setId($id);
		$instance->setName($name);
		$instance->setPassword($password);
		$instance->setPhone($phone);

		return $instance;
	}
	
	public static function withoutID($name, $email ,$phone, $password,$address ) {
		
		$instance = new self();
		$instance->setAddress($address);
		$instance->setEmail($email);
// 		$instance->setId($id);
		$instance->setName($name);
		$instance->setPassword($password);
		$instance->setPhone($phone);
	
		return $instance;
	}
	
	function __construct( $id, $name, $email ,$phone, $password,$address)
	{
		$this->address = $address;
		$this->email = $email;
		$this->id = $id;
		$this->name = $name;
		$this->password = $password;
		$this->phone = $phone;	
	}*/
	
	public function jsonSerialize()
	{
		return [
	
				'id' => $this->id,
				'name' => $this->name,
				'address' => $this->address,
				'password' => $this->password,
				'phone' => $this->phone,
				'email' => $this->email,
				'isActive' =>$this->isActive
				 
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

function getAddress(){return $this->address;}
function setAddress($address){$this->address=$address;}

function getIsActive(){return $this->isActive;}
function setIsActive($isActive){$this->isActive=$isActive;}

}

