<?php 

include '../inc/publicHeader.php';
?>
<div class="printable" id="form-print">
<?php 
if (isset($_GET['lang']) && $_GET['lang']=="en")
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
<style>
body {
/*     background-image: url("images/back2.jpg"); */
    background-repeat: no-repeat;
    background-attachment: fixed;
}
</style>
<div id="nav2" class="section section-100">
	<div class="section section-12"><a href="<?= $language == 'fr_FR'?'http://lafermeaunaturel.com':'http://naturalfarms.ca'?>" class="logo"><img src="images/logo.png"/></a></div>
	<div class="section section-75" style="text-align: center; border-bottom: 1px solid #CCC;height:40px;line-height:50px;"><?= gettext("LA FERME AU NATUREL INC.") ?> / <?= gettext("NATURAL FARMS INC.") ?></div>
	<div class="section section-12">
		<a href="#" onclick="language('en')" style="cursor: pointer; float: right;" class="topmenu <?= $_GET["lang"]=="en"?"isactive":"" ?>"> <?= gettext("EN")?></a>
		<a href="#" onclick="language('fr')" style="cursor: pointer; float: right;" class="topmenu <?= $_GET["lang"]=="fr"?"isactive":"" ?>"> <?= gettext("FR")?></a>
		
		<a href="<?= $language == 'fr_FR'?'http://lafermeaunaturel.com':'http://naturalfarms.ca'?>" class="topmenu" style="cursor: pointer; float: left;"><i class="fa fa-home"></i> <?= gettext(" ")?></a>
	</div>
	<div class="section section-85" style="text-align: center; height:20px;line-height:20px; font-size: 14px; margin-top: 8px; word-spacing: 2px;">HST:  818954570 RT 0001 <i class="fa fa-phone"> 1-613-800-2214</i> <i class="fa fa-envelope"> <?= ($language == "en_US")?"admin@naturalfarms.ca":"admin@lafermeaunaturel.com" ?></i></div>
</div>
