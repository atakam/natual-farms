<?php 

include 'formtop.php';

if (isset($_GET['id'])) {
	$fid = $_GET['id'];

	$sql = "SELECT * FROM form_completion WHERE id=".$fid." LIMIT 1";

	$result = $conn->query($sql);
	$rowFC = $result->fetch_assoc();
	
	$sql2 = "SELECT * FROM customer WHERE id=".$rowFC['customer_id']." LIMIT 1";
	$result2 = $conn->query($sql2);
	$row2 = $result2->fetch_assoc();
	
	$firstname = $row2["firstname"];
	$lastname = $row2["lastname"];
	$nff = $row2["nff"];
?>

<div class="form-style-2">
	<form method="post"  action="../actions/actionadminedit.php" autocomplete="on"> <!-- onsubmit="return validateForm()" -->
		<div class="form-style-2-heading"><?= gettext(" ")?></div>
		<div class="row">
			<div class="section section-40">
				<p><?= gettext("Last Name")?> <span class="required">*</span></p>
				<input type="text" class="input-field mandatory" name="lastname" value="<?php echo $row2["lastname"];?>" />
			</div>
			<div class="section section-40">
				<p><?= gettext("First Name")?> <span class="required">*</span></p>
				<input type="text" class="input-field mandatory" name="firstname" value="<?php echo $row2["firstname"];?>" />
			</div>
<!-- 			
			<div class="section section-10">
				<p><?= gettext("Given Partner")?></p>
				<input type="radio" class="checkbox-field" name="married" value="partner" />
			</div> 
-->
			
			<div class="section section-20">
				<p><?= gettext("NFF")?></p>
				<input type="text" class="input-field <?= $admin_flag == '1'?"":"disabled" ?>" tabIndex="-1" name="formid" value="<?php echo $row2["nff"];?>" <?= $admin_flag == '1'?"":"readOnly" ?>/>
				<input type="hidden" class="input-field disabled" tabIndex="-1" name="customerid" value="<?php echo $row2["id"];?>" readonly/>
				<input type="hidden" class="input-field disabled" tabIndex="-1" name="fid" value="<?php echo $fid;?>" readonly/>
				<?php if ($_GET['edited']) { ?>
				<input type="hidden"  tabIndex="-1" name="edited" value="yes"/>
				<?php } ?>
			</div>
		</div>
		<div class="row">
			<div class="section section-60">
				<p><?= gettext("Email")?> <span class="required">*</span></p>
				<input type="email" class="input-field mandatory" name="email" value="<?php echo $row2["email"];?>" />
			</div>	
			<div class="section section-40">
				<p><?= gettext("Tel Home")?> <span class="required">*</span></p>
			    <span>
				    <input type="tel" class="tel-number-field mandatory" name="phone" value="<?php echo $row2["phone"];?>" maxlength="10" />
				</span>
			</div>
			<div class="section section-40">
			    <p><?= gettext("Tel Work")?></p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="workphone" value="<?php echo $row2["workphone"];?>" maxlength="10" />	
			    </span>
			</div>
			<div class="section section-40">
			    <p><?= gettext("Fax")?></p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="fax" value="<?php echo $row2["fax"];?>" maxlength="10" />	
			    </span>
			</div>
			<div class="section section-20">
				<p><?= gettext("Marital Status")?></p>
				  <select name="maritalstatus" class="select-field">
				  	<option selected></option>
				  	<option <?php if ($row2["maritalstatus"]==="SINGLE") echo "selected";?>>Single</option>
				    <option <?php if ($row2["maritalstatus"]==="MARRIED") echo "selected";?>>Married</option>
				    <option <?php if ($row2["maritalstatus"]==="GIVEN PARTNER") echo "selected";?>>Given Partner</option>
				  </select>
<!-- 				<input type="radio" class="checkbox-field" name="married" value="married" /> -->
			</div>
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="form-style-2-heading"><?= gettext("Additional Information")?></div>
		
		<div class="row">
			<div class="section section-50">
				<p><?= gettext("Last Name")?></p>
				<input type="text" class="input-field" name="lastname2" value="<?php echo $row2["lastname2"];?>" />
			</div>
			<div class="section section-50">
				<p><?= gettext("First Name")?></p>
				<input type="text" class="input-field" name="firstname2" value="<?php echo $row2["firstname2"];?>" />
			</div>
		</div>
		<div class="row">
			<div class="section section-60">
				<p><?= gettext("Email")?></p>
				<input type="email" class="input-field" name="email2" value="<?php echo $row2["email2"];?>" />
			</div>
			<div class="section section-40">
			    <p><?= gettext("Tel")?></p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="phone2" value="<?php echo $row2["phone2"];?>" maxlength="10" />	
			    </span>
			</div>
			<div class="section section-0">
			    <p><?= gettext("Fax")?></p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="fax2" value="<?php echo $row2["fax2"];?>" maxlength="10" />	
			    </span>
			</div>
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="form-style-2-heading"><?= gettext("Address Information")?></div>
		
		<div class="row">
			<div class="section section-50">
				<p><?= gettext("Address Line 1")?><span class="required">*</span></p>
				<input type="text" class="input-field mandatory" name="streetaddress1" value="<?php echo $row2["streetaddress1"];?>" />
			</div>
			<div class="section section-50">
				<p><?= gettext("Address Line 2")?></p>
				<input type="text" class="input-field" name="streetaddress2" value="<?php echo $row2["streetaddress2"];?>" />
			</div>
		</div>
		
		<div class="row">
			<div class="section section-40">
				<p><?= gettext("City")?> <span class="required">*</span></p>
				<input type="text" class="input-field mandatory" name="city" value="<?php echo $row2["city"];?>" />
			</div>
			<div class="section section-20">
				<p><?= gettext("Province")?> <span class="required">*</span></p>
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
				<p><?= gettext("Postal Code")?> <span class="required">*</span></p>
				<input type="text" class="input-field postalcode mandatory" name="postal" value="<?php echo $row2["postalcode"];?>"/>
			</div>
			<div class="section section-20">
				<p><?= gettext("Sector")?></p>
				<input type="text" class="input-field" name="sector" value="<?php echo $row2["sector"];?>" list="sectors"/>
				<datalist id="sectors">
				    <optgroup label="Gatinea Area">
                        <option value="Aylmer">
                        <option value="Buckingham">
                        <option value="Cantley">
                        <option value="Gatineau">
                        <option value="Gracefield">
                        <option value="Hawkesbury">
                        <option value="Hull">
                        <option value="Luskville">
                        <option value="Maniwaki">
                        <option value="Masham">
                        <option value="Masson-angers">
                        <option value="Plaissance">
                        <option value="Rockland">
                        <option value="Thurso">
                        <option value="Val-des-monts">
                    </optgroup>
                    <optgroup label="Ottawa Area">
                        <option value="Cumberland">
                        <option value="Gloucester (Orleans)">
                        <option value="Kanata">
                        <option value="Nepean">
                        <option value="South Keys">
                        <option value="Stittsville">
                        <option value="West Carleton">
                    </optgroup>
                </datalist>
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
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="form-style-2-heading">
			<?= gettext("Product List")?>
			<a href='#mycart' style='float: right'><i class='fa fa-shopping-cart'></i> <?= gettext("VIEW MY ORDER"); ?></a>
		</div>
		
		<div class="row" id="shop">
			<?php include 'addProducts2.php';?>
		</div>
		
		<div id="mycart" class="overlay">
			<div class="popup">
				<div class="title">
				    <p><?= $firstname . ' ' . $lastname . ' (NFF: ' . $nff . ')' ?></p>
					<h2><?= gettext("MY ORDER LIST")?></h2>
					<p class="cartPoints"><?= gettext("Total Points Selected")?>: <i id="cartPoints">0</i></p>
					<a class="close" onclick="checkQuatity()">CONTINUE</a>
				</div>
				<div class="clear"></div>
				<div class="formproducts">
					<div class="section section-33">
						<p><?= gettext("Products")?></p>
					</div>
					<div class="section section-10">
						<p><?= gettext("Codes")?></p>
					</div>
					<div class="section section-25">
						<p><?= gettext("Size")?> <span class="required">*</span></p>
					</div>
					<div class="section section-25">
						<div class="section section-25" style="background-color: #62c462; color: #fff;">
							<p class="quantity"><?= gettext("1st")?> <span class="required">*</span></p>
						</div>
						<div class="section section-25" style="background-color: #fb7a2c; color: #fff;">
							<p class="quantity"><?= gettext("2nd")?> <span class="required">*</span></p>
						</div>
						<div class="section section-25" style="background-color: #ee5f5b; color: #fff;">
							<p class="quantity"><?= gettext("3rd")?> <span class="required">*</span></p>
						</div>
						<div class="section section-15" style="background-color: #0088cc; color: #fff;">
							<p class="quantity"><?= gettext("PTS")?> <span class="required"></span></p>
						</div>
					</div>
				</div>
				<div class="formproducts">
					<div class="section section-30" style="float:right">
						<div class="section section-20">
							<p id="points1"></p>
						</div>
						<div class="section section-20">
							<p id="points2"></p>
						</div>
						<div class="section section-20">
							<p id="points3"></p>
						</div>
						<div class="section section-15">
							<p></p>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div id="cartItems">
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="section section-100">
				<p><?= gettext("Order Notes")?></p>
				<textarea name="notice2" class="textarea-field"><?php echo $rowFC["notice2"];?></textarea>
			</div>
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="form-style-2-heading"><?= gettext("Order Summary")?></div>
		
		<div class="row">
			<div class="section section-50">
				<p><?= gettext("Contract Notes")?></p>
				<textarea name="notice" class="textarea-field"><?php echo $rowFC["notice"];?></textarea>
			</div>
			<div class="section section-25">
				<p><?= gettext("Total Points")?></p>
				<input type="number" class="input-field disabled" min="0" max="999999" step="1" tabIndex="-1" name="points" id="points" value="<?php echo $rowFC['edited_status']==1&&isset($_GET['edited'])?$rowFC['edited_points']:$rowFC['total_points'];?>" readonly/>
			</div>
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
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="form-style-2-heading">
			<div class="section section-40">
				<?= gettext("Payment Information")?>
			</div>
			<div class="section section-20">
				<?= gettext("Payment") . " 1"?>
			</div>
			<div class="section section-20">
				<?= gettext("Payment") . " 2"?>
			</div>
			<div class="section section-20">
				<?= gettext("Payment") . " 3"?>
			</div>
		</div>
		
		<div class="row">
			<div class="section section-40">
			    <select name="payment" class="select-field">
			    	<option value="0"><?= gettext("Select Payment Method")?></option>
			    	<option value="1" <?php if ($rowFC["cc_flag"]==="1") echo "selected";?>><?= gettext("Visa / Master Card")?></option>
			    	<option value="2" <?php if ($rowFC["preauthorized_flag"]==="1") echo "selected";?>><?= gettext("Pre-Authorized Payment")?></option>
			    	<option value="3" <?php if ($rowFC["cash_flag"]==="1") echo "selected";?>><?= gettext("Cash / Cheque")?></option>
			    </select>
				<!--  <input type="checkbox" class="input-checkbox" name="hascredit" value="1" />-->
			</div>
			<div class="section section-60">
				<div class="section section-33">
					<input type="date" class="input-field initial-width" name="payment1" id="payment1" value="<?= $rowFC["payment1"] ?>"> 
				</div>
				<div class="section section-33">
					<input type="date" class="input-field initial-width" name="payment2" id="payment2" value="<?= $rowFC["payment2"] ?>">
				</div>
				<div class="section section-33">
					<input type="date" class="input-field initial-width" name="payment3" id="payment3" value="<?= $rowFC["payment3"] ?>"> 
				</div>
			</div>	
				<!-- 
				<div class="row">
					<div class="section section-30">
						<p><?= gettext("Visa / Master Card #")?></p>
						<input type="text" class="tel-number-field cc_number" name="creditcard" value="<?php echo $rowFC['cc_number'];?>" />
					</div>
					<div class="section section-10">
						<p><?= gettext("Month")?></p>
						<input type="text" class="tel-number-field cc_month" name="creditmonth" value="<?php echo $rowFC['cc_month'];?>" maxlength="2"/>
					</div>
					<div class="section section-10">
						<p><?= gettext("Year")?></p>
						<input type="text" class="tel-number-field cc_year" name="credityear" value="<?php echo $rowFC['cc_year'];?>" maxlength="4"/>
					</div>
					<div class="section section-10">
						<p><?= gettext("CCV")?></p>
						<input type="text" class="tel-number-field cc_ccv" name="creditccv" value="<?php echo $rowFC['cc_ccv'];?>" maxlength="3"/>
					</div>
					<div class="section section-40">
						<p><?= gettext("Name on the Card")?></p>
						<input type="text" class="input-field" name="creditname" value="<?php echo $rowFC['cc_name'];?>" />
					</div>
				</div>
				 -->
		</div>
		<!--  
		<div class="row">
			<div class="section section-20">
				<p><?= gettext("Pre-Authorized Payment")?></p>
				<input type="checkbox" class="input-checkbox" name="haspreauthorized" value="1" <?php if ($row2["preauthorized_flag"]==="1") echo "checked";?> />
			</div>
			<div class="section section-80">
				<p><?= gettext("Notes")?></p>
				<input type="text" class="input-field" name="notes2" value="<?php echo $rowFC['preauthorized_notes'];?>" />
			</div>
		</div>
		
		<div class="row">
			<div class="section section-20">
				<p><?= gettext("Cash / Cheque")?></p>
				<input type="checkbox" class="input-checkbox" name="hascash" value="1" <?php if ($row2["cash_flag"]==="1") echo "checked";?> />
			</div>
			<div class="section section-80">
				<p><?= gettext("Notes")?></p>
				<input type="text" class="input-field" name="notes3" value="<?php echo $rowFC['cash_notes'];?>" />
				
				<div class="section section-33">
					 <div class="section section-60">
						<p><?= gettext("P.3: Date")?></p>
						<input type="date" class="input-field" name="postal" value="" />
					</div>
					<div class="section section-40">
						<p><?= gettext("P.3: Amount")?></p>
						<input type="text" class="input-field" name="postal" value="" />
					</div>
				</div>
			</div>
		</div>
		-->
		
		<?php 
			include 'formterms.php';
		?>
		<div class="row">
			<div class="section section-100">
				<?= gettext("SIGNED ON")?> <input type="date" class="input-field initial-width mandatory" name="signeddate" value="<?php echo $rowFC['signature_date'];?>"> <?= gettext("AT")?> <input type="text" class="input-field width-50" name="signedaddress" placeholder="Street Address, City, Province, Postal Code" value="<?php echo $rowFC['signature_address'];?>">
			</div>
			<div class="section section-50">
				<p><?= gettext("Merchant:")?> <span class="required">*</span></p>
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
				<p><?= gettext("Consumer(s):")?> <span class="required">*</span></p>
				<input type="text" class="input-field mandatory" name="signedconsumer1" placeholder="FULL NAME" value="<?php echo $rowFC['signature_consumer_name'];?>">
				<input type="hidden" class="" name="signed2" id="signed2" value="<?php echo $rowFC['signature_consumer_url'];?>">
				<div id="signature-pad2">
					<div class="m-signature-pad--body">
						<img alt="Merchant Signature" src="<?php echo "images/signatures/".$rowFC['signature_consumer_url']; ?>">
					</div>
				</div>
				<?php 
					$s2 = str_replace(" ", "", trim($rowFC['signature_consumer2_name']));
					if ($s2 != "") {
				?>
				<input type="text" class="input-field" name="signedconsumer2" placeholder="FULL NAME" value="<?php echo $rowFC['signature_consumer2_name'];?>">
				<input type="hidden" class="" name="signed3" id="signed3" value="<?php echo $rowFC['signature_consumer2_url'];?>">
				<div id="signature-pad3">
					<div class="m-signature-pad--body">
						
						<img alt="Merchant Signature" src="<?php echo "images/signatures/".$rowFC['signature_consumer2_url']; ?>">
						
					</div>
				</div>
				<?php 
					}
				?>
			</div>
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="row">
			<div class="section section-100">
				<p><?= gettext(" ")?></p>
				<!--<input type="button" value="Validate" />-->
				<input type="submit" name="submitform" value="<?= gettext('Save')?>" class="right"/>
			</div>
		</div>
			
	</form>
</div>

<?php 
}
include 'formbottom.php';
echo "</div>";
?>
