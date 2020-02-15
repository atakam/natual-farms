<?php 
include 'header.php';

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
		
		// url to edit orders
		$editurl2 = "edit.php?edit=yes&edited=yes&";
		$editurl2 = "order/".$editurl2."id=".$row['id']."&rid=".$row['representative_id']."#mycart";
		if ($row['edited_status'] !== '1' && $row['edited'] !== '1')
		{
			$editurl2 = "edit.php?id=".$row['id']."&edit=yes&uid=".$row['customer_id'];
			$editurl2 = "order/".$editurl2."#mycart";
		}
		
		$fullname = $row2['firstname'].' '.$row2['lastname'];
		
		// context menu for each event in calendar
		$idxx = 'f'.$row['id'].'ctx';
		echo "<div id='$idxx' class='cntnr'><ul class='items'><li><a href='#' onclick='confirmOrder(1, $row[id])'><i class='fa fa-check'></i> Confirmed</a></li><li><a href='#' onclick='deliverOrder(1, $row[id])'><i class='fa fa-truck'></i> Delivered</a></li><li><a href='$editurl2' target='_blanck' onclick='hideContextMenu()'><i class='fa fa-pencil'></i> Edit Order</a></li><li><a ".'href="#" onclick="sendOrderEmail(\''.$row['id'].'\', \''.$fullname.'\', \''.$row2['email'].'\');hideContextMenu()"'."><i class='fa fa-envelope'></i> Send Order Email</a></li></ul></div>";
		
		// context menu for each event in calendar
		$idxx = 's'.$row['id'].'ctx';
		echo "<div id='$idxx' class='cntnr'><ul class='items'><li><a href='#' onclick='confirmOrder(2, $row[id])'><i class='fa fa-check'></i> Confirmed</a></li><li><a href='#' onclick='deliverOrder(2, $row[id])'><i class='fa fa-truck'></i> Delivered</a></li><li><a href='$editurl2' target='_blanck' onclick='hideContextMenu()'><i class='fa fa-pencil'></i> Edit Order</a></li><li><a ".'href="#" onclick="sendOrderEmail(\''.$row['id'].'\', \''.$fullname.'\', \''.$row2['email'].'\');hideContextMenu()"'."><i class='fa fa-envelope'></i> Send Order Email</a></li></ul></div>";
		
		// context menu for each event in calendar
		$idxx = 't'.$row['id'].'ctx';
		echo "<div id='$idxx' class='cntnr'><ul class='items'><li><a href='#' onclick='confirmOrder(3, $row[id])'><i class='fa fa-check'></i> Confirmed</a></li><li><a href='#' onclick='deliverOrder(3, $row[id])'><i class='fa fa-truck'></i> Delivered</a></li><li><a href='$editurl2' target='_blanck' onclick='hideContextMenu()'><i class='fa fa-pencil'></i> Edit Order</a></li><li><a ".'href="#" onclick="sendOrderEmail(\''.$row['id'].'\', \''.$fullname.'\', \''.$row2['email'].'\');hideContextMenu()"'."><i class='fa fa-envelope'></i> Send Order Email</a></li></ul></div>";
		
		$dateSelect = "<input type='date' style='width:90%' id='$row[id]conditions_firstdeliverydate' value='$row[conditions_firstdeliverydate]'>";
		$dateSelect .= "<span id='save".$row['id']."conditions_firstdeliverydate' style='display:none; float:right'><a href='#' onclick='saveDate(this,\"".$row['id']."\", \"conditions_firstdeliverydate\", 1)' style='float:right; position:absolute; right:15px'><i class='fa fa-save'></i></a></span>";
		/******** FIRST DELIVER ********/
		echo '<div id="f'.$row['id'].'" class="modal hide">';
			echo '<div class="modal-header">';
            echo '<button data-dismiss="modal" class="close" type="button">×</button>';
            echo '<h3>Orders for: '.$fullname.' on '.$row['conditions_firstdeliverydate'].' <span style="color:green">(First Delivery)</span></h3>';
            
            echo '<h5><span style="float:right" id="date'.$row['id'].'conditions_firstdeliverydate">'. $row['conditions_firstdeliverydate'] . '</span>';
            
            echo "<span id='select".$row['id']."conditions_firstdeliverydate' style='display:none; float:right; margin-left: 10px;'>$dateSelect</span><span id='edit$row[id]conditions_firstdeliverydate'>
            <a href='#' style='float:right; margin-right:5px' onclick='changeDate(this,\"".$row['id']."conditions_firstdeliverydate\")'> <i class='fa fa-pencil' style='padding-left:10px'></i></a></span>";
            
            echo '<a style="padding: 0 4px; background: #f6b8ff" href="#" onclick="changeView(\'pintAreal1'.$row["id"].'\', \'pintAreaf1'.$row["id"].'\')" title="Fournisseur"><i class="fa fa-podcast"></i> Fournisseur</a> | 
			<a style="padding: 0 4px; background: #aef3de" href="#" onclick="changeView(\'pintAreaf1'.$row["id"].'\', \'pintAreal1'.$row["id"].'\')" title="Livraison"><i class="fa fa-truck"></i> Livraison</a>
			<a style="float: right; margin-bottom: 10px; padding: 0 4px; background: #f6b8ff" href="#" title="Print" onclick="printDiv(\'f'.$row['id'].'\')"><i class="fa fa-print"></i> Print</a>
				<a style="float: right; margin-bottom: 10px; margin-right: 8px; padding: 0 4px; background: #aef3de" href="'.$editurl2.'" target="_blanck" title="Edit Order"><i class="fa fa-pencil"></i> Edit Order</a>
				<a style="float: right; margin-bottom: 10px; margin-right: 8px; padding: 0 4px; background: #c0ff9d" href="#" onclick="sendOrderEmail(\''.$row['id'].'\', \''.$fullname.'\', \''.$row2['email'].'\')" title="Send Orders Email"><i class="fa fa-envelope"></i> Send Orders Email</a></div></h5>';
			
            // Fiche du fournisseur
            echo '<div class="modal-body open" id="pintAreaf1'.$row["id"].'">';
            echo '<style type="text/css" media="print">
			  				@page { size: landscape; }
						</style>';
            
            if ($admin_flag == 1) {
            	$checked1 = $row['notconfirm1']=="1"?"checked":"";
            	$checked2 = $row['confirm1']=="1"?"checked":"";
            	$checked3 = $row['deliver1']=="1"?"checked":"";
            	echo '<form method="post"  action="actions/actionconfirm.php">';
            	echo '<table style="width:100%;font-size:small"><tr>
						<td>Not Confirmed: <input type="checkbox" name="notconfirmed" '.$checked1.'/>
								<input type="hidden" name="id" value="'.$row['id'].'"/>
			      				<input type="hidden" name="index" value="1"/>
						        <input type="hidden" name="redirect" value="ordersCal.php"/>
			      				<input type="hidden" name="nextdelivery" value="'.$row['conditions_firstdeliverydate'].'"/>
			      				<input type="hidden" name="email" value="'.$row2['email'].'"/>
			      				<input type="hidden" name="name" value="'.$row2['firstname']." ".$row2['lastname'].'"/>
			      		</td>
						<td>Confirmed: <input type="checkbox" name="confirmed" '.$checked2.' /></td>
						<td>Delivered: <input type="checkbox" name="delivered" '.$checked3.'/></td>
			      		<td>Send Email: <input type="checkbox" name="sendemail" /></td>
						<td><input type="submit"/></td>
				</tr></table><br><hr>';
            	echo '</form>';
            }
            
			echo '<h4 style="float: left;">La Ferme au Naturel</h4><h5 style="float: right;">Bon de Commande Fournisseur</h5><div style="clear:both"></div><hr>';
			echo '<div style="float: left;">'.$fullname.'<br>'.$row2['phone'].'</div>';
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
			$subtotal = number_format((float)$subtotal, 2, '.', '');
			$total1 = $total1 + $subtotal;
			$total1 = number_format((float)$total1, 2, '.', '');
			
			echo "<tr>";
			echo "<td>".$rowPtl["code"]." - ".$rowPtl3["name_fr"]." ".$rowPtl3["name_en"]."</td>";
			echo "<td>".$rowPtl2["type"]." : ".$rowPtl2["quantity"]."</td>";
			echo "<td>".$rowOrd["quantity1"]."</td>";
			echo "<td>$ ".$rowPtl["purchase_price"]."</td>";
			echo "<td>$ ".$subtotal."</td>";
			echo "</tr>";
		}
		echo "<tr>";
		echo "<td colspan='2'><h5>Notes:$row[notice2]</h5></td>";
		echo "<td colspan='2'><b>Total de la Commande</b></td>";
		echo "<td><b>$ ".$total1."</b></td>";
		echo "</tr>";
		echo '</table>';
		
		echo '</div>';
		
		// Fiche de livraison
		echo '<div class="modal-body open" style="display: none" id="pintAreal1'.$row["id"].'">';
		echo '<h4 style="float: left;">La Ferme au Naturel / Natural Farms</h4><h5 style="float: right;">Bon de Livraison</h5><div style="clear:both"></div>';
		echo '<div>2285-A10 Blvd St-Laurent<br>Ottawa (Ontario) k1G 4Z4<br>Tél: 613-800-2214<br>Courriel: admin@nffood.ca<br>Site web: www.lafermeaunaturel.com</div>';
		echo '<hr>';
		
		echo '<table class="bon-table"><tr><td>'.$fullname.'</td>
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
							
		echo '</div></div></div>';
		
		
		$dateSelect = "<input type='date' style='width:90%' id='$row[id]conditions_seconddeliverydate' value='$row[conditions_seconddeliverydate]'>";
		$dateSelect .= "<span id='save".$row['id']."conditions_seconddeliverydate' style='display:none; float:right'><a href='#' onclick='saveDate(this,\"".$row['id']."\", \"conditions_seconddeliverydate\", 1)' style='float:right; position:absolute; right:15px'><i class='fa fa-save'></i></a></span>";
		
		/******** SECOND DELIVER ********/
		echo '<div id="s'.$row['id'].'" class="modal hide">';
		echo '<div class="modal-header">';
		echo '<button data-dismiss="modal" class="close" type="button">×</button>';
		echo '<h3>Orders for: '.$fullname.' on '.$row['conditions_seconddeliverydate'].' <span style="color:green">(Second Delivery)</span></h3>';
		
		echo '<h5><span style="float:right" id="date'.$row['id'].'conditions_seconddeliverydate">'. $row['conditions_seconddeliverydate'] . '</span>';
		
		echo "<span id='select".$row['id']."conditions_seconddeliverydate' style='display:none; float:right; margin-left: 10px;'>$dateSelect</span><span id='edit$row[id]conditions_seconddeliverydate'>
		<a href='#' style='float:right; margin-right:5px' onclick='changeDate(this,\"".$row['id']."conditions_seconddeliverydate\")'> <i class='fa fa-pencil' style='padding-left:10px'></i></a></span>";
		
		echo '<a style="padding: 0 4px; background: #f6b8ff" href="#" onclick="changeView(\'pintAreal2'.$row["id"].'\', \'pintAreaf2'.$row["id"].'\')" title="Fournisseur"><i class="fa fa-podcast"></i> Fournisseur</a> |
				<a style="padding: 0 4px; background: #aef3de" href="#" onclick="changeView(\'pintAreaf2'.$row["id"].'\', \'pintAreal2'.$row["id"].'\')" title="Livraison"><i class="fa fa-truck"></i> Livraison</a>
				<a style="float: right; margin-bottom: 10px; padding: 0 4px; background: #f6b8ff" href="#" title="Print" onclick="printDiv(\'s'.$row['id'].'\')"><i class="fa fa-print"></i> Print</a>
				<a style="float: right; margin-bottom: 10px; margin-right: 8px; padding: 0 4px; background: #aef3de" href="'.$editurl2.'" target="_blanck" title="Edit Order"><i class="fa fa-pencil"></i> Edit Order</a>
				<a style="float: right; margin-bottom: 10px; margin-right: 8px; padding: 0 4px; background: #c0ff9d" href="#" onclick="sendOrderEmail(\''.$row['id'].'\', \''.$fullname.'\', \''.$row2['email'].'\')" title="Send Orders Email"><i class="fa fa-envelope"></i> Send Orders Email</a></div></h5>';
			
		// Fiche du fournisseur
		echo '<div class="modal-body open" id="pintAreaf2'.$row["id"].'">';
		echo '<style type="text/css" media="print">
			  				@page { size: landscape; }
						</style>';
		
		if ($admin_flag == 1) {
			$checked1 = $row['notconfirm2']=="1"?"checked":"";
			$checked2 = $row['confirm2']=="1"?"checked":"";
			$checked3 = $row['deliver2']=="1"?"checked":"";
			echo '<form method="post"  action="actions/actionconfirm.php">';
			echo '<table style="width:100%;font-size:small"><tr>
						<td>Not Confirmed: <input type="checkbox" name="notconfirmed" '.$checked1.'/>
								<input type="hidden" name="id" value="'.$row['id'].'"/>
			      				<input type="hidden" name="index" value="2"/>
								<input type="hidden" name="redirect" value="ordersCal.php"/>
			      				<input type="hidden" name="nextdelivery" value="'.$row['conditions_seconddeliverydate'].'"/>
			      				<input type="hidden" name="email" value="'.$row2['email'].'"/>
			      				<input type="hidden" name="name" value="'.$row2['firstname']." ".$row2['lastname'].'"/>
			      		</td>
						<td>Confirmed: <input type="checkbox" name="confirmed" '.$checked2.' /></td>
						<td>Delivered: <input type="checkbox" name="delivered" '.$checked3.'/></td>
			      		<td>Send Email: <input type="checkbox" name="sendemail" /></td>
						<td><input type="submit"/></td>
				</tr></table><br><hr>';
			echo '</form>';
		}
		
		echo '<h4 style="float: left;">La Ferme au Naturel</h4><h5 style="float: right;">Bon de Commande Fournisseur</h5><div style="clear:both"></div><hr>';
		echo '<div style="float: left;">'.$fullname.'</div>';
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
			echo "<td>$ ".$rowPtl["purchase_price"]."</td>";
			echo "<td>$ ".$subtotal."</td>";
			echo "</tr>";
		}
		echo "<tr>";
		echo "<td colspan='2'><h5>Notes:$row[notice2]</h5></td>";
		echo "<td colspan='2'><b>Total de la Commande</b></td>";
		echo "<td><b>$ ".$total2."</b></td>";
		echo "</tr>";
		echo '</table>';
		
		echo '</div>';
		
		// Fiche de livraison
		echo '<div class="modal-body open" style="display: none" id="pintAreal2'.$row["id"].'">';
		echo '<h4 style="float: left;">La Ferme au Naturel / Natural Farms</h4><h5 style="float: right;">Bon de Livraison</h5><div style="clear:both"></div>';
		echo '<div>2285-A10 Blvd St-Laurent<br>Ottawa (Ontario) k1G 4Z4<br>Tél: 613-800-2214<br>Courriel: admin@nffood.ca<br>Site web: www.lafermeaunaturel.com</div>';
		echo '<hr>';
		
		echo '<table class="bon-table"><tr><td>'.$fullname.'</td>
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
		
		echo '</div></div></div>';
		
		$dateSelect = "<input type='date' style='width:90%' id='$row[id]conditions_thirddeliverydate' value='$row[conditions_thirddeliverydate]'>";
		$dateSelect .= "<span id='save".$row['id']."conditions_thirddeliverydate' style='display:none; float:right'><a href='#' onclick='saveDate(this,\"".$row['id']."\", \"conditions_thirddeliverydate\", 1)' style='float:right; position:absolute; right:15px'><i class='fa fa-save'></i></a></span>";
		
		/******** THIRD DELIVER ********/
		echo '<div id="t'.$row['id'].'" class="modal hide">';
		echo '<div class="modal-header">';
		echo '<button data-dismiss="modal" class="close" type="button">×</button>';
		echo '<h3>Orders for: '.$fullname.' on '.$row['conditions_thirddeliverydate'].' <span style="color:green">(Third Delivery)</span></h3>';
		
		echo '<h5><span style="float:right" id="date'.$row['id'].'conditions_thirddeliverydate">'. $row['conditions_thirddeliverydate'] . '</span>';
		
		echo "<span id='select".$row['id']."conditions_thirddeliverydate' style='display:none; float:right; margin-left: 10px;'>$dateSelect</span><span id='edit$row[id]conditions_thirddeliverydate'>
		<a href='#' style='float:right; margin-right:5px' onclick='changeDate(this,\"".$row['id']."conditions_thirddeliverydate\")'> <i class='fa fa-pencil' style='padding-left:10px'></i></a></span>";
		
		
		echo '<a style="padding: 0 4px; background: #f6b8ff" href="#" onclick="changeView(\'pintAreal3'.$row["id"].'\', \'pintAreaf3'.$row["id"].'\')" title="Fournisseur"><i class="fa fa-podcast"></i> Fournisseur</a> |
				<a style="padding: 0 4px; background: #aef3de" href="#" onclick="changeView(\'pintAreaf3'.$row["id"].'\', \'pintAreal3'.$row["id"].'\')" title="Livraison"><i class="fa fa-truck"></i> Livraison</a>
				<a style="float: right; margin-bottom: 10px; padding: 0 4px; background: #f6b8ff" href="#" title="Print" onclick="printDiv(\'t'.$row['id'].'\')"><i class="fa fa-print"></i> Print</a>
				<a style="float: right; margin-bottom: 10px; margin-right: 8px; padding: 0 4px; background: #aef3de" href="'.$editurl2.'" target="_blanck" title="Edit Order"><i class="fa fa-pencil"></i> Edit Order</a>
				<a style="float: right; margin-bottom: 10px; margin-right: 8px; padding: 0 4px; background: #c0ff9d" href="#" onclick="sendOrderEmail(\''.$row['id'].'\', \''.$fullname.'\', \''.$row2['email'].'\')" title="Send Orders Email"><i class="fa fa-envelope"></i> Send Orders Email</a></div>';
		
		// Fiche du fournisseur
		echo '<div class="modal-body open" id="pintAreaf3'.$row["id"].'">';
		echo '<style type="text/css" media="print">
			  				@page { size: landscape; }
						</style>';
		
		if ($admin_flag == 1) {
			$checked1 = $row['notconfirm3']=="1"?"checked":"";
			$checked2 = $row['confirm3']=="1"?"checked":"";
			$checked3 = $row['deliver3']=="1"?"checked":"";
			echo '<form method="post"  action="actions/actionconfirm.php">';
			echo '<table style="width:100%;font-size:small"><tr>
						<td>Not Confirmed: <input type="checkbox" name="notconfirmed" '.$checked1.'/>
								<input type="hidden" name="id" value="'.$row['id'].'"/>
			      				<input type="hidden" name="index" value="3"/>
								<input type="hidden" name="redirect" value="ordersCal.php"/>
			      				<input type="hidden" name="nextdelivery" value="'.$row['conditions_thirddeliverydate'].'"/>
			      				<input type="hidden" name="email" value="'.$row2['email'].'"/>
			      				<input type="hidden" name="name" value="'.$row2['firstname']." ".$row2['lastname'].'"/>
			      		</td>
						<td>Confirmed: <input type="checkbox" name="confirmed" '.$checked2.' /></td>
						<td>Delivered: <input type="checkbox" name="delivered" '.$checked3.'/></td>
			      		<td>Send Email: <input type="checkbox" name="sendemail" /></td>
						<td><input type="submit"/></td>
				</tr></table><br><hr>';
			echo '</form>';
		}
		
		echo '<h4 style="float: left;">La Ferme au Naturel</h4><h5 style="float: right;">Bon de Commande Fournisseur</h5><div style="clear:both"></div><hr>';
		echo '<div style="float: left;">'.$fullname.'</div>';
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
			echo "<td>$ ".$rowPtl["purchase_price"]."</td>";
			echo "<td>$ ".$subtotal."</td>";
			echo "</tr>";
		}
		echo "<tr>";
		echo "<td colspan='2'><h5>Notes:$row[notice2]</h5></td>";
		echo "<td colspan='2'><b>Total de la Commande</b></td>";
		echo "<td><b>$ ".$total3."</b></td>";
		echo "</tr>";
		echo '</table>';
		
		echo '</div>';
		
		// Fiche de livraison
		echo '<div class="modal-body open" style="display: none" id="pintAreal3'.$row["id"].'">';
		echo '<h4 style="float: left;">La Ferme au Naturel / Natural Farms</h4><h5 style="float: right;">Bon de Livraison</h5><div style="clear:both"></div>';
		echo '<div>2285-A10 Blvd St-Laurent<br>Ottawa (Ontario) k1G 4Z4<br>Tél: 613-800-2214<br>Courriel: admin@nffood.ca<br>Site web: www.lafermeaunaturel.com</div>';
		echo '<hr>';
		
		echo '<table class="bon-table"><tr><td>'.$fullname.'</td>
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
		
		echo '</div></div></div>';
	}
	
	function generateSummary($date, $id) {
		echo "<script>xhttp = new XMLHttpRequest();
			  xhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			     document.getElementById('$id').innerHTML = this.responseText;
			    }
			  };
			  xhttp.open('GET', 'generate/summary.php?date=$date', true);
			  xhttp.send();</script>";
	}
	
	/******** FIRST DELIVERY ********/
	$cnt = 1;
	foreach ($delivery1 as $date)
	{
		$d = str_replace("-","",$date);
		echo "<div id='map$d' class='modal hide maparea'></div>";
		echo '<div id="'.$date.$date.$date.'" style="display: none;"></div>';
		echo '<div id="cf'.str_replace("-", "", $date).'" class="modal hide"></div>';
		generateSummary($date, "cf".str_replace("-", "", $date));
		//include 'generate/summary.php';
		//generateMap($date, $idx2, false);
	}
	
	/******** SECOND DELIVERY ********/
	foreach ($delivery2 as $date)
	{
		$d = str_replace("-","",$date);
		echo "<div id='map$d' class='modal hide maparea'></div>";
		echo '<div id="'.$date.$date.$date.'" style="display: none;"></div>';
		echo '<div id="cf'.str_replace("-", "", $date).'" class="modal hide"></div>';
		generateSummary($date, "cf".str_replace("-", "", $date));
		//include 'generate/summary.php';
		//generateMap($date, $idx2, false);
	}
	
	/******** THIRD DELIVERY ********/
	foreach ($delivery3 as $date)
	{
		$d = str_replace("-","",$date);
		echo "<div id='map$d' class='modal hide maparea'></div>";
		echo '<div id="'.$date.$date.$date.'" style="display: none;"></div>';
		echo '<div id="cf'.str_replace("-", "", $date).'" class="modal hide"></div>';
		generateSummary($date, "cf".str_replace("-", "", $date));
		//include 'generate/summary.php';
		//generateMap($date, $idx2, false);
	}
	
	/******** MONTHLY DELIVERY ********/
	foreach ($deliveryMonths as $date)
	{
		$d = str_replace("-","",$date);
		echo '<div id="map'.$d.'" class="modal hide maparea sss"></div>';
		echo '<div id="'.$date.$date.$date.'" style="display: none;"></div>';
		//generateMonthlyMap($m, $conn, false);
	}
}
?>