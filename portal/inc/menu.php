<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/fullcalendar.css" />
<link rel="stylesheet" href="css/uniform.css" />
<link rel="stylesheet" href="css/custom.css" />
<link rel="stylesheet" href="css/select2.css" />
<link rel="stylesheet" href="css/matrix-style.css" />
<link rel="stylesheet" href="css/matrix-media.css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

<?php 

    $sql = "SELECT * FROM notifications WHERE isread=0";
    $result = $conn->query($sql);
    $count = 0;
    
    while ($row = $result->fetch_assoc())
    {
    	$count++;
    }
?>

<!--Header-part-->
<div id="header">
  <h1><a href="/"></a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse" style="left: inherit;right: 0;">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text"> <?= gettext("Welcome") ?> <?= $user_name?> </span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="profile.php?id=<?= $user_id ?>"><i class="icon-user"></i> My Profile</a></li>
        <li class="divider"></li>
        <li><a href="logout.php"><i class="icon-key"></i> Log Out</a></li>
      </ul>
    </li>
     <?php 
    if ($customer_flag=='0') {
    ?>
    <li id="menu-messages"><a href="notifications.php" class="dropdown-toggle"><i class="icon icon-flag"></i> <span class="text"> Notifications </span> <?php if ($count != 0) {?><span class="label label-important"><?= $count ?></span><?php }?></a>
    </li>
    <?php 
    }
    if ($admin_flag=='1') {
    ?>
    <li class=""><a title="" href="settings.php"><i class="icon icon-cog"></i> <span class="text">Settings</span></a></li>
    <?php } ?>
    <li class=""><a title="" href="logout.php"><i class="icon icon-share-alt"></i> <span class="text"><?= gettext("Logout") ?></span></a></li>
  </ul>
</div>

<!--sidebar-menu-->
<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-th"></i>Tables</a>
<ul>
<?php 
 if ($customer_flag=='0') {
 ?>
<li><a href="index.php" title="Dashboard"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
<?php }?>
<?php 
 if ($customer_flag=='0') {
 ?>
<li class="submenu"> <a href="#" title="Orders"><i class="icon icon-tag"></i> <span>Orders</span></a>
<ul>
<li><a href="orders.php" title="List of Orders"><i class="icon icon-list" style="display: none"></i> <span>List of Orders</span></a></li>
<?php 
if ($delivery_flag == '1' || $supplier_flag == '1') {
	echo '<li><a href="staffordersCal.php" title="Calendar View"><i class="icon icon-calendar" style="display: none"></i> <span>Calendar View</span></a></li>';
}else if ($customer_flag=='0') {
 ?>
<li><a href="ordersCal.php" title="Calendar View"><i class="icon icon-calendar" style="display: none"></i> <span>Calendar View</span></a></li>
<?php 
if ($admin_flag=='1') {
?>
<li><a href="modifiedorders.php" title="Modified Orders"><i class="icon icon-edit" style="display: none"></i> <span>Modified Orders</span></a></li>
<li><a href="order/start.php?lang=en" title="New order" target="_blank"><i class="icon icon-plus" style="display: none"></i> <span>New Order</span></a></li>
<li><a href="superOrders.php" title="Super Admin View"><i class="icon icon-tags" style="display: none"></i> <span>Super Admin View</span></a></li>
<?php }}?>
</ul>
</li>
<?php } else { ?>
<li><a href="customer_orders.php" title="Orders"><i class="icon icon-tag"></i> <span><?= gettext("Orders") ?></span></a></li>
<?php 
}
if ($admin_flag=='1') {
?>
<li class="submenu"> <a href="#" title="Products"><i class="icon icon-th"></i> <span>Products</span></a>
<ul>
<li><a href="products.php" title="Product List"><i class="icon icon-list" style="display: none"></i> <span>Product List</span></a></li>
<li><a href="categories.php" title="Product Categories"><i class="icon icon-th" style="display: none"></i> <span>Product Categories</span></a></li>
</ul>
</li>
<li><a href="customers.php" title="Customers"><i class="icon icon-user"></i> <span>Customers</span></a></li>
<li><a href="representatives.php" title="Staff"><i class="icon icon-user-md"></i> <span>Staff</span></a></li>
<?php } 
 if ($customer_flag=='0' && $delivery_flag == '0' && $supplier_flag == '0') {
 ?>
<li><a href="notifications.php" title="Notifications"><i class="icon icon-flag"></i> <span>Notifications</span> <?php if ($count != 0) {?><span class="label label-important"><?= $count ?></span><?php } ?></a></li>
<?php }if ($admin_flag=='1') { ?>
<li><a href="templates.php" title="Email Templates"><i class="icon icon-envelope"></i> <span>Email Templates</span></a> </li>
<li><a href="orders_demo.php" title="Dummy Orders"><i class="icon icon-coffee"></i> <span>Dummy Orders</span></a> </li>
<li><a href="export.php" title="Export"><i class="fa fa-external-link"></i> <span>Export</span></a> </li>
<li><a href="restore.php" title="Restore"><i class="fa fa-download"></i> <span>Restore</span></a> </li>
<?php } ?>
<!-- <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Forms</span> <span class="label label-important">3</span></a> -->
<!-- <ul> -->
<!-- <li><a href="form-common.html">Basic Form</a></li> -->
<!-- <li><a href="form-validation.html">Form with Validation</a></li> -->
<!-- <li><a href="form-wizard.html">Form with Wizard</a></li> -->
<!-- </ul> -->
<!-- </li> -->
<!-- <li><a href="interface.html"><i class="icon icon-pencil"></i> <span>Eelements</span></a></li> -->
</ul>
</div>