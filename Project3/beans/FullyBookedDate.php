<?php
/*ID
 DATE_
 EMP_ID
*/
class FullyBookedDate //implements JsonSerializable
{
	private  $id;
	private  $date;
	private  $employeeId;
	
	function __construct($date, $employeeId,$id=false) 
	{
		$this->id = $id;
		$this->date=$date;
		$this->employeeId=$employeeId;
	}
	

	


function getId(){return $this->id;}
function setId($id){$this->id = $id;}

function getDate(){return $this->date;}
function setDate($date){$this->date=$date;}


function getEmployeeId(){return $this->employeeId;}
function setEmployeeId($employeeId){$this->employeeId=$employeeId;}
}





