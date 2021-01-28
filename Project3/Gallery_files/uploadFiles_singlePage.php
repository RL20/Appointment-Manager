<?php
//http://www.w3schools.com/php/php_file_upload.asp
//submit איך לבדוק שאכן שלחו קובץ ולא לחצו רק על 
//http://stackoverflow.com/questions/10096977/how-to-check-if-the-file-field-is-empty

if (isset($_FILES['filename']))
{
	if($_FILES['filename']['error']!= 4)
	{
		$fname=$_FILES['filename']['name'];
		$type=$_FILES['filename']['type'];
		$size=$_FILES['filename']['size'];
		$tmp=$_FILES['filename']['tmp_name'];
		echo "$fname <br/> $type <br/> $size <br/> $tmp <br/>";
		var_dump($_FILES);
		move_uploaded_file($tmp, $fname);
	}
	else
		echo "no file uploaded!!!<br/>";
}
else {

?>
<html>

<head>
<title>upload file</title>
</head>
<body>
	<form method="post" action="newfile.php" enctype="multipart/form-data">
	Select file for upload: <input type="file" name="filename" size="20"/> <br/>
	<input type="submit" value="upload file"/>
	</form>

</body>


</html>
<?php }?>