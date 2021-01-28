<?php
/*ID
 APP_DATE
 APP_TIME
 CUST_ID
 EMP_ID
 COMMENT_*/
class Appointment implements JsonSerializable
{
	private  $id;
	private  $appointmentDate;
	private  $appointmentTime;
    private  $durationTime;
    private  $customerId;
	private  $employeeId;
	private  $comment;
	
	function __construct($appointmentDate, $appointmentTime ,$durationTime,$customerId, $employeeId,$comment,$id=false)
	{
		$this->id = $id;
		$this->appointmentDate=$appointmentDate;
		$this->appointmentTime=$appointmentTime;
		$this->durationTime=$durationTime;
		$this->customerId=$customerId;
		$this->employeeId=$employeeId;
		$this->comment=$comment;
		
	}

    public static function createObjectFromJson( $json)
    {
        if(!isset($json)) throw new Exception("null Exception!");
        $object = $json;
        return new self($object['appointmentDate'], $object['appointmentTime'],$object['durationTime'], $object['customerId'], $object['employeeId'], $object['comment'], $object['id']);
    }

    public static function createObjectsFromJsonArray( $jsonArray )
    {
        $objArray = [];
//        $array = json_decode( $jsonArray );
        foreach ($jsonArray as $object)
         $objArray[] = new self($object['appointmentDate'], $object['appointmentTime'],$object['durationTime'], $object['customerId'], $object['employeeId'], $object['comment'], $object['id']);


        return $objArray;
    }

	public function jsonSerialize() {
		return [
                'id' => $this->id,
				'appointmentDate' => $this->appointmentDate,
				'appointmentTime' => $this->appointmentTime,
				'durationTime' => $this->durationTime,
				'customerId' => $this->customerId,
				'employeeId' => $this->employeeId,
				'comment' => $this->comment
               
        ];
	}
	
	function equals(Appointment $app)
	{
		
		$isEquals = $this->appointmentDate === $app->appointmentDate; 
		if(!$isEquals)return false;
		$isEquals = $this->appointmentTime === $app->appointmentTime;
		if(!$isEquals)return false;
		$isEquals = $this->durationTime === $app->durationTime;
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
	


function getId(){return $this->id;}
function setId($id){$this->id = $id;}

function getAppointmentDate(){return $this->appointmentDate;}
function setAppointmentDate($appointmentDate){$this->appointmentDate=$appointmentDate;}

function getAppointmentTime(){return $this->appointmentTime;}
function setAppointmentTime($appointmentTime){$this->appointmentTime=$appointmentTime;}

function getDurationTime(){return $this->durationTime;}
function setDurationTime($durationTime){$this->durationTime=$durationTime;}

function getCustomerId(){return $this->customerId;}
function setCustomerId($customerId){$this->customerId=$customerId;}

function getEmployeeId(){return $this->employeeId;}
function setEmployeeId($employeeId){$this->employeeId=$employeeId;}

function getComment(){return $this->comment;}
function setComment($comment){$this->comment=$comment;}
}









