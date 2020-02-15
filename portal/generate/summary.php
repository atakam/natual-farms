<?php 

include '../inc/config.php';

$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$staff = isset($_GET['staff']) ? true : false;

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
$ext = $staff ? "AND confirm1='1'" : "";
$sql = "SELECT * FROM form_completion WHERE conditions_firstdeliverydate='$date' $ext";
echo $sql;
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
	echo '<div class="landscape" style="page-break-after:always">';
	echo '<h4>First Delivery</h4>';
	echo '<h4 style="float: left;">La Ferme au Naturel</h4><h5 style="float: right;">Bon de Commande Fournisseur</h5><div style="clear:both"></div><hr>';
	echo '<div style="float: left;">'.$row2['firstname'].' '.$row2['lastname'].'</div>';
	echo '<div style="float: right;"># Référence:'.$row2['nff'].'<br>'.$row['conditions_firstdeliverydate'].'<br># Commande: 1<br><br></div>';
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
		
	$summary .= '<tr><td>'.$row2['firstname'].' '.$row2['lastname'].'</td>';
	$summary .= '<td>'.$total1.'</td>';
	$summary .= '<td>#1</td></tr>';
	$summaryAmt = $summaryAmt + (float)$total1;
}

$ext = $staff ? "AND confirm2='1'" : "";
$sql = "SELECT * FROM form_completion WHERE conditions_seconddeliverydate='$date' $ext";
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
	echo '<div class="landscape" style="page-break-after:always">';

	echo '<h4>Second Delivery</h4>';
	echo '<h4 style="float: left;">La Ferme au Naturel</h4><h5 style="float: right;">Bon de Commande Fournisseur</h5><div style="clear:both"></div><hr>';
	echo '<div style="float: left;">'.$row2['firstname'].' '.$row2['lastname'].'</div>';
	echo '<div style="float: right;"># Référence:'.$row2['nff'].'<br>'.$row['conditions_firstdeliverydate'].'<br># Commande: 1<br><br></div>';
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
		
	$summary .= '<tr><td>'.$row2['firstname'].' '.$row2['lastname'].'</td>';
	$summary .= '<td>'.$total1.'</td>';
	$summary .= '<td>#2</td></tr>';
	$summaryAmt = $summaryAmt + (float)$total1;
}

$ext = $staff ? "AND confirm3='1'" : "";
$sql = "SELECT * FROM form_completion WHERE conditions_thirddeliverydate='$date' $ext";
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

	echo '<div class="landscape" style="page-break-after:always">';
	echo '<h4>Third Delivery</h4>';
	echo '<h4 style="float: left;">La Ferme au Naturel</h4><h5 style="float: right;">Bon de Commande Fournisseur</h5><div style="clear:both"></div><hr>';
	echo '<div style="float: left;">'.$row2['firstname'].' '.$row2['lastname'].'</div>';
	echo '<div style="float: right;"># Référence:'.$row2['nff'].'<br>'.$row['conditions_firstdeliverydate'].'<br># Commande: 1<br><br></div>';
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
	$summary .= '<tr><td>'.$row2['firstname'].' '.$row2['lastname'].'</td>';
	$summary .= '<td>'.$total1.'</td>';
	$summary .= '<td>#1</td></tr>';
	$summaryAmt = $summaryAmt + (float)$total1;
}
$summary .= '<tr><th>TOTAL</th><th>'.$summaryAmt.'</th><th></th></table></div>';
echo $summary;
echo '</div>';

// Fiche de livraison
echo '<div class="modal-body open hide" id="pintAreacl1'.$date.'">';

$ext = $staff ? "AND confirm1='1'" : "";
$sql = "SELECT * FROM form_completion WHERE conditions_firstdeliverydate='$date' $ext";
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
	echo '<div class="printable" style="page-break-after:always">';
	echo '<h4 style="float: left;">La Ferme au Naturel / Natural Farms</h4><h5 style="float: right;">Bon de Livraison</h5><div style="clear:both"></div>';
	echo '<div>2285-A10 Blvd St-Laurent<br>Ottawa (Ontario) k1G 4Z4<br>Tél: 613-800-2214<br>Courriel: admin@nffood.ca<br>Site web: www.lafermeaunaturel.com</div>';
	echo '<hr>';

	echo '<table class="bon-table"><tr><td>'.$row2['firstname'].' '.$row2['lastname'].'</td>
						<td>Telephone: '.$row2['phone'].'</td>
						<td>Client #: '.$row2['nff'].'</td></tr>'.
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

	echo '';
	echo '</div>';
}

//2
$ext = $staff ? "AND confirm2='1'" : "";
$sql = "SELECT * FROM form_completion WHERE conditions_seconddeliverydate='$date' $ext";
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
	echo '<div class="printable" style="page-break-after:always">';
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

	echo '';
	echo '</div>';
}

//3
$ext = $staff ? "AND confirm3='1'" : "";
$sql = "SELECT * FROM form_completion WHERE conditions_thirddeliverydate='$date' $ext";
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
	echo '<div class="printable" style="page-break-after:always">';
	echo '<h4 style="float: left;">La Ferme au Naturel / Natural Farms</h4><h5 style="float: right;">Bon de Livraison</h5><div style="clear:both"></div>';
	echo '<div>2285-A10 Blvd St-Laurent<br>Ottawa (Ontario) k1G 4Z4<br>Tél: 613-800-2214<br>Courriel: admin@nffood.ca<br>Site web: www.lafermeaunaturel.com</div>';
	echo '<hr>';

	echo '<table class="bon-table"><tr><td>'.$row2['firstname'].' '.$row2['lastname'].'</td>
						<td>Telephone: '.$row2['phone'].'</td>
						<td>Client #: '.$row2['nff'].'</td></tr>'.
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

	echo '';
	echo '</div>';
}

echo '</div>';

?>