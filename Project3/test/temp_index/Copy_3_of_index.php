<?php function getPossibleAppointmentsList_ByDay(WorkHours $singleDay) // מחזיר לנו רשימה של כל התורים האפשריים של עובד ספיציפי באותו היום
{
	// $possibleAppointmentsList is the argument from the function's caller
	// $possibleAppointmentsList;
	
	// מקבל את הערכים מהאובייקט שהתקבל
	$day = $singleDay->getDay ();
	// $possibleAppointmentsList[$day][];
	
	$start1 = $singleDay->getFromHour1 ();
	$end1 = $singleDay->getToHour1 ();
	
	$start2 = $singleDay->getFromHour2 ();
	$end2 = $singleDay->getToHour2 ();
	
	// set the first hour (the hour that the worker starts working)
	$currentRunHour = $start1;
	
	// $possibleAppointmentsList[$day]; לבדוק שזה עובד במקרה שהיום שהתקבל הוא יום חופש
	
	// runs untill it gets to $end1 - which is the worker's end of the day or a lunch break
	while ( $currentRunHour !== $end1 ) {
		// insert $currentRunHour to the list a the specified day
		$possibleAppointmentsList [] = $currentRunHour;
		// convert the $currentRunHour which is a string to Long
		$timeFromStr = strtotime ( $currentRunHour );
		// add 15 minutes
		$timeFromStr += 900; // מסמל זמן של 15 דקות ונהפוך אותו בהמשך ל אובייקט
		                     // sets the value back to $currentRunHour
		$currentRunHour = date ( "H:i:s", $timeFromStr ); // ממיר את זה חזרה למחרוזת
	}
	
	// checks if $start2 is not null - which means worker has a lunch break or split working day
	if (isset ( $start2 )) {
		// the same as the whlie loop above^^
		$currentRunHour = $start2;
		while ( $currentRunHour !== $end2 ) {
			$possibleAppointmentsList [] = $currentRunHour;
			$timeFromStr = strtotime ( $currentRunHour );
			$timeFromStr += 900;
			$currentRunHour = date ( "H:i:s", $timeFromStr );
		}
	}
	
	// returns the list
	return $possibleAppointmentsList;
}
?>