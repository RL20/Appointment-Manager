<?php
//
//submit איך לבדוק שאכן שלחו קובץ ולא לחצו רק על 
//http://stackoverflow.com/questions/10096977/how-to-check-if-the-file-field-is-emptyהעלאת קבצים
if ($_FILES['filename']['error']!= 4)
{
	//שם הקובץ
	$fname=$_FILES['filename']['name'];
	//סוג הקובץ
	$type=$_FILES['filename']['type'];
	//גודל הקובץ
	$size=$_FILES['filename']['size'];
	//בדיקה אם ההעלאה הצליחה
	$erroe=$_FILES['filename']['error'];
	//הקובץ מתקבל בשם וזמני ובתיקיה זמנית ואפשר פשוט להעתיק אותו ולעשות בו שימושים שנרצה אחר כך
	$tmp=$_FILES['filename']['tmp_name'];
	//פונקציה שמעבירה את הקובץ למיקום החדש שנרצה , היא מקבלת שני פרמטרים :שם הקובץ הזמני שנרצה ולאיזה מיקום
	//כלומר אפשר לכתוב בפרמטר השני את כל הנתיב ,אם נרשום בנתיב רק את שם הקובץ בשם שנרצה לשמור זה ישמר בתיקיה הראשית של האתר
	move_uploaded_file($tmp, $fname);
	echo "you have upload the file seccesfuly";
}
else 
	echo "no file uploaded!!!<br/>";


		

?>



