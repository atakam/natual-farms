<?PHP
  // form handler
  	
  	include "../inc/config.php";
  
    $sql = "SELECT * FROM form_completion WHERE endnotification=0";
    $resultFC = $conn->query($sql);
	while($rowFC = $resultFC->fetch_assoc())
	{
	    $sql = "SELECT * FROM customer WHERE isactive=1 AND id=".$rowFC['customer_id'];
        $resultC = $conn->query($sql);
        $rowC = $resultC->fetch_assoc();
        
        $sql2 = "SELECT * FROM representative WHERE id=".$rowFC['representative_id'];
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch_assoc();
        
        //1
        $today = time();
        $interval = strtotime($rowFC['conditions_thirddeliverydate']) - $today;
        $days = floor($interval / 86400); // 1 day
        if($days < 30) {
	        
	        $sql3 = "UPDATE form_completion SET
	  		endnotification='1'
	  		WHERE id=".$rowFC['id'];
  	
          	//echo $sqlStatement_customer;
        
          	// Now insert the new form into DB
          	if ($conn->query($sql3) === FALSE){
          		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
          		exit();
  	}
	        
	       $message = "The contract below will end in 30 days:<br><br> ";
           $message .= "Customer Name: ".$rowC['firstname']." ".$rowC['lastname']."<br>";
           $message .= "Customer NFF: ".$rowC['nff']."<br>";
           $message .= "Customer Phone: ".$rowFC['phone']."<br>";
           $message .= "Last Delivery Date: ".$rowFC['conditions_thirddeliverydate']."<br>";
           $message .= "Sales Representative: ".$row2['name']."<br>";
           
            $sql = "SELECT * FROM settings";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            
          	$subject = "Contracts Ending Soon";
          	$mail->Subject = $subject;
          	
          	$mail->addAddress($row["admin_email"]);
          	$mail->addBCC($row2 ["email"]);
          	 
          	echo $message . "Email:" . $row["admin_email"];
          	
          	$mail->isHTML(true);
          	$mail->Body    = $message;
          	$mail->send();
        }
	}
	//echo $message;
  	
  

?>