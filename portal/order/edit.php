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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.1/jquery.form.min.js" integrity="sha384-tIwI8+qJdZBtYYCKwRkjxBGQVZS3gGozr3CtI+5JF/oL1JmPEHzCEnIKbDbLTCer" crossorigin="anonymous"></script>
   <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I=" crossorigin="anonymous"></script>

   <script>
     // wait for the DOM to be loaded
     $(function() {
       // bind 'myForm' and provide a simple callback function
       $('#myForm').ajaxForm(function() {
           alert("Thank you for your comment!");
       });
     });
   </script>

<div class="form-style-2">
	<form method="post" id="editform"  action="../actions/actionedit.php" autocomplete="on"> <!-- onsubmit="return validateForm()" -->
		<div style="float: right; font-size: 14px"><span class="cartPoints"><?= gettext("Original Points")?>: <i id="oldPoints1" style="font-weight: bold"><?php echo $rowFC["total_points"]?></i></span>
					<span class="cartPoints"><?= gettext("New Points")?>: <i id="cartPoints1"  <?php echo $rowFC["edited_points"] > $rowFC["total_points"] ? 'style="color:red;font-weight: bold;"' : 'style="color:green;font-weight: bold;"' ?>><?php echo $rowFC["edited_points"]?></i></span></div>
		<div class="row">
			<div class="section section-80">
				<h2><?= gettext("Orders For")?>: <?php echo $row2["firstname"] . " " . $row2["lastname"];?> </h2>
			</div>
			<div class="section section-20">
				<p><?= gettext("NFF")?></p>
				<input type="text" class="input-field disabled" tabIndex="-1" name="formid" value="<?php echo $row2["nff"];?>" readonly/>
				<input type="hidden" class="input-field disabled" tabIndex="-1" name="nff" value="<?php echo $row2["id"];?>" readonly/>
				<input type="hidden" class="input-field disabled" tabIndex="-1" name="fid" value="<?php echo $fid;?>" readonly/>
				<input type="hidden" class="input-field disabled" tabIndex="-1" name="email" value="<?php echo $row2["email"];?>" readonly/>
				<input type="hidden" class="input-field disabled" tabIndex="-1" name="phone" value="<?php echo $row2["phone"];?>" readonly/>
				<input type="hidden" class="input-field disabled" tabIndex="-1" name="name" value="<?php echo $row2["firstname"];?>" readonly/>
			</div>
		</div>
		
		<a href='#mycart' style='float: right; padding-top: 20px;'><i class='fa fa-shopping-cart'></i> <?= gettext("VIEW MY ORDER")?></a>
		<div class="row" id="shop">
			<?php include 'addProducts2.php';?>
		</div>
		
		<div id="mycart" class="overlay">
			<div class="popup">
				<div>
				<h2><?php echo $row2["firstname"] . " " . $row2["lastname"];?></h2>
				</div>
				<div class="title">
				    <p><?= $firstname . ' ' . $lastname . ' (NFF: ' . $nff . ')' ?></p>
					<h2><?= gettext("MY ORDER LIST")?></h2>
					<span class="cartPoints"><?= gettext("Original Points")?>: <i id="oldPoints2" style="font-weight: bold"><?php echo $rowFC["total_points"]?></i></span>
					<span class="cartPoints"><?= gettext("New Points")?>: <i id="cartPoints2"  <?php echo $rowFC["edited_points"] > $rowFC["total_points"] ? 'style="color:red;font-weight: bold;"' : 'style="color:green;font-weight: bold;"' ?>><?php echo $rowFC["edited_points"]?></i></span>
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
							<p id="delivered-title1"><?= gettext("Delivered")?></p>
							<p class="quantity"><?= gettext("1st")?> <span class="required">*</span></p>
						</div>
						<div class="section section-25" style="background-color: #fb7a2c; color: #fff;">
							<p id="delivered-title2"><?= gettext("Delivered")?></p>
							<p class="quantity"><?= gettext("2nd")?> <span class="required">*</span></p>
						</div>
						<div class="section section-25" style="background-color: #ee5f5b; color: #fff;">
							<p id="delivered-title3"><?= gettext("Delivered")?></p>
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
				<input type="number" class="input-field disabled" min="0" max="999999" step="1" tabIndex="-1" name="edited_points" id="points" value="<?php echo $rowFC['edited']==1?$rowFC['edited_points']:$rowFC['total_points'];?>" readonly/>
			</div>
			<div class="section section-25">
				<p><?= gettext("Sales Price")?></p>
				<input type="number" class="input-field mandatory" min="0" max="999999" step="0.01" tabIndex="-1" name="edited_price" id="price" oninput="updateTotal()" value="<?php echo $rowFC['edited']==1?$rowFC['edited_price']:$rowFC['price'];?>" <?php echo $customer_flag=='1'?"readonly":"" ?>/>
			</div>
			<div class="section section-25">
				<p><?= gettext("Rebate")?></p>
				<input type="number" class="input-field"  min="0" max="999999" step="0.01"  id="rebate" name="edited_rebate" value="<?php echo $rowFC['edited']==1?$rowFC['edited_rebate']:$rowFC['rebate'];?>" oninput="updateTotal()" <?php echo $customer_flag=='1'?"readonly":"" ?>/>
			</div>
			<div class="section section-25">
				<p><?= gettext("Deposit")?></p>
				<input type="number" class="input-field" min="0" max="999999" step="0.01" id="deposit" name="edited_deposit" value="<?php echo $rowFC['edited']==1?$rowFC['edited_deposit']:$rowFC['deposit'];?>" oninput="updateTotal()" <?php echo $customer_flag=='1'?"readonly":"" ?>/>
			</div>
			<div class="section section-25">
				<p><?= gettext("Sub Total")?></p>
				<input type="number" class="input-field disabled" min="0" max="999999" step="0.01" tabIndex="-1" name="edited_subtotal" id="subtotal" value="<?php echo $rowFC['edited']==1?$rowFC['edited_subtotal']:$rowFC['subtotal'];?>" readonly/>
			</div>
			<div class="section section-25">
				<p><?= gettext("Total Balance")?></p>
				<input type="number" class="input-field disabled" min= "0" max="999999" step="0.01"tabIndex="-1" name="edited_total" id="total" value="<?php echo $rowFC['edited']==1?$rowFC['edited_total']:$rowFC['total'];?>" readonly/>
			</div>
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="row">
			<div class="section section-100">
				<div class="section section-25">
					<?php if ($admin_flag == '1'){?>
						<h2><?= gettext("Approve Updates")?></h2>
						<input type="checkbox" class="checkbox-field"  name="edited_status" id="edited_status" checked/>
					<?php }?>
				</div>
				<div class="section section-25">
					<?php if ($admin_flag == '1'){?>
						<h2><?= gettext("Send Emails")?>?</h2>
						<input type="checkbox" class="checkbox-field"  name="send_email" id="send_email"/>
					<?php }?>
				</div>
				<div class="section section-25">
					<?php if ($admin_flag == '1'){?>
						<h2><?= gettext("Allow Modification")?>?</h2>
						<?php
						    if ($rowFC['edited_status'] === '0') {
						?>
						    <input type="checkbox" class="checkbox-field"  name="allow_modification" id="allow_modification" disabled/>
						<?php
						    } else {
						?>
						    <input type="checkbox" class="checkbox-field"  name="allow_modification" id="allow_modification"/>
					<?php }}?>
				</div>
			
				<p><?= gettext(" ")?></p>
				<!--<input type="button" value="Validate" />-->
				<?php if ($customer_flag == 1) {?>
				<input type="button" name="submitform" value="<?= gettext('Save')?>" class="right" onclick="submitForm()"/>
				<?php }
				else {?>
				<input type="submit" name="submitform" value="<?= gettext('Save')?>" class="right"/>
				<?php }?>
			</div>
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<input type="hidden" class="tel-number-field initial-width disabled" tabIndex="-1" id="conditions-price1" value="<?php echo $rowFC['total'];?>" readonly>
		<input type="hidden" class="tel-number-field initial-width disabled" tabIndex="-1" id="conditions-price2" value="<?php echo $rowFC['total'];?>" readonly>
			
	</form>
</div>
<?php 
if ($customer_flag == 1) {
	?>
<script>
$(document).ready(function() {
	disableDelivered();
	
});

function disableDelivered() {
	var del1 = "<?php echo $rowFC["deliver1"] ?>";
	var del2 = "<?php echo $rowFC["deliver2"] ?>";
	var del3 = "<?php echo $rowFC["deliver3"] ?>";

	var allow = "<?php echo $rowFC["allowAccess"] ?>";

	if (allow === "1") {

		if (del1 === "1")
		{
			$(".delivered1").attr("readonly", true);
			$(".delivered1").addClass("delivered");
			document.getElementById("delivered-title1").style.visibility = "visible";
		}

		if (del2 === "1")
		{
			$(".delivered2").attr("readonly", true);
			$(".delivered2").addClass("delivered");
			document.getElementById("delivered-title2").style.visibility = "visible";
		}

		if (del3 === "1")
		{
			$(".delivered3").attr("readonly", true);
			$(".delivered3").addClass("delivered");
			document.getElementById("delivered-title3").style.visibility = "visible";
		}
	}
	else {
		var next1 = false;
		var next2 = false;
		var next3 = false;

		if (del1 === "1")
		{
			$(".delivered1").attr("readonly", true);
			$(".delivered1").addClass("delivered");
			document.getElementById("delivered-title1").style.visibility = "visible";
			next2 = true;
		}

		if (del2 === "1" || !next2)
		{
			$(".delivered2").attr("readonly", true);
			$(".delivered2").addClass("delivered");
			if (del2 === "1") {
				document.getElementById("delivered-title2").style.visibility = "visible";
				next3 = true;
			}
		}

		if (del3 === "1" || !next3)
		{
			$(".delivered3").attr("readonly", true);
			$(".delivered3").addClass("delivered");
			if (del3 === "1")
				document.getElementById("delivered-title3").style.visibility = "visible";
		}
	}
}

	</script>

	
	<script>
		$(document).ready(function(){
		    $('#editform').submit(ajax);
		})
		function ajax(){
		        $.ajax({
		            url : '../actions/actionedit.php?ajax=yes',
		            type : 'POST',
		            data : $('form').serialize(),
		            success: function(data){
		                $('#resultado').html(data);
		            }
		        });
		        return false;
		}
		window.onload=function(){
		    setInterval(ajax, 5000);
		}

		function submitForm() {
			document.getElementById("editform").submit();
		}
	</script>
	<?php 
}
}
include 'formbottom.php';
echo "</div>";
?>
