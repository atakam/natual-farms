<?php
include 'inc/header.php';
?>
<title>Home</title>

<!-- Sidebar -->
<?php
if ($customer_flag=='1') {
	header("Location: orders.php");
}

include 'inc/menu.php';
?>
<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
  	
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
  </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
  <div class="container-fluid">
    <div class="quick-actions_homepage">
      <ul class="quick-actions">
        <li class="bg_lg"> <a href="orders.php"> <i class="icon-tag"></i> Orders</a> </li>
        <?php if ($supplier_flag === '1' || $delivery_flag === '1'){?>
         <li class="bg_ly"> <a href="staffordersCal.php"> <i class="icon-calendar"></i> Calendar View </a> </li>
         <?php }?>
        <?php if ($supplier_flag !== '1' && $delivery_flag !== '1'){?>
        <li class="bg_lb"> <a href="order/start.php?lang=en" target="_blank"> <i class="icon-plus"></i> New Order </a> </li>
        <?php }?>
        <?php if ($admin_flag == '1'){?>
        <li class="bg_ly"> <a href="products.php"> <i class="icon-th-list"></i> Products </a> </li>
        <li class="bg_lr"> <a href="customers.php"> <i class="icon-user"></i> Customers</a> </li>
        <li class="bg_ls"> <a href="representatives.php"> <i class="icon-user-md"></i> Representatives</a> </li>
        <li class="bg_lo"> <a href="notifications.php"> <i class="icon-flag"></i><?php if ($count != 0) {?><span class="label label-error"><?= $count ?></span><?php } ?> Notifications</a> </li>
        <?php }?>
      </ul>
    </div>
<!--End-Action boxes-->    
<hr/>
<!--Chart-box-->   
<?php if ($supplier_flag !== '1' && $delivery_flag !== '1'){?> 
    <div class="row-fluid">
      <div class="span6">
    	<div class="widget-box">
          <div class="widget-title bg_ly" data-toggle="collapse" href="#collapseG2"><span class="icon"><i class="icon-chevron-down"></i></span>
            <h5>Notifications</h5>
          </div>
          <div class="widget-content nopadding collapse in" id="collapseG2">
            <ul class="recent-posts">
            <?php 
				$sql = "SELECT * FROM notifications ORDER BY date DESC LIMIT 3";
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
    <?php if ($admin_flag == '1'){?>
	    <div class="span6">
	      <div class="widget-box">
	        <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
	          <h5>Statistics</h5>
	        </div>
	        <div class="widget-content" >
	          <div class="row-fluid">
	              <ul class="site-stats">
	              
	              <?php 
	              // Count customers
	              $sql = "SELECT * FROM customer";
	              $result = $conn->query($sql);
	              $customerCount = 0;
	              $customerCount2 = 0;
	              
	              while ($row = $result->fetch_assoc())
	              {
	              	if ($row['isactive'] === '1')
	              		$customerCount++;
	              	else
	              		$customerCount2++;
	              }
	              
	              $sql = "SELECT * FROM customer";
	              $result = $conn->query($sql);
	              $customerCountExpired = 0;
	              while ($row = $result->fetch_assoc())
	              {
	              	$sql2 = "SELECT * FROM form_completion WHERE customer_id=".$row['id']." ORDER BY id DESC";
	              	$result2 = $conn->query($sql2);
	              	$row2 = $result2->fetch_assoc();
	              	if ($row['isactive'] === '1' && $row2['deliver3'] === '1') {
	              		$customerCountExpired++;
	              	}
	              }
	              
	              // Count orders
	              $sql = "SELECT * FROM form_completion";
	              $result = $conn->query($sql);
	              $orderCount = 0;
	              
	              while ($row = $result->fetch_assoc())
	              {
	              	$orderCount++;
	              }
	              
	              // Count unverified orders
	              $sql = "SELECT * FROM customer WHERE nff=''";
	              $result = $conn->query($sql);
	              $order2Count = 0;
	              
	              while ($row = $result->fetch_assoc())
	              {
	              	$order2Count++;
	              }
	              
	              // New orders
	              $sql = "SELECT * FROM form_completion WHERE conditions_startcontractdate=CURDATE()";
	              $result = $conn->query($sql);
	              $order3Count = 0;
	              
	              while ($row = $result->fetch_assoc())
	              {
	              	$order3Count++;
	              }
	              ?>
	                <li class="bg_lb"><i class="icon-user"></i> <strong><?= $customerCount?></strong> <small>Active Customers</small></li>
	                <li class="bg_lr"><i class="icon-user"></i> <strong><?= $customerCount2?></strong> <small>Inactive Customers</small></li>
	                <li class="bg_ly"><i class="icon-user"></i> <strong><?= $customerCountExpired?></strong> <small>Expired Customers</small></li>
	                <li class="bg_lg"><i class="icon-tag"></i> <strong><?= $orderCount?></strong> <small>Total Orders</small></li>
	                <li class="bg_lb"><i class="icon-repeat"></i> <strong><?= $order2Count?></strong> <small>Pending Orders</small></li>
	                <li class="bg_lr"><i class="icon-plus"></i> <strong><?= $order3Count?></strong> <small>New Orders </small></li>
	              </ul>
	          </div>
	        </div>
	      </div>
	    </div>
	   <?php } ?>
    </div>
 <?php }?>   
    <!--  
    <div class="row-fluid">
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
            <h5>Category Pie chart</h5>
          </div>
          <div class="widget-content">
            <div class="pie"></div>
          </div>
        </div>
      </div>
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
            <h5>Line chart</h5>
          </div>
          <div class="widget-content">
            <div class="bars"></div>
          </div>
        </div>
      </div>
    </div>-->
<!--End-Chart-box--> 
<!--   
    <div class="row-fluid">
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title bg_ly" data-toggle="collapse" href="#collapseG2"><span class="icon"><i class="icon-chevron-down"></i></span>
            <h5>Latest Posts</h5>
          </div>
          <div class="widget-content nopadding collapse in" id="collapseG2">
            <ul class="recent-posts">
              <li>
                <div class="user-thumb"> <img width="40" height="40" alt="User" src="img/demo/av1.jpg"> </div>
                <div class="article-post"> <span class="user-info"> By: john Deo / Date: 2 Aug 2012 / Time:09:27 AM </span>
                  <p><a href="#">This is a much longer one that will go on for a few lines.It has multiple paragraphs and is full of waffle to pad out the comment.</a> </p>
                </div>
              </li>
              <li>
                <div class="user-thumb"> <img width="40" height="40" alt="User" src="img/demo/av2.jpg"> </div>
                <div class="article-post"> <span class="user-info"> By: john Deo / Date: 2 Aug 2012 / Time:09:27 AM </span>
                  <p><a href="#">This is a much longer one that will go on for a few lines.It has multiple paragraphs and is full of waffle to pad out the comment.</a> </p>
                </div>
              </li>
              <li>
                <div class="user-thumb"> <img width="40" height="40" alt="User" src="img/demo/av4.jpg"> </div>
                <div class="article-post"> <span class="user-info"> By: john Deo / Date: 2 Aug 2012 / Time:09:27 AM </span>
                  <p><a href="#">This is a much longer one that will go on for a few lines.Itaffle to pad out the comment.</a> </p>
                </div>
              <li>
                <button class="btn btn-warning btn-mini">View All</button>
              </li>
            </ul>
          </div>
        </div>
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-ok"></i></span>
            <h5>To Do list</h5>
          </div>
          <div class="widget-content">
            <div class="todo">
              <ul>
                <li class="clearfix">
                  <div class="txt"> Luanch This theme on Themeforest <span class="by label">Alex</span></div>
                  <div class="pull-right"> <a class="tip" href="#" title="Edit Task"><i class="icon-pencil"></i></a> <a class="tip" href="#" title="Delete"><i class="icon-remove"></i></a> </div>
                </li>
                <li class="clearfix">
                  <div class="txt"> Manage Pending Orders <span class="date badge badge-warning">Today</span> </div>
                  <div class="pull-right"> <a class="tip" href="#" title="Edit Task"><i class="icon-pencil"></i></a> <a class="tip" href="#" title="Delete"><i class="icon-remove"></i></a> </div>
                </li>
                <li class="clearfix">
                  <div class="txt"> MAke your desk clean <span class="by label">Admin</span></div>
                  <div class="pull-right"> <a class="tip" href="#" title="Edit Task"><i class="icon-pencil"></i></a> <a class="tip" href="#" title="Delete"><i class="icon-remove"></i></a> </div>
                </li>
                <li class="clearfix">
                  <div class="txt"> Today we celebrate the theme <span class="date badge badge-info">08.03.2013</span> </div>
                  <div class="pull-right"> <a class="tip" href="#" title="Edit Task"><i class="icon-pencil"></i></a> <a class="tip" href="#" title="Delete"><i class="icon-remove"></i></a> </div>
                </li>
                <li class="clearfix">
                  <div class="txt"> Manage all the orders <span class="date badge badge-important">12.03.2013</span> </div>
                  <div class="pull-right"> <a class="tip" href="#" title="Edit Task"><i class="icon-pencil"></i></a> <a class="tip" href="#" title="Delete"><i class="icon-remove"></i></a> </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-ok"></i></span>
            <h5>Progress Box</h5>
          </div>
          <div class="widget-content">
            <ul class="unstyled">
              <li> <span class="icon24 icomoon-icon-arrow-up-2 green"></span> 81% Clicks <span class="pull-right strong">567</span>
                <div class="progress progress-striped ">
                  <div style="width: 81%;" class="bar"></div>
                </div>
              </li>
              <li> <span class="icon24 icomoon-icon-arrow-up-2 green"></span> 72% Uniquie Clicks <span class="pull-right strong">507</span>
                <div class="progress progress-success progress-striped ">
                  <div style="width: 72%;" class="bar"></div>
                </div>
              </li>
              <li> <span class="icon24 icomoon-icon-arrow-down-2 red"></span> 53% Impressions <span class="pull-right strong">457</span>
                <div class="progress progress-warning progress-striped ">
                  <div style="width: 53%;" class="bar"></div>
                </div>
              </li>
              <li> <span class="icon24 icomoon-icon-arrow-up-2 green"></span> 3% Online Users <span class="pull-right strong">8</span>
                <div class="progress progress-danger progress-striped ">
                  <div style="width: 3%;" class="bar"></div>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <div class="widget-box">
          <div class="widget-title bg_lo"  data-toggle="collapse" href="#collapseG3" > <span class="icon"> <i class="icon-chevron-down"></i> </span>
            <h5>News updates</h5>
          </div>
          <div class="widget-content nopadding updates collapse in" id="collapseG3">
            <div class="new-update clearfix"><i class="icon-ok-sign"></i>
              <div class="update-done"><a title="" href="#"><strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</strong></a> <span>dolor sit amet, consectetur adipiscing eli</span> </div>
              <div class="update-date"><span class="update-day">20</span>jan</div>
            </div>
            <div class="new-update clearfix"> <i class="icon-gift"></i> <span class="update-notice"> <a title="" href="#"><strong>Congratulation Maruti, Happy Birthday </strong></a> <span>many many happy returns of the day</span> </span> <span class="update-date"><span class="update-day">11</span>jan</span> </div>
            <div class="new-update clearfix"> <i class="icon-move"></i> <span class="update-alert"> <a title="" href="#"><strong>Maruti is a Responsive Admin theme</strong></a> <span>But already everything was solved. It will ...</span> </span> <span class="update-date"><span class="update-day">07</span>Jan</span> </div>
            <div class="new-update clearfix"> <i class="icon-leaf"></i> <span class="update-done"> <a title="" href="#"><strong>Envato approved Maruti Admin template</strong></a> <span>i am very happy to approved by TF</span> </span> <span class="update-date"><span class="update-day">05</span>jan</span> </div>
            <div class="new-update clearfix"> <i class="icon-question-sign"></i> <span class="update-notice"> <a title="" href="#"><strong>I am alwayse here if you have any question</strong></a> <span>we glad that you choose our template</span> </span> <span class="update-date"><span class="update-day">01</span>jan</span> </div>
          </div>
        </div>
        
      </div>
      <div class="span6">
        <div class="widget-box widget-chat">
          <div class="widget-title bg_lb"> <span class="icon"> <i class="icon-comment"></i> </span>
            <h5>Chat Option</h5>
          </div>
          <div class="widget-content nopadding collapse in" id="collapseG4">
            <div class="chat-users panel-right2">
              <div class="panel-title">
                <h5>Online Users</h5>
              </div>
              <div class="panel-content nopadding">
                <ul class="contact-list">
                  <li id="user-Alex" class="online"><a href=""><img alt="" src="img/demo/av1.jpg" /> <span>Alex</span></a></li>
                  <li id="user-Linda"><a href=""><img alt="" src="img/demo/av2.jpg" /> <span>Linda</span></a></li>
                  <li id="user-John" class="online new"><a href=""><img alt="" src="img/demo/av3.jpg" /> <span>John</span></a><span class="msg-count badge badge-info">3</span></li>
                  <li id="user-Mark" class="online"><a href=""><img alt="" src="img/demo/av4.jpg" /> <span>Mark</span></a></li>
                  <li id="user-Maxi" class="online"><a href=""><img alt="" src="img/demo/av5.jpg" /> <span>Maxi</span></a></li>
                </ul>
              </div>
            </div>
            <div class="chat-content panel-left2">
              <div class="chat-messages" id="chat-messages">
                <div id="chat-messages-inner"></div>
              </div>
              <div class="chat-message well">
                <button class="btn btn-success">Send</button>
                <span class="input-box">
                <input type="text" name="msg-box" id="msg-box" />
                </span> </div>
            </div>
          </div>
        </div>
        <div class="widget-box">
          <div class="widget-title"><span class="icon"><i class="icon-user"></i></span>
            <h5>Our Partner (Box with Fix height)</h5>
          </div>
          <div class="widget-content nopadding fix_hgt">
            <ul class="recent-posts">
              <li>
                <div class="user-thumb"> <img width="40" height="40" alt="User" src="img/demo/av1.jpg"> </div>
                <div class="article-post"> <span class="user-info">John Deo</span>
                  <p>Web Desginer &amp; creative Front end developer</p>
                </div>
              </li>
              <li>
                <div class="user-thumb"> <img width="40" height="40" alt="User" src="img/demo/av2.jpg"> </div>
                <div class="article-post"> <span class="user-info">John Deo</span>
                  <p>Web Desginer &amp; creative Front end developer</p>
                </div>
              </li>
              <li>
                <div class="user-thumb"> <img width="40" height="40" alt="User" src="img/demo/av4.jpg"> </div>
                <div class="article-post"> <span class="user-info">John Deo</span>
                  <p>Web Desginer &amp; creative Front end developer</p>
                </div>
            </ul>
          </div>
        </div>
        <div class="accordion" id="collapse-group">
          <div class="accordion-group widget-box">
            <div class="accordion-heading">
              <div class="widget-title"> <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse"> <span class="icon"><i class="icon-magnet"></i></span>
                <h5>Accordion Example 1</h5>
                </a> </div>
            </div>
            <div class="collapse in accordion-body" id="collapseGOne">
              <div class="widget-content"> It has multiple paragraphs and is full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end. </div>
            </div>
          </div>
          <div class="accordion-group widget-box">
            <div class="accordion-heading">
              <div class="widget-title"> <a data-parent="#collapse-group" href="#collapseGTwo" data-toggle="collapse"> <span class="icon"><i class="icon-magnet"></i></span>
                <h5>Accordion Example 2</h5>
                </a> </div>
            </div>
            <div class="collapse accordion-body" id="collapseGTwo">
              <div class="widget-content">And is full of waffle to It has multiple paragraphs and is full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end.</div>
            </div>
          </div>
          <div class="accordion-group widget-box">
            <div class="accordion-heading">
              <div class="widget-title"> <a data-parent="#collapse-group" href="#collapseGThree" data-toggle="collapse"> <span class="icon"><i class="icon-magnet"></i></span>
                <h5>Accordion Example 3</h5>
                </a> </div>
            </div>
            <div class="collapse accordion-body" id="collapseGThree">
              <div class="widget-content"> Waffle to It has multiple paragraphs and is full of waffle to pad out the comment. Usually, you just </div>
            </div>
          </div>
        </div>
        <div class="widget-box collapsible">
          <div class="widget-title"> <a data-toggle="collapse" href="#collapseOne"> <span class="icon"><i class="icon-arrow-right"></i></span>
            <h5>Toggle, Open by default, </h5>
            </a> </div>
          <div id="collapseOne" class="collapse in">
            <div class="widget-content"> This box is opened by default, paragraphs and is full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end. </div>
          </div>
          <div class="widget-title"> <a data-toggle="collapse" href="#collapseTwo"> <span class="icon"><i class="icon-remove"></i></span>
            <h5>Toggle, closed by default</h5>
            </a> </div>
          <div id="collapseTwo" class="collapse">
            <div class="widget-content"> This box is now open </div>
          </div>
          <div class="widget-title"> <a data-toggle="collapse" href="#collapseThree"> <span class="icon"><i class="icon-remove"></i></span>
            <h5>Toggle, closed by default</h5>
            </a> </div>
          <div id="collapseThree" class="collapse">
            <div class="widget-content"> This box is now open </div>
          </div>
        </div>
        <div class="widget-box">
          <div class="widget-title">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#tab1">Tab1</a></li>
              <li><a data-toggle="tab" href="#tab2">Tab2</a></li>
              <li><a data-toggle="tab" href="#tab3">Tab3</a></li>
            </ul>
          </div>
          <div class="widget-content tab-content">
            <div id="tab1" class="tab-pane active">
              <p>And is full of waffle to It has multiple paragraphs and is full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end.multiple paragraphs and is full of waffle to pad out the comment.</p>
              <img src="img/demo/demo-image1.jpg" alt="demo-image"/></div>
            <div id="tab2" class="tab-pane"> <img src="img/demo/demo-image2.jpg" alt="demo-image"/>
              <p>And is full of waffle to It has multiple paragraphs and is full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end.multiple paragraphs and is full of waffle to pad out the comment.</p>
            </div>
            <div id="tab3" class="tab-pane">
              <p>And is full of waffle to It has multiple paragraphs and is full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end.multiple paragraphs and is full of waffle to pad out the comment. </p>
              <img src="img/demo/demo-image3.jpg" alt="demo-image"/></div>
          </div>
        </div>
      </div>
    </div>-->
  </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->

<!-- footer -->
<?php
include 'inc/footer.php';

// Code to update database with price and english names of products
// $i=0;
// $handle = fopen("prices.csv","r");
// while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
// 	if($i>0){
// 		//$import="UPDATE products_details SET purchase_price='".str_replace(" ", "", str_replace("$", "", $data[4]))."' WHERE code='$data[0]'";
// 		//$conn->query($import);
// 		//echo $import;
// 		$code = $data[0];
// 		$sql = "SELECT * FROM products_details WHERE code='" . $data[0] . "' LIMIT 1;";
// 		$result = mysqli_query ( $conn, $sql ) or die ( $sql . "<br>" . mysqli_error ( $conn ) );
// 		while ( $row = $result->fetch_assoc () ) {
// 			$id = $row['product_id'];
			
// 			$import="UPDATE products SET name_en='".explode(" // ", $data[2])[1]."' WHERE id='$id'";
// 			$conn->query($import);
// 		}
// 	}
// 	$i=1;
// }
?>

<script type="text/javascript">
  // This function is called from the pop-up menus to transfer to
  // a different page. Ignore if the value returned is a null string:
  function goPage (newURL) {

      // if url is empty, skip the menu dividers and reset the menu selection to default
      if (newURL != "") {
      
          // if url is "-", it is this page -- reset the menu:
          if (newURL == "-" ) {
              resetMenu();            
          } 
          // else, send page to designated URL            
          else {  
            document.location.href = newURL;
          }
      }
  }

// resets the menu selection upon entry to this page:
function resetMenu() {
   document.gomenu.selector.selectedIndex = 2;
}
</script>
