<?php 
include 'formtopdemo.php';

$sql = "SELECT * FROM form_completion WHERE id=0 LIMIT 1";

$result = $conn->query($sql);
$rowFC = $result->fetch_assoc();
?>

<style>
.demo {
	display: none;
}
</style>

<div class="form-style-2">
	<form method="post"  action="../actions/actiondemo.php" autocomplete="on"> <!-- onsubmit="return validateForm()" -->
	
		<input type="hidden" name="lang" value="<?php echo $_GET['lang']?>"/>
		<input type="hidden" name="userid" value="<?php echo $user_id;?>"/>
		<input type="hidden" name="redirect" value="<?php echo $_GET['lang']=='en'?"http://naturalfarms.ca/thank-you/":"http://www.lafermeaunaturel.com/merci/"; ?>"/>
		<div class="row">
			<div class="form-style-2-heading"><?= gettext(" ")?></div>
			<div class="section section-40">
				<p><?= gettext("Name")?> *</p>
				<input type="text" class="input-field mandatory" name="lastname" value="" id="prefillLastName" oninput="prefill1()" required/>
			</div>
			<!--
			<div class="section section-40">
				<p><?= gettext("First Name")?> </p>
				<input type="text" class="input-field mandatory" name="firstname" value="" id="prefillFirstName" oninput="prefill1()"/>
			</div>
 			
			<div class="section section-10">
				<p><?= gettext("Given Partner")?></p>
				<input type="radio" class="checkbox-field" name="married" value="partner" />
			</div> 

			
			<div class="section section-20">
				<p><?= gettext("NFF")?></p>
				<input type="text" class="input-field disabled" tabIndex="-1" name="nff" value="" readonly/>
			</div>
			-->
			<div class="section section-40">
				<p><?= gettext("Email")?> *</p>
				<input type="email" class="input-field mandatory" name="email" value="" required/>
			</div>	
			<div class="section section-20">
				<p><?= gettext("Tel Home")?></p>
			    <span>
				    <input type="tel" class="tel-number-field" name="phone" value="" maxlength="10" />
				</span>
			</div>
		</div>
		
		<!--  
			<div class="section section-25">
			    <p><?= gettext("Tel Work")?></p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="workphone" value="" maxlength="10" />	
			    </span>
			</div>
			<div class="section section-25">
			    <p><?= gettext("Fax")?></p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="fax" value="" maxlength="10" />	
			    </span>
			</div>
		</div>
		
		<div class="row">
			<div class="section section-25">
				<p><?= gettext("Marital Status")?></p>
				  <select name="maritalstatus" class="select-field">
				  	<option selected></option>
				  	<option>Single</option>
				    <option>Married</option>
				    <option>Given Partner</option>
				  </select>
 				<input type="radio" class="checkbox-field" name="married" value="married" />
			</div>
			<div class="section section-25">
				<p><?= gettext("# of Dependent")?></p>
				<input type="number" class="tel-number-field" name="dependent" value="" />
			</div>
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="form-style-2-heading"><?= gettext("Additional Information")?></div>
		
		<div class="row">
			<div class="section section-40">
				<p><?= gettext("Last Name")?></p>
				<input type="text" class="input-field" name="lastname2" id="prefillLastName2" value="" oninput="prefill2()"/>
			</div>
			<div class="section section-40">
				<p><?= gettext("First Name")?></p>
				<input type="text" class="input-field" name="firstname2" id="prefillFirstName2" value="" oninput="prefill2()"/>
			</div>
		</div>
		<div class="row">
			<div class="section section-30">
				<p><?= gettext("Email")?></p>
				<input type="email" class="input-field" name="email2" value="" />
			</div>
			<div class="section section-25">
			    <p><?= gettext("Tel")?></p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="phone2" value="" maxlength="10" />	
			    </span>
			</div>
			<div class="section section-25">
			    <p><?= gettext("Fax")?></p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="fax2" value="" maxlength="10" />	
			    </span>
			</div>
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="form-style-2-heading"><?= gettext("Address Information")?></div>
		
		<div class="row">
			<div class="section section-50">
				<p><?= gettext("Address Line 1")?></p>
				<input type="text" class="input-field mandatory" name="streetaddress1" value="" />
			</div>
			<div class="section section-50">
				<p><?= gettext("Address Line 2")?></p>
				<input type="text" class="input-field" name="streetaddress2" value="" />
			</div>
		</div>
		
		<div class="row">
			<div class="section section-40">
				<p><?= gettext("City")?> </p>
				<input type="text" class="input-field mandatory" name="city" id="city" value="" oninput="fillAddress()"/>
			</div>
			<div class="section section-20">
				<p><?= gettext("Province")?> </p>
				<select name="province" class="select-field mandatory" id="province" oninput="fillAddress()">
				  	<option selected></option>
				  	<option>AB</option><option>BC</option><option>MB</option><option>NB</option><option>NL</option>
				    <option>NS</option><option>ON</option><option>PE</option><option>QC</option><option>SK</option>
				</select>
			</div>
			<div class="section section-20">
				<p><?= gettext("Postal Code")?> </p>
				<input type="text" class="input-field postalcode mandatory" name="postal" value="" />
			</div>
			<div class="section section-20">
				<p><?= gettext("Sector")?></p>
				<input type="text" class="input-field" name="sector" value="" />
			</div>			
		</div>
		
		<div class="row">
			<div class="section section-30">
				<p><?= gettext("How many years at this address?")?></p>
				<input type="number" class="tel-number-field" name="howlong" value="" />
			</div>
			<div class="section section-15">
				<p><?= gettext("Owner")?></p>
				<input type="radio" class="checkbox-field" name="owner" value="1" />
			</div>
			<div class="section section-10">
				<p><?= gettext("Tenant")?></p>
				<input type="radio" class="checkbox-field" name="owner" value="0" />
			</div>			
		</div>
		-->
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="form-style-2-heading">
			<?= gettext("Product List")?>
			<a href='#mycart' style='float: right'><i class='fa fa-shopping-cart'></i> <?= gettext("VIEW MY ORDER"); ?></a>
		</div>
		
		<div class="row" id="shop">
			
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
							<span id="tab-<?php echo $rowCat['slug']; ?>" class="tabTitle active" onclick="showTab('<?php echo $rowCat['slug']; ?>')"><?php echo ($language == "en_US")?$rowCat['name_en']:$rowCat['name_fr']; ?></span>
				<?php 
						}
						else {
				?>
							<span id="tab-<?php echo $rowCat['slug']; ?>" class="tabTitle" onclick="showTab('<?php echo $rowCat['slug']; ?>')"><?php echo ($language == "en_US")?$rowCat['name_en']:$rowCat['name_fr']; ?></span>
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
						
						$codes = " [ ";
						
						while ($row2 = mysqli_fetch_array($results2))
						{
							$details = array();
							array_push($details, $row2['id']);
							array_push($details, $row2['point']);
							
							$sql3 = "SELECT * FROM product_packaging WHERE id=".$row2['packaging_id']." LIMIT 1";
							$results3 = mysqli_query($conn, $sql3) or die ($sql3."<br>".mysqli_error());
							$row3 = mysqli_fetch_array($results3);
							array_push($details, "[". $row2['code'] ."] " . $row3['type'] . " : " . $row3['quantity']);
							
							array_push($cart, $details);
							
							$codes .= $row2['code'] . ', ';
						}
						
						$codes = rtrim($codes, ', ');
						$codes .= " ] ";
						
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
						$width = str_replace(",", ".", (100/$numOfColumns));
						$name = ($language == "en_US")?$row['name_en']:$row['name_fr'];
						echo "<li class='section product-display' style='width:".$width."%;'>";
						echo "<span onclick='addProduct(this)' data-image='".$row['image_name']."' data-name='".$row['name_fr']."' data-details='".$details."' data-id='".$row['id']."'>";
						echo "<a href='#mycart'><img src='../order/images/products/".$row['image_name']."' alt='productImage' /></a>";
						echo "</span>";
						echo "<div class='pname' onclick='addProduct(this)' data-image='".$row['image_name']."' data-name='".$row['name_fr']."' data-details='".$details."' data-id='".$row['id']."'>
				    		  <p>".$name.$codes."</p>".
    		                 "<a href='#mycart' class='product-item-select'><span class='perPdtPts' id='perPdtPts".$row['id']."'></span><span>". gettext("Add") . "</span></a></div>";
						echo "</li>";
					}
					echo "</ul>";
					
					?>
				</div>
				<?php } ?>
			</div>
			
			<div class="clear"></div>

		</div>
		
		<div id="mycart" class="overlay">
			<div class="popup">
				<div class="title">
					<h2><?= gettext("MY ORDER LIST")?></h2>
					<p class="cartPoints"><?= gettext("Total Points Selected:")?> <i id="cartPoints">0</i></p>
					<a class="close" onclick="checkQuatity()">CONTINUE</a>
				</div>
				<div class="clear"></div>
				<div class="formproducts">
					<div class="section section-40">
						<p><?= gettext("Products")?></p>
					</div>
					<div class="section section-30">
						<p><?= gettext("Size")?> </p>
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
				<p><?= isset($_GET['lang'])&&$_GET['lang']=='en'?"Comments":"Commentaires" ?></p>
				<textarea name="notice" class="textarea-field"></textarea>
			</div>
			<div class="section section-25">
				<p><?= gettext("Total Points")?></p>
				<input type="number" class="input-field disabled" min="0" max="999999" step="1" tabIndex="-1" name="points" id="points" value="" readonly/>
			</div>
			<!--  
			<div class="section section-25">
				<p><?= gettext("Sales Price")?> </p>
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
			-->
		</div>
		<!--  
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="form-style-2-heading"><?= gettext("Payment Information")?></div>
		
		<div class="row">
			<div class="section section-20">
				<p><?= gettext("Visa / Master Card")?></p>
				<input type="checkbox" class="input-checkbox" name="hascredit" value="1" />
			</div>
			<div class="section section-80">
				<p><?= gettext("Notes")?></p>
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
			</div>
		</div>
		
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
				
				<!--<div class="section section-33">
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
			//include 'formterms.php';
		?>
		<!--  
		<div class="row">
			<div class="section section-100">
				<?= gettext("SIGNED ON")?> <input type="date" class="input-field initial-width mandatory" name="signeddate" id="signeddate"> <?= gettext("AT")?> <input type="text" class="input-field width-50" name="signedaddress" id="signedaddress" placeholder="City, Province">
			</div>
			<div class="section section-50">
				<p><?= gettext("Merchant:")?> </p>
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
				<p><?= gettext("Consumer(s):")?> </p>
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
		-->
		<div class="row">
			<div class="section section-100">
				<p><?= gettext(" ")?></p>
				<!--<input type="button" value="Validate" />-->
				<input type="submit" name="submitform" value="<?= gettext('Submit')?>" class="right"/>
			</div>
		</div>
			
	</form>
  </div>
</div>
<?php 
$numOfRows = 100;
include '../order/formbottom.php';
?>