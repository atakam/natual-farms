<style>
tr:nth-child(odd) {background-color: #ccc;}
</style>
<?php 
include 'header.php';

$sql = "SELECT * FROM form_completion WHERE representative_id=".$user_id;
//if ($admin_flag=='1') {
$sql = "SELECT * FROM form_completion";
//}
$readonly = $delivery_flag == 1 ? "disabled readonly" : "";

generateOrderModal($conn, $sql, $admin_flag, $delivery_flag, $supplier_flag, 0);
generateOrderModal($conn, $sql, $admin_flag, $delivery_flag, $supplier_flag, 1);
?>
<style>
.open-order {opacity: 1;}
</style>