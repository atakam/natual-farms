<?php 

include '../inc/header.php';

?>
<style>
body {
	position: absolute;
    width: 100%;
    top: 25%;
    background: url(../img/login.jpg) no-repeat center center fixed;
}
.startpage p, .button {
    font-size: 18px !important;
}
</style>

<style type="text/css">
.form-style-5{
    max-width: 500px;
    padding: 10px 20px;
    background: #f4f7f8;
    margin: 10px auto;
    padding: 40px;
    background: #f4f7f8;
    border-radius: 8px;
    font-family: Georgia, "Times New Roman", Times, serif;
}
.form-style-5 fieldset{
    border: none;
}
.form-style-5 legend {
    font-size: 1.4em;
    margin-bottom: 10px;
}
.form-style-5 label {
    display: block;
    margin-bottom: 8px;
}
.form-style-5 input[type="text"],
.form-style-5 input[type="date"],
.form-style-5 input[type="datetime"],
.form-style-5 input[type="email"],
.form-style-5 input[type="number"],
.form-style-5 input[type="search"],
.form-style-5 input[type="time"],
.form-style-5 input[type="url"],
.form-style-5 textarea,
.form-style-5 select {
    font-family: Georgia, "Times New Roman", Times, serif;
    background: rgba(255,255,255,.1);
    border: none;
    border-radius: 4px;
    font-size: 16px;
    margin: 0;
    outline: 0;
    padding: 7px;
    width: 100%;
    box-sizing: border-box; 
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box; 
    background-color: #e8eeef;
    color:#8a97a0;
    -webkit-box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
    box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
    margin-bottom: 30px;
    
}
.form-style-5 input[type="text"]:focus,
.form-style-5 input[type="date"]:focus,
.form-style-5 input[type="datetime"]:focus,
.form-style-5 input[type="email"]:focus,
.form-style-5 input[type="number"]:focus,
.form-style-5 input[type="search"]:focus,
.form-style-5 input[type="time"]:focus,
.form-style-5 input[type="url"]:focus,
.form-style-5 textarea:focus,
.form-style-5 select:focus{
    background: #d2d9dd;
}
.form-style-5 select{
    -webkit-appearance: menulist-button;
    height:35px;
}
.form-style-5 .number {
    background: #1abc9c;
    color: #fff;
    height: 30px;
    width: 30px;
    display: inline-block;
    font-size: 0.8em;
    margin-right: 4px;
    line-height: 30px;
    text-align: center;
    text-shadow: 0 1px 0 rgba(255,255,255,0.2);
    border-radius: 15px 15px 15px 0px;
}

.form-style-5 input[type="submit"],
.form-style-5 input[type="button"]
{
    position: relative;
    display: block;
    padding: 19px 39px 18px 39px;
    color: #FFF;
    margin: 0 auto;
    background: #1abc9c;
    font-size: 18px;
    text-align: center;
    font-style: normal;
    width: 100%;
    border: 1px solid #16a085;
    border-width: 1px 1px 3px;
    margin-bottom: 10px;
}
.form-style-5 input[type="submit"]:hover,
.form-style-5 input[type="button"]:hover
{
    background: #109177;
}
</style>
<div class="form-style-2 form-style-5">
	<div class="form startpage"> <!-- onsubmit="return validateForm()" -->
		<form method="post"  action="order.php?sales=<?= $user_id ?>" autocomplete="off">
			<div class="row">
				<div class="section section-100">
					<?php echo '<p>Sales Representative : <b>'.$user_name.'</b></p>' ?>
				</div>
			</div>
			<div class="row start" style="display: block;" id="start-customer">
				<div class="section section-100">
					<p>Langue / Language</p>
					  <select class="select-field" id="language" name="lang">
					  	<option selected></option>
					  	<option value="en" <?php echo $_GET['lang']=="en"?"selected":"" ?>>English</option>
					    <option value="fr" <?php echo $_GET['lang']=="fr"?"selected":"" ?>>French</option>
					  </select>
				</div>
				<div class="section section-100">
					<p>Type de Client / Customer Type?</p>
					  <select class="select-field" id="formfiller">
					  	<option selected></option>
					  	<option value="0">Nouveau client / New Customer</option>
					    <option value="1">Renouvellement / Renew</option>
					  </select>
				</div>
				<div class="section section-100" id="oldSystem" style="display: none;">
					<p>Client Depuis / Customer Since?</p>
					<input type="date" id="dateSince" name="dateSince" value="<?= date("Y-m-d") ?>"/>
				</div>
				<div class="section section-100" id="renewal" style="display: none;">
					<p>NFF</p>
					<input type="text" id="nff" name="nff"/>
				</div>
			</div>
			
			<a href="." class="button" style="float: left"><i class="fa fa-arrow-left" > BACK</i></a>
			<span id="continue" style="display: none;">
				<input type="submit" class="button start" id="start-continue" style="float: right" value="CONTINUE">
			</span>
			<div style="clear:both">
			</div>
		</form>
	</div>
</div>
<script>

// $('#start-choose').on('change', function() {
// 	  if(this.value === "0") {
// 			document.getElementById("start-repname").style.display = "block";
// 			document.getElementById("start-customer").style.display = "block";
// 	  }
// 	  else if(this.value === "1"){
// 		  document.getElementById("start-repname").style.display = "none";
// 		  document.getElementById("start-customer").style.display = "block";
// 	  }
// 	  else {
// 		  document.getElementById("start-repname").style.display = "none";
// 		  document.getElementById("start-customer").style.display = "none";
// 	  }
// 	});

$('#formfiller').on('change', function() {
	var renew = document.getElementById("nff");
	if(this.value === "0") {
		document.getElementById("renewal").style.display = "none";
		renew.removeAttribute("required");
		document.getElementById("oldSystem").style.display = "block";
		document.getElementById("continue").style.display = "block";
	  }
	  else if(this.value === "1"){
		document.getElementById("renewal").style.display = "block";
		renew.setAttribute("required", ""); 
		document.getElementById("oldSystem").style.display = "none";
		document.getElementById("continue").style.display = "block";
	  }
	  else {
		document.getElementById("renewal").style.display = "none";
		renew.removeAttribute("required");
		document.getElementById("oldSystem").style.display = "none";
		document.getElementById("continue").style.display = "none";
	  }
});
$('#language').on('change', function() {
	if(this.value === "0") {
		//window.location.href = "start.php?lang=en";
	  }
	  else if(this.value === "1"){
		  //window.location.href = "start.php?lang=fr";
	  }
});

</script>

<link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  if ( $('[type="date"]').prop('type') != 'date' ) {
        $('[type="date"]').datepicker({ dateFormat: 'yy-mm-dd' }).val();
    }
  </script>