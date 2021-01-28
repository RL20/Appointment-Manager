<?php
require_once 'requires.php';


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "appointmentappdb";



function getCustomer($custId)
{
// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);
// Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// } 

if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

// $custId = 1;

if (!($stmt = $mysqli->prepare("SELECT ID, NAME_,ADDRESS,PASSWORD_,EMAIL,PHONE FROM customer WHERE ID = ?"))) {
	echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
// $stmt = $conn->prepare("SELECT * FROM customer where ID = ?");


if (!$stmt->bind_param("i", $custId)) {
	echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}

if (!$stmt->execute()) {
	echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
// else 
//   {
// 	while ($row = $stmt->fetch()) {
// 		print_r($stmt->fetch_all());
//   }

  	
  	if (!($res = $stmt->get_result())) {
  		echo "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error;
  	}
  	
  	
//   	 
//   	echo $res->fetch_object($result)."hgf";
// }


    $row = $res->fetch_object();
	
	
	$customer = new Customer($row->ID, $row->NAME_,$row->EMAIL,$row->PHONE, $row->PASSWORD_,  $row->ADDRESS);
	
	
	var_dump($customer);

// 	echo ;
// 	echo $row->NAME_;
// 	echo $row->ADDRESS;
// 	echo $row->PASSWORD_;
// 	echo $row->EMAIL;
// 	echo $row->PHONE;







// $sql = "SELECT * FROM customer WHERE ID = 1";
// //$sql = "SELECT * FROM employee_absence WHERE EMP_ID = ?";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     // output data of each row
//     while($row = $result->fetch_assoc()) {
//         echo "id: " . $row["ID"]. " - Name: " . $row["NAME_"]. " " . $row["ADDRESS"]. "password: " . $row["PASSWORD_"]. " - email: " . $row["EMAIL"]. "phone " . $row["PHONE"]. "<br>";
//     }
// } else {
//     echo "0 results";
// }
$mysqli->close();
}

