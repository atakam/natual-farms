<?PHP
  // form handler
  	
  	include "../inc/config.php";
  
    $sql = "SELECT * FROM form_completion";
    $resultFC = $conn->query($sql);
    $message = "The deliveries in the next 7 days:<br><br> ";
    $send = false;
	while($rowFC = $resultFC->fetch_assoc())
	{
	    $sql = "SELECT * FROM customer WHERE isactive=1 AND id=".$rowFC['customer_id'];
        $resultC = $conn->query($sql);
        $rowC = $resultC->fetch_assoc();
        
        //1
        $today = time();
        $interval = strtotime($rowFC['conditions_firstdeliverydate']) - $today;
        $days = floor($interval / 86400); // 1 day
        if($days < 7) {
           $message .= "Customer Name: ".$rowC['firstname']." ".$rowC['lastname']."<br>";
           $message .= "Customer NFF: ".$rowC['nff']."<br>";
           $message .= "Customer Phone: ".$rowFC['phone']."<br>";
           $message .= "Deliver Date: ".$rowFC['conditions_firstdeliverydate']."<br>";
           $message .= "Customer #: 1<br><br>";
           $send = true;
        }
        
        //2
        $interval = strtotime($rowFC['conditions_seconddeliverydate']) - $today;
        $days = floor($interval / 86400); // 1 day
        if($days < 7) {
        	$message .= "Customer Name: ".$rowC['firstname']." ".$rowC['lastname']."<br>";
        	$message .= "Customer NFF: ".$rowC['nff']."<br>";
        	$message .= "Customer Phone: ".$rowFC['phone']."<br>";
        	$message .= "Deliver Date: ".$rowFC['conditions_firstdeliverydate']."<br>";
        	$message .= "Customer #: 1<br><br>";
        	$send = true;
        }

        //3
        $interval = strtotime($rowFC['conditions_thirddeliverydate']) - $today;
        $days = floor($interval / 86400); // 1 day
        if($days < 7) {
        	$message .= "Customer Name: ".$rowC['firstname']." ".$rowC['lastname']."<br>";
        	$message .= "Customer NFF: ".$rowC['nff']."<br>";
        	$message .= "Customer Phone: ".$rowFC['phone']."<br>";
        	$message .= "Deliver Date: ".$rowFC['conditions_firstdeliverydate']."<br>";
        	$message .= "Customer #: 1<br><br>";
        	$send = true;
        }
	}
	//echo $message;
  	$sql = "SELECT * FROM settings";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    
  	$subject = "The deliveries in the next 7 days";
  	
  	$mail->Subject = $subject;
  	
  	$mail->addAddress($row["admin_email"]);
  	 
  	echo $message . "Email:" . $row["admin_email"];
  	
  	$mail->isHTML(true);
  	$mail->Body    = $message;
  	if ($send == true) {
  		$mail->send();
  	}
  

?>