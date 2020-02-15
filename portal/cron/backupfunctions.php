<?php
function uploadToDb($file_path, $folder)
{
	$file_path_str = $file_path;

	$url_path_str = 'https://api-content.dropbox.com/1/files_put/auto/'.$folder.'/'.$file_path_str;
	$header = array(
			"Authorization:Bearer N-1rQ-7SasAAAAAAAAAADI6XeekjKE3mxGJie6fddKgIdRkRZ7Iep4RgfIJSXH6R",
			"Content-Length:".filesize($file_path_str));

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url_path_str);
	curl_setopt($ch, CURLOPT_PUT, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

	$fh_res = fopen($file_path_str, 'r');
	$file_data_str = fread($fh_res, filesize($file_path_str));
	rewind($fh_res);

	curl_setopt($ch, CURLOPT_INFILE, $fh_res);
	curl_setopt($ch, CURLOPT_INFILESIZE, filesize($file_path_str));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$curl_response_res = curl_exec ($ch);

	echo $curl_response_res; // Server response
	print_r(curl_getinfo($ch)); // Http Response
	curl_close($ch);

	fclose($fh_res);
}
?>