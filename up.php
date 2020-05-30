<html>
<head>
<title></title>
<meta http-equiv="content-type" content="application/xhtml xml; charset=utf-8"/>
</head>
<body>
<?php
echo '<font color="blue"><b>unzip file online</b></font><br><br>';
$submit=$_POST["submit"];
if(!$submit){echo'<form method="post" enctype="multipart/form-data"><font color="red">Tải lên file.zip .jar _jar:<br/><input type="file" name="file"><br/>Nhập link file </font><br><input type="text" name="link" value="http://"><br>giải nén</font><br><input type="text" name="thumuc"><br><input type="submit" name="submit" value="ok"></form><br>';}else{$file=$_FILES['file']['name'];
$link=$_POST['link'];
$thumuc=$_POST['thumuc'];
if($file){$type=$_FILES['file']['type'];
if(($type!="application/zip")&&($type!="application/x-java-archive")&&($type!="application/octet-stream")){echo'<font color="purple">định dạng tập tin không hợp lệ.Chỉ cho phép .zip .jar _jar !</font>';
exit("</body></html>");}
$file=str_replace(' ','_',$file);
$file=rand(100,900).$file;
move_uploaded_file($_FILES['file']['tmp_name'],$file);}
if(($link)&&($link!="http://")){$file=basename($link);
$ex=explode('.',$file);
if((end($ex)!='zip') &&
(end($ex)!='jar')&&(end($ex)!='rar'))
{echo'<font color="purple">link không hợp lệ.Chỉ cho phép .zip .jar _jar !</font><br><br>';
exit("</body></html>");}else{
$file=rand(100,900).$file;
copy($link,$file);}}
if(!file_exists($thumuc)){mkdir($thumuc);};
if($file){$zip=new ZipArchive();
if($zip->open($file)===TRUE){if($zip->extractTo($thumuc)===TRUE){echo '<br>giải nén thành công vào thư mục <b>'.$thumuc.'</b><br><a href="'.$thumuc.'">Đến thư mục vừa giải nén</a>';unlink($file);}else{echo'kô giải nén được';}
$zip->close();}}
;}
echo '<br>';
?>
</body>
</html>
