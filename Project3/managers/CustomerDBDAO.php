<?php
// Data Access Object commiunicating with DB

require_once  __DIR__.'/../requires.php';
//sinlgeton class
 class CustomerDBDAO 
{
	
// 	private static $customerDBDAO;
	
	
// 	private function __construct(){}
	
// 	public static function getInstance()
// 	{
// 		if(!isset(self::$customerDBDAO))
// 		{
// 			self::$customerDBDAO = new CustomerDBDAO;
// 		}
// 		return self::$customerDBDAO;
// 	}
	
	
	
	
	

	static function getCustomer($custId)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT ID, NAME_,ADDRESS,PASSWORD_,EMAIL,PHONE ,IS_ACTIVE FROM customer WHERE ID = ?"))) {
            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		if (!$stmt->bind_param("i", $custId)) {
            printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
            printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		 
		if (!($result = $stmt->get_result())) {
            printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		
	
		try {
			$row = $result->fetch_object();
			$customer = new Customer($row->NAME_,$row->EMAIL,$row->PHONE, $row->PASSWORD_,  $row->ADDRESS,$row->ID,$row->IS_ACTIVE);
		}
		catch (Exception $e)
		{
			throw new IdDoesNotExistsException($e->getMessage());
		}
		//$customer = Customer::withID($row->ID, $row->NAME_,$row->EMAIL,$row->PHONE, $row->PASSWORD_,  $row->ADDRESS);
		
	
		
		$mysqli->close();
		
		return $customer;
	}
	
	static function getCustomerName($custId)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("SELECT  NAME_ FROM customer WHERE ID = ?"))) {
            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		if (!$stmt->bind_param("i", $custId)) {
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
			throw new IdDoesNotExistsException();
		}
		//$customer = Customer::withID($row->ID, $row->NAME_,$row->EMAIL,$row->PHONE, $row->PASSWORD_,  $row->ADDRESS);
	
	
	
		$mysqli->close();
	
		return $name;
	}

	
	//3-2-2017
	static function getCustomerID(Customer $customer)//���� ����� ����� ������� ID �������� ������
	{
		$mysqli = SQLConnection::getConnection();
		//����� ���� �� ��� ������� �� ���� ��
		if (!($stmt = $mysqli->prepare("SELECT * FROM customer  WHERE NAME_ = ? AND PHONE=? AND EMAIL=?"))) {
            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		$name=$customer->getName();
		$phone=$customer->getPhone();
		$email=$customer->getEmail();
		if (!$stmt->bind_param("sss",$name,$phone,$email)) {
            printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		if (!$stmt->execute()) {
            printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
			
		if (!($result = $stmt->get_result())) {
            printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		$row = $result->fetch_object();
	
		if ($row)//����� ����� ����� ����� �� ������� ��� ,�� �� ���  ���� ��� �� ����� ����� ���� ���� ���� ������� �� ������� �� ����
		{
			$id = $row->ID;
// 			new Customer($name, $email, $phone, $password, $address)	
		}
	
		$mysqli->close();
	
		if (isset($id))
			return $id;
		else return false;
		
	}


	static function getCustomerByEmail( $email)//���� ����� ����� ������� ID �������� ������
	{
		$mysqli = SQLConnection::getConnection();
		//����� ���� �� ��� ������� �� ���� ��
		if (!($stmt = $mysqli->prepare("SELECT * FROM customer  WHERE EMAIL=?"))) {
            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}

		if (!$stmt->bind_param("s",$email)) {
            printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}

		if (!$stmt->execute()) {
            printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}

		if (!($result = $stmt->get_result())) {
            printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}


		$row = $result->fetch_object();

		if ($row)//����� ����� ����� ����� �� ������� ��� ,�� �� ���  ���� ��� �� ����� ����� ���� ���� ���� ������� �� ������� �� ����
		{
			$cust= new Customer($row->NAME_, $row->EMAIL, $row->PHONE, $row->PASSWORD_, $row->ADDRESS,$row->ID);
// 			new Customer($name, $email, $phone, $password, $address)
		}

		$mysqli->close();

		if (isset($cust))
			return $cust;
		else return false;

	}

	static function getCustomersNames($customersIdList)//���� ����� ����� ������� ID �������� ������
	{
        $customerNames = [];
		$mysqli = SQLConnection::getConnection();
		//����� ���� �� ��� ������� �� ���� ��
		if (!($stmt = $mysqli->prepare("SELECT NAME_ FROM customer  WHERE ID=?"))) {
            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}

       foreach ($customersIdList as $id) {
           if (!$stmt->bind_param("i", $id)) {
               printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
           }

           if (!$stmt->execute()) {
               printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
           }

           if (!($result = $stmt->get_result())) {
               printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
           }

           $customerNames[$id] = $result->fetch_object()->NAME_;
       }

		$mysqli->close();

        return $customerNames;

	}

	
	static function createCustomer(Customer $customer)
	{
	    try{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("INSERT INTO customer (NAME_,ADDRESS,PASSWORD_,EMAIL,PHONE) VALUES (?,?,?,?,?)"))) {
            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		
// 		$id = $customer->getId(); incremental ����� ��� ���� �� �� 
		$name = $customer->getName();
		$address = $customer->getAddress();
		$password = $customer->getPassword();
		$email = $customer->getEmail();
		$phone = $customer->getPhone();
		if (!$stmt->bind_param("sssss", $name,$address, $password, $email, $phone)) {
            printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}



            if (!$stmt->execute()) {
//                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                throw new Exception($stmt->error, $stmt->errno);
            }
            else {
		    printToTerminal( "customer created successfuly!!");
		    $id = $mysqli->insert_id;
            }
        }catch(Exception $e)
        {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        finally{
            printToTerminal("mysqli close");
            $mysqli->close();
            return  $id;
        }

	}
	
	static function updateCustomer(Customer $customer)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("UPDATE customer SET NAME_=?,ADDRESS=?,PASSWORD_=?,EMAIL=?,PHONE=?,IS_ACTIVE=? WHERE ID=?"))) {
            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
	
		$id = $customer->getId();
		$name = $customer->getName();
		$address = $customer->getAddress();
		$password = $customer->getPassword();
		$email = $customer->getEmail();
		$phone = $customer->getPhone();
		$isActive = $customer->getIsActive();
		if (!$stmt->bind_param("sssssii", $name,$address, $password, $email, $phone, $isActive, $id)) {
            printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}


	
		if (!$stmt->execute()) {
            printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		} else printToTerminal( "customer updated successfuly!!");
		$mysqli->close();
	
	}
	
	static function deleteCustomer( $custId)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("DELETE FROM customer WHERE ID=?"))) {
            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
	
		
		if (!$stmt->bind_param("i", $custId)) {
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
				throw new Exception("ID does not exist!");
			}
			else if($rowsNum > 1)
			{
				// 				write to log
			}
		}
	
		$mysqli->close();
	
	}
	//3-2-2017
	static function getAllCustomers()
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($result = $mysqli->query("SELECT * FROM customer"))) {
            printToTerminal( "Getting result set failed: (" . $mysqli->errno . ") " . $mysqli->error);
			//echo "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error;
		}
	
		$allCustomersList = [];
		while ($row = $result->fetch_object())
		{
			$Customer = new Customer($row->NAME_,$row->EMAIL,$row->PHONE,$row->PASSWORD_,$row->ADDRESS,$row->ID,$row->IS_ACTIVE);
			$allCustomersList[] = $Customer;
		}
	
		$mysqli->close();
	
		return $allCustomersList;
	}
	//---------------22.3.2017--------------activate
	static function activateCustomer($custId)
	{
		$customer=self::getCustomer($custId);
	
		$customer->setIsActive(true);
		self::updateCustomer($customer);
	}
	static function deactivateCustomer($custId)
	{
	
		$customer=self::getCustomer($custId);
		
		$customer->setIsActive(false);
		self::updateCustomer($customer);
	}
	
    static function getCustomerIsActive($custId)// ��� ����� ����� �������� ���� ��� ������ �� ���� ������ �� ����� ����� ����� �������  updateCustomerDetails �������� isActive= null ������� ������ ����� �� ����� �� ���� ����� ���� �������� �� ����� ����� ��  
    {
    	$mysqli = SQLConnection::getConnection();
    	
    	if (!($stmt = $mysqli->prepare("SELECT IS_ACTIVE FROM customer WHERE ID = ?"))) {
            printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
    	}
    	
    	if (!$stmt->bind_param("i", $custId)) {
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
    		throw new IdDoesNotExistsException("check this exeption!!");
    	}
    	//$customer = Customer::withID($row->ID, $row->NAME_,$row->EMAIL,$row->PHONE, $row->PASSWORD_,  $row->ADDRESS);
    	
    	
    	
    	$mysqli->close();
    	
    	return $isActive;
    }
	
}


