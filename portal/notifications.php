<?php
include 'inc/header.php';
?>
<title>Orders</title>

<!-- Sidebar -->
<?php
include 'inc/menu.php';
?>
<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
    	<a href="#" class="current">Notifications</a> 
    </div>
  </div>
<!--End-breadcrumbs-->

<!--Chart-box-->    
<div class="container-fluid">
    <div class="row-fluid">
    	<div class="widget-box">
          <div class="widget-title bg_ly"  href="#collapseG2"><span class="icon"><i class="icon-lightbulb"></i></span>
            <h5>Notifications</h5>
            <?php if ($admin_flag == '1') {?>
            <div class="buttons"> 
            	<a href="#" onclick="deleteAction('notifications', 'delete')" target="_blank" class="btn btn-inverse btn-mini"><i class="icon-trash icon-white"></i> Clear All</a>
            </div>
            <?php }?>
          </div>
          <div class="widget-content nopadding collapse in" id="collapseG2">
            <ul class="recent-posts">
            <?php 
				$sql = "SELECT * FROM notifications ORDER BY date DESC";
				$result = $conn->query($sql);
				
				while ($row = $result->fetch_assoc())
				{
					$name = "";
					$date = $row['date'];
					$message = $row['message'];

					if ($row['iscustomer'] == "1")
					{
						$sql2 = "SELECT * FROM customer WHERE id=".$row['userid']." LIMIT 1";
						$result2 = $conn->query($sql2);
						$row2 = $result2->fetch_assoc();
						$name = "$row2[firstname] $row2[lastname]";
					}
					else {
						$sql2 = "SELECT * FROM representative WHERE id=".$row['userid']." LIMIT 1";
						$result2 = $conn->query($sql2);
						$row2 = $result2->fetch_assoc();
						$name = "$row2[name]";
					}
					
					?>
					
					<li>
	                	<div class="user-thumb"> <img width="40" height="40" alt="User" src="img/demo/av1.jpg"> </div>
	                	<div class="article-post"> <span class="user-info"> By: <?= $name ?> / <?= $date ?> </span>
	                  	<p><a href="#"><?= $message ?></a> </p>
	                	</div>
	              	</li>
					
					<?php
				}
				
				$sql = "UPDATE notifications SET isread = 1";
				$conn->query($sql);
			?>
            </ul>
          </div>
    </div>
   </div>
  </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->

<!-- footer -->
<?php
include 'inc/footer.php';
?>
