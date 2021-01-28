<?php
class EmployeeAbsence implements JsonSerializable//������ ����
{
	
	/*
	 EMP_ID
	
	 DATE_
	 */
	private $id;
	private $employeeId;
	private $date;
	private $fromHour;
	private $toHour;
	
	
	function __construct($employeeId,$date,$fromHour,$toHour,$id=false)
	{
		$this->employeeId=$employeeId;
		$this->date=$date;
		$this->fromHour=$fromHour;
		$this->toHour=$toHour;
		$this->id=$id;
	}

    public static function createObjectFromJson( $json)
    {
        $object = $json;
        return new self($object['employeeId'], $object['date'], $object['fromHour'], $object['toHour'], $object['id']);
    }

    public static function createObjectsFromJsonArray( $jsonArray )
    {
        $objArray = [];
//        $array = json_decode( $jsonArray );
        foreach ($jsonArray as $object)
            $objArray[] = new self($object['employeeId'], $object['date'], $object['fromHour'], $object['toHour'], $object['id']);

        return $objArray;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'employeeId' => $this->employeeId,
            'date' => $this->date,
            'fromHour' => $this->fromHour,
            'toHour' => $this->toHour,
        ];
    }
	
	function getId(){return $this->id;}
	function setId($id){$this->id = $id;}
	
	function getEmployeeId(){return $this->employeeId;}
	function setEmployeeId($employeeId){$this->employeeId=$employeeId;}
	
	function getDate(){return $this->date;}
	function setDate($date){$this->date=$date;}
	
	function getFromHour(){return $this->fromHour;}
	function setFromHour($fromHour){$this->fromHour=$fromHour;}
	
	function getToHour(){return $this->toHour;}
	function setToHour($toHour){$this->toHour=$toHour;}



}
