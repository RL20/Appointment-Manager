<?php
// Data Access Object commiunicating with DB
require_once  __DIR__.'/../requires.php';

//sinlgeton class

class ContactUsDBDAO 
{
	/*
	 // 	private static $CustomerDBDAO;
	
	
	
	// 	private function __construct(){}
	
	// 	public static function getInstance()// SQL ����� �������� ������ ��
	// 	{
	// 		if(!isset(self::$CustomerDBDAO))
		// 		{
		// 			self::$CustomerDBDAO = new CustomerDBDAO;
		// 		}
	// 		return self::$CustomerDBDAO;
	// 	}
	 */

	static function getContactUs()
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($result = $mysqli->query("SELECT * FROM contact_us"))) {
			printToTerminal( "Getting result set failed: (" . $mysqli->errno . ") " . $mysqli->error);
			//printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
		$row = $result->fetch_object();
		
		try{
		if(!$row)
		{
			throw new Exception("Contact Us is empty!");
		}
		$contactUs = new ContactUs($row->BUSINESS_NAME,$row->ADDRESS,$row->PHONE1,$row->LOGO_SRC,$row->PHONE2,$row->PHONE3,$row->EMAIL,$row->WHATSAPP,$row->GOOGLE,$row->SKYPE,
				$row->TELEGRAM,$row->FACEBOOK,$row->TWITTER);
		}
		catch (Exception $e)
		{
			throw new ContactUsIsEmptyException();
				
		}
		finally {
		$mysqli->close();
		}
		
	
		return $contactUs;
	}
	
	
	//---------------------------------------
	/*
	 * ����� ������ �������� ���� ����� ���� ��� �� ������ ������ ��������
	 * static function getfutureAppointments_byStartingDate($startDate ,$limit = false) // �������� ������ ���� �� ��������� - �� ������ ������ ���� ������
	{
		if(!$limit)
			$limit = "LIMIT 10";
		else if($limit)
			$limit = "";
		
		$mysqli = SQLConnection::getConnection();
	    
		if (!($stmt = $mysqli->prepare("SELECT * FROM appointment WHERE APP_DATE >= ? ORDER BY APP_DATE ASC ". $limit))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	 */
	static function createContactUs(ContactUs $ContactUs)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("INSERT INTO contact_us (BUSINESS_NAME,ADDRESS,PHONE1,PHONE2,PHONE3,EMAIL,WHATSAPP,GOOGLE,SKYPE,TELEGRAM
,FACEBOOK,TWITTER,SHARE,LOGO_SRC) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
		  $businessName= $ContactUs->getBusinessName();
		  $address=$ContactUs->getAddress();
		  $phone1=$ContactUs->getPhone1();
		  $phone2=$ContactUs->getPhone2();
		  $phone3=$ContactUs->getPhone3();
		  $email=$ContactUs->getEmail();
		  $whatsapp=$ContactUs->getWhatsapp();
		  $google=$ContactUs->getGoogle();
		  $skype=$ContactUs->getSkype();
		  $telegram=$ContactUs->getTelegram();
		  $facebook=$ContactUs->getFacebook();
		  $twitter=$ContactUs->getTwitter();
		  $share=$ContactUs->getShare();
		  $logoSrc=$ContactUs->getLogoSrc();
		
		if (!$stmt->bind_param("ssssssssssssss", $businessName,$address, $phone1,$phone2,$phone3, $email, $whatsapp,$google,$skype,$telegram,
				$facebook,$twitter,$share,$logoSrc)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		printToTerminal( "contact Us  created successfuly!!");
		$mysqli->close();
	
	}
	
	static function updateContactUs(ContactUs $ContactUs)
	{
		$mysqli = SQLConnection::getConnection();
	
		if (!($stmt = $mysqli->prepare("UPDATE contact_us SET BUSINESS_NAME=?,ADDRESS=?,PHONE1=?,PHONE2=?,PHONE3=?,EMAIL=?,WHATSAPP=?,GOOGLE=?,SKYPE=?,TELEGRAM=?
,FACEBOOK=?,TWITTER=?,SHARE=?,LOGO_SRC=?"))) {
			printToTerminal( "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
		}
	
	
		$businessName= $ContactUs->getBusinessName();
		$address=$ContactUs->getAddress();
		$phone1=$ContactUs->getPhone1();
		$phone2=$ContactUs->getPhone2();
		$phone3=$ContactUs->getPhone3();
		$email=$ContactUs->getEmail();
		$whatsapp=$ContactUs->getWhatsapp();
		$google=$ContactUs->getGoogle();
		$skype=$ContactUs->getSkype();
		$telegram=$ContactUs->getTelegram();
		$facebook=$ContactUs->getFacebook();
		$twitter=$ContactUs->getTwitter();
		$share=$ContactUs->getShare();
		$logoSrc=$ContactUs->getLogoSrc();
		
		
	if (!$stmt->bind_param("ssssssssssssss", $businessName,$address, $phone1,$phone2,$phone3, $email, $whatsapp,$google,$skype,$telegram,
				$facebook,$twitter,$share,$logoSrc)) {
			printToTerminal( "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
	
		if (!$stmt->execute()) {
			printToTerminal( "Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
	
	
		printToTerminal( "contact us updated successfuly!!");
		$mysqli->close();
	
	}
	
	static function deleteContactUs()
	{
		
		$mysqli = SQLConnection::getConnection();
	
		if (!($result = $mysqli->query("DELETE FROM contact_us"))) {
			printToTerminal( "Getting result set failed: (" . $mysqli->errno . ") " . $mysqli->error);
			//printToTerminal( "Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
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
		}else printToTerminal( "contact_us deleted seccessfuly");
	
		$mysqli->close();
	
	}
	

	
	
	
}
 

