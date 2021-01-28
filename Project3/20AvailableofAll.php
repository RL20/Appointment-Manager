<?php

 class Available
 {
    static function getFirst20AvailableAppointmentsFromAllEmployees()// 6.4.2017 7:00
	{
		//����� �������� ������ ������ ������ �� ������ ��� ��� ����� ��� �� ���� �����  
		$priority=0;//������ �� ������
		$allAppointments=[];//�� ������ �� �� �������
		$employeesArr=EmployeeDBDAO::getAllEmployees();
		for ($i=0;$i<count($employeesArr);$i++)
		{
			$allAppointments[$employeesArr[$i]->getId()]=self::getFirst20AvailableAppointments($employeesArr[$i]->getId());
// 			$allAppointments[]=self::getFirst20AvailableAppointments($employeesArr[$i]->getId());
				
		}
		foreach ($allAppointments as $value)//����� ���� ���� ��� �� ������� �� ������� ��� �������
			foreach ($value as $innerValue)
				$allAppointments2[]=$innerValue;
				
			$arr=[];
			$arr2=[];
			sort($allAppointments2);
			foreach ($allAppointments2 as $appintment)
			{
// 				$arr[$appintment->getAppointmentDate()][]=$appintment->getAppointmentTime();
				$arr[$appintment->getAppointmentDate()][]=$appintment;	
// 				$arr2[$appintment->getAppointmentDate()][$appintment->getAppointmentTime()]=[$appintment];
				$arr2[$appintment->getAppointmentDate()][$appintment->getAppointmentTime()][]=$appintment;
				

			}
			var_dump($arr2);
			echo "<br/><br/><br/><br/> arr finnish";
			foreach ($arr2 as $value)
					var_dump($value);
				
				
			
// 			$priority=[3,2,4];
		

			
			 return $arr2;
		
	}
	static function getFirst20AvailableAppointmentsFromAllEmployees1()//$sort='random'//or priority)//6.4.2017 19:44
	{
		//����� �������� ������ ������ ������ �� ������ ��� ��� ����� ��� �� ���� �����
		$priority=0;//������ �� ������
		$allAppointments=[];//�� ������ �� �� �������
		$employeesArr=EmployeeDBDAO::getAllEmployees();
		for ($i=0;$i<count($employeesArr);$i++)
		{
		$allAppointments[$employeesArr[$i]->getId()]=self::getFirst20AvailableAppointments($employeesArr[$i]->getId());
		// 			$allAppointments[]=self::getFirst20AvailableAppointments($employeesArr[$i]->getId());
	
		}
		foreach ($allAppointments as $value)//����� ���� ���� ��� �� ������� �� ������� ��� �������
		foreach ($value as $innerValue)
		$allAppointments2[]=$innerValue;
	
		$arr=[];
		$arr2=[];
		sort($allAppointments2);
		foreach ($allAppointments2 as $appintment)
		{
	
		$arr[$appintment->getAppointmentDate()][]=$appintment;
		$arr2[$appintment->getAppointmentDate()][$appintment->getAppointmentTime()][]=$appintment;
	
	
		}
		// 			var_dump($arr2);
		// 			echo "<br/><br/><br/><br/> arr finnish";
		foreach ($arr2 as $value)
			var_dump($value);
	
	
			// 			if ($sort==='priority')
				// 			{
	
				// 			}
				// 			$priority=[3,2,4];
	
			$arr3=[];
	
	
			// 			foreach ($arr2 as $value)
			// 			{
	
			// 				foreach ($value as $innerValue )
			// 				{
				
			// 					foreach ($innerValue as $innerinner)
				// 					{
				// 						switch ($innerinner->getEmployeeId())
				// 						{
				// 							case :
				// 						}
				// // 						if ($innerinner->getEmployeeId()==4)
					// // 							$arr3[]=$innerinner;
						
			// 						//var_dump($innerinner);
			// 					}
			// 				}
				
	
			// 			}
	
								
	
				
				
			 return  'end ';
	
		}
 }
	
