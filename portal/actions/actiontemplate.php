<?PHP
  // form handler
  if($_POST){
  	
  	include "../inc/config.php";
  	
  	/**************************************
  	 *		Customer's informations
  	 **************************************/

  	$template_name	 			= mysqli_real_escape_string($conn, isset($_POST['name']) ? $_POST['name'] : "");
  	$template_subjectfr	 			= mysqli_real_escape_string($conn, isset($_POST['subjectfr']) ? $_POST['subjectfr'] : "");
  	$template_contentfr 			= mysqli_real_escape_string($conn, isset($_POST['contentfr']) ? $_POST['contentfr'] : "");
  	$template_subject	 			= mysqli_real_escape_string($conn, isset($_POST['subject']) ? $_POST['subject'] : "");
  	$template_content 			= mysqli_real_escape_string($conn, isset($_POST['content']) ? $_POST['content'] : "");
  	$template_id 				= mysqli_real_escape_string($conn, isset($_POST['id']) ? $_POST['id'] : 0);
  	 
	/********************************************
	 *		Insert new product in the database
	 ********************************************/
  	
  	$sqlStatement = "UPDATE email_templates SET
  	
  	name='$template_name',	subject_fr='$template_subjectfr',  content_fr='$template_contentfr',
  	subject_en='$template_subject',  content_en='$template_content'
  	
  	WHERE id=$template_id";
  	
  	//echo $sqlStatement_customer;
  	
  	// Now insert the new form into DB
  	if ($conn->query($sqlStatement) === FALSE){
  		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
  		exit();
  	}
  	
  	echo "Template edited successfully";
  	
  	$url= "../template.php?id=".$template_id;
  	//header('Location: ' . $_SERVER['HTTP_REFERER']);
  	echo "<script>window.location.href = '$url';</script>";
}
//header("Location: ../");
//exit();
?>