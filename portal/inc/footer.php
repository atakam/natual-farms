<!--Footer-part-->
<div class="row-fluid">
<div class="soonatech" style="text-align:center;"> Website powered by <a target="_blank" rel="nofollow" href="http://soonatech.com"><img src="./soonatech/img/soonatech-footer-min.png" alt="SoonaTech" width="100%" height="100%"></a>
 | 2017 &copy; Natural Farms Inc.
</div>
</div>
<!--end-Footer-part-->
<div id="jsscripts">
	<script src="js/jquery.min.js"></script> 
	<script src="js/jquery.ui.custom.js"></script> 
	<script src="js/bootstrap.min.js"></script> 
	<script src="js/jquery.uniform.js"></script> 
	<script src="js/select2.min.js"></script> 
	<script src="js/jquery.dataTables.min.js"></script> 
	<script src="js/matrix.js"></script> 
	<script src="js/matrix.tables.js"></script>
	<script src="js/fullcalendar.min.js"></script> 
	<?php if ($admin_flag == '1'){?>
	<script src="js/matrix.calendar.js"></script>
	<?php }else{?>
	<script src="js/matrix.calendar2.js"></script>
	<?php }?>
	<script>
	// When the user clicks on div, open the popup
	function popuptext(id) {
	    var popup = document.getElementById(id);
	    popup.classList.toggle("show");
	}
	</script>
</div>

