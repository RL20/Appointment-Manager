<?php

class WorkHours implements JsonSerializable
{
	/*
	  EMP_ID
	  DAY_
	  FROM_HOUR1
	  TO_HOUR1
	  FROM_HOUR2
	  TO_HOUR2 
	 */
	private $id;
	private $employeeId;
	private $day;
	private $fromHour1;
	private $toHour1;
	private $fromHour2;
	private $toHour2;
	
	function __construct($employeeId,$day,$fromHour1,$toHour1,$fromHour2,$toHour2,$id=false) 
	{
		$this->employeeId=$employeeId;
		$this->day=$day;
		$this->fromHour1=$fromHour1;
		$this->toHour1=$toHour1;
		$this->fromHour2=$fromHour2;
		$this->toHour2=$toHour2;
		$this->id=$id;
	}

    public static function createObjectFromJson( $json)
    {
        if(!isset($json)) throw new Exception("null Exception!");
        $object = $json;
        return new self($object['employeeId'], $object['day'], $object['fromHour1'], $object['toHour1'], $object['fromHour2'], $object['toHour2'],$object['id']);
    }

    public static function createObjectsFromJsonArray( $jsonArray )
    {
        $objArray = [];
//        $array = json_decode( $jsonArray );
        foreach ($jsonArray as $object)
            $objArray[] = new self($object['employeeId'], $object['day'], $object['fromHour1'], $object['toHour1'], $object['fromHour2'], $object['toHour2'],$object['id']);


        return $objArray;
    }

    public function jsonSerialize() {
		return [
				'ID' => $this->id,
				'EmployeeId' => $this->employeeId,
				'Day' => $this->day,
				'FromHour1' => $this->fromHour1,
				'ToHour1' => $this->toHour1,
				'FromHour2' => $this->fromHour2,
				'ToHour2' => $this->toHour2
		];
	}
	
	function equals(WorkHours $workHours)
	{
	
		$isEquals = $this->id === $workHours->getId();
		if(!$isEquals)return false;
		$isEquals = $this->employeeId === $workHours->getEmployeeId();
		if(!$isEquals)return false;
		$isEquals = $this->day === $workHours->getDay();
		if(!$isEquals)return false;
		$isEquals = $this->fromHour1 === $workHours->getFromHour1();
		if(!$isEquals)return false;
		$isEquals = $this->toHour1 === $workHours->getToHour1();
		if(!$isEquals)return false;
		$isEquals = $this->fromHour2 === $workHours->getFromHour2();
		if(!$isEquals)return false;
		$isEquals = $this->toHour2 === $workHours->getToHour2();
		if(!$isEquals)return false;
		else return true;
	}

function getId(){return $this->id;}
function setId($id){$this->id = $id;}
	
function getEmployeeId(){return $this->employeeId;}
function setEmployeeId($employeeId){$this->employeeId=$employeeId;}

function getDay(){return $this->day;}
function setDay($day){$this->day=$day;}

function getFromHour1(){return $this->fromHour1;}
function setFromHour1($fromHour1){$this->fromHour1=$fromHour1;}

function getToHour1(){return $this->toHour1;}
function setToHour1($toHour1){$this->toHour1=$toHour1;}

function getFromHour2(){return $this->fromHour2;}
function setFromHour2($fromHour2){$this->fromHour2=$fromHour2;}

function getToHour2(){return $this->toHour2;}
function setToHour2($toHour2){$this->toHour2=$toHour2;}

}

