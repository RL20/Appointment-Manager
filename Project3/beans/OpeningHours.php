<?php
class OpeningHours implements JsonSerializable
{
	/*
	  DAY_
	  FROM_HOUR1
	  TO_HOUR1
	  FROM_HOUR2
	  TO_HOUR2 
	 */
	private $day;
	private $fromHour1;
	private $toHour1;
	private $fromHour2;
	private $toHour2;
	
	function __construct($day,$fromHour1,$toHour1,$fromHour2,$toHour2) 
	{
		$this->day=$day;
		$this->fromHour1=$fromHour1;
		$this->toHour1=$toHour1;
		$this->fromHour2=$fromHour2;
		$this->toHour2=$toHour2;
		
	}

    public static function createObjectFromJson( $jsonString )
    {
        $object = json_decode( $jsonString );
        return new self($object['day'], $object['fromHour1'], $object['toHour1'], $object['fromHour2'], $object['toHour2']);
    }

    public static function createObjectsFromJsonArray( $jsonArray )
    {
        $objArray = [];
//        $array = json_decode( $jsonArray );
        foreach ($jsonArray as $object){
//            printToTerminal("OpeningHours               :   ".$object);
            $objArray[] = new self( $object['day'], $object['fromHour1'], $object['toHour1'], $object['fromHour2'], $object['toHour2']);
        }


        return $objArray;
    }

    public function jsonSerialize() {
        return [
            'day' => $this->day,
            'fromHour1' => $this->fromHour1,
            'toHour1' => $this->toHour1,
            'fromHour2' => $this->fromHour2,
            'toHour2' => $this->toHour2
        ];
    }
	
	

	
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

