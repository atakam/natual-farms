
<?php 
//error_reporting(E_ERROR);

include 'formtopdemo.php';

if (isset($_GET['id'])) {
	$fid = $_GET['id'];

	$sql = "SELECT * FROM form_completion_demo WHERE id=".$fid." LIMIT 1;";

	$result = $conn->query($sql);
	$rowFC = $result->fetch_assoc();
	
	$sql2 = "SELECT * FROM customer_demo WHERE id=".$rowFC['customer_id']." LIMIT 1";
	$result2 = $conn->query($sql2);
	$row2 = $result2->fetch_assoc();

?>

<div class="form-style-2">
	<form method="post"  action="../actions/actionedit.php" autocomplete="on" id="contract"> <!-- onsubmit="return validateForm()" -->
		<div class="form-style-2-heading"><?= gettext(" ")?></div>
		<div class="row">
			<div class="section section-40">
				<p><?= gettext("Last Name")?></p>
				<input type="text" class="input-field mandatory" name="lastname" id="lastname" value="<?php echo $row2["lastname"];?>" />
			</div>
			<!--  
			<div class="section section-40">
				<p><?= gettext("First Name")?></p>
				<input type="text" class="input-field mandatory" name="firstname"  id="firstname" value="<?php echo $row2["firstname"];?>" />
			</div>
			<div class="section section-20">
				<p><?= gettext("NFF")?></p>
				<input type="text" class="input-field disabled" tabIndex="-1" name="formid" value="<?php echo $row2["nff"];?>" readonly/>
				<input type="hidden" class="input-field disabled" tabIndex="-1" name="nff" value="<?php echo $row2["id"];?>" readonly/>
				<input type="hidden" class="input-field disabled" tabIndex="-1" name="fid" value="<?php echo $fid;?>" readonly/>
			</div>
			-->
			<div class="section section-40">
				<p><?= gettext("Email")?></p>
				<input type="email" class="input-field mandatory" name="email" value="<?php echo $row2["email"];?>" />
			</div>	
			<div class="section section-20">
				<p><?= gettext("Tel Home")?></p>
			    <span>
				    <input type="tel" class="tel-number-field mandatory" name="phone" value="<?php echo $row2["phone"];?>" maxlength="10" />
				</span>
			</div>
		</div>
		<!--  
		<div class="row">
			
			<div class="section section-25">
			    <p><?= gettext("Tel Work")?></p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="workphone" value="<?php echo $row2["workphone"];?>" maxlength="10" />	
			    </span>
			</div>
			<div class="section section-25">
			    <p><?= gettext("Fax")?></p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="fax" value="<?php echo $row2["fax"];?>" maxlength="10" />	
			    </span>
			</div>
		</div>
		
		<div class="row">
			<div class="section section-25">
				<p><?= gettext("Marital Status")?></p>
				  <select name="maritalstatus" class="select-field">
				  	<option selected></option>
				  	<option <?php if ($row2["maritalstatus"]==="SINGLE") echo "selected";?>>Single</option>
				    <option <?php if ($row2["maritalstatus"]==="MARRIED") echo "selected";?>>Married</option>
				    <option <?php if ($row2["maritalstatus"]==="GIVEN PARTNER") echo "selected";?>>Given Partner</option>
				  </select>
<!-- 				<input type="radio" class="checkbox-field" name="married" value="married" /> 
			</div>
			<div class="section section-25">
				<p><?= gettext("# of Dependent")?></p>
				<input type="number" class="tel-number-field" name="dependent" value="<?php echo $row2["numdependent"];?>" />
			</div>
		</div>
		
		<div class="row">
			
		</div>
		
		<div class="form-style-2-heading"><?= gettext("Additional Information")?></div>
		
		<div class="row">
			<div class="section section-40">
				<p><?= gettext("Last Name")?></p>
				<input type="text" class="input-field" name="lastname2" value="<?php echo $row2["lastname2"];?>" />
			</div>
			<div class="section section-40">
				<p><?= gettext("First Name")?></p>
				<input type="text" class="input-field" name="firstname2" value="<?php echo $row2["firstname2"];?>" />
			</div>
		</div>
		<div class="row">
			<div class="section section-30">
				<p><?= gettext("Email")?></p>
				<input type="email" class="input-field" name="email2" value="<?php echo $row2["email2"];?>" />
			</div>
			<div class="section section-25">
			    <p><?= gettext("Tel")?></p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="phone2" value="<?php echo $row2["phone2"];?>" maxlength="10" />	
			    </span>
			</div>
			<div class="section section-25">
			    <p><?= gettext("Fax")?></p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="fax2" value="<?php echo $row2["fax2"];?>" maxlength="10" />	
			    </span>
			</div>
		</div>
		
		<div class="row">
			
		</div>
		
		<div class="form-style-2-heading"><?= gettext("Address Information")?></div>
		
		<div class="row">
			<div class="section section-50">
				<p><?= gettext("Address Line 1")?></p>
				<input type="text" class="input-field mandatory" name="streetaddress1" value="<?php echo $row2["streetaddress1"];?>" />
			</div>
			<div class="section section-50">
				<p><?= gettext("Address Line 2")?></p>
				<input type="text" class="input-field" name="streetaddress2" value="<?php echo $row2["streetaddress2"];?>" />
			</div>
		</div>
		
		<div class="row">
			<div class="section section-40">
				<p><?= gettext("City")?></p>
				<input type="text" class="input-field mandatory" name="city" value="<?php echo $row2["city"];?>" />
			</div>
			<div class="section section-20">
				<p><?= gettext("Province")?></p>
				<select name="province" class="select-field mandatory">
				  	<option selected></option>
				  	<option <?php if ($row2["province"]==="AB") echo "selected";?>>AB</option>
				  	<option <?php if ($row2["province"]==="BC") echo "selected";?>>BC</option>
				  	<option <?php if ($row2["province"]==="MB") echo "selected";?>>MB</option>
				  	<option <?php if ($row2["province"]==="NB") echo "selected";?>>NB</option>
				  	<option <?php if ($row2["province"]==="NL") echo "selected";?>>NL</option>
				    <option <?php if ($row2["province"]==="NS") echo "selected";?>>NS</option>
				    <option <?php if ($row2["province"]==="ON") echo "selected";?>>ON</option>
				    <option <?php if ($row2["province"]==="PE") echo "selected";?>>PE</option>
				    <option <?php if ($row2["province"]==="QC") echo "selected";?>>QC</option>
				    <option <?php if ($row2["province"]==="SK") echo "selected";?>>SK</option>
				</select>
			</div>
			<div class="section section-20">
				<p><?= gettext("Postal Code")?></p>
				<input type="text" class="input-field postalcode mandatory" name="postal" value="<?php echo $row2["postalcode"];?>"/>
			</div>
			<div class="section section-20">
				<p><?= gettext("Sector")?></p>
				<input type="text" class="input-field" name="sector" value="<?php echo $row2["sector"];?>" />
			</div>			
		</div>
		
		<div class="row">
			<div class="section section-30">
				<p><?= gettext("How many years at this address?")?></p>
				<input type="number" class="tel-number-field" name="howlong" value="<?php echo $row2["howlongyear"];?>" />
			</div>
			<div class="section section-15">
				<p><?= gettext("Owner")?></p>
				<input type="radio" class="checkbox-field" name="owner" value="1" <?php if ($row2["owner"]==='1') echo "checked";?>/>
			</div>
			<div class="section section-10">
				<p><?= gettext("Tenant")?></p>
				<input type="radio" class="checkbox-field" name="owner" value="0" <?php if ($row2["owner"]==='0') echo "checked";?>/>
			</div>			
		</div>
		-->
		<div class="row">
			
		</div>
		
		<div class="form-style-2-heading">
			<?= gettext("Product List")?>
			<a href='#mycart' style='float: right'><i class='fa fa-shopping-cart'></i> <?= gettext("VIEW MY ORDER"); ?></a>
		</div>
		
		<div class="row" id="shop" style="display:none">
			
			<div>
				<div class="section section-100 tabs">
				<?php 
					$sqlCat = "SELECT * FROM products_category";
					$resultsCat = mysqli_query($conn, $sqlCat) or die ($sqlCat."<br>".mysqli_error());
					$firstTab = 0;
					while ($rowCat = mysqli_fetch_array($resultsCat))
					{
						if ($firstTab === 0)
						{
							$firstTab = 1;
				?>
							<span id="tab-<?php echo $rowCat['slug']; ?>" class="tabTitle active" onclick="showTab('<?php echo $rowCat['slug']; ?>')"><?php echo $rowCat['name_fr']; ?></span>
				<?php 
						}
						else {
				?>
							<span id="tab-<?php echo $rowCat['slug']; ?>" class="tabTitle" onclick="showTab('<?php echo $rowCat['slug']; ?>')"><?php echo $rowCat['name_fr']; ?></span>
				<?php
						}
			    	}
			    ?>
			                <span class="cart-tab"><a href='#mycart'><i class="fa fa-shopping-cart"></i></a></span>
				</div>
				
				<?php 
				$resultsCat = mysqli_query($conn, $sqlCat) or die ($sqlCat."<br>".mysqli_error());
				$firstTab = 0;
				while ($rowCat = mysqli_fetch_array($resultsCat))
				{
				
				if ($firstTab === 0)
				{
					?>
					<div class="section section-100 tab active" id="<?php echo $rowCat['slug']; ?>">
					<?php 
				}
				else {
				?>
					<div class="section section-100 tab" id="<?php echo $rowCat['slug']; ?>">
					<?php 
				}
				$firstTab++;
				
					echo "<ul class='nodisplay active product-list' id='".$rowCat['slug']."list'>";
					
					$sql = "SELECT * FROM products WHERE category_id=".$rowCat['id'];
					
					$results = mysqli_query($conn, $sql) or die ($sql."<br>".mysqli_error());

					while ($row = mysqli_fetch_array($results))
					{
						$sql2 = "SELECT * FROM products_details WHERE product_id=".$row['id'].";";
						//echo $sql2;
						$results2 = mysqli_query($conn, $sql2) or die ($sql2."<br>".mysqli_error());
						$cart = array();
						
						while ($row2 = mysqli_fetch_array($results2))
						{
							$details = array();
							array_push($details, $row2['id']);
							array_push($details, $row2['point']);
							
							$sql3 = "SELECT * FROM product_packaging WHERE id=".$row2['packaging_id']." LIMIT 1";
							$results3 = mysqli_query($conn, $sql3) or die ($sql3."<br>".mysqli_error());
							$row3 = mysqli_fetch_array($results3);
							array_push($details, $row3['type'] . " : " . $row3['quantity']);
							
							array_push($cart, $details);
						}
						
						$details = "";
						foreach($cart as $r) {
							foreach ($r as $t)
							{
								$details .= $t . ",";
							}
							$details = rtrim($details, ",");
							$details .= "~";
						}
						$details = rtrim($details, "~");
						
						echo "<li class='section product-display' style='width:".(100/$numOfColumns)."%;'>";
						echo "<img src='../order/images/products/".$row['image_name']."' alt='productImage' />";
						echo "<div class='pname' onclick='addProduct(this, \"none\")' id='edit".$row['id']."' data-image='".$row['image_name']."' data-name='".$row['name_fr']."' data-details='".$details."' data-id='".$row['id']."'><p>".$row['name_fr']."</p>".
    		                 "<a href='#mycart' class='product-item-select'><span class='perPdtPts' id='perPdtPts".$row['id']."'></span><span>Ajouter</span></a></div>";
						echo "</li>";
					}
					echo "</ul>";
					
					?>
				</div>
				<?php } ?>
			</div>
			
			<?php 
			$sqlOrd = "SELECT * FROM orders_demo WHERE form_id=".$fid;
			if ($rowFC['edited_status']==1&&isset($_GET['edited'])){
				$sqlOrd = "SELECT * FROM orders_updates WHERE form_id=".$fid;
			}
			$resultsOrd = mysqli_query($conn, $sqlOrd) or die ($sqlOrd."<br>".mysqli_error());
			echo '<script type="text/javascript">';
			echo '$(document).ready(function() {';
			$countPtl = 0;
			while ($rowOrd = mysqli_fetch_array($resultsOrd))
			{
				$sqlPtl = "SELECT * FROM products_details WHERE id=".$rowOrd['product_details_id']." LIMIT 1";
				$resultsPtl = mysqli_query($conn, $sqlPtl) or die ($sqlPtl."<br>".mysqli_error());
				$rowPtl = mysqli_fetch_array($resultsPtl);
					
				echo 'document.getElementById("edit'.$rowPtl["product_id"].'").click();';
				//echo 'var el = document.getElementById("detail'.$countPtl.'");';
				//echo 'document.getElementById("detail'.$countPtl.'").getElementsByTagName("option")[11].selected = "selected"';
				echo 'document.getElementById("detail'.$countPtl.'").value = '.$rowOrd["product_details_id"].';';
				echo 'document.getElementById("qty1'.$countPtl.'").value = '.$rowOrd["quantity1"].';';
				echo 'document.getElementById("qty2'.$countPtl.'").value = '.$rowOrd["quantity2"].';';
				echo 'document.getElementById("qty3'.$countPtl++.'").value = '.$rowOrd["quantity3"].';';
				echo 'updateTotal();';
			}
			echo '});';
			echo '</script>';
			?>
			
			<div class="clear"></div>

		</div>
		
		<div id="mycart3" class="overlay3">
			<div class="popup3">
				<div class="clear"></div>
				<div class="formproducts">
					<div class="section section-40">
						<p><?= gettext("Products")?></p>
					</div>
					<div class="section section-30">
						<p><?= gettext("Size")?></p>
					</div>
					<div class="section section-25">
						<div class="section section-30" style="background-color: #62c462; color: #fff;">
							<p class="quantity"><?= gettext("1st")?> <span class="required">*</span></p>
						</div>
						<div class="section section-30" style="background-color: #fb7a2c; color: #fff;">
							<p class="quantity"><?= gettext("2nd")?> <span class="required">*</span></p>
						</div>
						<div class="section section-30" style="background-color: #ee5f5b; color: #fff;">
							<p class="quantity"><?= gettext("3rd")?> <span class="required">*</span></p>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div id="cartItems">
				</div>
			</div>
		</div>
		
		
		<div class="row">
			<div class="section section-75">
				<p><?= "Comments / Commentaires" ?></p>
				<textarea name="notice" class="textarea-field"><?php echo $rowFC["notice"];?></textarea>
			</div>
			<div class="section section-25">
				<p><?= gettext("Total Points")?></p>
				<input type="number" class="input-field disabled" min="0" max="999999" step="1" tabIndex="-1" name="points" id="points" value="<?php echo $rowFC['edited_status']==1&&isset($_GET['edited'])?$rowFC['edited_points']:$rowFC['total_points'];?>" readonly/>
			</div>
			<!-- 
			<div class="section section-25">
				<p><?= gettext("Sales Price")?></p>
				<input type="number" class="input-field mandatory" min="0" max="999999" step="0.01" tabIndex="-1" name="price" id="price" oninput="updateTotal()" value="<?php echo $rowFC['edited_status']==1&&isset($_GET['edited'])?$rowFC['edited_price']:$rowFC['price'];?>" />
			</div>
			<div class="section section-25">
				<p><?= gettext("Rebate")?></p>
				<input type="number" class="input-field"  min="0" max="999999" step="0.01"  name="rebate" id="rebate" value="<?php echo $rowFC['edited_status']==1&&isset($_GET['edited'])?$rowFC['edited_rebate']:$rowFC['rebate'];?>" oninput="updateTotal()"/>
			</div>
			<div class="section section-25">
				<p><?= gettext("Deposit")?></p>
				<input type="number" class="input-field" min="0" max="999999" step="0.01" name="deposit" id="deposit" value="<?php echo $rowFC['edited_status']==1&&isset($_GET['edited'])?$rowFC['edited_deposit']:$rowFC['deposit'];?>" oninput="updateTotal()"/>
			</div>
			<div class="section section-25">
				<p><?= gettext("Sub Total")?></p>
				<input type="number" class="input-field disabled" min="0" max="999999" step="0.01" tabIndex="-1" name="subtotal" id="subtotal" value="<?php echo $rowFC['edited_status']==1&&isset($_GET['edited'])?$rowFC['edited_subtotal']:$rowFC['subtotal'];?>" readonly/>
			</div>
			<div class="section section-25">
				<p><?= gettext("Total Balance")?></p>
				<input type="number" class="input-field disabled" min= "0" max="999999" step="0.01"tabIndex="-1" name="total" id="total" value="<?php echo $rowFC['edited_status']==1&&isset($_GET['edited'])?$rowFC['edited_total']:$rowFC['total'];?>" readonly/>
			</div>
			 -->
		</div>
		
		<!-- 
		<div class="form-style-2-heading"><?= gettext("Payment Information")?></div>
		
		<div class="row">
			<div class="section section-20">
				<i><?= gettext("Hidden for security reasons")?>.</i>
			</div>
		</div>
		
		
		<?php 
			include 'formterms.php';
		?>
		
		<div class="row">
			<div class="section section-100">
				<?= gettext("SIGNED ON")?> <input type="date" class="input-field initial-width mandatory" name="signeddate" value="<?php echo $rowFC['signature_date'];?>"> 
				<?= gettext("AT")?> <input type="text" class="input-field width-50" name="signedaddress" placeholder="Street Address, City, Province, Postal Code" value="<?php echo $rowFC['signature_address'];?>">
			</div>
			<div class="section section-50">
				<p><?= gettext("Merchant:")?></p>
				<input type="text" class="input-field mandatory" name="signedmerchant"
					placeholder="FULL NAME" value="<?php echo $rowFC['signature_merchant_name'];?>">
				<input type="hidden" class="" name="signed1" id="signed1" value="<?php echo $rowFC['signature_merchant_url'];?>">
				<div id="signature-pad1">
					<div class="m-signature-pad--body">
						<img alt="Merchant Signature" src="<?php echo "images/signatures/".$rowFC['signature_merchant_url']; ?>">
					</div>
				</div>
			</div>
			<div class="section section-50">
				<p><?= gettext("Consumer(s):")?></p>
				<input type="text" class="input-field mandatory" name="signedconsumer1" placeholder="FULL NAME" value="<?php echo $rowFC['signature_consumer_name'];?>">
				<input type="hidden" class="" name="signed2" id="signed2" value="<?php echo $rowFC['signature_consumer_url'];?>">
				<div id="signature-pad2">
					<div class="m-signature-pad--body">
						<img alt="Consumer Signature" src="<?php echo "images/signatures/".$rowFC['signature_consumer_url']; ?>">
					</div>
				</div>
				<?php 
				    $s2 = str_replace(" ", "", trim($rowFC['signature_consumer2_name']));
					if ($s2 != "") {
				?>
				<input type="text" class="input-field" name="signedconsumer2" placeholder="FULL NAME" value="<?php echo $rowFC['signature_consumer2_name'];?>" disabled>
				<input type="hidden" class="" name="signed3" id="signed3" value="<?php echo $rowFC['signature_consumer2_url'];?>">
				<div id="signature-pad3">
					<div class="m-signature-pad--body">
						<img alt="Consumer Signature" src="<?php echo "images/signatures/".$rowFC['signature_consumer2_url']; ?>">
					</div>
				</div>
				<?php 
					}
				?>
			</div>
		</div>
			 -->
	</form>
</div>
<script>
$(document).ready(function() {
	$("#contract :input").attr("disabled", true);
	//$("#contract :select").attr("disabled", true);
});
	</script>
<?php 
}
include '../order/formbottom.php';
?>
