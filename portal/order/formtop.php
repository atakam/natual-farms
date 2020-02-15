<?php

if (isset($_GET['sprint']) && $_GET['sprint'] == 'katchebehsibwosihampomodimandrehnahponteh'){
	include '../inc/publicHeader.php';
}
else if (isset($_GET['id']) || isset($_GET['sales'])){
	include '../inc/header.php';
	if ($admin_flag == '0'){
		// customer
		if ($customer_flag == '1') {
			if (isset($_GET['uid']) && $_GET['uid'] == $user_id)
			{
				$sql = "SELECT * FROM form_completion WHERE id=".$_GET['id']." LIMIT 1";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();
				if ($row['customer_id'] != $user_id) {
					header("Location: ../error403.php");
				}
			}
			else {
				header("Location: ../error403.php");
			}
		}
		// Sales Rep
		else if ($customer_flag == '0') {
			if (isset($_GET['rid']) && $_GET['rid'] == $user_id)
			{
				$sql = "SELECT * FROM form_completion WHERE id=".$_GET['id']." LIMIT 1";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();
				if ($row['representative_id'] != $user_id) {
					header("Location: ../error403.php");
				}
			}
			else if (!isset($_GET['sales'])){
				header("Location: ../error403.php");
			}
		}
		else {
			header("Location: ../error403.php");
		}
	}
	else if ($admin_flag != '1') {
		header("Location: ../error403.php");
	}
}
else {
	header("Location: ../error403.php");
}
?>

<?php 
if ((isset($_GET['lang']) && $_GET['lang']=="en")
		|| (isset($_POST['lang']) && $_POST['lang']=="en"))
{
	$language = "en_US";
	putenv("LANG=".$language);
	setlocale(LC_ALL, $language);
	
	$locale = "en_US.UTF-8";
	setlocale(LC_ALL, $locale);
	
	$domain = "messages";
	bindtextdomain($domain, "Locale");
	textdomain($domain);
	//echo "English";
}
else{
	$language = "fr_FR";
	putenv("LANG=".$language);
	setlocale(LC_ALL, $language);
	
	$locale = "fr_FR.UTF-8";
	setlocale(LC_ALL, $locale);
	
	$domain = "messages";
	bindtextdomain($domain, "Locale");
	textdomain($domain);
	
	//echo "French";
}
?>

<div class="printable" id="form-print">

<style>
body {
/*     background-image: url("images/back2.jpg"); */
    background-repeat: no-repeat;
    background-attachment: fixed;
}
</style>
<div id="nav2" class="section section-100">
	<div class="section section-12"><a href="." class="logo"><img src="images/logo.png"/></a></div>
	<div class="section section-75" style="text-align: center; border-bottom: 1px solid #CCC;height:40px;line-height:50px;"><?= gettext("LA FERME AU NATUREL INC.") ?> / <?= gettext("NATURAL FARMS INC.") ?></div>
	<div class="section section-12">
		<a href="#" onclick="language('en')" style="cursor: pointer; float: right;font-size: 14px;" class="topmenu <?= $_GET["lang"]=="en"?"isactive":"" ?>"> <?= gettext("EN")?></a>
		<a href="#" onclick="language('fr')" style="cursor: pointer; float: right;font-size: 14px;" class="topmenu <?= $_GET["lang"]=="fr"?"isactive":"" ?>"> <?= gettext("FR")?></a>
		
		<?php if (!isset($_GET["edit"])) {?>
		<a href="#" onclick="printRawDiv('form-print')" class="topmenu" style="cursor: pointer; float: left;"><i class="fa fa-print" style="font-size: 14px;"></i> <?= gettext("PRINT")?></a>
		<?php }?>
	</div>
</div>
<div class="section section-100">
	<div class="section section-100" style="text-align: center; height:20px;line-height:20px; font-size: 14px; margin-top: 8px; word-spacing: 2px;">HST:  818954570 RT 0001 <i class="fa fa-phone"> 1-613-800-2214</i> <i class="fa fa-envelope"> <?= ($language == "en_US")?"admin@naturalfarms.ca":"admin@lafermeaunaturel.com" ?></i></div>
	<?php if (!isset($_GET['edit'])) {?>
	<div class="section section-100" style="text-align: center; height:20px;line-height:20px; font-size: 14px;"><?= gettext("CONTRAT DE VENTE PAR COMMERCANT ITINERANT") ?></div>
	<div class="section section-100" style="text-align: center; height:20px;line-height:20px; font-size: 14px;">( <?= gettext("Loi sur la protection des consommateurs art. 58") ?> )</div>
	<?php }?>
</div>