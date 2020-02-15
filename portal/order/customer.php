<?php 

include '../inc/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM customer WHERE id=$id";
    $sql2 = "SELECT * FROM form_completion WHERE customer_id=$id";
    
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

?>
<div class="form-style-2">
	<div class="form-style-2-heading"><?php echo $row["firstname"]." ". $row["lastname"];?></div>
	<form method="post" id="validate1" action="../actions/actionedit.php"> <!-- onsubmit="return validateForm()" -->
		<div class="form-style-2-heading"></div>
		<div class="row">
			<div class="section section-40">
				<p>Last Name <span class="required">*</span></p>
				<input type="text" class="input-field mandatory" name="lastname" value="<?php echo $row["lastname"];?>" />
			</div>
			<div class="section section-40">
				<p>First Name <span class="required">*</span></p>
				<input type="text" class="input-field mandatory" name="firstname" value="<?php echo $row["firstname"];?>" />
			</div>
<!-- 			
			<div class="section section-10">
				<p>Given Partner</p>
				<input type="radio" class="checkbox-field" name="married" value="partner" />
			</div> 
-->
			
			<div class="section section-20">
				<p>NFF</p>
				<input type="text" class="input-field disabled" tabIndex="-1" name="nff" value="<?php echo $row["id"];?>" readonly/>
			</div>
		</div>
		<div class="row">
			<div class="section section-25">
				<p>Email <span class="required">*</span></p>
				<input type="email" class="input-field mandatory" name="email" value="<?php echo $row["email"];?>" />
			</div>	
			<div class="section section-25">
				<p>Tel Home <span class="required">*</span></p>
			    <span>
				    <input type="tel" class="tel-number-field mandatory" name="phone" value="<?php echo $row["phone"];?>" maxlength="10" />
				</span>
			</div>
			<div class="section section-25">
			    <p>Tel Work</p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="workphone" value="<?php echo $row["workphone"];?>" maxlength="10" />	
			    </span>
			</div>
			<div class="section section-25">
			    <p>Fax</p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="fax" value="<?php echo $row["fax"];?>" maxlength="10" />	
			    </span>
			</div>
		</div>
		
		<div class="row">
			<div class="section section-25">
				<p>Marital Status</p>
				  <select name="maritalstatus" class="select-field">
				  	<option selected></option>
				  	<option <?php if ($row["maritalstatus"]==="SINGLE") echo "selected";?>>Single</option>
				    <option <?php if ($row["maritalstatus"]==="MARRIED") echo "selected";?>>Married</option>
				    <option <?php if ($row["maritalstatus"]==="GIVEN PARTNER") echo "selected";?>>Given Partner</option>
				  </select>
<!-- 				<input type="radio" class="checkbox-field" name="married" value="married" /> -->
			</div>
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="form-style-2-heading">Address Information</div>
		
		<div class="row">
			<div class="section section-50">
				<p>Address Line 1<span class="required">*</span></p>
				<input type="text" class="input-field mandatory" name="streetaddress1" value="<?php echo $row["streetaddress1"];?>" />
			</div>
			<div class="section section-50">
				<p>Address Line 2</p>
				<input type="text" class="input-field" name="streetaddress2" value="<?php echo $row["streetaddress2"];?>" />
			</div>
		</div>
		
		<div class="row">
			<div class="section section-40">
				<p>City <span class="required">*</span></p>
				<input type="text" class="input-field mandatory" name="city" value="<?php echo $row["city"];?>" />
			</div>
			<div class="section section-20">
				<p>Province <span class="required">*</span></p>
				<select name="province" class="select-field mandatory">
				  	<option selected></option>
				  	<option <?php if ($row["province"]==="AB") echo "selected";?>>AB</option>
				  	<option <?php if ($row["province"]==="BC") echo "selected";?>>BC</option>
				  	<option <?php if ($row["province"]==="MB") echo "selected";?>>MB</option>
				  	<option <?php if ($row["province"]==="NB") echo "selected";?>>NB</option>
				  	<option <?php if ($row["province"]==="NL") echo "selected";?>>NL</option>
				    <option <?php if ($row["province"]==="NS") echo "selected";?>>NS</option>
				    <option <?php if ($row["province"]==="ON") echo "selected";?>>ON</option>
				    <option <?php if ($row["province"]==="PE") echo "selected";?>>PE</option>
				    <option <?php if ($row["province"]==="QC") echo "selected";?>>QC</option>
				    <option <?php if ($row["province"]==="SK") echo "selected";?>>SK</option>
				</select>
			</div>
			<div class="section section-20">
				<p>Postal Code <span class="required">*</span></p>
				<input type="text" class="input-field postalcode mandatory" name="postal" value="<?php echo $row["postalcode"];?>"/>
			</div>
			<div class="section section-20">
				<p>Sector</p>
				<input type="text" class="input-field" name="sector" value="<?php echo $row["sector"];?>" />
			</div>			
		</div>
		
		<div class="row">
			<div class="section section-30">
				<p>How many years at this address?</p>
				<input type="number" class="tel-number-field" name="howlong" value="<?php echo $row["howlongyear"];?>" />
			</div>
			<div class="section section-15">
				<p>Owner</p>
				<input type="radio" class="checkbox-field" name="owner" value="1" <?php if ($row["owner"]==='1') echo "checked";?>/>
			</div>
			<div class="section section-10">
				<p>Tenant</p>
				<input type="radio" class="checkbox-field" name="owner" value="0" <?php if ($row["owner"]==='0') echo "checked";?>/>
			</div>			
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="form-style-2-heading">Additional Information</div>
		
		<div class="row">
			<div class="section section-40">
				<p>Last Name</p>
				<input type="text" class="input-field" name="lastname2" value="<?php echo $row["lastname2"];?>" />
			</div>
			<div class="section section-40">
				<p>First Name</p>
				<input type="text" class="input-field" name="firstname2" value="<?php echo $row["firstname2"];?>" />
			</div>
		</div>
		<div class="row">
			<div class="section section-30">
				<p>Email</p>
				<input type="email" class="input-field" name="email2" value="<?php echo $row["email2"];?>" />
			</div>
			<div class="section section-25">
			    <p>Tel</p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="phone2" value="<?php echo $row["phone2"];?>" maxlength="10" />	
			    </span>
			</div>
			<div class="section section-25">
			    <p>Fax</p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="fax2" value="<?php echo $row["fax2"];?>" maxlength="10" />	
			    </span>
			</div>
		</div>
		
		<div class="row">
			<div class="section section-100">
				<p> </p>
				<!--<input type="button" value="Validate" />-->
				<input type="submit" name="submitform" value="Save" class="right"/>
			</div>
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="form-style-2-heading">Orders</div>
			
		<div class="row" id="input_fields_wrap">
			
			<?php

				$result2 = $conn->query($sql2);
				echo "<table>";
				echo "<thead><tr>";
				echo "<td>Date</td><td>Total Points</td><td>Total Price</td><td>First Delivery Date</td><td>Sales Representative</td><td></td>";
				echo "</tr></thead>";
				
				while ($row2 = $result2->fetch_assoc())
				{
					echo "<tr>";
					echo "<td>$row2[signature_date]</td><td>$row2[total_points]</td><td>$row2[price]</td><td>$row2[conditions_firstdeliverydate]</td><td>".
					"$row2[signature_merchant_name]</td><td><a href='edit.php?id=$row2[id]'><i class='fa fa-edit'></i></a></td>".
					"<td><a href='print.php?id=$row2[id]'><i class='fa fa-file-pdf-o'></i></a></td>";
					echo "</tr>";
				}
				echo "</table>";
			?>
		</div>
	</form>
</div>
<?php 
}
else {
?>

<div class="form-style-2">
	<form method="post"  action="../actions/action.php" autocomplete="on" id="validate2"> <!-- onsubmit="return validateForm()" -->
		<div class="form-style-2-heading"></div>
		<div class="row">
			<div class="section section-40">
				<p>Last Name <span class="required">*</span></p>
				<input type="text" class="input-field mandatory" name="lastname" value="" />
			</div>
			<div class="section section-40">
				<p>First Name <span class="required">*</span></p>
				<input type="text" class="input-field mandatory" name="firstname" value="" />
			</div>
<!-- 			
			<div class="section section-10">
				<p>Given Partner</p>
				<input type="radio" class="checkbox-field" name="married" value="partner" />
			</div> 
-->
			
			<div class="section section-20">
				<p>NFF</p>
				<input type="text" class="input-field disabled" tabIndex="-1" name="nff" value="" readonly/>
			</div>
		</div>
		<div class="row">
			<div class="section section-25">
				<p>Email <span class="required">*</span></p>
				<input type="email" class="input-field mandatory" name="email" value="" />
			</div>	
			<div class="section section-25">
				<p>Tel Home <span class="required">*</span></p>
			    <span>
				    <input type="tel" class="tel-number-field mandatory" name="phone" value="" maxlength="10" />
				</span>
			</div>
			<div class="section section-25">
			    <p>Tel Work</p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="workphone" value="" maxlength="10" />	
			    </span>
			</div>
			<div class="section section-25">
			    <p>Fax</p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="fax" value="" maxlength="10" />	
			    </span>
			</div>
		</div>
		
		<div class="row">
			<div class="section section-25">
				<p>Marital Status</p>
				  <select name="maritalstatus" class="select-field">
				  	<option selected></option>
				  	<option>Single</option>
				    <option>Married</option>
				    <option>Given Partner</option>
				  </select>
<!-- 				<input type="radio" class="checkbox-field" name="married" value="married" /> -->
			</div>
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="form-style-2-heading">Address Information</div>
		
		<div class="row">
			<div class="section section-50">
				<p>Address Line 1<span class="required">*</span></p>
				<input type="text" class="input-field mandatory" name="streetaddress1" value="" />
			</div>
			<div class="section section-50">
				<p>Address Line 2</p>
				<input type="text" class="input-field" name="streetaddress2" value="" />
			</div>
		</div>
		
		<div class="row">
			<div class="section section-40">
				<p>City <span class="required">*</span></p>
				<input type="text" class="input-field mandatory" name="city" value="" />
			</div>
			<div class="section section-20">
				<p>Province <span class="required">*</span></p>
				<select name="province" class="select-field mandatory">
				  	<option selected></option>
				  	<option>AB</option><option>BC</option><option>MB</option><option>NB</option><option>NL</option>
				    <option>NS</option><option>ON</option><option>PE</option><option>QC</option><option>SK</option>
				</select>
			</div>
			<div class="section section-20">
				<p>Postal Code <span class="required">*</span></p>
				<input type="text" class="input-field postalcode mandatory" name="postal" value="" />
			</div>
			<div class="section section-20">
				<p>Sector</p>
				<input type="text" class="input-field" name="sector" value="" />
			</div>			
		</div>
		
		<div class="row">
			<div class="section section-30">
				<p>How many years at this address?</p>
				<input type="number" class="tel-number-field" name="howlong" value="" />
			</div>
			<div class="section section-15">
				<p>Owner</p>
				<input type="radio" class="checkbox-field" name="owner" value="1" />
			</div>
			<div class="section section-10">
				<p>Tenant</p>
				<input type="radio" class="checkbox-field" name="owner" value="0" />
			</div>			
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="form-style-2-heading">Additional Information</div>
		
		<div class="row">
			<div class="section section-40">
				<p>Last Name</p>
				<input type="text" class="input-field" name="lastname2" value="" />
			</div>
			<div class="section section-40">
				<p>First Name</p>
				<input type="text" class="input-field" name="firstname2" value="" />
			</div>
		</div>
		<div class="row">
			<div class="section section-30">
				<p>Email</p>
				<input type="email" class="input-field" name="email2" value="" />
			</div>
			<div class="section section-25">
			    <p>Tel</p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="phone2" value="" maxlength="10" />	
			    </span>
			</div>
			<div class="section section-25">
			    <p>Fax</p>
			    <span style="width:100%">
				    <input type="tel" class="tel-number-field" name="fax2" value="" maxlength="10" />	
			    </span>
			</div>
		</div>
		<div class="row">
			<div class="section section-100">
				<p> </p>
				<!--<input type="button" value="Validate" />-->
				<input type="submit" name="submitform" value="Submit" class="right"/>
			</div>
		</div>
	</form>
</div>
<?php	
}

echo "</div>";
?>