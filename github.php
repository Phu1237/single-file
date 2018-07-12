<?php
$str = file_get_contents('D:\github.txt');
$str = preg_match_all("/github.com\/(.*) \|/",$str,$res);
echo '<textarea rows="10" cols="50">';
foreach ($res[1] as $url) {
	echo $url."\n";
}
echo '</textarea>';
$url = implode(PHP_EOL,$res[1]);
file_put_contents('D:\github.txt', $url);