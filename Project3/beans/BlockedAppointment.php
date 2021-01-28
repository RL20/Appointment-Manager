<?php

class BlockedAppointment implements JsonSerializable
{
    /*ID
 APP_DATE
 APP_TIME
 EMP_ID
 */
	private  $id;
	private  $blockedAppointmentDate;
	private  $blockedAppointmentTime;
	private  $employeeId;
	
	function __construct($blockedAppointmentDate, $blockedAppointmentTime, $employeeId, $id=false)
	{
		$this->id = $id;
		$this->blockedAppointmentDate=$blockedAppointmentDate;
		$this->blockedAppointmentTime=$blockedAppointmentTime;
		$this->employeeId=$employeeId;
		
	}

//gets an array with this class parameters from the silex controller and converts it to this class object
    public static function createObjectFromJson($json)
    {
//        $object = json_decode( $jsonString );
//		printToTerminal("createObjectFromJson: ".$jsonString);

        $object = $json;

//        printToTerminal("createObjectFromJson: ".$jsonString['blockedAppointmentTime']);
        return new self($object['blockedAppointmentDate'], $object['blockedAppointmentTime'], $object['employeeId'], $object['id'] );
    }
//gets an array with this class parameters from the silex controller and converts it to this class object
//see controller.php 'before' function for more information
    public static function createObjectsFromJsonArray($jsonArray)
    {
        $objArray = [];
//        $array = json_decode( $jsonArray );
        foreach ($jsonArray as $object)
            $objArray[] = new self($object['blockedAppointmentDate'], $object['blockedAppointmentTime'], $object['employeeId'], $object['id'] );


        return $objArray;
    }

	public function jsonSerialize() {
		return [
                'id' => $this->id,
				'blockedAppointmentDate' => $this->blockedAppointmentDate,
				'blockedAppointmentTime' =>  $this->blockedAppointmentTime,
				'employeeId' => $this->employeeId
               
        ];
	}
	
	function equals(BlockedAppointment $app)
	{
		
		$isEquals = $this->blockedAppointmentDate === $app->getblockedAppointmentDate(); 
		if(!$isEquals)return false;
		$isEquals = $this->blockedAppointmentTime === $app->getblockedAppointmentTime();
		if(!$isEquals)return false;
		$isEquals = $this->employeeId === $app->getEmployeeId();
		if(!$isEquals)return false;
		else return true;
	}

	


function getId(){return $this->id;}
function setId($id){$this->id = $id;}

function getblockedAppointmentDate(){return $this->blockedAppointmentDate;}
function setblockedAppointmentDate($blockedAppointmentDate){$this->blockedAppointmentDate=$blockedAppointmentDate;}

function getblockedAppointmentTime(){return $this->blockedAppointmentTime;}
function setblockedAppointmentTime($blockedAppointmentTime){$this->blockedAppointmentTime=$blockedAppointmentTime;}


function getEmployeeId(){return $this->employeeId;}
function setEmployeeId($employeeId){$this->employeeId=$employeeId;}

}






