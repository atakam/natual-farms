<?php
include 'inc/header.php';
?>
<title>Products</title>

<!-- Sidebar -->
<?php
include 'inc/menu.php';
if ($admin_flag=='1') {
?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="#" class="current">Email Templates</a> 
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Email Templates</h5>
          </div>
          <div class="widget-content nopadding">
	<?php 
	
	$sql = "SELECT * FROM email_templates";
	
	$result = $conn->query($sql);
	//echo '<a href="product.php" class="button"><i class="fa fa-plus"> Add Product</i></a>';
	echo "<table id='table-products' class='table table-bordered data-table'>";
	echo "<thead><tr>";
	echo "<th>Id</th><th>Name</th><th>Subject (French)</th><th>Subject (English)</th>
    			<th></th>";
	echo "</tr></thead><tbody>";
	
	while ($row = $result->fetch_assoc())
	{
		echo "<tr>";
		echo "<td>$row[id]</td><td>$row[name]</td><td>$row[subject_fr]</td><td>$row[subject_en]</td>
				<td><a href='template.php?id=$row[id]'><i class='fa fa-edit'></i></a></td>";
		echo "</tr>";
	}
	echo "</tobdy></table>";
	
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