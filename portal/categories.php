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
    	<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="#" class="current">Product Categories</a> 
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Product Categories</h5>
            <div class="buttons"> 
            	<a href="category.php" class="btn btn-inverse btn-mini"><i class="icon-plus icon-white"></i> Add Category</a>
            </div>
          </div>
          <div class="widget-content nopadding">
	<?php 
	
	$sql = "SELECT * FROM products_category";
	
	$result = $conn->query($sql);
	echo "<table id='table-categories' class='table table-bordered data-table'>";
	echo "<thead><tr>";
	echo "<th>Name (English)</th><th>Name (French)</th><th></th><th></th>";
	echo "</tr></thead>";
	
	while ($row = $result->fetch_assoc())
	{
		echo "<tr>";
		echo "<td>$row[name_en]</td><td>$row[name_fr]</td><td><a href='category.php?id=$row[id]'><i class='fa fa-edit'></i></a></td><td>"
				."<a href='#' onclick=\"deleteAction('catid', $row[id])\"><i class='fa fa-trash'></i></a></td>";
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