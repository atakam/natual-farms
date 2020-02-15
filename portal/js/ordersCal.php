<?php
include 'inc/header.php';
?>
<title>Orders</title>

<!-- Sidebar -->
<?php
if ($customer_flag=='0') {
include 'inc/menu.php';
?>

<script>
function generateMap(dateVal)
{
	alert(document.getElementById("cf"+dateVal).innerHTML);
}
</script>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="#" class="current">Orders</a> 
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
	  <div class="buttons"> 
	      <a href="orders.php" class="btn btn-inverse btn-mini"><i class="icon-th-list icon-white"></i> List View</a>
	      <a href="mapView.php" class="btn btn-inverse btn-mini"><i class="icon-map-marker icon-white"></i> Map View</a>
	  </div>
  	</div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box widget-calendar">
          <div class="widget-title"> <span class="icon"><i class="icon-calendar"></i></span>
            <h5>Calendar: Calendar View</h5>
          </div>
          <div class="widget-content">
            <div class="panel-left" style="margin-top:27px">
              <div id="fullcalendar"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php 
//$sql = "SELECT * FROM form_completion WHERE representative_id=".$user_id;
if ($admin_flag=='1') {
	$sql = "SELECT * FROM form_completion";
}
$sql = "SELECT * FROM form_completion";
$result = $conn->query($sql);

$delivery1 = array();
$delivery2 = array();
$delivery3 = array();

echo '<script type="text/javascript">';
echo '$(document).ready(function(){';
while ($row = $result->fetch_assoc())
{
	$sql2 = "SELECT * FROM customer WHERE id=".$row['customer_id']." LIMIT 1";
	$result2 = $conn->query($sql2);
	$row2 = $result2->fetch_assoc();
	
	if($row2['isactive'] == '0')
	{
		continue;
	}
	
	$status = "Completed";
	if ($row['status'] === "0")
	{
		$status = "ID not assigned";
	}


	// 		$edited = $row['edited_points'] != 0 ? "<i style='color: red; font-weight: bold;'>FORM EDITED</i>": "";
	$edited = "";	// For now we don't need to handle the customer edit

	$name = "$row2[firstname] $row2[lastname]";
	$date = $row['conditions_firstdeliverydate'] . "GMT-0500";
	$date2 = $row['conditions_seconddeliverydate'] . "GMT-0500";
	$date3 = $row['conditions_thirddeliverydate'] . "GMT-0500";
	
	if (!in_array($row['conditions_firstdeliverydate'], $delivery1))
	{
		array_push($delivery1, $row['conditions_firstdeliverydate']);
	}
	if (!in_array($row['conditions_seconddeliverydate'], $delivery2))
	{
		array_push($delivery2, $row['conditions_seconddeliverydate']);
	}
	if (!in_array($row['conditions_thirddeliverydate'], $delivery3))
	{
		array_push($delivery3, $row['conditions_thirddeliverydate']);
	}
	
	echo 'addEventToCalendar("1 - '.$name.'", "'.$date.'", "#f'.$row['id'].'", "#62c462");';
	echo 'addEventToCalendar("2 - '.$name.'", "'.$date2.'", "#s'.$row['id'].'", "#fb7a2c");';
	echo 'addEventToCalendar("3 - '.$name.'", "'.$date3.'", "#t'.$row['id'].'", "#ee5f5b");';
}
echo '});';
echo '</script>';
}
else {
	header("Location: customer_orders.php");
}

if ($admin_flag == '1') {
	$sql = "SELECT * FROM form_completion";
	$result = $conn->query($sql);
	
	while ($row = $result->fetch_assoc())
	{
		$sql2 = "SELECT * FROM customer WHERE id=".$row['customer_id']." LIMIT 1";
		$result2 = $conn->query($sql2);
		$row2 = $result2->fetch_assoc();
		
		if($row2['isactive'] == '0')
		{
			continue;
		}
		
		/******** FIRST DELIVER ********/
		echo '<div id="f'.$row['id'].'" class="modal hide">';
			echo '<div class="modal-header">';
            echo '<button data-dismiss="modal" class="close" type="button">×</button>';
            echo '<h3>Orders for: '.$row2['firstname'].' '.$row2['lastname'].' on '.$row['conditions_firstdeliverydate'].' (First Delivery)</h3>';
            echo '<a href="#" onclick="changeView(\'pintAreal1'.$row["id"].'\', \'pintAreaf1'.$row["id"].'\')" title="Fournisseur"><i class="fa fa-podcast"></i> Fournisseur</a> | 
			<a href="#" onclick="changeView(\'pintAreaf1'.$row["id"].'\', \'pintAreal1'.$row["id"].'\')" title="Livraison"><i class="fa fa-truck"></i> Livraison</a>
			<a style="float: right; margin-bottom: 10px" href="#" title="Print" onclick="printDiv(\'f'.$row['id'].'\')"><i class="fa fa-print"></i> Print</a></div>';
			
            // Fiche du fournisseur
            echo '<div class="modal-body open" id="pintAreaf1'.$row["id"].'">';
            echo '<style type="text/css" media="print">
			  				@page { size: landscape; }
						</style>';
			echo '<h4 style="float: left;">La Ferme au Naturel</h4><h5 style="float: right;">Bon de Commande Fournisseur</h5><div style="clear:both"></div><hr>';
			echo '<div style="float: left;">'.$row2['firstname'].' '.$row2['lastname'].'</div>';
			echo '<div style="float: right;"># Référence:'.$row['formId'].'<br>'.$row['conditions_firstdeliverydate'].'<br># Commande: 1<br><br></div>';
			echo '<table style="font-size:small" class="table table-bordered">';
			echo '<thead><tr><th>Nom du produit</th><th>Emballage</th><th>Quantité</th><th>Prix Unitaire</th><th>Prix Total</th></tr></thead>';
						
			$sqlOrd = "SELECT * FROM orders WHERE form_id=".$row["id"];
			$resultsOrd = $conn->query($sqlOrd);
				
		$total1 = 0;
				
		while ($rowOrd = $resultsOrd->fetch_assoc())
		{
			$sqlPtl = "SELECT * FROM products_details WHERE id=".$rowOrd['product_details_id']." LIMIT 1";
			$resultsPtl = $conn->query($sqlPtl);
			$rowPtl = $resultsPtl->fetch_assoc();
			
			$sqlPtl = "SELECT * FROM product_packaging WHERE id=".$rowPtl['packaging_id']." LIMIT 1";
			$resultsPtl2 = $conn->query($sqlPtl);
			$rowPtl2 = $resultsPtl2->fetch_assoc();
		
			$sqlPtl = "SELECT * FROM products WHERE id=".$rowPtl['product_id']." LIMIT 1";
			$resultsPtl3 = $conn->query($sqlPtl);
			$rowPtl3 = $resultsPtl3->fetch_assoc();
			
			$subtotal = (((int)$rowOrd["quantity1"])*((int)$rowPtl["purchase_price"]));
			$total1 = $total1 + $subtotal;
			
			echo "<tr>";
			echo "<td>".$rowPtl["code"]." - ".$rowPtl3["name_fr"]." ".$rowPtl3["name_en"]."</td>";
			echo "<td>".$rowPtl2["type"]." : ".$rowPtl2["quantity"]."</td>";
			echo "<td>".$rowOrd["quantity1"]."</td>";
			echo "<td>".$rowPtl["purchase_price"]."</td>";
			echo "<td>".$subtotal."</td>";
			echo "</tr>";
		}
		echo "<tr>";
		echo "<td colspan='2'><h5>Notes:$row[notice2]</h5></td>";
		echo "<td colspan='2'><b>Total de la Commande</b></td>";
		echo "<td><b>".$total1."</b></td>";
		echo "</tr>";
		echo '</table>';
		
		echo '</div>';
		
		// Fiche de livraison
		echo '<div class="modal-body open" style="display: none" id="pintAreal1'.$row["id"].'">';
		echo '<h4 style="float: left;">La Ferme au Naturel / Natural Farms</h4><h5 style="float: right;">Bon de Livraison</h5><div style="clear:both"></div>';
		echo '<div>2285-A10 Blvd St-Laurent<br>Ottawa (Ontario) k1G 4Z4<br>Tél: 613-800-2214<br>Courriel: admin@nffood.ca<br>Site web: www.lafermeaunaturel.com</div>';
		echo '<hr>';
		
		echo '<table class="bon-table"><tr><td>'.$row2['firstname'].' '.$row2['lastname'].'</td>
					<td>Telephone: '.$row2['phone'].'</td>
					<td>Client #: '.$row['formId'].'</td></tr>'.
				'<tr><td>'.$row2['firstname2'].' '.$row2['lastname2'].'</td>
					<td>Telephone 2: '.$row2['phone2'].'</td>
					<td>Commande #: 1</td></tr>'.
				'<tr><td>'.$row2['streetaddress1'].' '.$row2['streetaddress2'].'</td>
					<td></td>
					<td>'.$row['conditions_firstdeliverydate'].'</td></tr>'.
				'<tr><td>'.$row2['city'].', '.$row2['province'].' '.$row2['postalcode'].'</td>
					<td></td>
					<td></td></tr></table>';
		echo '<hr>';
	
		echo '<table style="font-size:small" class="table table-bordered">';
		echo '<thead><tr><th>Nom du produit</th><th>Emballage</th><th>Quantité</th></tr></thead>';
		
		$sqlOrd = "SELECT * FROM orders WHERE form_id=".$row["id"];
		$resultsOrd = $conn->query($sqlOrd);
			
		while ($rowOrd = $resultsOrd->fetch_assoc())
		{
			$sqlPtl = "SELECT * FROM products_details WHERE id=".$rowOrd['product_details_id']." LIMIT 1";
			$resultsPtl = $conn->query($sqlPtl);
			$rowPtl = $resultsPtl->fetch_assoc();
		
			$sqlPtl = "SELECT * FROM product_packaging WHERE id=".$rowPtl['packaging_id']." LIMIT 1";
			$resultsPtl2 = $conn->query($sqlPtl);
			$rowPtl2 = $resultsPtl2->fetch_assoc();
		
			$sqlPtl = "SELECT * FROM products WHERE id=".$rowPtl['product_id']." LIMIT 1";
			$resultsPtl3 = $conn->query($sqlPtl);
			$rowPtl3 = $resultsPtl3->fetch_assoc();
			echo "<tr>";
			echo "<td>".$rowPtl3["name_fr"]." ".$rowPtl3["name_en"]."</td>";
			echo "<td>".$rowPtl2["type"]." : ".$rowPtl2["quantity"]."</td>";
			echo "<td>".$rowOrd["quantity1"]."</td>";
			echo "</tr>";
		}
		echo '</table>';
		echo '<h4 style="text-align: center;">MERCI!!!</h4><hr><p style="text-align: center;">Pour de plus amples informations concernant ce bon de commande, veuillez communiquer au 613-800-2214</p>';
							
		echo '</div></div></div>';
		
		/******** SECOND DELIVER ********/
		echo '<div id="s'.$row['id'].'" class="modal hide">';
		echo '<div class="modal-header">';
		echo '<button data-dismiss="modal" class="close" type="button">×</button>';
		echo '<h3>Orders for: '.$row2['firstname'].' '.$row2['lastname'].' on '.$row['conditions_seconddeliverydate'].' (Second Delivery)</h3>';
		echo '<a href="#" onclick="changeView(\'pintAreal2'.$row["id"].'\', \'pintAreaf2'.$row["id"].'\')" title="Fournisseur"><i class="fa fa-podcast"></i> Fournisseur</a> |
				<a href="#" onclick="changeView(\'pintAreaf2'.$row["id"].'\', \'pintAreal2'.$row["id"].'\')" title="Livraison"><i class="fa fa-truck"></i> Livraison</a>
				<a style="float: right; margin-bottom: 10px" href="#" title="Print" onclick="printDiv(\'s'.$row['id'].'\')"><i class="fa fa-print"></i> Print</a></div>';
			
		// Fiche du fournisseur
		echo '<div class="modal-body open" id="pintAreaf2'.$row["id"].'">';
		echo '<style type="text/css" media="print">
			  				@page { size: landscape; }
						</style>';
		echo '<h4 style="float: left;">La Ferme au Naturel</h4><h5 style="float: right;">Bon de Commande Fournisseur</h5><div style="clear:both"></div><hr>';
		echo '<div style="float: left;">'.$row2['firstname'].' '.$row2['lastname'].'</div>';
		echo '<div style="float: right;"># Référence:'.$row['formId'].'<br>'.$row['conditions_firstdeliverydate'].'<br># Commande: 2<br><br></div>';
		echo '<table style="font-size:small" class="table table-bordered">';
		echo '<thead><tr><th>Nom du produit</th><th>Emballage</th><th>Quantité</th><th>Prix Unitaire</th><th>Prix Total</th></tr></thead>';
		
		$sqlOrd = "SELECT * FROM orders WHERE form_id=".$row["id"];
		$resultsOrd = $conn->query($sqlOrd);
		
		$total2 = 0;
			
		while ($rowOrd = $resultsOrd->fetch_assoc())
		{
			$sqlPtl = "SELECT * FROM products_details WHERE id=".$rowOrd['product_details_id']." LIMIT 1";
			$resultsPtl = $conn->query($sqlPtl);
			$rowPtl = $resultsPtl->fetch_assoc();
		
			$sqlPtl = "SELECT * FROM product_packaging WHERE id=".$rowPtl['packaging_id']." LIMIT 1";
			$resultsPtl2 = $conn->query($sqlPtl);
			$rowPtl2 = $resultsPtl2->fetch_assoc();
		
			$sqlPtl = "SELECT * FROM products WHERE id=".$rowPtl['product_id']." LIMIT 1";
			$resultsPtl3 = $conn->query($sqlPtl);
			$rowPtl3 = $resultsPtl3->fetch_assoc();
			
			$subtotal = (((int)$rowOrd["quantity1"])*((int)$rowPtl["purchase_price"]));
			$total2 = $total2 + $subtotal;
			
			echo "<tr>";
			echo "<td>".$rowPtl["code"]." - ".$rowPtl3["name_fr"]." ".$rowPtl3["name_en"]."</td>";
			echo "<td>".$rowPtl2["type"]." : ".$rowPtl2["quantity"]."</td>";
			echo "<td>".$rowOrd["quantity2"]."</td>";
			echo "<td>".$rowPtl["purchase_price"]."</td>";
			echo "<td>".$subtotal."</td>";
			echo "</tr>";
		}
		echo "<tr>";
		echo "<td colspan='2'><h5>Notes:$row[notice2]</h5></td>";
		echo "<td colspan='2'><b>Total de la Commande</b></td>";
		echo "<td><b>".$total2."</b></td>";
		echo "</tr>";
		echo '</table>';
		
		echo '</div>';
		
		// Fiche de livraison
		echo '<div class="modal-body open" style="display: none" id="pintAreal2'.$row["id"].'">';
		echo '<h4 style="float: left;">La Ferme au Naturel / Natural Farms</h4><h5 style="float: right;">Bon de Livraison</h5><div style="clear:both"></div>';
		echo '<div>2285-A10 Blvd St-Laurent<br>Ottawa (Ontario) k1G 4Z4<br>Tél: 613-800-2214<br>Courriel: admin@nffood.ca<br>Site web: www.lafermeaunaturel.com</div>';
		echo '<hr>';
		
		echo '<table class="bon-table"><tr><td>'.$row2['firstname'].' '.$row2['lastname'].'</td>
					<td>Telephone: '.$row2['phone'].'</td>
					<td>Client #: '.$row['formId'].'</td></tr>'.
						'<tr><td>'.$row2['firstname2'].' '.$row2['lastname2'].'</td>
					<td>Telephone 2: '.$row2['phone2'].'</td>
					<td>Commande #: 2</td></tr>'.
						'<tr><td>'.$row2['streetaddress1'].' '.$row2['streetaddress2'].'</td>
					<td></td>
					<td>'.$row['conditions_seconddeliverydate'].'</td></tr>'.
						'<tr><td>'.$row2['city'].', '.$row2['province'].' '.$row2['postalcode'].'</td>
					<td></td>
					<td></td></tr></table>';
		echo '<hr>';
		
		echo '<table style="font-size:small" class="table table-bordered">';
		echo '<thead><tr><th>Nom du produit</th><th>Emballage</th><th>Quantité</th></tr></thead>';
		
		$sqlOrd = "SELECT * FROM orders WHERE form_id=".$row["id"];
		$resultsOrd = $conn->query($sqlOrd);
		
		while ($rowOrd = $resultsOrd->fetch_assoc())
		{
			$sqlPtl = "SELECT * FROM products_details WHERE id=".$rowOrd['product_details_id']." LIMIT 1";
			$resultsPtl = $conn->query($sqlPtl);
			$rowPtl = $resultsPtl->fetch_assoc();
		
			$sqlPtl = "SELECT * FROM product_packaging WHERE id=".$rowPtl['packaging_id']." LIMIT 1";
			$resultsPtl2 = $conn->query($sqlPtl);
			$rowPtl2 = $resultsPtl2->fetch_assoc();
		
			$sqlPtl = "SELECT * FROM products WHERE id=".$rowPtl['product_id']." LIMIT 1";
			$resultsPtl3 = $conn->query($sqlPtl);
			$rowPtl3 = $resultsPtl3->fetch_assoc();
			echo "<tr>";
			echo "<td>".$rowPtl3["name_fr"]." ".$rowPtl3["name_en"]."</td>";
			echo "<td>".$rowPtl2["type"]." : ".$rowPtl2["quantity"]."</td>";
			echo "<td>".$rowOrd["quantity2"]."</td>";
			echo "</tr>";
		}
		echo '</table>';
		echo '<h4 style="text-align: center;">MERCI!!!</h4><hr><p style="text-align: center;">Pour de plus amples informations concernant ce bon de commande, veuillez communiquer au 613-800-2214</p>';
		
		echo '</div></div></div>';
		
		/******** THIRD DELIVER ********/
		echo '<div id="t'.$row['id'].'" class="modal hide">';
		echo '<div class="modal-header">';
		echo '<button data-dismiss="modal" class="close" type="button">×</button>';
		echo '<h3>Orders for: '.$row2['firstname'].' '.$row2['lastname'].' on '.$row['conditions_thirddeliverydate'].' (Third Delivery)</h3>';
		echo '<a href="#" onclick="changeView(\'pintAreal3'.$row["id"].'\', \'pintAreaf3'.$row["id"].'\')" title="Fournisseur"><i class="fa fa-podcast"></i> Fournisseur</a> |
				<a href="#" onclick="changeView(\'pintAreaf3'.$row["id"].'\', \'pintAreal3'.$row["id"].'\')" title="Livraison"><i class="fa fa-truck"></i> Livraison</a>
				<a style="float: right; margin-bottom: 10px" href="#" title="Print" onclick="printDiv(\'t'.$row['id'].'\')"><i class="fa fa-print"></i> Print</a></div>';
		
		// Fiche du fournisseur
		echo '<div class="modal-body open" id="pintAreaf3'.$row["id"].'">';
		echo '<style type="text/css" media="print">
			  				@page { size: landscape; }
						</style>';
		echo '<h4 style="float: left;">La Ferme au Naturel</h4><h5 style="float: right;">Bon de Commande Fournisseur</h5><div style="clear:both"></div><hr>';
		echo '<div style="float: left;">'.$row2['firstname'].' '.$row2['lastname'].'</div>';
		echo '<div style="float: right;"># Référence:'.$row['formId'].'<br>'.$row['conditions_thirddeliverydate'].'<br># Commande: 3<br><br></div>';
		echo '<table style="font-size:small" class="table table-bordered">';
		echo '<thead><tr><th>Nom du produit</th><th>Emballage</th><th>Quantité</th><th>Prix Unitaire</th><th>Prix Total</th></tr></thead>';
		
		$sqlOrd = "SELECT * FROM orders WHERE form_id=".$row["id"];
		$resultsOrd = $conn->query($sqlOrd);
		
		$total3 = 0;
		
		while ($rowOrd = $resultsOrd->fetch_assoc())
		{
			$sqlPtl = "SELECT * FROM products_details WHERE id=".$rowOrd['product_details_id']." LIMIT 1";
			$resultsPtl = $conn->query($sqlPtl);
			$rowPtl = $resultsPtl->fetch_assoc();
		
			$sqlPtl = "SELECT * FROM product_packaging WHERE id=".$rowPtl['packaging_id']." LIMIT 1";
			$resultsPtl2 = $conn->query($sqlPtl);
			$rowPtl2 = $resultsPtl2->fetch_assoc();
		
			$sqlPtl = "SELECT * FROM products WHERE id=".$rowPtl['product_id']." LIMIT 1";
			$resultsPtl3 = $conn->query($sqlPtl);
			$rowPtl3 = $resultsPtl3->fetch_assoc();
			
			$subtotal = (((int)$rowOrd["quantity1"])*((int)$rowPtl["purchase_price"]));
			$total3 = $total3 + $subtotal;
			
			echo "<tr>";
			echo "<td>".$rowPtl["code"]." - ".$rowPtl3["name_fr"]." ".$rowPtl3["name_en"]."</td>";
			echo "<td>".$rowPtl2["type"]." : ".$rowPtl2["quantity"]."</td>";
			echo "<td>".$rowOrd["quantity3"]."</td>";
			echo "<td>".$rowPtl["purchase_price"]."</td>";
			echo "<td>".$subtotal."</td>";
			echo "</tr>";
		}
		echo "<tr>";
		echo "<td colspan='2'><h5>Notes:$row[notice2]</h5></td>";
		echo "<td colspan='2'><b>Total de la Commande</b></td>";
		echo "<td><b>".$total3."</b></td>";
		echo "</tr>";
		echo '</table>';
		
		echo '</div>';
		
		// Fiche de livraison
		echo '<div class="modal-body open" style="display: none" id="pintAreal3'.$row["id"].'">';
		echo '<h4 style="float: left;">La Ferme au Naturel / Natural Farms</h4><h5 style="float: right;">Bon de Livraison</h5><div style="clear:both"></div>';
		echo '<div>2285-A10 Blvd St-Laurent<br>Ottawa (Ontario) k1G 4Z4<br>Tél: 613-800-2214<br>Courriel: admin@nffood.ca<br>Site web: www.lafermeaunaturel.com</div>';
		echo '<hr>';
		
		echo '<table class="bon-table"><tr><td>'.$row2['firstname'].' '.$row2['lastname'].'</td>
					<td>Telephone: '.$row2['phone'].'</td>
					<td>Client #: '.$row['formId'].'</td></tr>'.
						'<tr><td>'.$row2['firstname2'].' '.$row2['lastname2'].'</td>
					<td>Telephone 2: '.$row2['phone2'].'</td>
					<td>Commande #: 3</td></tr>'.
						'<tr><td>'.$row2['streetaddress1'].' '.$row2['streetaddress2'].'</td>
					<td></td>
					<td>'.$row['conditions_thirddeliverydate'].'</td></tr>'.
						'<tr><td>'.$row2['city'].', '.$row2['province'].' '.$row2['postalcode'].'</td>
					<td></td>
					<td></td></tr></table>';
		echo '<hr>';
		
		echo '<table style="font-size:small" class="table table-bordered">';
		echo '<thead><tr><th>Nom du produit</th><th>Emballage</th><th>Quantité</th></tr></thead>';
		
		$sqlOrd = "SELECT * FROM orders WHERE form_id=".$row["id"];
		$resultsOrd = $conn->query($sqlOrd);
		
		while ($rowOrd = $resultsOrd->fetch_assoc())
		{
			$sqlPtl = "SELECT * FROM products_details WHERE id=".$rowOrd['product_details_id']." LIMIT 1";
			$resultsPtl = $conn->query($sqlPtl);
			$rowPtl = $resultsPtl->fetch_assoc();
		
			$sqlPtl = "SELECT * FROM product_packaging WHERE id=".$rowPtl['packaging_id']." LIMIT 1";
			$resultsPtl2 = $conn->query($sqlPtl);
			$rowPtl2 = $resultsPtl2->fetch_assoc();
		
			$sqlPtl = "SELECT * FROM products WHERE id=".$rowPtl['product_id']." LIMIT 1";
			$resultsPtl3 = $conn->query($sqlPtl);
			$rowPtl3 = $resultsPtl3->fetch_assoc();
			echo "<tr>";
			echo "<td>".$rowPtl3["name_fr"]." ".$rowPtl3["name_en"]."</td>";
			echo "<td>".$rowPtl2["type"]." : ".$rowPtl2["quantity"]."</td>";
			echo "<td>".$rowOrd["quantity3"]."</td>";
			echo "</tr>";
		}
		echo '</table>';
		echo '<h4 style="text-align: center;">MERCI!!!</h4><hr><p style="text-align: center;">Pour de plus amples informations concernant ce bon de commande, veuillez communiquer au 613-800-2214</p>';
		
		echo '</div></div></div>';
	}
	
	function generateMap($date, $conn) {
	
		echo '<div id="map'.str_replace("-", "", $date).'" class="modal hide">';
		echo '<div class="modal-header">';
		echo '<button data-dismiss="modal" class="close" type="button">×</button>';
		echo '<h3>Map View for '.$date.'</h3>';
	
		echo '<div class="modal-body">';
		$sql = "SELECT * FROM form_completion WHERE conditions_firstdeliverydate='$date'";
		$result = $conn->query($sql);
		
		while ($row = $result->fetch_assoc())
		{
			$sql2 = "SELECT * FROM customer WHERE id=".$row['customer_id']." LIMIT 1";
			$result2 = $conn->query($sql2);
			$row2 = $result2->fetch_assoc();
		
			if($row2['isactive'] == '0')
			{
				continue;
			}
		
			$nextdate = $row['conditions_firstdeliverydate'];
			$delivery = 1;
			if(strtotime($nextdate) < strtotime('now') ) {
				$nextdate = $row['conditions_seconddeliverydate'];
				$delivery = 2;
			}
			if(strtotime($nextdate) < strtotime('now') ) {
				$nextdate = $row['conditions_thirddeliverydate'];
				$delivery = 3;
			}
			// Get lat and long by address
			//$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$row2['postalcode']);
		
			$curlSession = curl_init();
			curl_setopt($curlSession, CURLOPT_URL, 'http://maps.googleapis.com/maps/api/geocode/json?address='.$row2['postalcode']);
			curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
			curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
		
			$output = json_decode(curl_exec($curlSession));
			curl_close($curlSession);
		
			$output= json_decode($geocode);
			$latitude = $output->results[0]->geometry->location->lat;
			$longitude = $output->results[0]->geometry->location->lng;
		
		
			$customer = new Customer();
			array_push($customers, [$row2['firstname'].$row2['lastname'], $nextdate, $delivery, $row2['postalcode']]);
		}
		
		$jsonVal = json_encode($customers);
		?>
		<div class="maparea"></div>
		<script>
		var jsonVal = '<?= $jsonVal;?>';
		var parsed = JSON.parse(jsonVal);
		</script>
	<?php
		echo '</div></div>';
	}
	
	function generateSummary($date, $conn) {
	
		echo '<div id="cf'.str_replace("-", "", $date).'" class="modal hide">';
		echo '<div class="modal-header">';
		echo '<button data-dismiss="modal" class="close" type="button">×</button>';
		echo '<h3>Order Summary for '.$date.'</h3>';
		echo '<a href="#" onclick="changeView(\'pintAreacl1'.$date.'\', \'pintAreacf1'.$date.'\')" title="Fournisseur"><i class="fa fa-podcast"></i> Fournisseur</a> |
				<a href="#" onclick="changeView(\'pintAreacf1'.$date.'\', \'pintAreacl1'.$date.'\')" title="Livraison"><i class="fa fa-truck"></i> Livraison</a>
				<a style="float: right; margin-bottom: 10px" href="#" title="Print" onclick="printDiv(\'cf'.str_replace("-", "", $date).'\')"><i class="fa fa-print"></i> Print</a></div>';
	
		$summary  = '<div class="landscape"><h4>Order Summary</h4>
					<table style="font-size:small" class="table table-bordered">';
		$summary .= '<thead><tr><th>Nom du client</th><th>Prix Total</th><th># Commande</th></tr></thead>';
		$summaryAmt = 0;
		// Fiche du fournisseur
		echo '<div class="modal-body open" id="pintAreacf1'.$date.'">';
		echo '<style type="text/css" media="print">
			  				@page { size: landscape; }
						</style>';
		$sql = "SELECT * FROM form_completion WHERE conditions_firstdeliverydate='$date'";
		$result = $conn->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$sql2 = "SELECT * FROM customer WHERE id=".$row['customer_id']." LIMIT 1";
			$result2 = $conn->query($sql2);
			$row2 = $result2->fetch_assoc();
	
			if($row2['isactive'] == '0')
			{
				continue;
			}
			echo '<div class="landscape">';
			echo '<h4>First Delivery</h4>';
			echo '<h4 style="float: left;">La Ferme au Naturel</h4><h5 style="float: right;">Bon de Commande Fournisseur</h5><div style="clear:both"></div><hr>';
			echo '<div style="float: left;">'.$row2['firstname'].' '.$row2['lastname'].'</div>';
			echo '<div style="float: right;"># Référence:'.$row['formId'].'<br>'.$row['conditions_firstdeliverydate'].'<br># Commande: 1<br><br></div>';
			echo '<table style="font-size:small" class="table table-bordered">';
			echo '<thead><tr><th>Nom du produit</th><th>Emballage</th><th>Quantité</th><th>Prix Unitaire</th><th>Prix Total</th></tr></thead>';
	
			$sqlOrd = "SELECT * FROM orders WHERE form_id=".$row["id"];
			$resultsOrd = $conn->query($sqlOrd);
				
			$total1 = 0;
				
			while ($rowOrd = $resultsOrd->fetch_assoc())
			{
				$sqlPtl = "SELECT * FROM products_details WHERE id=".$rowOrd['product_details_id']." LIMIT 1";
				$resultsPtl = $conn->query($sqlPtl);
				$rowPtl = $resultsPtl->fetch_assoc();
	
				$sqlPtl = "SELECT * FROM product_packaging WHERE id=".$rowPtl['packaging_id']." LIMIT 1";
				$resultsPtl2 = $conn->query($sqlPtl);
				$rowPtl2 = $resultsPtl2->fetch_assoc();
	
				$sqlPtl = "SELECT * FROM products WHERE id=".$rowPtl['product_id']." LIMIT 1";
				$resultsPtl3 = $conn->query($sqlPtl);
				$rowPtl3 = $resultsPtl3->fetch_assoc();
	
				$subtotal = (((int)$rowOrd["quantity1"])*((int)$rowPtl["purchase_price"]));
				$total1 = $total1 + $subtotal;
	
				echo "<tr>";
				echo "<td>".$rowPtl["code"]." - ".$rowPtl3["name_fr"]." ".$rowPtl3["name_en"]."</td>";
				echo "<td>".$rowPtl2["type"]." : ".$rowPtl2["quantity"]."</td>";
				echo "<td>".$rowOrd["quantity1"]."</td>";
				echo "<td>".$rowPtl["purchase_price"]."</td>";
				echo "<td>".$subtotal."</td>";
				echo "</tr>";
			}
			echo "<tr>";
			echo "<td colspan='2'><h5>Notes:$row[notice2]</h5></td>";
			echo "<td colspan='2'><b>Total de la Commande</b></td>";
			echo "<td><b>".$total1."</b></td>";
			echo "</tr>";
			echo '</table><hr><hr>';
			echo '</div>';
			
			$summary .= '<tr><td>'.$row2['firstname'].' '.$row2['lastname'].'</td>';
			$summary .= '<td>'.$total1.'</td>';
			$summary .= '<td>#1</td></tr>';
			$summaryAmt = $summaryAmt + (int)$total1;
		}
		
		$sql = "SELECT * FROM form_completion WHERE conditions_seconddeliverydate='$date'";
		$result = $conn->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$sql2 = "SELECT * FROM customer WHERE id=".$row['customer_id']." LIMIT 1";
			$result2 = $conn->query($sql2);
			$row2 = $result2->fetch_assoc();
		
			if($row2['isactive'] == '0')
			{
				continue;
			}
			echo '<div class="landscape">';
		
			echo '<h4>Second Delivery</h4>';
			echo '<h4 style="float: left;">La Ferme au Naturel</h4><h5 style="float: right;">Bon de Commande Fournisseur</h5><div style="clear:both"></div><hr>';
			echo '<div style="float: left;">'.$row2['firstname'].' '.$row2['lastname'].'</div>';
			echo '<div style="float: right;"># Référence:'.$row['formId'].'<br>'.$row['conditions_firstdeliverydate'].'<br># Commande: 1<br><br></div>';
			echo '<table style="font-size:small" class="table table-bordered">';
			echo '<thead><tr><th>Nom du produit</th><th>Emballage</th><th>Quantité</th><th>Prix Unitaire</th><th>Prix Total</th></tr></thead>';
		
			$sqlOrd = "SELECT * FROM orders WHERE form_id=".$row["id"];
			$resultsOrd = $conn->query($sqlOrd);
		
			$total1 = 0;
		
			while ($rowOrd = $resultsOrd->fetch_assoc())
			{
				$sqlPtl = "SELECT * FROM products_details WHERE id=".$rowOrd['product_details_id']." LIMIT 1";
				$resultsPtl = $conn->query($sqlPtl);
				$rowPtl = $resultsPtl->fetch_assoc();
		
				$sqlPtl = "SELECT * FROM product_packaging WHERE id=".$rowPtl['packaging_id']." LIMIT 1";
				$resultsPtl2 = $conn->query($sqlPtl);
				$rowPtl2 = $resultsPtl2->fetch_assoc();
		
				$sqlPtl = "SELECT * FROM products WHERE id=".$rowPtl['product_id']." LIMIT 1";
				$resultsPtl3 = $conn->query($sqlPtl);
				$rowPtl3 = $resultsPtl3->fetch_assoc();
		
				$subtotal = (((int)$rowOrd["quantity1"])*((int)$rowPtl["purchase_price"]));
				$total1 = $total1 + $subtotal;
		
				echo "<tr>";
				echo "<td>".$rowPtl["code"]." - ".$rowPtl3["name_fr"]." ".$rowPtl3["name_en"]."</td>";
				echo "<td>".$rowPtl2["type"]." : ".$rowPtl2["quantity"]."</td>";
				echo "<td>".$rowOrd["quantity1"]."</td>";
				echo "<td>".$rowPtl["purchase_price"]."</td>";
				echo "<td>".$subtotal."</td>";
				echo "</tr>";
			}
			echo "<tr>";
			echo "<td colspan='2'><h5>Notes:$row[notice2]</h5></td>";
			echo "<td colspan='2'><b>Total de la Commande</b></td>";
			echo "<td><b>".$total1."</b></td>";
			echo "</tr>";
			echo '</table><hr><hr>';
			echo '</div>';
			
			$summary .= '<tr><td>'.$row2['firstname'].' '.$row2['lastname'].'</td>';
			$summary .= '<td>'.$total1.'</td>';
			$summary .= '<td>#2</td></tr>';
			$summaryAmt = $summaryAmt + (int)$total1;
		}
		
		$sql = "SELECT * FROM form_completion WHERE conditions_thirddeliverydate='$date'";
		$result = $conn->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$sql2 = "SELECT * FROM customer WHERE id=".$row['customer_id']." LIMIT 1";
			$result2 = $conn->query($sql2);
			$row2 = $result2->fetch_assoc();
		
			if($row2['isactive'] == '0')
			{
				continue;
			}
		
			echo '<div class="landscape">';
			echo '<h4>Third Delivery</h4>';
			echo '<h4 style="float: left;">La Ferme au Naturel</h4><h5 style="float: right;">Bon de Commande Fournisseur</h5><div style="clear:both"></div><hr>';
			echo '<div style="float: left;">'.$row2['firstname'].' '.$row2['lastname'].'</div>';
			echo '<div style="float: right;"># Référence:'.$row['formId'].'<br>'.$row['conditions_firstdeliverydate'].'<br># Commande: 1<br><br></div>';
			echo '<table style="font-size:small" class="table table-bordered">';
			echo '<thead><tr><th>Nom du produit</th><th>Emballage</th><th>Quantité</th><th>Prix Unitaire</th><th>Prix Total</th></tr></thead>';
		
			$sqlOrd = "SELECT * FROM orders WHERE form_id=".$row["id"];
			$resultsOrd = $conn->query($sqlOrd);
		
			$total1 = 0;
		
			while ($rowOrd = $resultsOrd->fetch_assoc())
			{
				$sqlPtl = "SELECT * FROM products_details WHERE id=".$rowOrd['product_details_id']." LIMIT 1";
				$resultsPtl = $conn->query($sqlPtl);
				$rowPtl = $resultsPtl->fetch_assoc();
		
				$sqlPtl = "SELECT * FROM product_packaging WHERE id=".$rowPtl['packaging_id']." LIMIT 1";
				$resultsPtl2 = $conn->query($sqlPtl);
				$rowPtl2 = $resultsPtl2->fetch_assoc();
		
				$sqlPtl = "SELECT * FROM products WHERE id=".$rowPtl['product_id']." LIMIT 1";
				$resultsPtl3 = $conn->query($sqlPtl);
				$rowPtl3 = $resultsPtl3->fetch_assoc();
		
				$subtotal = (((int)$rowOrd["quantity1"])*((int)$rowPtl["purchase_price"]));
				$total1 = $total1 + $subtotal;
		
				echo "<tr>";
				echo "<td>".$rowPtl["code"]." - ".$rowPtl3["name_fr"]." ".$rowPtl3["name_en"]."</td>";
				echo "<td>".$rowPtl2["type"]." : ".$rowPtl2["quantity"]."</td>";
				echo "<td>".$rowOrd["quantity1"]."</td>";
				echo "<td>".$rowPtl["purchase_price"]."</td>";
				echo "<td>".$subtotal."</td>";
				echo "</tr>";
			}
			echo "<tr>";
			echo "<td colspan='2'><h5>Notes:$row[notice2]</h5></td>";
			echo "<td colspan='2'><b>Total de la Commande</b></td>";
			echo "<td><b>".$total1."</b></td>";
			echo "</tr>";
			echo '</table><hr><hr>';
			echo '</div>';
			$summary .= '<tr><td>'.$row2['firstname'].' '.$row2['lastname'].'</td>';
			$summary .= '<td>'.$total1.'</td>';
			$summary .= '<td>#1</td></tr>';
			$summaryAmt = $summaryAmt + (int)$total1;
		}
		$summary .= '<tr><th>TOTAL</th><th>'.$summaryAmt.'</th><th></th></table></div>';
		echo $summary;
		echo '</div>';
	
		// Fiche de livraison
		echo '<div class="modal-body open hide" id="pintAreacl1'.$date.'">';
		
		$sql = "SELECT * FROM form_completion WHERE conditions_firstdeliverydate='$date'";
		$result = $conn->query($sql);
	
		while ($row = $result->fetch_assoc())
		{
			$sql2 = "SELECT * FROM customer WHERE id=".$row['customer_id']." LIMIT 1";
			$result2 = $conn->query($sql2);
			$row2 = $result2->fetch_assoc();
	
			if($row2['isactive'] == '0')
			{
				continue;
			}
			echo '<div class="printable">';
			echo '<h4 style="float: left;">La Ferme au Naturel / Natural Farms</h4><h5 style="float: right;">Bon de Livraison</h5><div style="clear:both"></div>';
			echo '<div>2285-A10 Blvd St-Laurent<br>Ottawa (Ontario) k1G 4Z4<br>Tél: 613-800-2214<br>Courriel: admin@nffood.ca<br>Site web: www.lafermeaunaturel.com</div>';
			echo '<hr>';
	
			echo '<table class="bon-table"><tr><td>'.$row2['firstname'].' '.$row2['lastname'].'</td>
						<td>Telephone: '.$row2['phone'].'</td>
						<td>Client #: '.$row['formId'].'</td></tr>'.
						'<tr><td>'.$row2['firstname2'].' '.$row2['lastname2'].'</td>
						<td>Telephone 2: '.$row2['phone2'].'</td>
						<td>Commande #: 1</td></tr>'.
						'<tr><td>'.$row2['streetaddress1'].' '.$row2['streetaddress2'].'</td>
						<td></td>
						<td>'.$row['conditions_firstdeliverydate'].'</td></tr>'.
						'<tr><td>'.$row2['city'].', '.$row2['province'].' '.$row2['postalcode'].'</td>
						<td></td>
						<td></td></tr></table>';
			echo '<hr>';
	
			echo '<table style="font-size:small" class="table table-bordered">';
			echo '<thead><tr><th>Nom du produit</th><th>Emballage</th><th>Quantité</th></tr></thead>';
	
			$sqlOrd = "SELECT * FROM orders WHERE form_id=".$row["id"];
			$resultsOrd = $conn->query($sqlOrd);
	
			while ($rowOrd = $resultsOrd->fetch_assoc())
			{
				$sqlPtl = "SELECT * FROM products_details WHERE id=".$rowOrd['product_details_id']." LIMIT 1";
				$resultsPtl = $conn->query($sqlPtl);
				$rowPtl = $resultsPtl->fetch_assoc();
	
				$sqlPtl = "SELECT * FROM product_packaging WHERE id=".$rowPtl['packaging_id']." LIMIT 1";
				$resultsPtl2 = $conn->query($sqlPtl);
				$rowPtl2 = $resultsPtl2->fetch_assoc();
	
				$sqlPtl = "SELECT * FROM products WHERE id=".$rowPtl['product_id']." LIMIT 1";
				$resultsPtl3 = $conn->query($sqlPtl);
				$rowPtl3 = $resultsPtl3->fetch_assoc();
				echo "<tr>";
				echo "<td>".$rowPtl3["name_fr"]." ".$rowPtl3["name_en"]."</td>";
				echo "<td>".$rowPtl2["type"]." : ".$rowPtl2["quantity"]."</td>";
				echo "<td>".$rowOrd["quantity1"]."</td>";
				echo "</tr>";
			}
			echo '</table>';
			echo '<h4 style="text-align: center;">MERCI!!!</h4><hr><p style="text-align: center;">Pour de plus amples informations concernant ce bon de commande, veuillez communiquer au 613-800-2214</p>';
	
			echo '<hr><hr>';
			echo '</div>';
		}
		
		//2
		$sql = "SELECT * FROM form_completion WHERE conditions_seconddeliverydate='$date'";
		$result = $conn->query($sql);
		
		while ($row = $result->fetch_assoc())
		{
			$sql2 = "SELECT * FROM customer WHERE id=".$row['customer_id']." LIMIT 1";
			$result2 = $conn->query($sql2);
			$row2 = $result2->fetch_assoc();
		
			if($row2['isactive'] == '0')
			{
				continue;
			}
			echo '<div class="printable">';
			echo '<h4 style="float: left;">La Ferme au Naturel / Natural Farms</h4><h5 style="float: right;">Bon de Livraison</h5><div style="clear:both"></div>';
			echo '<div>2285-A10 Blvd St-Laurent<br>Ottawa (Ontario) k1G 4Z4<br>Tél: 613-800-2214<br>Courriel: admin@nffood.ca<br>Site web: www.lafermeaunaturel.com</div>';
			echo '<hr>';
			
			echo '<table class="bon-table"><tr><td>'.$row2['firstname'].' '.$row2['lastname'].'</td>
						<td>Telephone: '.$row2['phone'].'</td>
						<td>Client #: '.$row['formId'].'</td></tr>'.
								'<tr><td>'.$row2['firstname2'].' '.$row2['lastname2'].'</td>
						<td>Telephone 2: '.$row2['phone2'].'</td>
						<td>Commande #: 2</td></tr>'.
								'<tr><td>'.$row2['streetaddress1'].' '.$row2['streetaddress2'].'</td>
						<td></td>
						<td>'.$row['conditions_seconddeliverydate'].'</td></tr>'.
								'<tr><td>'.$row2['city'].', '.$row2['province'].' '.$row2['postalcode'].'</td>
						<td></td>
						<td></td></tr></table>';
			echo '<hr>';
		
			echo '<table style="font-size:small" class="table table-bordered">';
			echo '<thead><tr><th>Nom du produit</th><th>Emballage</th><th>Quantité</th></tr></thead>';
		
			$sqlOrd = "SELECT * FROM orders WHERE form_id=".$row["id"];
			$resultsOrd = $conn->query($sqlOrd);
		
			while ($rowOrd = $resultsOrd->fetch_assoc())
			{
				$sqlPtl = "SELECT * FROM products_details WHERE id=".$rowOrd['product_details_id']." LIMIT 1";
				$resultsPtl = $conn->query($sqlPtl);
				$rowPtl = $resultsPtl->fetch_assoc();
		
				$sqlPtl = "SELECT * FROM product_packaging WHERE id=".$rowPtl['packaging_id']." LIMIT 1";
				$resultsPtl2 = $conn->query($sqlPtl);
				$rowPtl2 = $resultsPtl2->fetch_assoc();
		
				$sqlPtl = "SELECT * FROM products WHERE id=".$rowPtl['product_id']." LIMIT 1";
				$resultsPtl3 = $conn->query($sqlPtl);
				$rowPtl3 = $resultsPtl3->fetch_assoc();
				echo "<tr>";
				echo "<td>".$rowPtl3["name_fr"]." ".$rowPtl3["name_en"]."</td>";
				echo "<td>".$rowPtl2["type"]." : ".$rowPtl2["quantity"]."</td>";
				echo "<td>".$rowOrd["quantity2"]."</td>";
				echo "</tr>";
			}
			echo '</table>';
			echo '<h4 style="text-align: center;">MERCI!!!</h4><hr><p style="text-align: center;">Pour de plus amples informations concernant ce bon de commande, veuillez communiquer au 613-800-2214</p>';
		
			echo '<hr><hr>';
			echo '</div>';
		}
		
		//3
		$sql = "SELECT * FROM form_completion WHERE conditions_thirddeliverydate='$date'";
		$result = $conn->query($sql);
		
		while ($row = $result->fetch_assoc())
		{
			$sql2 = "SELECT * FROM customer WHERE id=".$row['customer_id']." LIMIT 1";
			$result2 = $conn->query($sql2);
			$row2 = $result2->fetch_assoc();
		
			if($row2['isactive'] == '0')
			{
				continue;
			}
			echo '<div class="printable">';
			echo '<h4 style="float: left;">La Ferme au Naturel / Natural Farms</h4><h5 style="float: right;">Bon de Livraison</h5><div style="clear:both"></div>';
			echo '<div>2285-A10 Blvd St-Laurent<br>Ottawa (Ontario) k1G 4Z4<br>Tél: 613-800-2214<br>Courriel: admin@nffood.ca<br>Site web: www.lafermeaunaturel.com</div>';
			echo '<hr>';
		
			echo '<table class="bon-table"><tr><td>'.$row2['firstname'].' '.$row2['lastname'].'</td>
						<td>Telephone: '.$row2['phone'].'</td>
						<td>Client #: '.$row['formId'].'</td></tr>'.
								'<tr><td>'.$row2['firstname2'].' '.$row2['lastname2'].'</td>
						<td>Telephone 2: '.$row2['phone2'].'</td>
						<td>Commande #: 3</td></tr>'.
								'<tr><td>'.$row2['streetaddress1'].' '.$row2['streetaddress2'].'</td>
						<td></td>
						<td>'.$row['conditions_thirddeliverydate'].'</td></tr>'.
								'<tr><td>'.$row2['city'].', '.$row2['province'].' '.$row2['postalcode'].'</td>
						<td></td>
						<td></td></tr></table>';
			echo '<hr>';
		
			echo '<table style="font-size:small" class="table table-bordered">';
			echo '<thead><tr><th>Nom du produit</th><th>Emballage</th><th>Quantité</th></tr></thead>';
		
			$sqlOrd = "SELECT * FROM orders WHERE form_id=".$row["id"];
			$resultsOrd = $conn->query($sqlOrd);
		
			while ($rowOrd = $resultsOrd->fetch_assoc())
			{
				$sqlPtl = "SELECT * FROM products_details WHERE id=".$rowOrd['product_details_id']." LIMIT 1";
				$resultsPtl = $conn->query($sqlPtl);
				$rowPtl = $resultsPtl->fetch_assoc();
		
				$sqlPtl = "SELECT * FROM product_packaging WHERE id=".$rowPtl['packaging_id']." LIMIT 1";
				$resultsPtl2 = $conn->query($sqlPtl);
				$rowPtl2 = $resultsPtl2->fetch_assoc();
		
				$sqlPtl = "SELECT * FROM products WHERE id=".$rowPtl['product_id']." LIMIT 1";
				$resultsPtl3 = $conn->query($sqlPtl);
				$rowPtl3 = $resultsPtl3->fetch_assoc();
				echo "<tr>";
				echo "<td>".$rowPtl3["name_fr"]." ".$rowPtl3["name_en"]."</td>";
				echo "<td>".$rowPtl2["type"]." : ".$rowPtl2["quantity"]."</td>";
				echo "<td>".$rowOrd["quantity3"]."</td>";
				echo "</tr>";
			}
			echo '</table>';
			echo '<h4 style="text-align: center;">MERCI!!!</h4><hr><p style="text-align: center;">Pour de plus amples informations concernant ce bon de commande, veuillez communiquer au 613-800-2214</p>';
		
			echo '<hr><hr>';
			echo '</div>';
		}
	
		echo '</div></div>';
	}
	
	/******** FIRST DELIVERY ********/
	foreach ($delivery1 as $date)
	{
		generateSummary($date, $conn);
	}
	
	/******** SECOND DELIVERY ********/
	foreach ($delivery2 as $date)
	{
		generateSummary($date, $conn);
	}
	
	/******** THIRD DELIVERY ********/
	foreach ($delivery3 as $date)
	{
		generateSummary($date, $conn);
	}
}
?>
<!-- footer -->
<?php
include 'inc/footer.php';
?>
