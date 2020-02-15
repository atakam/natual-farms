<?php 

$img = $_POST['imgBase64'];
$name = $_POST['name'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$fileData = base64_decode($img);
//saving
$fileName = getcwd() . '/images/signatures/'. $name .'.png';
file_put_contents($fileName, $fileData);

?>