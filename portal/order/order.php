<?php 
include 'formtop.php';

error_reporting(E_ERROR | E_PARSE);

$sql = "SELECT * FROM form_completion WHERE id=0 LIMIT 1";

$result = $conn->query($sql);
$rowFC = $result->fetch_assoc();

if (isset($_POST['nff']) && $_POST['nff'] !== "")
{
	$nff = $_POST['nff'];
	$sql = "SELECT * FROM customer WHERE nff='$nff' LIMIT 1";
	
	$result = $conn->query($sql);
	$rowC = $result->fetch_assoc();
	
	$firstname = $row2["firstname"];
	$lastname = $row2["lastname"];
}
?>

<div class="form-style-2">
	<form method="post"  action="../actions/action.php" autocomplete="on"> <!-- onsubmit="return validateForm()" -->
	
		<input type="hidden" name="userid" value="<?php echo $user_id;?>"/>
		<input type="hidden" name="customerid" value="<?= $rowC['id'] ? $rowC['id'] : '' ?>"/>
		<input type="hidden" name="lang" value="<?php echo isset($_POST['lang'])?$_POST['lang']:"fr"?>"/>
		<input type="hidden" name="since" value="<?php echo isset($_POST['dateSince'])?$_POST['dateSince']:"";?>"/>
		<div class="row">
			<div class="form-style-2-heading"><?= gettext(" ")?></div>
			<div class="section section-40">
				<p><?= gettext("Last Name")?> <span class="required">*</span></p>
				<input type="text" class="input-field mandatory" name="lastname" value="<?= $rowC['firstname'] ?>" id="prefillLastName" oninput="prefill1()"/>
			</div>
			<div class="section section-40">
				<p><?= gettext("First Name")?> <span class="required">*</span></p>
				<input type="text" class="input-field mandatory" name="firstname" value="<?= $rowC['lastname'] ?>" id="prefillFirstName" oninput="prefill1()"/>
			</div>
<!-- 			
			<div class="section section-10">
				<p><?= gettext("Given Partner")?></p>
				<input type="radio" class="checkbox-field" name="married" value="partner" />
			</div> 
-->
			
			<div class="section section-20">
				<p><?= gettext("NFF")?></p>
				<input type="text" class="input-field <?= $admin_flag=='1'?"":"disabled" ?>" tabIndex="-1" name="nff" id="prefillNFF" value="<?= $rowC['nff'] ?>" <?= $admin_flag=='1'?"":"readonly" ?>/>
			</div>
		</div>
		<div class="row">
			<div class="section section-60">
				<p><?= gettext("Email")?> <span class="required">*</span></p>
				<input type="email" class="input-field mandatory" name="email" value="<?= $rowC['email'] ?>" />
			</div>	
			<div class="section section-40">
				<p><?= gettext("Tel Home")?> <span class="required">*</span></p>
			    <span>
				    <input type="tel" class="tel-number-field mandatory" name="phone" value="<?= $rowC['phone'] ?>" maxlength="10" />
				</span>
			</div>
			<div class="section section-40">
			    <p><?= gettext("Tel Work")?></p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="workphone" value="<?= $rowC['workphone'] ?>" maxlength="10" />	
			    </span>
			</div>
			<div class="section section-40">
			    <p><?= gettext("Fax")?></p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="fax" value="<?= $rowC['fax'] ?>" maxlength="10" />	
			    </span>
			</div>
			<div class="section section-20">
				<p><?= gettext("Marital Status")?></p>
				  <select name="maritalstatus" class="select-field">
				  	<option selected></option>
				  	<option <?php if ($rowC["maritalstatus"]==="SINGLE") echo "selected";?>>Single</option>
				    <option <?php if ($rowC["maritalstatus"]==="MARRIED") echo "selected";?>>Married</option>
				    <option <?php if ($rowC["maritalstatus"]==="GIVEN PARTNER") echo "selected";?>>Given Partner</option>
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
				<input type="text" class="input-field" name="lastname2" id="prefillLastName2" value="<?= $rowC['lastname2'] ?>" oninput="prefill2()"/>
			</div>
			<div class="section section-50">
				<p><?= gettext("First Name")?></p>
				<input type="text" class="input-field" name="firstname2" id="prefillFirstName2" value="<?= $rowC['firstname2'] ?>" oninput="prefill2()"/>
			</div>
		</div>
		<div class="row">
			<div class="section section-60">
				<p><?= gettext("Email")?></p>
				<input type="email" class="input-field" name="email2" value="<?= $rowC['email2'] ?>" />
			</div>
			<div class="section section-40">
			    <p><?= gettext("Tel")?></p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="phone2" value="<?= $rowC['phone2'] ?>" maxlength="10" />	
			    </span>
			</div>
			<div class="section section-0">
			    <p><?= gettext("Fax")?></p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="fax2" value="<?= $rowC['fax2'] ?>" maxlength="10" />	
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
				<input type="text" class="input-field mandatory" name="streetaddress1" value="<?= $rowC['streetaddress1'] ?>" />
			</div>
			<div class="section section-50">
				<p><?= gettext("Address Line 2")?></p>
				<input type="text" class="input-field" name="streetaddress2" value="<?= $rowC['streetaddress2'] ?>" />
			</div>
		</div>
		
		<div class="row">
			<div class="section section-40">
				<p><?= gettext("City")?> <span class="required">*</span></p>
				<input type="text" class="input-field mandatory" name="city" id="city" value="<?= $rowC['city'] ?>" oninput="fillAddress()"/>
			</div>
			<div class="section section-20">
				<p><?= gettext("Province")?> <span class="required">*</span></p>
				<select name="province" class="select-field mandatory" id="province" oninput="fillAddress()">
				  	<option selected></option>
				  	<option <?php if ($rowC["province"]==="AB") echo "selected";?>>AB</option>
				  	<option <?php if ($rowC["province"]==="BC") echo "selected";?>>BC</option>
				  	<option <?php if ($rowC["province"]==="MB") echo "selected";?>>MB</option>
				  	<option <?php if ($rowC["province"]==="NB") echo "selected";?>>NB</option>
				  	<option <?php if ($rowC["province"]==="NL") echo "selected";?>>NL</option>
				    <option <?php if ($rowC["province"]==="NS") echo "selected";?>>NS</option>
				    <option <?php if ($rowC["province"]==="ON") echo "selected";?>>ON</option>
				    <option <?php if ($rowC["province"]==="PE") echo "selected";?>>PE</option>
				    <option <?php if ($rowC["province"]==="QC") echo "selected"; if ($rowC["province"]=="") echo "selected";?>>QC</option>
				    <option <?php if ($rowC["province"]==="SK") echo "selected";?>>SK</option>
				</select>
			</div>
			<div class="section section-20">
				<p><?= gettext("Postal Code")?> <span class="required">*</span></p>
				<input type="text" class="input-field postalcode mandatory" name="postal" value="<?= $rowC['postalcode'] ?>" />
			</div>
			<div class="section section-20">
				<p><?= gettext("Sector")?></p>
				<input type="text" class="input-field" name="sector" value="<?= $rowC['sector'] ?>" list="sectors"/>
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
				<input type="number" class="tel-number-field" name="howlong" value="<?= $rowC['howlongyear'] ?>" />
			</div>
			<div class="section section-15">
				<p><?= gettext("Owner")?></p>
				<input type="radio" class="checkbox-field" name="owner" value="1" <?php if ($rowC["owner"]==='1') echo "checked";?> />
			</div>
			<div class="section section-10">
				<p><?= gettext("Tenant")?></p>
				<input type="radio" class="checkbox-field" name="owner" value="1" <?php if ($rowC["owner"]==='0') echo "checked";?> />
			</div>			
		</div>
		
		<div class="row">
			<div class="space1"></div>
			<a onclick="startOrder()" id="startorder" style='display: none;font-size:16px;padding: 5px; border: 4px solid green; float: right' class="close" >START ORDER</a>
		</div>
		
		<div id="myorder">
			<div class="row" id="shopTop">
				<div class="space1"></div>
			</div>
			<div class="form-style-2-heading">
				<?= gettext("Product List")?>
				<a href='#mycart' style='float: right'><i class='fa fa-shopping-cart'></i> <?= gettext("VIEW MY ORDER"); ?></a>
				<a href='#mycart' onclick='addAllProducts()' style='float: right; margin-right: 20px'><i class='fa fa-cart-plus'></i> <?= gettext("ALL PRODUCTS TO CART"); ?></a>
			</div>
			
			<div class="row" id="shop">
				<?php include 'addProducts1.php';?>
			</div>
		</div>
		
		<div class="row">
			<a onclick="endOrder()" id="endorder" style='font-size:16px;padding: 5px; border: 4px solid green; float: right; cursor: pointer;'>END ORDER</a>
		</div>
		
		<div id="mycart" class="overlay">
			<div class="popup">
				<div class="title" id='topCartMenu'>
					<p id="cartCustomerName"></p>
					<h2><?= gettext("MY ORDER LIST")?></h2>
					<p class="cartPoints"><?= gettext("Total Points Selected:")?> <i id="cartPoints">0</i></p>
					<a class="close" onclick="checkQuatity()">CONTINUE</a>
					<a class="close" onclick="validateCart()" style="margin-right: 30px"><?= gettext('VALIDATE CART')?></a>
					<a class="close" onclick="clearAllProducts()" style="margin-right: 30px; border: 2px solid #ee5f5b;">CLEAR ALL</a>
				</div>
				<div class="clear"></div>
				<div class="formproducts" id="form-print2">
					<div class="section section-33">
						<p><?= gettext("Products")?></p>
					</div>
					<div class="section section-10">
						<p><?= gettext("Codes")?></p>
					</div>
					<div class="section section-25">
						<p><?= gettext("Size")?> <span class="required">*</span></p>
					</div>
					<div class="section section-30">
						<div class="section section-20" style="background-color: #62c462; color: #fff;">
							<p class="quantity"><?= gettext("1st")?> <span class="required">*</span></p>
						</div>
						<div class="section section-20" style="background-color: #fb7a2c; color: #fff;">
							<p class="quantity"><?= gettext("2nd")?> <span class="required">*</span></p>
						</div>
						<div class="section section-20" style="background-color: #ee5f5b; color: #fff;">
							<p class="quantity"><?= gettext("3rd")?> <span class="required">*</span></p>
						</div>
						<div class="section section-15" style="background-color: #0088cc; color: #fff;">
							<p class="quantity"><?= gettext("PTS")?> <span class="required"></span></p>
						</div>
						<div class="section section-25" style="background-color: #2744ee; color: #fff;">
							<p class="quantity">1 ONLY <input type="checkbox" name='oneonly' id='oneonly' onchange='oneOnly()' /></p>
						</div>
					</div>
					<div class="section section-5">
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
				<textarea name="notice2" class="textarea-field"></textarea>
			</div>
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="form-style-2-heading"><?= gettext("Order Summary")?></div>
		
		<div class="row">
			<div class="section section-50">
				<p><?= gettext("Contract Notes")?></p>
				<textarea name="notice" class="textarea-field"></textarea>
			</div>
			<div class="section section-25">
				<p><?= gettext("Total Points")?></p>
				<input type="number" class="input-field disabled" min="0" max="999999" step="1" tabIndex="-1" name="points" id="points" value="" readonly/>
			</div>
			<div class="section section-25">
				<p><?= gettext("Sales Price")?> <span class="required">*</span></p>
				<input type="number" class="input-field mandatory" min="0" max="999999" step="0.01" tabIndex="-1" name="price" id="price" oninput="updateTotal()" value="" />
			</div>
			<div class="section section-25">
				<p><?= gettext("Rebate")?></p>
				<input type="number" class="input-field"  min="0" max="999999" step="0.01"  name="rebate" id="rebate" value="" oninput="updateTotal()"/>
			</div>
			<div class="section section-25">
				<p><?= gettext("Deposit")?></p>
				<input type="number" class="input-field" min="0" max="999999" step="0.01" name="deposit" id="deposit" value="" oninput="updateTotal()"/>
			</div>
			<div class="section section-25">
				<p><?= gettext("Sub Total")?></p>
				<input type="number" class="input-field disabled" min="0" max="999999" step="0.01" tabIndex="-1" name="subtotal" id="subtotal" value="" readonly/>
			</div>
			<div class="section section-25">
				<p><?= gettext("Total Balance")?></p>
				<input type="number" class="input-field disabled" min= "0" max="999999" step="0.01"tabIndex="-1" name="total" id="total" value="" readonly/>
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
			    	<option value="1"><?= gettext("Visa / Master Card")?></option>
			    	<option value="2"><?= gettext("Pre-Authorized Payment")?></option>
			    	<option value="3"><?= gettext("Cash / Cheque")?></option>
			    </select>
				<!--  <input type="checkbox" class="input-checkbox" name="hascredit" value="1" />-->
			</div>
			<div class="section section-60">
				<div class="section section-33">
					<input type="date" class="input-field initial-width" name="payment1" id="payment1"> 
				</div>
				<div class="section section-33">
					<input type="date" class="input-field initial-width" name="payment2" id="payment2">
				</div>
				<div class="section section-33">
					<input type="date" class="input-field initial-width" name="payment3" id="payment3"> 
				</div>
			</div>
			<!-- 
			<div class="section section-80">
				<p><?= gettext("Notes")?><?= gettext(" (Do not include credit card information on this form)")?></p>
				<input type="text" class="input-field" name="notes1" value="" />
				
				<div class="row">
					<div class="section section-30">
						<p><?= gettext("Visa / Master Card #")?></p>
						<input type="text" class="tel-number-field cc_number" name="creditcard" value="" />
					</div>
					<div class="section section-10">
						<p><?= gettext("Month")?></p>
						<input type="text" class="tel-number-field cc_month" name="creditmonth" value="" maxlength="2"/>
					</div>
					<div class="section section-10">
						<p><?= gettext("Year")?></p>
						<input type="text" class="tel-number-field cc_year" name="credityear" value="" maxlength="4"/>
					</div>
					<div class="section section-10">
						<p><?= gettext("CCV")?></p>
						<input type="text" class="tel-number-field cc_ccv" name="creditccv" value="" maxlength="3"/>
					</div>
					<div class="section section-40">
						<p><?= gettext("Name on the Card")?></p>
						<input type="text" class="input-field" name="creditname" value="" />
					</div>
				</div>
			</div> -->
		</div>
		<!-- 
		<div class="row">
			<div class="section section-20">
				<p><?= gettext("Pre-Authorized Payment")?></p>
				<input type="checkbox" class="input-checkbox" name="haspreauthorized" value="1" />
			</div>
			<div class="section section-80">
				<p><?= gettext("Notes")?></p>
				<input type="text" class="input-field" name="notes2" value="" />
			</div>
		</div>
		
		<div class="row">
			<div class="section section-20">
				<p><?= gettext("Cash / Cheque")?></p>
				<input type="checkbox" class="input-checkbox" name="hascash" value="1" />
			</div>
			<div class="section section-80">
				<p><?= gettext("Notes")?></p>
				<input type="text" class="input-field" name="notes3" value="" />
				
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
				<?= gettext("SIGNED ON")?> 
				<input type="date" class="input-field initial-width mandatory" name="signeddate" id="signeddate"> 
				<?= gettext("AT")?> <input type="text" class="input-field width-50" name="signedaddress" id="signedaddress" placeholder="City, Province">
			</div>
			<div class="section section-50">
				<p><?= gettext("Merchant:")?> <span class="required">*</span></p>
				<input type="text" class="input-field mandatory" name="signedmerchant"
					placeholder="FULL NAME" value="<?php echo $user_name;?>" readonly>
				<input type="hidden" class="" name="signed1" id="signed1">
				<div id="signature-pad1">
					<div class="m-signature-pad--body">
						<div class="left">
							<i><?= gettext("Sign here")?></i>
						</div>
						<div class="right">
							<button type="button" class="button clear" data-action="clear">Clear</button>
						</div>
						<canvas></canvas>
					</div>
				</div>
			</div>
			<div class="section section-50">
				<p><?= gettext("Consumer(s):")?> <span class="required">*</span></p>
				<input type="text" class="input-field mandatory" name="signedconsumer1" id="signedconsumer1" placeholder="FULL NAME" readonly>
				<input type="hidden" class="" name="signed2" id="signed2">
				<div id="signature-pad2">
					<div class="m-signature-pad--body">
						<div class="left">
							<i><?= gettext("Sign here")?></i>
						</div>
						<div class="right">
							<button type="button" class="button clear" data-action="clear">Clear</button>
						</div>
						<canvas></canvas>
					</div>
				</div>
				<div id="signedconsumersection2">
					<input type="text" class="input-field" name="signedconsumer2" id="signedconsumer2" placeholder="FULL NAME" readonly>
					<input type="hidden" class="" name="signed3" id="signed3">
					<div id="signature-pad3">
						<div class="m-signature-pad--body">
							<div class="left">
								<i><?= gettext("Sign here")?></i>
							</div>
							<div class="right">
								<button type="button" class="button clear" data-action="clear"><?= gettext("Clear")?></button>
							</div>
							<canvas></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="row">
			<div class="section section-100">
				<p><?= gettext(" ")?></p>
				<!--<input type="button" value="Validate" />-->
				<input type="submit" name="submitform" value="<?= gettext('Preview & Submit')?>" class="right"/>
			</div>
		</div>
			
	</form>
  </div>
</div>
<?php 
include 'formbottom.php';
?>
<script>
prefill1();
prefill2();
fillAddress();

function startOrder() {
	document.getElementById('startorder').style.display = "none";
	document.getElementById('endorder').style.display = "block";

	document.getElementById('myorder').style.display = "block";
	document.getElementById('mycart').classList.add("overlay");

	document.getElementById('topCartMenu').style.display = "block";
}

function endOrder() {
	document.getElementById('startorder').style.display = "block";
	document.getElementById('endorder').style.display = "none";

	document.getElementById('myorder').style.display = "none";
	document.getElementById('mycart').classList.remove("overlay");

	document.getElementById('topCartMenu').style.display = "none";
}

function oneOnly() {
	var dels;
	if (document.getElementById('oneonly').checked) 
  	{
		dels = document.getElementsByClassName('delivered1');
		for (var i=0; i<dels.length; i++) {
			dels[i].setAttribute('disabled', true);
			dels[i].classList.add("disabled");
			dels[i].value = 0;
		}
		dels = document.getElementsByClassName('delivered2');
		for (var i=0; i<dels.length; i++) {
			dels[i].setAttribute('disabled', true);
			dels[i].classList.add("disabled");
			dels[i].value = 0;
		}
  	} else {
  		dels = document.getElementsByClassName('delivered1');
  		for (var i=0; i<dels.length; i++) {
			dels[i].removeAttribute('disabled');
			dels[i].classList.remove("disabled");
		}
		dels = document.getElementsByClassName('delivered2');
		for (var i=0; i<dels.length; i++) {
			dels[i].removeAttribute('disabled');
			dels[i].classList.remove("disabled");
		}
  	}
}
</script>