<?php

//date_default_timezone_set('Asia/Jerusalem');
//הגדרת איזור זמן php


// // לבדוק אם ספר אקטיבי או לא
// var_dump(strtotime(date ("Y-m-d", time()))); בדיקה של לונג לתאריך ללא שעות
require_once 'requires.php';
function getFirst20AvalableApp($date, $EMP_ID = false) {
	
	// if(workinghors.sunday1=)
}

// EmployeeWorkHours(2);// EmployeeWorkHours קריאה לפונקציה /בדיקה
function appointmentHandle($EMP_ID, $date) // EMP_ID פונקציה שבודקת התאמה בין תאריך ל
{
}
function checkEmployeeWorkHours($EMP_ID, $date, $hour) // פונקציה שבודקת שעות עבודה של עובד לפי יום בשבוע ,התאריך שמתקבל בפרמטר מתורגם ליום בשבוע
{
	// לא סיימתי את הפונקציה ***************************************
	$dateCovert = date_create_from_format ( 'd-m-Y', $date );
	$day = $dateCovert->getTimestamp ();
	$dayTextual = strtoupper ( date ( 'l', $day ) );
	$employeeWorkingHours = WorkHoursDBDAO::getAllEmpWorkHours ( $EMP_ID );
	
	foreach ( $employeeWorkingHours as $value ) {
		
		if ($value->getDay () == $dayTextual) {
			echo "$dayTextual it is day i am working<br/>";
			$start1 = $value->getFromHour1 ();
			$end1 = $value->getToHour1 ();
			
			$start2 = $value->getFromHour2 ();
			$end2 = $value->getToHour2 ();
			
			$hourCovert = strtotime ( $hour );
			echo $hourCovert;
			echo date ( 'd-m-Y', $hourCovert );
			// $hourTimeStamp=$hourCovert->getTimestamp();
		}
	}
	// checkEmployeeWorkHours(2, '22-12-2016', '8:00'); // checkEmployeeWorkHours בדיקה לפונקציה
}
/*
 * function getAvailableDaysInMonth($year, $month, $employeeId = false) // פונקציה שמחזירה את הימים שבהם יש לפחות תור אחד פנוי בחודש הנבדק
 * {
 * $numberOfDaysInMonth = cal_days_in_month ( CAL_GREGORIAN, $month, $year ); // כמה ימים יש בחודש הנבחר
 *
 * // $possibleAppointmentsList = [];
 *
 * if ($employeeId !== false) {
 * $allEmpWorkHours = WorkHoursDBDAO::getAllEmpWorkHours ( $employeeId );
 *
 * foreach ( $allEmpWorkHours as $singleDay ) {
 *
 * // $day = $singleDay->getDay();
 *
 * $possibleAppointmentsList [$singleDay->getDay ()] = getPossibleAppointmentsList_ByDay ( $singleDay ); // מחזיר לנו רשימה של כל התורים האפשריים של עובד ספיציפי באותו היום
 * }
 * // var_dump($possibleAppointmentsList);
 * }
 * // else //$openingHours = OpeningHoursDBDAO::getAllOpeningkHours();
 * $index = 1;
 * // $i = יהיה שווה ליום הנוכחי במקרה שהחודש שהתקבל הוא החודש הנוכחי
 * $presentDayinCurrentMonth = date ( 'j', time () );
 * if ($month == date ( 'm', time () ) && $year == date ( 'Y', time () ))
 * $i = ( int ) $presentDayinCurrentMonth;
 * else
 * $i = 1;
 * // var_dump($possibleAppointmentsList);
 * for($i; $i <= $numberOfDaysInMonth; $i ++) // אינדקס של הימים בחודש $i
 * {
 * $strDate = $i . '-' . $month . '-' . $year;
 * $strDay = strtoupper ( date ( 'l', strtotime ( $strDate ) ) ); // המרה של התאריך ליום בשבוע כדי לרוץ על השעות שלו
 * // print($strDay."<br/>");
 * // $possibleAppointmentsList[$strDay][];
 * $isAppAvailable = false;
 * $j = 0;
 * while ( ! $isAppAvailable ) // כל זמן שאין תור פנוי תרוץ עד שתימצא תור פנוי או עד שייסתיים היום
 * {
 * if ($j >= count ( $possibleAppointmentsList [$strDay] )) // תרוץ על מקסימום התורים האפשריים באותו היום וכשאין יותר כאלה תצא מהלולאה
 * {
 * break;
 * }
 *
 * $appointment = new Appointment ( strtotime ( $strDate ), $possibleAppointmentsList [$strDay] [$j], "", $employeeId, "" );
 * // print($possibleAppointmentsList[$strDay][$j]."</br>");
 * if (AppointmentDBDAO::checkAppointmentAvailability ( $appointment )) {
 * // echo '<script type="text/javascript">alert("Data has been submitted to ' . $i . '");</script>';
 * $availableDaysList [] = $i;
 * $isAppAvailable = true;
 * }
 * print ($index ++) ;
 * var_dump ( $appointment );
 *
 * $j ++;
 * }
 * }
 *
 * return $availableDaysList;
 * }
 */
/*
 * function getPossibleAppointmentsList_ByDay(WorkHours $singleDay) // מחזיר לנו רשימה של כל התורים האפשריים של עובד ספיציפי באותו היום
 * {
 * // $possibleAppointmentsList is the argument from the function's caller
 * // $possibleAppointmentsList;
 *
 * // מקבל את הערכים מהאובייקט שהתקבל
 * $day = $singleDay->getDay ();
 * // $possibleAppointmentsList[$day][];
 *
 * $start1 = $singleDay->getFromHour1 ();
 * $end1 = $singleDay->getToHour1 ();
 *
 * $start2 = $singleDay->getFromHour2 ();
 * $end2 = $singleDay->getToHour2 ();
 *
 * // set the first hour (the hour that the worker starts working)
 * $currentRunHour = $start1;
 *
 * // $possibleAppointmentsList[$day]; לבדוק שזה עובד במקרה שהיום שהתקבל הוא יום חופש
 *
 * // runs untill it gets to $end1 - which is the worker's end of the day or a lunch break
 * while ( $currentRunHour !== $end1 ) {
 * // insert $currentRunHour to the list a the specified day
 * $possibleAppointmentsList [] = $currentRunHour;
 * // convert the $currentRunHour which is a string to Long
 * $timeFromStr = strtotime ( $currentRunHour );
 * // add 15 minutes
 * $timeFromStr += 900; // מסמל זמן של 15 דקות ונהפוך אותו בהמשך ל אובייקט
 * // sets the value back to $currentRunHour
 * $currentRunHour = date ( "H:i:s", $timeFromStr ); // ממיר את זה חזרה למחרוזת
 * }
 *
 * // checks if $start2 is not null - which means worker has a lunch break or split working day
 * if (isset ( $start2 )) {
 * // the same as the whlie loop above^^
 * $currentRunHour = $start2;
 * while ( $currentRunHour !== $end2 ) {
 * $possibleAppointmentsList [] = $currentRunHour;
 * $timeFromStr = strtotime ( $currentRunHour );
 * $timeFromStr += 900;
 * $currentRunHour = date ( "H:i:s", $timeFromStr );
 * }
 * }
 *
 * // returns the list
 * return $possibleAppointmentsList;
 * }
 */

// $singleday = WorkHoursDBDAO::getEmployeeWorkHoursByDay(3, "SUNDAY");
// $possibleAppointmentsListt = null;
// $possibleAppointmentsListt = getPossibleAppointmentsList_ByDay($possibleAppointmentsListt,$singleday);
// for($i = 0; $i<count($possibleAppointmentsListt["SUNDAY"]); $i++)
// {
// //echo '<script type="text/javascript">alert("Data has been submitted to ' . $possibleAppointmentsListt["SUNDAY"][$i] . '");</script>';
// $sqlTime = strtotime($possibleAppointmentsListt["SUNDAY"][$i]);
// $appointment = new Appointment(1484438400, $sqlTime, 68, 3, "jhgf");
// AppointmentDBDAO::createAppointment($appointment);
// }

/* var_dump(getAvailableDaysInMonth("2017","01",2)); */

/*
 * $appointment = new Appointment(1484438400, "10:30:00", "", 3, "");
 * // print($possibleAppointmentsList[$strDay][$j]."</br>");
 * $bool = AppointmentDBDAO::checkAppointmentAvailability($appointment);
 *
 * // echo '<script type="text/javascript">alert("' . $bool. '");</script>';
 *
 */

// $appointment= new Appointment("2016-12-20","2016-12-20 09:30:00", 56, 4, 'bldfvdfibli');
// $result = AppointmentDBDAO::checkAppointmentAvailability($appointment);
// echo $result;

// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// /////////////////////////הפונקציה עובדת! אם תכניס תור שקיים במערכת תקבל שגיאה שאומרת שהתור קיים אם התור לא קיים יודפס על המסך "1" שהוא שווה ערך ל"אמת" ת
// //////////////////////////תור שקיים במערכת הוא תור שהתאריך השעה והאיי די של העובד קיימים בטבלה
// /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// *******************************************************************************************************************************************
// function getFirst20AvailableAppointments($date = false, $employeeId = false) {
// 	$firstCall = false;
	
// 	if ($date == false) {
// 		$date = time ();
// 		// print date('H:i:s',$date);
		
// 		$firstCall = true;
// 		// print($date);
// 	}
	
// 	// $month=(int)date('j',$date);
// 	// $year=(int)date('y',$date);
// 	// $numberOfDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $month,$year);// כמה ימים יש בחודש הנבחר
	
// 	if ($employeeId !== false) {
// 		$allEmpWorkHours = WorkHoursDBDAO::getAllEmpWorkHours ( $employeeId );
		
// 		foreach ( $allEmpWorkHours as $singleDay ) {
// 			$possibleAppointmentsList [$singleDay->getDay ()] = getPossibleAppointmentsList_ByDay ( $singleDay ); // מחזיר לנו רשימה של כל התורים האפשריים של עובד ספיציפי באותו היום
// 		}
		
// 		// else //$openingHours = OpeningHoursDBDAO::getAllOpeningkHours();
		
// 		$listIndex = 0;
// 		$first20availablAppList = [ ];
// 		while ( $listIndex < 20 ) {
			
// 			$strTime = date ( 'H:i:s', $date );
// 			$strDate = date ( 'd-m-Y', $date );
// 			$strDay = strtoupper ( date ( 'l', strtotime ( $strDate ) ) ); // המרה של התאריך ליום בשבוע כדי לרוץ על השעות שלו
			                                                               
// 			// if(!dayIsFull)
// 			for($j = 0; $j < count ( $possibleAppointmentsList [$strDay] ); $j ++) // כל זמן שאין תור פנוי תרוץ עד שתימצא תור פנוי או עד שייסתיים היום
// {
// 				// if(isset($date) && $firstTime=true)
// 				// {
				
// 				// $firstTime=false;
// 				// }
				
// 				$possibleHourFromAppointmentList = $possibleAppointmentsList [$strDay] [$j];
// 				print ("J=No" . $j . "</br>") ;
// 				if ($firstCall) {
// 					$hourFromList = date ( 'Hi', strtotime ( $possibleHourFromAppointmentList ) );
// 					$timeNow = date ( 'Hi', strtotime ( $strTime ) );
// 					echo intval ( $hourFromList ) . "       " . intval ( $timeNow ) . "</br>";
// 					if (intval ( $hourFromList ) < intval ( $timeNow )) {
// 						print ("Time has already passed-" . $possibleHourFromAppointmentList . "</br>") ;
// 						// $j++;
// 						// break ;
// 					} else {
// 						$firstCall = false;
// 						$message = "it's the current hour   " . $hourFromList;
// 						echo "<script type='text/javascript'>alert('$message');</script>";
// 						$j --;
// 					}
// 				} else {
					
// 					// print("siudfhvsierfvhjslfirvghsldfiuhvsoiduhosiuhfsdf</br>");
// 					$appointment = new Appointment ( strtotime ( $strDate ), $possibleHourFromAppointmentList, "", $employeeId, "" );
// 					// print($possibleAppointmentsList[$strDay][$j]."</br>");
// 					// echo $listIndex."<br/>"; // בדיקה של אובייקט התורים
// 					// var_dump($appointment);
// 					// var_dump ( $appointment );
// 					if (AppointmentDBDAO::checkAppointmentAvailability ( $appointment )) {
// 						// echo '<script type="text/javascript">alert("Data has been submitted to ' . $i . '");</script>';
// 						$first20availablAppList [] = $appointment;
						
// 						$listIndex ++; // add 1 to listIndex if appointment available
// 					}
// 					// var_dump($appointment);
					
// 					if ($listIndex >= 20)
// 						break;
// 				}
// 			}
			
// 			if (date ( 'j', $date ) != date ( 'j', time () ))
// 				$firstCall = false;
			
// 			if ($listIndex < 20) {
// 				$date += 24 * 60 * 60;
// 			}
// 		}
		
// 		return $first20availablAppList;
// 	}
// }
// $wed = getFirst20AvailableAppointments ( false, 3 );
// getFirst20AvailableAppointments ( $wed [20]->getAppointmentDate (), $wed [20]->getEmployeeId () );
// getFirst20AvailableAppointments ( $wed [20]->getAppointmentDate (), $wed [20]->getEmployeeId () );

// var_dump ( getFirst20AvailableAppointments ( false, 2) );

// var_dump(getAvailableDaysInMonth("2017","01",2));

// $strDate = date ("Y-m-d", time()+(24*60*60)*2);
// $strDay = strtoupper ( date('l', strtotime ($strDate)));

// $singleDay = WorkHoursDBDAO::getEmployeeWorkHoursByDay(3, $strDay);
// $list = getPossibleAppointmentsList_ByDay($singleDay);
// var_dump($list);
// $i = 0;

// while(count($list) !== $i)
// {
// print($list[$i]);
// $d= new Appointment(strtotime($strDate) ,strtotime($strDate . $list[$i]), 55, 3, 'blibli');
// AppointmentDBDAO::createAppointment($d);
// $i++;
// }

// var_dump(EmployeeDBDAO::getAllEmployees());

/*
 * function getAvailableDaysInMonthForAllEmployees($year, $month) // פונקציה שמחזירה את הימים שבהם יש לפחות תור אחד פנוי בחודש הנבדק לפחות לעובד אחד
 * {
 * $numberOfDaysInMonth = cal_days_in_month ( CAL_GREGORIAN, $month, $year ); // כמה ימים יש בחודש הנבחר
 *
 * // $availableDaysList = null;
 *
 *
 *
 * // $i = יהיה שווה ליום הנוכחי במקרה שהחודש שהתקבל הוא החודש הנוכחי
 * $presentDayinCurrentMonth = date ( 'j', time () );
 * if ($month == date ( 'm', time () ) && $year == date ( 'Y', time () ))
 * $i = ( int ) $presentDayinCurrentMonth;
 * else
 * $i = 1;
 *
 *
 * for($i; $i <= $numberOfDaysInMonth; $i ++) // אינדקס של הימים בחודש $i
 * {
 * $strDate = $i . '-' . $month . '-' . $year;
 * $date = strtotime($strDate); // המרה של התאריך ליום בשבוע כדי לרוץ על השעות שלו
 * // DateTime $DTdate = strtotime(date ("Y-m-d", $date));
 *
 * if (!FullyBookedDateDBDAO::checkIfDayIsFullyBooked($date)) {
 * // echo '<script type="text/javascript">alert("Data has been submitted to ' . $i . '");</script>';
 * $availableDaysList [] = $i;
 * }
 *
 *
 * }
 *
 * return $availableDaysList;
 * }
 */

/*
 * function getAvailableDaysInMonthByEmployeeId($year, $month, $employeeId = false) // פונקציה שמחזירה את הימים שבהם יש לפחות תור אחד פנוי בחודש הנבדק לפחות לעובד אחד
 * {
 * $numberOfDaysInMonth = cal_days_in_month ( CAL_GREGORIAN, $month, $year ); // כמה ימים יש בחודש הנבחר
 *
 * // $availableDaysList = null;
 *
 *
 *
 * // $i = יהיה שווה ליום הנוכחי במקרה שהחודש שהתקבל הוא החודש הנוכחי
 * $presentDayinCurrentMonth = date ( 'j', time () );
 * if ($month == date ( 'm', time () ) && $year == date ( 'Y', time () ))
 * $i = ( int ) $presentDayinCurrentMonth;
 * else
 * $i = 1;
 *
 *
 * for($i; $i <= $numberOfDaysInMonth; $i ++) // אינדקס של הימים בחודש $i
 * {
 * $strDate = $i . '-' . $month . '-' . $year;
 * $date = strtotime($strDate); // המרה של התאריך ליום בשבוע כדי לרוץ על השעות שלו
 *
 * $fullyBookedDate = new FullyBookedDate($date, $employeeId);
 * if (!FullyBookedDateDBDAO::checkIfFullyBooked($fullyBookedDate)) {
 * // echo '<script type="text/javascript">alert("Data has been submitted to ' . $i . '");</script>';
 * $availableDaysList [] = $i;
 * }
 *
 *
 * }
 *
 * return $availableDaysList;
 * }
 */

// var_dump(commonActions::getFirst20AvailableAppointments(2));
// var_dump(getAvailableDaysInMonthByEmployeeId("2017","01",3));
// var_dump(getAvailableDaysInMonthForAllEmployees("2017","01"));

// function getFirst20AvailableAppointments_2($employeeId, $date = false) // SELF למחלקה המתאימה  getPossibleAppointmentsList_ByDay  לזכור לשנות את הקריאה לפונקציה של
// {
// 	$firstCall = false;
	
// 	if ($date == false) //אם לא התקבל תאריך זאת קריאה ראשונה ואז נרוץ על התורים האפשריים כדי לדלג על שעות שכבר עברו  
// 	{
// 		$date = time ();// לזכור לשנות את זה לאיזור הזמן המתאים
// 		// print date('H:i:s',$date);
		
// 		$firstCall = true;
// 	}
	
// 		$allEmpWorkHours = WorkHoursDBDAO::getAllEmpWorkHours ( $employeeId );
		
// 		foreach ( $allEmpWorkHours as $singleDay ) {
// 			$possibleAppointmentsList [$singleDay->getDay ()] = commonActions::getPossibleAppointmentsList_ByDay ( $singleDay ); // מחזיר לנו רשימה של כל התורים האפשריים של עובד ספיציפי באותו היום
// 		}
		
// 		// else //$openingHours = OpeningHoursDBDAO::getAllOpeningkHours();
		
// 		$listIndex = 0;
// 		$first20availablAppList = [];
// 		while ( $listIndex < 20 ) {
			
// 			$strTime = date ( 'H:i:s', $date );
// 			$strDate = date ( 'd-m-Y', $date );
// 			$strDay = strtoupper ( date ( 'l', strtotime ( $strDate ) ) ); // המרה של התאריך ליום בשבוע כדי לרוץ על השעות שלו
			
// 			$FullyBooked = new FullyBookedDate ( $date, $employeeId );
// 			if (! FullyBookedDateDBDAO::checkIfFullyBooked ( $FullyBooked )) 
// 			{
				
// 				for($j = 0; $j < count ( $possibleAppointmentsList [$strDay] ); $j ++) // כל זמן שאין תור פנוי תרוץ עד שתימצא תור פנוי או עד שייסתיים היום
//                  { 
					
// 					$possibleHourFromAppointmentList = $possibleAppointmentsList [$strDay] [$j];
// 					print ("J=No" . $j . "</br>") ;
// 					if ($firstCall) 
// 					{
// 						$hourFromList = date ( 'Hi', strtotime ( $possibleHourFromAppointmentList ) );
// 						$timeNow = date ( 'Hi', strtotime ( $strTime ) );
// 						echo intval ( $hourFromList ) . "       " . intval ( $timeNow ) . "</br>";
// 						if (intval ( $hourFromList ) < intval ( $timeNow )) {
// 							print ("Time has already passed-" . $possibleHourFromAppointmentList . "</br>") ;
// 							// $j++;
// 							// break ;
// 						} 
// 						else 
// 						{
// 							$firstCall = false;
// 							$message = "it's the current hour   " . $hourFromList;
// 							echo "<script type='text/javascript'>alert('$message');</script>";
// 							$j --;
// 						}
// 					} 
// 					else 
// 					{
						
// 						// print("siudfhvsierfvhjslfirvghsldfiuhvsoiduhosiuhfsdf</br>");
// 						$appointment = new Appointment ( strtotime ( $strDate ), $possibleHourFromAppointmentList, "", $employeeId, "" );
// 						// print($possibleAppointmentsList[$strDay][$j]."</br>");
// 						// echo $listIndex."<br/>"; // בדיקה של אובייקט התורים
// 						// var_dump($appointment);
// 						// var_dump ( $appointment );
// 						if (AppointmentDBDAO::checkAppointmentAvailability ( $appointment )) 
// 						{
// 							// echo '<script type="text/javascript">alert("Data has been submitted to ' . $i . '");</script>';
// 							$first20availablAppList [] = $appointment;
							
// 							$listIndex ++; // add 1 to listIndex if appointment available
// 						}
// 						// var_dump($appointment);
						
// 						if ($listIndex >= 20)
// 							break;
// 					}
// 				}
// 			}
		
			
			
// 			// יש לבדוק שאכן הימים מקודמים כמות שצריך 
// 			if ($listIndex < 20) //  לא צריך לעשות בדיקה של כמה ימים יש בחודש כיוון שהקוד הזה בעצמו כבר ידע לקדם את התאריך ביומן 
// 			{
// 				$date += 24 * 60 * 60;
// 			}
// 			//                  במצב שהשעה הנוכחית מאוחרת יותר מהתור האחרון האפשרי לאותו יום,ולאחר שסיימנו לרוץ על היום הנוכחי
// 			//             , כדי להפסיק לעשות השוואה שבודקת אם התורים עברו, falseיהיה firstCall נגדיל ביום אחד ונדאג ש
// 			//                                      בגלל שזה תאריך עתידי שבו השעות עוד לא חלפו אז אין צורך יותר בבדיקה
// 			//    לעולם לא יגדל listIndex וגם כיוון שנכנס ללולאה אין סופית כי תמיד תהיה השוואה לשעה הנוכחית מול האפשרית והאינדקס
// 			if (date ( 'j', $date ) != date ( 'j', time () ))
// 				$firstCall = false;
// 		}
		
// 		return $first20availablAppList;
	
// }

// var_dump(getFirst20AvailableAppointments_2(2));
// echo date('j',1485302400);

//להוסיף בדיקה  שתבדוק אם יום הוא נוכחי אם כן לוודא שהשעות שיכנסו למערך עתידיות ולא כבר חלפו
function allEmployeeAvailableHoursInDay($date,$employeeId )//פונקציה שמחזירה את כל התורים הפנויים של עובד בתאריך מסויים
{
	$availableAppointment=[];
	$FullyBooked = new FullyBookedDate ( $date, $employeeId );
	if (! FullyBookedDateDBDAO::checkIfEmplooyeeDayIsFullyBooked ( $FullyBooked ))
	{
		$day=strtoupper(date('l',$date));
		$possibleHourtList =WorkHoursDBDAO::getEmployeeWorkHoursByDay($employeeId, $day);//מקבל אובייקט של כל שעות העבודה של העובד באותו היום
		$arr=commonActions::getPossibleAppointmentsList_ByDay($possibleHourtList);// מקבל רשימה של התורים האפשריים ליום שהתקבל  
		
		for ($i=0;$i<count($arr);$i++)
		{
// 			echo $i."<br/>";
			if (!(strtotime( $arr[$i])< time()))//בודק שהשעות הנבדקות לא חלפו וזה נבדק בלונג כך שאם יבדק תאריך או זמן שעברו הם לא יכנסו למערך של השעות הזמינות
			{
				echo $i."." .strtotime( $arr[$i])."<br/>";
				$app= new Appointment($date, $arr[$i], null, $employeeId, null);
				if (AppointmentDBDAO::checkAppointmentAvailability($app))
					$availableAppointment[]=$app;
			}
			
				
		}		
	}
	else return $availableAppointment;
		
	
	return $availableAppointment;// false אם המערך ריק יחזיר
	
}

// var_dump(allEmployeeAvailableHoursInDay(time(),2));
// var_dump(commonActions::getFirst20AvailableAppointments(2,1392854400));

// var_dump(AppointmentDBDAO::getAppointmentOfCustomer(2));

// $dt=time();
// var_dump(FullyBookedDateDBDAO::checkAndWrite_FullyBooked($dt, 2));



// $week[]=new  OpeningHours('SUNDAY',"08:00", "20:00", null, null);
// $week[]=new OpeningHours('MONDAY', "08:00", "20:00", null, null);
// $week[]=new OpeningHours('TUESDAY', "08:00", "20:00", null, null);
// $week[]=new OpeningHours('WEDNESDAY', "08:00", "20:00", null, null);
// $week[]=new OpeningHours('THURSDAY', "08:00", "20:00", null, null);
// $week[]=new OpeningHours('FRIDAY', "07:00", "14:00", null, null);
// $week[]=new OpeningHours('SATURDAY', null, null, null, null);

// var_dump(managerActions::setOpeningHours($week));

// var_dump(customerActions::showAppointments(2));

// $appointment= AppointmentDBDAO::getAppointment(358);
// var_dump($appointment->getCustomerId());
// customerActions::cancelAppointment($appointment);
// echo strtotime(2017-01-28);
// echo FullyBookedDateDBDAO::getFullyBookedDate_ID(strtotime("28-01-2017"), 2);


// $week=[];
// $week[]=new  OpeningHours('SATURDAY',"09:00", "21:00", null, null);
// $week[]=new  OpeningHours('THURSDAY',"09:00", "21:00", null, null);


// managerActions::updateOpeningHours($week);

// $bla = 2232; 
// // = "jyfhgh". 654634;
// if($bla) echo "true";
// else echo "false";
// print(json_encode(AppointmentDBDAO::getAppointment(351)));
// print(json_encode(AppointmentDBDAO::getAppointment(351)));




// $wh= WorkHoursDBDAO::getEmployeeWorkHoursByDay(2, "SUNDAY");

// $possibleAppointmentsList  = commonActions::getPossibleAppointmentsList_ByDay ($wh); // מחזיר לנו רשימה של כל התורים האפשריים של עובד ספיציפי באותו היום

// //*****
// for($j = 0; $j < count ( $possibleAppointmentsList )-2; $j ++) // כל זמן שאין תור פנוי תרוץ עד שתימצא תור פנוי או עד שייסתיים היום
// {
// 	//*****//
// 		$possibleHourFromAppointmentList = $possibleAppointmentsList[$j];
// 		print ("J=No" . $j . "</br>") ;


// 		$appointment = new Appointment ( 1487462400 , strtotime("19:30:00"), 2, 2, "ftghr" );

// 		customerActions::setAppointment($appointment);
	

// }


// customerActions::cancelAppointment(642);

// $emp=new Employee('yaron', 'zayin', '0235', 'y@y');
// $emp=EmployeeDBDAO::getEmployee(2);
// var_dump($emp);
// // managerActions::setNewEmployee($emp);
// echo EmployeeDBDAO::getEmployeeID($emp);

// $customer= new Customer('man', 'm@m', '03030', '656565', 'jhg');
// $customer= CustomerDBDAO::getCustomer(5);
// managerActions::setNewCustomer($customer);

// echo CustomerDBDAO::getCustomerID($customer);

// var_dump(managerActions::showWorkes());
// var_dump(managerActions::showCustomers());

// $app=AppointmentDBDAO::getAppointment(667);
// var_dump($app);
// managerActions::changeAppointment($app, time(), time()+2*60*60 );
// var_dump($app);

// $app=AppointmentDBDAO::getAppointment(667);
// var_dump($app);
// managerActions::changeAppointment_2(667, time(), time()+4*60*60 );
// $app=AppointmentDBDAO::getAppointment(667);
// var_dump($app);


// var_dump(managerActions::showTodayAppointmentsList());

// var_dump(customerActions::showOpeningHours());

// $cust=CustomerDBDAO::getCustomer(6);
// var_dump($cust);
// var_dump(managerActions::deleteCustomer($cust));
/*$d= new DateTime('6-2-2017');
var_dump(AppointmentDBDAO::getAllAppointments_byMonth($d));*/

// var_dump(AppointmentDBDAO::getAllAppointments_fromDateToDate(1483228800, 1487116800));
// echo "second";
// var_dump(AppointmentDBDAO::getAllAppointments_fromDateToDate_2(1487462400 ));

// print(commonActions::cancelAppointment(692));


// $id1 = new Appointment("yugihoj", "syeruf", 986541, 45, "jghfgdfghjjhgfd");

// $id2 = new Appointment("yugihoj", "syeruf", "986541", 45, "jghfgdfghjjhgfd");
// // $id2 = $id1;
// // $id2->setComment("rtdfyug");
// // $id1 = "bla";
// // $id2 = "bla";
// if($id1->equals($id2))echo "ביצים";


// var_dump(AppointmentDBDAO::getAllEmployeeAppointments_fromDateToDate(1485907200, 1487462400, 2));

// var_dump(AppointmentDBDAO::getfutureAppointments_byStartingDate(time()));
// var_dump(AppointmentDBDAO::getfutureAppointments_byStartingDate(time()+3*24*60*60));

// var_dump(ContactUsDBDAO::getContactUs());echo "<br/>";
// var_dump(ContactUsDBDAO::deleteContactUs());echo "<br/>";
// var_dump(ContactUsDBDAO::getContactUs());

// echo '<a href= "http://'. $_SERVER['HTTP_HOST'].'"> site link</a>';

// print(json_encode(ContactUsDBDAO::getContactUs()));

// $contact= new ContactUs('fafa', 'kjkjkj', 'wwd', '$logodwdwdSrc');
// ContactUsDBDAO::deleteContactUs();
// ContactUsDBDAO::createContactUs($contact);
// $contactus=ContactUsDBDAO::getContactUs();
// $contactus->setBusinessName('r.lyyl');
// ContactUsDBDAO::updateContactUs($contactus);
// var_dump(ContactUsDBDAO::getContactUs());
// var_dump(managerActions::setContactUs($contact));
// var_dump(managerActions::showAppointmentsHistory());
// var_dump(managerActions::showCustomerAppointments(2));
// var_dump(managerActions::showEmployeeAppointments(2));
// var_dump(AppointmentDBDAO::getAllAppointments_byMonth(time()));

// $emloyeeIDS=array(2,3);
// $date=time();
// var_dump(managerActions::ExportAppointmentByDateToPDF($emloyeeIDS, $date));

// $d= new DateTime('19-2-2017');

//  var_dump(commonActions::getAllEmployeesAvailableHoursInDay(time()+32400));
// echo date('y.m.d H:i',time()+61200);
// var_dump(commonActions::allEmployeeAvailableHoursInDay(time()+61200,2));
// var_dump(allEmployeeAvailableHoursInDay(time()+3*24*60*60,4));

// echo time();
// var_dump(commonActions::getFirst20AvailableAppointments(2));

// $appointment = new Appointment ( 1491432342,1491308100, 2, 2, "" );

// customerActions::setAppointment($appointment);



// $var= strtotime('01:00:00')-strtotime('TODAY');
// echo date('h:i:s',$var);

// $var2= strtotime('1970-01-01 01:00:00');
// echo $var2;

// echo "<br/>";

// const ABSOLUTE_HOUR = '1970-01-01 ';
// $var3= strtotime(ABSOLUTE.'01:00:00');

// echo $var3;

// echo ABSOLUTE_HOUR;
// debug_to_console(commonActions::getFirst20AvailableAppointmentsFromAllEmployees_3());
// debug_to_console(commonActions::first20availableaviya());

// global $qwer;
// $qwer = commonActions::getFirst20AvailableAppointments(2);

// $qwer = commonActions::getFirst20AvailableAppointmentsFromAllEmployees();
// debug_to_console($qwer);

// $firstArr = end($qwer);
// $secondArr = end($firstArr);
// $date = end($secondArr)->getAppointmentDate()+60 * 60 * 24;
// $qwer = commonActions::getFirst20AvailableAppointmentsFromAllEmployees($date);
// debug_to_console($qwer);
// $firstArr = end($qwer);
// $secondArr = end($firstArr);
// $date = end($secondArr)->getAppointmentDate()+60 * 60 * 24;
// $qwer = commonActions::getFirst20AvailableAppointmentsFromAllEmployees($date);
// debug_to_console($qwer);
// $firstArr = end($qwer);
// $secondArr = end($firstArr);
// $date = end($secondArr)->getAppointmentDate()+60 * 60 * 24;
// $qwer = commonActions::getFirst20AvailableAppointmentsFromAllEmployees($date);
// debug_to_console($qwer);





// $time = $qwer[count($qwer)-1]->getAppointmentTime();
// $newdate = date('y-m-d',$date) . " " . date('H:i:s',$time);
// print("<br/>".$newdate."<br/>");
// print("<br/>".strtotime($newdate)."<br/>");






// debug_to_console(commonActions::getFirst20AvailableAppointments(2,strtotime($newdate)));

// debug_to_console(commonActions::getFirst20AvailableAppointmentsEditedByAviya(2,strtotime($newdate)));



//  מוגבל  var dump מחזירה את כל האובייקטים בצורה נוחה השימוש בה בגלל ש
// debug_to_console($qwer);
function debug_to_console( $data, $context = 'Debug in Console' ) {

	// Buffering to solve problems frameworks, like header() in this and not a solid return.
	ob_start();

	$output  = 'console.info( \'' . $context . ':\' );';
	$output .= 'console.log(' . json_encode( $data ) . ');';
	$output  = sprintf( '<script>%s</script>', $output );

	echo $output;
}


// // var_dump(AppointmentDBDAO::getfutureAppointments_byStartingDate(time(),time()));
// // var_dump(managerActions::showFutureAppointmentsList(time(),time()));
// // var_dump(AppointmentDBDAO::getfutureAppointments_byStartingDate(strtotime('10:15:00'')));

// var_dump(managerActions::showAppointmentsHistory(time(),strtotime('08:00:00')));

// $blocked= new blockedAppointment(1492128000, 1492161300, 2);
// // var_dump(BlockedAppointmentDBDAO::checkIfAppointmentIsBlocked($blocked));
// var_dump(BlockedAppointmentDBDAO::createBlockedAppointment($blocked));


// var_dump(commonActions::allEmployeeAvailableHoursInDay(1492128000,2 ));
// BlockedAppointmentDBDAO::deleteBlockedAppointment(1);
// $blocked= new blockedAppointment(1492128000, 1492161300, 2);
// var_dump(managerActions::unBlockAppointment(7));
// var_dump(BlockedAppointmentDBDAO::checkIfAppointmentIsBlocked($blocked));

// $blocked= new blockedAppointment(1492128000, 1492161300, 2);
// var_dump(managerActions::BlockAppointment($blocked));

// $blocked= new blockedAppointment(1492128000, 1492161300, 2);
// var_dump(managerActions::unBlockAppointment($blocked));
// var_dump(managerActions::unBlockAppointment(8));

// var_dump(EmployeeAbsenceDBDAO::checkIfEmployeeIsAbsent(2, 1492646400, 1492676100));
// var_dump(commonActions::allEmployeeAvailableHoursInDay(1492646400, 2));


//בדיקה קורדינאטות אם הערכים מלאים יכתוב לקובץ ואם הקובץ לא קיים ייצור קובץ
// managerActions::galleryLinks();
// managerActions::setCoordinates(3,2);
// managerActions::setCoordinates(0.2,0.2);

//בדיקה של הקורדינאטה הראשונה 
// $arr=managerActions::showCoordinates();
// var_dump($arr);

// $arrImage[]='z1.jpg';
// $arrImage[]='zzz.jpg';

// managerActions::deleteFromGallery($arrImage);


// if (0099)
// 	echo "true";
// else echo "flase";	
	
	
	
// commonActions::setAppointmentDuration('30');
// echo commonActions::getAppointmentDuration();

// $s= new EmployeeAbsence(2, 1493199000, "10:00:00", "11:00:00");
// var_dump(managerActions::setEmployeeAbsence($s));
// $s= new EmployeeAbsence(2, 1493199000, "11:00:00", "12:00:00");
// var_dump(managerActions::setEmployeeAbsence($s));
// $s= new EmployeeAbsence(2, 1493199000, "13:00:00", "16:00:00");
// var_dump(managerActions::setEmployeeAbsence($s));
// $s= new EmployeeAbsence(2, 1493199000, "20:00:00", "21:00:00");
// var_dump(managerActions::setEmployeeAbsence($s));

// $s= new EmployeeAbsence(3, 1494288000, "10:00:00", "11:00:00");
// var_dump(managerActions::setEmployeeAbsence($s));
// $s= new EmployeeAbsence(3, 1494288000, "11:00:00", "12:00:00");
// var_dump(managerActions::setEmployeeAbsence($s));
// $s= new EmployeeAbsence(2, 1494288000, "13:00:00", "16:00:00");
// var_dump(managerActions::setEmployeeAbsence($s));
// $s= new EmployeeAbsence(2, 1494288000, "20:00:00", "21:00:00");
// var_dump(managerActions::setEmployeeAbsence($s));


// var_dump(WorkHoursDBDAO::getWorkHours(2));

// EmployeeAbsenceDBDAO::deleteEmployeeAbsence_AccordingToEmployeeAndDate( 2,"2017-04-26");

// managerActions::setFullDayEmployeeAbsence(1493164800,2);

// print(json_encode(EmployeeDBDAO::getAllEmployees()));
// ini_set('memory_limit', '-1');

// var_dump(json_decode(json_encode(commonActions::getFirst20AvailableAppointments(2))));

// var_dump(commonActions::getFirst20AvailableAppointments(2));

// $date=1493164800; $employeeId=2;
// var_dump(EmployeeAbsenceDBDAO::checkIfEmployeeIsAbsentInThisDate($date, $employeeId));//בדיקה אם יש העדרות כל שהיא בתאריך הנבדק 

// var_dump(managerActions::deletAllEmployeeAbsenceInAday(1493164800,2));

// $date=1493164800; $employeeId=2;
// var_dump(EmployeeAbsenceDBDAO::checkIfEmployeeIsAbsentInThisDate(1493164800, $employeeId));//בדיקה אם יש העדרות כל שהיא בתאריך הנבדק


// var_dump(EmployeeAbsenceDBDAO::getEmployeeAbsence(1));//מחזיר לפי האיי די בטבלה 
// var_dump(EmployeeAbsenceDBDAO::getEmployeeAbsenceByEmployeeId(2));//מחזיר לפי האיי די בטבלה

// var_dump(managerActions::showComingEmployeeAbsence(2));

// var_dump(EmployeeAbsenceDBDAO::getAllEmployeesAbsence());
// var_dump(managerActions::showAllComingAbsences());

// date_default_timezone_set('Asia/Jerusalem');
// echo date('H:i:s' ,time());


// var_dump( CustomerDBDAO::getCustomerName(2));
// var_dump(EmployeeDBDAO::getEmployeeName(2));
// try{
// managerActions::setFullDayEmployeeAbsence2(1496188800 ,2);
// }
// catch(Exception $e){
// 	echo $e->getMessage()."<br/>";
//     managerActions::setFullDayEmployeeAbsence2(1496188800, 2, true, "sudyfgus");
// }
// $t = substr('10:00:00', 0, -1).'1';
// echo $t." <br/>";
// var_dump(AppointmentDBDAO::getAllEmployeeAppointmentsInDay_fromHourToHour(2, 1487462400, '10:00:00', '11:00:00'));

// $ea = new EmployeeAbsence(2, 1487462400, '12:00:00', '13:00:00');
// managerActions::setEmployeeAbsence($ea,true);
// var_dump(managerActions::showCustomers());
// managerActions::setNewCustomer(new Customer('asdf', 'asdasd@defcas.xw', '045-234232', 'sskdfj', 'sdojf'));
// managerActions::updateCustomerDetails(new Customer('asd545454rue', 'asdasd@defcas.xw', '045-234232', 'sskdfj', 'sdojf', 8));

// managerActions::unBlockCustomer(2);


function write_php_ini($array, $file)
{
	$res = array();
	foreach($array as $key => $val)
	{
		if(is_array($val))
		{
			$res[] = "[$key]";
			foreach($val as $skey => $sval) $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
		}
		else $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
	}
	safefilerewrite($file, implode("\r\n", $res));
}

function safefilerewrite($fileName, $dataToSave)
{    if ($fp = fopen($fileName, 'w'))
{
	$startTime = microtime(TRUE);
	do
	{            $canWrite = flock($fp, LOCK_EX);
	// If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
	if(!$canWrite) usleep(round(rand(0, 100)*1000));
	} while ((!$canWrite)and((microtime(TRUE)-$startTime) < 5));

	//file was locked so now we can store information
	if ($canWrite)
	{            fwrite($fp, $dataToSave);
	flock($fp, LOCK_UN);
	}
	fclose($fp);
}

}
//write to ini
$arr['theme']['appBarColor'] = 'tahat';
write_php_ini($arr,"project3.ini");

// get value from ini
$ini_array = parse_ini_file("project3.ini",true);
var_dump($ini_array['theme']['appBarColor']);
// $arr[]=1;
// safefilerewrite("/php.ini",$arr);
