<?php
require_once  __DIR__.'/../requires.php';
class EmployeeDBDAO {
// 	private static $EmployeeDBDAO;
	
	
// 	private function __construct(){}
	
// 	public static function getInstance()
// 	{
// 		if(!isset(self::$EmployeeDBDAO))
// 		{
// 			self::$EmployeeDBDAO = new EmployeeDBDAO;
// 		}
// 		return self::$EmployeeDBDAO;
// 	}
	
	
	
	
	

	static function getEmployee($empId)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT * FROM employee WHERE ID = ?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		if (!$stmt->bind_param("i", $empId)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		 
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		$row = $result->fetch_object();
	
		$Employee = new Employee($row->NAME_, $row->PASSWORD_, $row->PHONE, $row->EMAIL,$row->ID,$row->IS_ACTIVE);
	
		$mysqli->close();
		
		return $Employee;
	}
	
	static function getEmployeeName($empId)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT NAME_ FROM employee WHERE ID = ?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		if (!$stmt->bind_param("i", $empId)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
	
	
		try {
			$name = $result->fetch_object()->NAME_;
		}
		catch (Exception $e)
		{
			throw new IdDoesNotExistsException($e->getMessage());
		}
		//$customer = Customer::withID($row->ID, $row->NAME_,$row->EMAIL,$row->PHONE, $row->PASSWORD_,  $row->ADDRESS);
	
	
	
		$mysqli->close();
	
		return $name;
	}  
	
	//3-2-2017
	static function getEmployeeID(Employee $employee)//���� ����� ����� ������� ID �������� ������ 
	{
		$mysqli = SQLConnection::getConnection();
	//����� ���� �� ��� ������� �� ���� �� 
		if (!($stmt = $mysqli->prepare("SELECT ID, NAME_,PASSWORD_,PHONE,EMAIL FROM employee  WHERE NAME_ = ? AND PHONE=? AND EMAIL=?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		$name=$employee->getName();
		$phone=$employee->getPhone();
	    $email=$employee->getEmail();
		if (!$stmt->bind_param("sss", $name,$phone,$email)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		
		$row = $result->fetch_object();
	
// 		$emp= new Employee(null, null, null, null,$row->ID);
		if ($row)//����� ����� ����� ����� �� ������� ��� ,�� �� ���  ���� ��� �� ����� ����� ���� ���� ���� ������� �� ������� �� ���� 
		{
			$emp = new Employee($row->NAME_, $row->PASSWORD_, $row->PHONE, $row->EMAIL,$row->ID);
		}
		
	
		$mysqli->close();
	
		if (isset($emp))
			return $emp->getId();
		else return false;

//         return $row->ID;
	}

    static function getEmployeesNames($employeesIdList)//���� ����� ����� ������� ID �������� ������
    {
        $employeesNames = [];
        $mysqli = SQLConnection::getConnection();
        //����� ���� �� ��� ������� �� ���� ��
        if (!($stmt = $mysqli->prepare("SELECT NAME_ FROM employee  WHERE ID=?"))) {
            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
        }

        foreach ($employeesIdList as $id) {
            if (!$stmt->bind_param("i", $id)) {
                printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
            }

            if (!$stmt->execute()) {
                printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            }

            if (!($result = $stmt->get_result())) {
                printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
            }

            $employeesNames[$id] = $result->fetch_object()->NAME_;
        }

        $mysqli->close();

        return $employeesNames;

    }
	
	static function createEmployee(Employee $Employee)
	{

	    try {
            $mysqli = SQLConnection::getConnection();

            if (!($stmt = $mysqli->prepare("INSERT INTO employee (NAME_,PASSWORD_,PHONE,EMAIL) VALUES (?,?,?,?)"))) {
                printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
            }


// 		$id = $Employee->getId();
            $name = $Employee->getName();
            $password = $Employee->getPassword();
            $phone = $Employee->getPhone();
            $email = $Employee->getEmail();
            if (!$stmt->bind_param("ssss", $name, $password, $phone, $email)) {
                printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
            }


            if (!$stmt->execute()) {
//                printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
//			printToTerminal("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
                throw new Exception($stmt->error, $stmt->errno);
            } else printToTerminal( "Employee created successfuly!!");
        }catch(Exception $e)
        {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        finally{
	        printToTerminal("mysqli close");
            $mysqli->close();
        }

	
	}
	
	static function updateEmployee(Employee $employee)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("UPDATE employee SET NAME_=?,PASSWORD_=?,PHONE=?, EMAIL=?, IS_ACTIVE=? WHERE ID=?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		$id = $employee->getId();
		$name = $employee->getName();
		$password = $employee->getPassword();
		$email = $employee->getEmail();
		$phone = $employee->getPhone();
		$isActive = $employee->getIsActive();
		if (!$stmt->bind_param("ssssii", $name,$password,$phone,$email,$isActive, $id)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		printToTerminal( "Employee updated successfuly!!");
		$mysqli->close();
	
	}
	
	static function deleteEmployee( $empId)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("DELETE FROM employee WHERE ID=?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		
		if (!$stmt->bind_param("i", $empId)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		$rowsNum = $mysqli->affected_rows;
		
		//checks if rawsAffected is not equals to 1, if so this means that 0 rows affected or more than 1
		//if true handle result with suitable exception
		if($rowsNum !== 1)
		{
			if($rowsNum === 0)// ���� �� �� ���� ��� �� �� �� 0  �� ���� ���� ����
			{
				//write Exception class for this exception
				throw new Exception("Employee does not exist!");
			}
			else if($rowsNum > 1)
			{
				// 				write to log
			}
		}
		else
		{
			printToTerminal( " <br/> Employee deleted successfuly!!");
		}
		
		
		$mysqli->close();
	
	}
	
	//returns list with the full object i.e ({"id": "3","name": "asas","password": "jyg86dd8","phone": "6531", "email": "s@s", "isActive": "1"})
	static function getAllEmployees_Manager()
	{
		$mysqli = SQLConnection::getConnection();
	

	
			
		if (!($result = $mysqli->query("SELECT * FROM employee"))) {
			printToTerminal( "Getting result set failed: (" . $mysqli->errno . ") " . $mysqli->error);
			//printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
	
		$allEmployeesList = [];
		while ($row = $result->fetch_object())
		{
			$Employee = new Employee($row->NAME_, $row->PASSWORD_, $row->PHONE, $row->EMAIL,$row->ID,$row->IS_ACTIVE);
			$allEmployeesList[] = $Employee;
		}
		
		$mysqli->close();
	
		return $allEmployeesList;
	}

    //returns list with partial object i.e no phone and no password({"id": "3","name": "asas","password": null,"phone": null, "email": "s@s", "isActive": "1"})
    static function getAllEmployees_Customer()
	{
		$mysqli = SQLConnection::getConnection();




		if (!($result = $mysqli->query("SELECT * FROM employee"))) {
			printToTerminal( "Getting result set failed: (" . $mysqli->errno . ") " . $mysqli->error);
			//printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}


		$allEmployeesList = [];
		while ($row = $result->fetch_object())
		{
			$Employee = new Employee($row->NAME_, null, null, $row->EMAIL,$row->ID,$row->IS_ACTIVE);
			$allEmployeesList[] = $Employee;
		}

		$mysqli->close();

		return $allEmployeesList;
	}
	
	//---------------22.3.2017--------------activate
	static function activateEmployee($empId)
	{
		$employee=self::getEmployee($empId);
		$employee->setIsActive(true);
		self::updateEmployee($employee);
	}
	static function deactivateEmployee($empId)
	{
	
		$employee=self::getEmployee($empId);
		$employee->setIsActive(false);
		self::updateEmployee($employee);
	}
	
	static function getEmployeeIsActive($empId)//   ��� ����� ����� �������� ���� ��� ������ �� ���� ������ �� ����� ����� ����� �������  updateEmployeeDetails �������� isActive= null ������� ������ ����� �� ����� �� ���� ����� ���� �������� �� ����� ����� ��
	{
		$mysqli = SQLConnection::getConnection();
		 
		if (!($stmt = $mysqli->prepare("SELECT IS_ACTIVE FROM customer WHERE ID = ?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
		 
		if (!$stmt->bind_param("i", $empId)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		 
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!($result = $stmt->get_result())) {
			printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		 
		 
		 
		 
		try {
			$isActive = $result->fetch_object()->IS_ACTIVE;
		}
		catch (Exception $e)
		{
			throw new IdDoesNotExistsException($e->getMessage());
		}
		//$customer = Customer::withID($row->ID, $row->NAME_,$row->EMAIL,$row->PHONE, $row->PASSWORD_,  $row->ADDRESS);
		 
		 
		 
		$mysqli->close();
		 
		return $isActive;
	}
	
}

