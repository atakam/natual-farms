<?php
include 'inc/header.php';
?>
<title>Staff</title>

<!-- Sidebar -->
<?php
include 'inc/menu.php';
if ($admin_flag=='1') {
?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="#" class="current">Staff</a> 
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Staff</h5>
            <div class="buttons"> 
            	<a href="representative.php" class="btn btn-inverse btn-mini"><i class="icon-plus icon-white"></i> Add Staff</a>
            </div>
          </div>
          <div class="widget-content nopadding">
	<?php 
	
	$sql = "SELECT * FROM representative";
	
	$result = $conn->query($sql);
	echo "<table id='table-representatives' class='table table-bordered data-table'>";
	echo "<thead><tr>";
	echo "<th>Name</th><th>username</th><th>email</th><th>Role</th><th></th><th></th>";
	echo "</tr></thead>";
	
	while ($row = $result->fetch_assoc())
	{
		$role = $row['role'];
		$roleText = $role === "admin" ? "Administrator" : ($role === "supplier" ? "Supplier" :
				($role === "delivery" ? "Delivery Agent" : "Sales Representative"));
		$deleteText = $row['id']!='1'?"<a onclick=\"deleteAction('repid', $row[id])\" href='#'><i class='fa fa-trash'></i></a>":"";
		echo "<tr>";
		echo "<td>".$row['name']."</td><td>".$row['username']."</td><td>".$row['email']."</td><td>".$roleText."</td><td><a href='representative.php?id=".$row['id']."'><i class='fa fa-edit'></i></a></td>
				<td>$deleteText</td>";
		echo "</tr>";
	}
	
	echo "</table></div>";
	
	?>
		</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php
}
include 'inc/footer.php';
?>