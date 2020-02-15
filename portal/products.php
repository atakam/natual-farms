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
    	<a href="#" class="current">Products</a> 
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Products</h5>
            <div class="buttons"> 
            	<a id="add-event" href="product.php" class="btn btn-inverse btn-mini"><i class="icon-plus icon-white"></i> Add Product</a>
            </div>
          </div>
          <div class="widget-content nopadding">
	<?php 
	
	$sql = "SELECT * FROM products";
	
	$result = $conn->query($sql);
	//echo '<a href="product.php" class="button"><i class="fa fa-plus"> Add Product</i></a>';
	echo "<table id='table-products' class='table table-bordered data-table'>";
	echo "<thead><tr>";
	echo "<th>Name (English)</th>
    			<th>Name (French)</th><th>Category</th>
    			<th>Active</th>".
    			"<th></th>".
    			"<th></th>";
	echo "</tr></thead><tbody>";
	
	while ($row = $result->fetch_assoc())
	{
		$sql2 = "SELECT * FROM products_category WHERE id=".$row['category_id']." LIMIT 1";
		$result2 = $conn->query($sql2);
		$row2 = $result2->fetch_assoc();
		$active = $row['active'] === '1' ? '<i class="fa fa-check green"></i>' : '<i class="fa fa-times red"></i>';
		
		echo "<tr>";
		echo "<td>$row[name_en]</td>
				<td>$row[name_fr]</td><td>$row2[name_en] / $row2[name_fr]</td>
				<td>$active</td>
				<td><a href='product.php?id=$row[id]'><i class='fa fa-edit'></i></a></td>".
						//"<td>$row[image_name]</td>".
						"<td><a href='#' onclick=\"deleteAction('pdtid', $row[id])\"><i class='fa fa-trash'></i></a></td>";
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