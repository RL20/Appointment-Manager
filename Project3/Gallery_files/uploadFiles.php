<?php
//
//submit ��� ����� ���� ���� ���� ��� ���� �� �� 
//http://stackoverflow.com/questions/10096977/how-to-check-if-the-file-field-is-empty����� �����
if ($_FILES['filename']['error']!= 4)
{
	//�� �����
	$fname=$_FILES['filename']['name'];
	//��� �����
	$type=$_FILES['filename']['type'];
	//���� �����
	$size=$_FILES['filename']['size'];
	//����� �� ������ ������
	$erroe=$_FILES['filename']['error'];
	//����� ����� ��� ����� ������� ����� ����� ���� ������ ���� ������ �� ������� ����� ��� ��
	$tmp=$_FILES['filename']['tmp_name'];
	//������� ������� �� ����� ������ ���� ����� , ��� ����� ��� ������� :�� ����� ����� ����� ������ �����
	//����� ���� ����� ������ ���� �� �� ����� ,�� ����� ����� �� �� �� ����� ��� ����� ����� �� ���� ������ ������ �� ����
	move_uploaded_file($tmp, $fname);
	echo "you have upload the file seccesfuly";
}
else 
	echo "no file uploaded!!!<br/>";


		

?>



