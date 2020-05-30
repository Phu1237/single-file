<?php ob_start(); ?>
<html>
<head>
<title>Shell-Scanner</title>
</head>
<style type="text/css">
body,a{
background-color: black;
color: #BBBBBB;
font-family: Lucida Console,Tahoma;
font-size: 11px;
text-align: left;
}

input,select,textarea,table,button {
background: none repeat scroll 0 0 #000000;
border: 1px solid #990000;
color: #FFFFFF;
margin: 0;
font-family: Lucida Console,Tahoma;
font-size: 11px;
padding: 2px 4px;
}

input:hover, textarea:hover, select:hover, button:hover {
background: none repeat scroll 0 0 #220000;
border: 1px solid #FF0000;
}

option {
background: none repeat scroll 0 0 #000000;
}
a{
text-decoration: none;
}

</style>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/JavaScript">
$(document).ready(function(){
$('pre').fadeIn(3000);

$('input[type="text"]').click(function(){
$(this).val('');
});

$('a').click(function(){

if($(this).attr('href')=="#" ){
alert('the file seems to be affected by malware codes, please open the file in browser and check it.');
}else if($(this).attr('href')=="##" ){
alert('the file seems to be clean :)');

}

});


$('.start_scanning').mouseenter(function(){

$(this).attr('value','Scanning....');

}).mouseleave(function(){
$(this).attr('value','Start Scanning');
});



});

</script>

<body>

<center><pre style="display: none;"><font color="white" size="1">

 _______           _______  _        _         _______  _______  _______  _        _        _______  _______ 
(  ____ \|\     /|(  ____ \( \      ( \       (  ____ \(  ____ \(  ___  )( (    /|( (    /|(  ____ \(  ____ )
| (    \/| )   ( || (    \/| (      | (       | (    \/| (    \/| (   ) ||  \  ( ||  \  ( || (    \/| (    )|
| (_____ | (___) || (__    | |      | | _____ | (_____ | |      | (___) ||   \ | ||   \ | || (__    | (____)|
(_____  )|  ___  ||  __)   | |      | |(_____)(_____  )| |      |  ___  || (\ \) || (\ \) ||  __)   |     __)
      ) || (   ) || (      | |      | |             ) || |      | (   ) || | \   || | \   || (      | (\ (   
/\____) || )   ( || (____/\| (____/\| (____/\ /\____) || (____/\| )   ( || )  \  || )  \  || (____/\| ) \ \__
\_______)|/     \|(_______/(_______/(_______/ \_______)(_______/|/     \||/    )_)|/    )_)(_______/|/   \__/
                                                                                                                                                                                                    
</pre></font></center>
<br/><br/><br/><br/>  


<?php
if(!isset($_GET['do'])){
header("Location: ?do=index");
}

if($_GET['do'] == "Scan" ){
$self      = explode("\\",__FILE__);
$self_file = count($self) - 1;
$to_scan   = scandir(".");
unset($to_scan[0],$to_scan[1]);
$i = 1;
echo "<center><table width='60%' style='border-color:green;background-color:#200000;'><tr><th>FILE NAME</th><th>SCANNING REPORT</th><th>FILE SIZE</th>";
foreach($to_scan as $toscan){
if(is_file($toscan)){

if(preg_match('/backdoor|phpinfo|php_uname|milw0rm|popen|exec|passthru|phpversion|enctype|shell_exec|proc_open|base64_decode/i', file_get_contents($toscan))  && $toscan != $self[$self_file]){
$file_size = filesize($toscan);
echo"
<tr>
<td><center><font color='red'>$toscan</font></center></td>
<td><center><a href='#' title='Affected'><font color='red'>Click here to get the report</font></a></center></td>
<td><center><font color='red'>$file_size bytes</font></center></td>
";
}else{
$file_size  = filesize($toscan);
if($toscan != $self[$self_file]){

echo"
<tr>
<td><center><font color='green'>$toscan</font></center></td>
<td><center><a href='##' title='Clean'><font color='green'>Click here to get the report</font></a></center></td>
<td><center><font color='green'>$file_size bytes</font></center></td>
";
}
}
}
}// close foreach
echo "</tr></table><center><br /><a href='javascript:history.go(-1)'><input type='button' value='Go back'></a><br /><br />";
}else if($_GET['do'] == "about"){
echo '
<center>

<table width="40%" style="border-color:green;background-color:#200000;">
<tr><td>
This tool is coded By Walid Naceri.<br /><br />
For more Security Tool You can Follow me on : <br /><br />
website : <a href="http://security-dz.com" target="website">http://security-dz.com</a> <br /><br />
Twitter : <a href="https://twitter.com/walidnaceri" target="twitter">WalidNaceri</a><br /><br />
Facebook: <a href="https://www.facebook.com/walid.nacer25i" target="facebook">Walid.naceri25i</a><br /><br />
<font color="red">What is this tool?</font><br /><br />
Of course many people get their website hacked, but they have to delete all the files to make sure they deleted the malicious file.<br />
This is a security tool to help you to scan your folder, give you a report about the files if it contain a malicious code or not.<br /><br />
<font color="red">How to use it?</font><br /><br />
Take this script, and put in the folder you want to scan, and start scanning, the result are 80% sure.<br />
Note: make sure this script it scan only the folder you put it on, and not all the folders, so if you want to scan an other folder move the script to it.<br/><br/>
<center><a href="javascript:history.go(-1)"><input type="button" value="Go back"></a></center>
<br/><br/><br/><br/>
</center></td></tr>
</table></center>
';
}
else{
?>


<center>

<table width="40%" style='border-color:green;background-color:#200000;'>
<tr><td><center>
<br/><br/><br/><br/>
Host_Name : <input type="text" disabled="disabled" value="<?php echo $_SERVER['HTTP_HOST']; ?>">
<br/><br/>
Server_Name : <input type="text" disabled="disabled" value="<?php echo $_SERVER['SERVER_NAME']; ?>">&nbsp;&nbsp;
<br/><br/>
Server_IP : <input type="text" disabled="disabled" value="<?php echo $_SERVER['SERVER_ADDR']; ?>">
<br/><br/>
&nbsp;&nbsp;Your_IP : <input type="text" disabled="disabled" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
<br/><br/><br/>
<a href="?do=Scan" ><input type="button" value="Start Scanning" class="start_scanning"></a> <a href="?do=about"><input type="button" value="How To Use"></a>
<br/><br/><br/><br/>
</center></td></tr>
</table></center>
<?php } ob_end_flush(); ?>
<center><b><br />Coded By <a href="https://twitter.com/walidnaceri" target="twitter"><font color="gray">Walid</font></a> Visite us for more tools on 
<a href="http://security-dz.com" target="coder-dz"><font color="gray">Security-Dz</font></a></b></center>


</body>
</html>