
<?php 
//error_reporting(E_ERROR);

include 'formtop.php';

if (isset($_GET['id'])) {
	$fid = $_GET['id'];

	$sql = "SELECT * FROM form_completion WHERE id=".$fid." LIMIT 1;";

	$result = $conn->query($sql);
	$rowFC = $result->fetch_assoc();
	
	$sql2 = "SELECT * FROM customer WHERE id=".$rowFC['customer_id']." LIMIT 1";
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
		</div>
		<div class="row">
			<div class="section section-60">
				<p><?= gettext("Email")?></p>
				<input type="email" class="input-field mandatory" name="email" value="<?php echo $row2["email"];?>" />
			</div>	
			<div class="section section-40">
				<p><?= gettext("Tel Home")?></p>
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
		
		<div class="row">
			
		</div>
		
		<div class="form-style-2-heading" style="display:none"><?= gettext("Product List")?></div>
		
		<div id="mycart3" class="overlay3" style="display:none">
			<div class="popup3">
				<div class="clear"></div>
				<div class="formproducts">
					<div class="section section-33">
						<p><?= gettext("Products")?></p>
					</div>
					<div class="section section-10">
						<p><?= gettext("Codes")?></p>
					</div>
					<div class="section section-25">
						<p><?= gettext("Size")?></p>
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
			    	<option value="0" selected><?= gettext("No Payment Method")?></option>
			    	<option value="1" <?php echo $rowFC['cc_flag']==1?"selected":""?>><?= gettext("Visa / Master Card")?></option>
			    	<option value="2" <?php echo $rowFC['preauthorized_flag']==1?"selected":""?>><?= gettext("Pre-Authorized Payment")?></option>
			    	<option value="3" <?php echo $rowFC['cash_flag']==1?"selected":""?>><?= gettext("Cash / Cheque")?></option>
			    </select>
				<!--  <input type="checkbox" class="input-checkbox" name="hascredit" value="1" />-->
			</div>
			<div class="section section-60">
				<div class="section section-33">
					<input type="date" class="input-field initial-width" name="payment1" id="payment1" value="<?php echo $rowFC['payment1']?>"> 
				</div>
				<div class="section section-33">
					<input type="date" class="input-field initial-width" name="payment2" id="payment2" value="<?php echo $rowFC['payment2']?>">
				</div>
				<div class="section section-33">
					<input type="date" class="input-field initial-width" name="payment3" id="payment3" value="<?php echo $rowFC['payment3']?>"> 
				</div>
			</div>	
		</div>
		
		<div class="row">
			
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
			
	</form>
</div>
</div>
<?php 
}
include 'formbottom.php';
?>
<script>
$(document).ready(function() {
	var initials = document.getElementById("firstname").value.charAt(0) + "." + document.getElementById("lastname").value.charAt(0)  + ".";
	$("#contract :input").attr("disabled", true);
	$("#contract :select").attr("disabled", true);
	$(".initials").html(initials);
});
	</script>
	
<div class="row">
			<div class="space1"></div>
		</div>