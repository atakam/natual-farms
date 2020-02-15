<?php
include 'inc/header.php';
?>
<title>Orders</title>

<!-- Sidebar -->
<?php
if ($customer_flag=='0') {
include 'inc/menu.php';

include 'commonMap.php';
?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="#" class="current">Orders</a> 
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box widget-calendar">
          <div class="widget-title"> <span class="icon"><i class="icon-calendar"></i></span>
            <h5>Calendar: Calendar View</h5>
            <div class="buttons"> 
		      <a href="orders.php" class="btn btn-inverse btn-mini"><i class="icon-th-list icon-white"></i> List View</a>
		  </div>
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
$sql = "SELECT * FROM form_completion";
$result = $conn->query($sql);

$delivery1 = array();
$delivery2 = array();
$delivery3 = array();
$deliveryMonths = array();

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
		if ($row['confirm1'] == '1') {
			array_push($delivery1, $row['conditions_firstdeliverydate']);
		}
	}
	if (!in_array($row['conditions_seconddeliverydate'], $delivery2))
	{
		if ($row['confirm2'] == '1') {
			array_push($delivery2, $row['conditions_seconddeliverydate']);
		}
	}
	if (!in_array($row['conditions_thirddeliverydate'], $delivery3))
	{
		if ($row['confirm3'] == '1') {
			array_push($delivery3, $row['conditions_thirddeliverydate']);
		}
	}
	
	// For monthly map view
	$month1 = explode("-", $row['conditions_firstdeliverydate'])[0] ."-". explode("-", $row['conditions_firstdeliverydate'])[1];
	$month2 = explode("-", $row['conditions_seconddeliverydate'])[0] ."-". explode("-", $row['conditions_seconddeliverydate'])[1];
	$month3 = explode("-", $row['conditions_thirddeliverydate'])[0] ."-". explode("-", $row['conditions_thirddeliverydate'])[1];
	if (!in_array($month1, $deliveryMonths))
	{
		array_push($deliveryMonths, $month1);
	}
	if (!in_array($month2, $deliveryMonths))
	{
		array_push($deliveryMonths, $month2);
	}
	if (!in_array($month3, $deliveryMonths))
	{
		array_push($deliveryMonths, $month3);
	}
	
	if ($delivery_flag == '1' || $supplier_flag == '1') {
		if ($row['confirm1'] == '1' && $row['deliver1'] == 0) {
			echo 'addEventToCalendar("1 - '.$name.'", "'.$date.'", "#f'.$row['id'].'", "#62c462");';
		}if ($row['confirm2'] == '1' && $row['deliver2'] == 0) {
			echo 'addEventToCalendar("2 - '.$name.'", "'.$date2.'", "#s'.$row['id'].'", "#fb7a2c");';
		}if ($row['confirm3'] == '1' && $row['deliver3'] == 0) {
			echo 'addEventToCalendar("3 - '.$name.'", "'.$date3.'", "#t'.$row['id'].'", "#ee5f5b");';
		}
	}
	else {
		if ($row['deliver1'] == 0) {
			echo 'addEventToCalendar("1 - '.$name.'", "'.$date.'", "#f'.$row['id'].'", "#62c462");';
		}
		if ($row['deliver2'] == 0) {
			echo 'addEventToCalendar("2 - '.$name.'", "'.$date2.'", "#s'.$row['id'].'", "#fb7a2c");';
		}
		if ($row['deliver3'] == 0) {
			echo 'addEventToCalendar("3 - '.$name.'", "'.$date3.'", "#t'.$row['id'].'", "#ee5f5b");';
		}
	}
	
}
echo '});';
echo '</script>';
}
else {
	header("Location: customer_orders.php");
}

if ($admin_flag == '1' || $delivery_flag == '1' || $supplier_flag == '1') {
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
		if (($delivery_flag == '1' || $supplier_flag == '1')&&$row['confirm1'] == '1') {
			echo '<div id="f'.$row['id'].'" class="modal hide">';
				echo '<div class="modal-header">';
	            echo '<button data-dismiss="modal" class="close" type="button">×</button>';
	            echo '<h3>Orders for: '.$row2['firstname'].' '.$row2['lastname'].' on '.$row['conditions_firstdeliverydate'].' (First Delivery)</h3>';
	            echo '<a style="float: right; margin-bottom: 10px" href="#" title="Print" onclick="printDiv(\'f'.$row['id'].'\')"><i class="fa fa-print"></i> Print</a></div>';
	            // Fiche du fournisseur
	            if ($supplier_flag == '1') {
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
					if ($row['edited_status']==1){
						$sqlOrd = "SELECT * FROM orders_updates WHERE form_id=".$row["id"];
					}
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
						
						$subtotal = (((float)$rowOrd["quantity1"])*((float)$rowPtl["purchase_price"]));
						$subtotal = number_format((float)$subtotal, 2, '.', '');
						$total1 = $total1 + $subtotal;
						$total1 = number_format((float)$total1, 2, '.', '');
						
						echo "<tr>";
						echo "<td>".$rowPtl["code"]." - ".$rowPtl3["name_fr"]." ".$rowPtl3["name_en"]."</td>";
						echo "<td>".$rowPtl2["type"]." : ".$rowPtl2["quantity"]."</td>";
						echo "<td>".$rowOrd["quantity1"]."</td>";
						echo "<td>".$rowPtl["purchase_price"]." $</td>";
						echo "<td>".$subtotal." $</td>";
						echo "</tr>";
					}
					echo "<tr>";
					echo "<td colspan='2'><h5>Notes:$row[notice2]</h5></td>";
					echo "<td colspan='2'><b>Total de la Commande</b></td>";
					echo "<td><b>".$total1." $</b></td>";
					echo "</tr>";
					echo '</table>';
					
					echo '</div>';
	            }
			
				// Fiche de livraison
	            if ($delivery_flag == '1') {
					echo '<div class="modal-body open"  id="pintAreal1'.$row["id"].'">';
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
					if ($row['edited_status']==1){
						$sqlOrd = "SELECT * FROM orders_updates WHERE form_id=".$row["id"];
					}
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
										
					echo '</div>';
				}
					
				echo '</div>';
			}
			
			
			/******** SECOND DELIVER ********/
			if (($delivery_flag == '1' || $supplier_flag == '1')&&$row['confirm2'] == '1') {
				echo '<div id="s'.$row['id'].'" class="modal hide">';
				echo '<div class="modal-header">';
				echo '<button data-dismiss="modal" class="close" type="button">×</button>';
				echo '<h3>Orders for: '.$row2['firstname'].' '.$row2['lastname'].' on '.$row['conditions_seconddeliverydate'].' (Second Delivery)</h3>';
				
				if ($delivery_flag == 0 && $supplier_flag == 0) {
					echo '<a href="#" onclick="changeView(\'pintAreal2'.$row["id"].'\', \'pintAreaf2'.$row["id"].'\')" title="Fournisseur"><i class="fa fa-podcast"></i> Fournisseur</a> |
							<a href="#" onclick="changeView(\'pintAreaf2'.$row["id"].'\', \'pintAreal2'.$row["id"].'\')" title="Livraison"><i class="fa fa-truck"></i> Livraison</a>';
				}
				echo '<a style="float: right; margin-bottom: 10px" href="#" title="Print" onclick="printDiv(\'s'.$row['id'].'\')"><i class="fa fa-print"></i> Print</a></div>';
         		
				// Fiche du fournisseur
				if ($admin_flag == '1' || $supplier_flag == 1) {
					echo '<div class="modal-body open" id="pintAreaf2'.$row["id"].'">';
					echo '<style type="text/css" media="print">
			  				@page { size: landscape; }
						</style>';
					echo '<h4 style="float: left;">La Ferme au Naturel</h4><h5 style="float: right;">Bon de Commande Fournisseur</h5><div style="clear:both"></div><hr>';
					echo '<div style="float: left;">'.$row2['firstname'].' '.$row2['lastname'].'</div>';
					echo '<div style="float: right;"># Référence:'.$row2['nff'].'<br>'.$row['conditions_firstdeliverydate'].'<br># Commande: 2<br><br></div>';
					echo '<table style="font-size:small" class="table table-bordered">';
					echo '<thead><tr><th>Nom du produit</th><th>Emballage</th><th>Quantité</th><th>Prix Unitaire</th><th>Prix Total</th></tr></thead>';
					
					$sqlOrd = "SELECT * FROM orders WHERE form_id=".$row["id"];
					if ($row['edited_status']==1){
						$sqlOrd = "SELECT * FROM orders_updates WHERE form_id=".$row["id"];
					}
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
						
						$subtotal = (((float)$rowOrd["quantity2"])*((float)$rowPtl["purchase_price"]));
						$subtotal = number_format((float)$subtotal, 2, '.', '');
						$total2 = $total2 + $subtotal;
						$total2 = number_format((float)$total2, 2, '.', '');
						
						echo "<tr>";
						echo "<td>".$rowPtl["code"]." - ".$rowPtl3["name_fr"]." ".$rowPtl3["name_en"]."</td>";
						echo "<td>".$rowPtl2["type"]." : ".$rowPtl2["quantity"]."</td>";
						echo "<td>".$rowOrd["quantity2"]."</td>";
						echo "<td>".$rowPtl["purchase_price"]." $</td>";
						echo "<td>".$subtotal." $</td>";
						echo "</tr>";
					}
					echo "<tr>";
					echo "<td colspan='2'><h5>Notes:$row[notice2]</h5></td>";
					echo "<td colspan='2'><b>Total de la Commande</b></td>";
					echo "<td><b>".$total2." $</b></td>";
					echo "</tr>";
					echo '</table>';
					
					echo '</div>';
				}
		
				// Fiche de livraison
				if ($admin_flag == '1' || $delivery_flag == 1) {
					echo '<div class="modal-body open"  id="pintAreal2'.$row["id"].'">';
					echo '<h4 style="float: left;">La Ferme au Naturel / Natural Farms</h4><h5 style="float: right;">Bon de Livraison</h5><div style="clear:both"></div>';
					echo '<div>2285-A10 Blvd St-Laurent<br>Ottawa (Ontario) k1G 4Z4<br>Tél: 613-800-2214<br>Courriel: admin@nffood.ca<br>Site web: www.lafermeaunaturel.com</div>';
					echo '<hr>';
					
					echo '<table class="bon-table"><tr><td>'.$row2['firstname'].' '.$row2['lastname'].'</td>
								<td>Telephone: '.$row2['phone'].'</td>
								<td>Client #: '.$row2['nff'].'</td></tr>'.
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
					if ($row['edited_status']==1){
						$sqlOrd = "SELECT * FROM orders_updates WHERE form_id=".$row["id"];
					}
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
					
					echo '</div>';
				}
				
				echo '</div>';
			}
			
			/******** THIRD DELIVER ********/
			if (($delivery_flag == '1' || $supplier_flag == '1')&&$row['confirm3'] == '1') {
				echo '<div id="t'.$row['id'].'" class="modal hide">';
				echo '<div class="modal-header">';
				echo '<button data-dismiss="modal" class="close" type="button">×</button>';
				echo '<h3>Orders for: '.$row2['firstname'].' '.$row2['lastname'].' on '.$row['conditions_thirddeliverydate'].' (Third Delivery)</h3>';
				
				if ($delivery_flag == 0 && $supplier_flag == 0) {
					echo '<a href="#" onclick="changeView(\'pintAreal3'.$row["id"].'\', \'pintAreaf3'.$row["id"].'\')" title="Fournisseur"><i class="fa fa-podcast"></i> Fournisseur</a> |
							<a href="#" onclick="changeView(\'pintAreaf3'.$row["id"].'\', \'pintAreal3'.$row["id"].'\')" title="Livraison"><i class="fa fa-truck"></i> Livraison</a>';
				}
				echo '<a style="float: right; margin-bottom: 10px" href="#" title="Print" onclick="printDiv(\'t'.$row['id'].'\')"><i class="fa fa-print"></i> Print</a></div>';
				
				// Fiche du fournisseur
				if ($supplier_flag == 1) {
					echo '<div class="modal-body open" id="pintAreaf3'.$row["id"].'">';
					echo '<style type="text/css" media="print">
			  				@page { size: landscape; }
						</style>';
					echo '<h4 style="float: left;">La Ferme au Naturel</h4><h5 style="float: right;">Bon de Commande Fournisseur</h5><div style="clear:both"></div><hr>';
					echo '<div style="float: left;">'.$row2['firstname'].' '.$row2['lastname'].'</div>';
					echo '<div style="float: right;"># Référence:'.$row2['nff'].'<br>'.$row['conditions_thirddeliverydate'].'<br># Commande: 3<br><br></div>';
					echo '<table style="font-size:small" class="table table-bordered">';
					echo '<thead><tr><th>Nom du produit</th><th>Emballage</th><th>Quantité</th><th>Prix Unitaire</th><th>Prix Total</th></tr></thead>';
					
					$sqlOrd = "SELECT * FROM orders WHERE form_id=".$row["id"];
					if ($row['edited_status']==1){
						$sqlOrd = "SELECT * FROM orders_updates WHERE form_id=".$row["id"];
					}
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
						
						$subtotal = (((float)$rowOrd["quantity3"])*((float)$rowPtl["purchase_price"]));
						$subtotal = number_format((float)$subtotal, 2, '.', '');
						$total3 = $total3 + $subtotal;
						$total3 = number_format((float)$total3, 2, '.', '');
						
						echo "<tr>";
						echo "<td>".$rowPtl["code"]." - ".$rowPtl3["name_fr"]." ".$rowPtl3["name_en"]."</td>";
						echo "<td>".$rowPtl2["type"]." : ".$rowPtl2["quantity"]."</td>";
						echo "<td>".$rowOrd["quantity3"]."</td>";
						echo "<td>".$rowPtl["purchase_price"]." $</td>";
						echo "<td>".$subtotal." $</td>";
						echo "</tr>";
					}
					echo "<tr>";
					echo "<td colspan='2'><h5>Notes:$row[notice2]</h5></td>";
					echo "<td colspan='2'><b>Total de la Commande</b></td>";
					echo "<td><b>".$total3." $</b></td>";
					echo "</tr>";
					echo '</table>';
					
					echo '</div>';
				}
		
				// Fiche de livraison
				if ($delivery_flag == 1) {
					echo '<div class="modal-body open"  id="pintAreal3'.$row["id"].'">';
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
					if ($row['edited_status']==1){
						$sqlOrd = "SELECT * FROM orders_updates WHERE form_id=".$row["id"];
					}
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
					
					echo '</div>';
				}
						
				echo '</div>';
			}
	}
	
	function generateSummary($date, $id, $s, $d) {
		echo "<script>xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
			document.getElementById('$id').innerHTML = this.responseText;
			}
			};
			xhttp.open('GET', 'generate/summary.php?date=$date&staff=1', true);
			xhttp.send();</script>";
	}
	
	/******** FIRST DELIVERY ********/
	foreach ($delivery1 as $date)
	{
		echo '<div id="cf'.str_replace("-", "", $date).'" class="modal hide"></div>';
		generateSummary($date, 'cf'.str_replace("-", "", $date), $supplier_flag, $delivery_flag);
	}
	
	/******** SECOND DELIVERY ********/
	foreach ($delivery2 as $date)
	{
		echo '<div id="cf'.str_replace("-", "", $date).'" class="modal hide"></div>';
		generateSummary($date, 'cf'.str_replace("-", "", $date), $supplier_flag, $delivery_flag);
	}
	
	/******** THIRD DELIVERY ********/
	foreach ($delivery3 as $date)
	{
		echo '<div id="cf'.str_replace("-", "", $date).'" class="modal hide"></div>';
		generateSummary($date, 'cf'.str_replace("-", "", $date), $supplier_flag, $delivery_flag);
	}
	
	if ($delivery_flag == '1')
	{
		/******** FIRST DELIVERY ********/
		foreach ($delivery1 as $date)
		{
			$d = str_replace("-","",$date);
			echo "<div id='map$d' class='modal hide maparea'></div>";
			echo '<div id="'.$date.$date.$date.'" style="display: none;"></div>';
		}
		
		/******** SECOND DELIVERY ********/
		foreach ($delivery2 as $date)
		{
			$d = str_replace("-","",$date);
			echo "<div id='map$d' class='modal hide maparea'></div>";
			echo '<div id="'.$date.$date.$date.'" style="display: none;"></div>';
		}
		
		/******** THIRD DELIVERY ********/
		foreach ($delivery3 as $date)
		{
			$d = str_replace("-","",$date);
			echo "<div id='map$d' class='modal hide maparea'></div>";
			echo '<div id="'.$date.$date.$date.'" style="display: none;"></div>';
		}
		
		/******** MONTHLY DELIVERY ********/
		foreach ($deliveryMonths as $m)
		{
			//generateMonthlyMap($m, $conn, false);
		}
	}
}
?>
<!-- footer -->
<?php
include 'inc/footer.php';
?>
