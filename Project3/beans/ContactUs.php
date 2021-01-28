<?php
/*BUSINESS_NAME	
ADDRESS	
PHONE1	
PHONE2	
PHONE3	
EMAIL
WHATSAPP
GOOGLE+
SKYPE
TELEGRAM
FACEBOOK
TWITTER
SHARE
LOGO_SRC*/
class ContactUs implements JsonSerializable
{
	private  $businessName;
	private  $address;
	private  $phone1;
	private  $phone2;
	private  $phone3;
	private  $email;
	private  $whatsapp;
	private  $google;
	private  $skype;
	private  $telegram;
	private  $facebook;
	private  $twitter;
	private  $share;
	private  $logoSrc;
	
	function __construct($businessName, $address ,$phone1,$logoSrc, $phone2 = null,$phone3=null,$email=null,$whatsapp=null,$google=null,$skype=null,$telegram=null,$facebook=null,$twitter=null) 
	{
	
		
		$this->businessName=$businessName;
		$this->address=$address;
		$this->phone1=$phone1;
		$this->logoSrc=$logoSrc;
		$this->phone2=$phone2;
		$this->phone3=$phone3;
		$this->email=$email;
		$this->whatsapp=$whatsapp;
		$this->google=$google;
		$this->skype=$skype;
		$this->telegram=$telegram;
		$this->facebook=$facebook;
		$this->twitter=$twitter;
		$this->share="http://". $_SERVER['HTTP_HOST'];// PHP ���� �� �� ����� ���� ��� ��,��� ��������� ��� ����� ���� ��� �
		
	}
    public static function createObjectFromJson( $json)
    {
        $object = $json;
        return new self($object['businessName'], $object['address'], $object['phone1'], $object['logoSrc'], $object['phone2'], $object['phone3'],
            $object['email'],$object['whatsapp'],$object['google'],$object['skype'],$object['telegram'],$object['facebook'],$object['twitter']);
    }

    public static function createObjectsFromJsonArray( $jsonArray )
    {
        $objArray = [];
//        $array = json_decode( $jsonArray );
        foreach ($jsonArray as $object)
            $objArray[] = new self($object['businessName'], $object['address'], $object['phone1'], $object['logoSrc'], $object['phone2'], $object['phone3'],
                $object['email'],$object['whatsapp'],$object['google'],$object['skype'],$object['telegram'],$object['facebook'],$object['twitter']);

        return $objArray;
    }
	public function jsonSerialize() {
		return [
                
				'businessName' => $this->businessName,
				'address' =>$this->address,
				'phone1' =>$this->phone1,
				'phone2' =>$this->phone2,
				'phone3' =>$this->phone3,
				'email' =>$this->email,
				'whatsapp' =>$this->whatsapp,
				'google' =>$this->google,
				'skype' =>$this->skype,
				'telegram' =>$this->telegram,
				'facebook' =>$this->facebook,
				'twitter' =>$this->twitter,
				'share' =>$this->share,
				'logoSrc' =>$this->logoSrc
               
        ];
	}
	/*
	 //----------------------------------
	  * ��� ����� ����� �� ��� ������
	function equals(Appointment $app)
	{
		
		$isEquals = $this->appointmentDate === $app->appointmentDate; 
		if(!$isEquals)return false;
		$isEquals = $this->appointmentTime === $app->appointmentTime;
		if(!$isEquals)return false;
		$isEquals = $this->customerId === $app->customerId;
		if(!$isEquals)return false;
		$isEquals = $this->employeeId === $app->employeeId;
		if(!$isEquals)return false;
		$isEquals = $this->comment === $app->comment;
		if(!$isEquals)return false;
		else return true;
	}
// 	public static function withoutID($name, $email ,$phone, $password,$address )
// 	{
// 		$this->appointmentDate=$appointmentDate;
// 		$this->appointmentTime=$appointmentTime;
// 		$this->customerId=$customerId;
// 		$this->employeeId=$employeeId;
// 		$this->comment=$comment;
// 	}
// 	public static function withID($id,$name, $email ,$phone, $password,$address ) 
// 	{
// 		$this->id = $id;
// 		$this->appointmentDate=$appointmentDate;
// 		$this->appointmentTime=$appointmentTime;
// 		$this->customerId=$customerId;
// 		$this->employeeId=$employeeId;
// 		$this->comment=$comment;
// 	} 
	
	*/
	function getBusinessName(){return $this->businessName;}
	function setBusinessName($businessName){$this->businessName=$businessName;}
	
	function getAddress(){return$this->address;}
	function setAddress($address){$this->address=$address;}
	
	function getPhone1(){return$this->phone1;}
	function setPhone1($phone1){$this->phone1=$phone1;}
	
	function getPhone2(){return$this->phone2;}
	function setPhone2($phone2){$this->phone2=$phone2;}
	
	function getPhone3(){return$this->phone3;}
	function setPhone3($phone3){$this->phone3=$phone3;}
	
	function getEmail(){return$this->email;}
	function setEmail($email){$this->email=$email;}
	
	function getWhatsapp(){return$this->whatsapp;}
	function setWhatsapp($whatsapp){$this->whatsapp=$whatsapp;}
	
	function getGoogle(){return$this->google;}
	function setGoogle($google){$this->google=$google;}
	
	function getSkype(){return$this->skype;}
	function setSkype($skype){$this->skype=$skype;}
	
	function getTelegram(){return$this->telegram;}
	function setTelegram($telegram){$this->telegram=$telegram;}
	
	function getFacebook(){return$this->facebook;}
	function setFacebook($facebook){$this->facebook=$facebook;}
	
	function getTwitter(){return$this->twitter;}
	function setTwitter($twitter){$this->twitter=$twitter;}
	
	function getShare(){return$this->share;}
	function setShare($share){$this->share=$share;}
	
	function getLogoSrc(){return$this->logoSrc;}
	function setLogoSrc($logoSrc){$this->logoSrc=$logoSrc;}
	
	
	
}







