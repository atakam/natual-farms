<style>
$border-color: (
  light: #eaeaea,
  medium: #e0e0e0,
  dark: #d7d7d7
);

$font-weight: (
  light: 300,
  regular: 400,
  medium: 500,
  bold: 700
);

@function border-color($shade) {
  @return map-get($border-color, $shade);
}

@function font-weight($weight) {
  @return map-get($font-weight, $weight);
}

*,
*:after,
*:before {
  box-sizing: border-box;
}

html {
  -webkit-font-smoothing: antialiased;
}

.modal {
  font: font-weight(regular) 14px/1.5 "Roboto", sans-serif;
  padding: 0 20px;
}

input {
  margin: 0;
}

.container {
  margin: 24px auto;
  max-width: 960px;
}

.table {
  border-collapse: collapse;
  width: 100%;
}

table{
  border: 1px solid map-get($border-color, dark);
}

table{
  border-bottom: 2px solid #c6d5e3;
}

tr{
  border-bottom: 2px solid #c6d5e3;
  color: darken(#c6d5e3, 25%);

  table & {
    background: #f7fafc;
  }
}

tr {
  &:not(:last-of-type) {
    border-bottom: 1px solid map-get($border-color, light);
  }
}

th, td {
  padding: 16px 12px 14px;

  tr& {
    padding: 10px 12px 8px;
  }
  
  .table--bordered &:not(:last-of-type) {
    border-right: 1px solid map-get($border-color, light);
  }
  
  tr& {
    font-weight: font-weight(bold);
  }
}


th, td {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

#form, #init {display: none}
/*
td, th {padding-right: 50px;padding-top: 20px;}
p {margin:0}

tr {margin: 15px 0;}
*/
th {text-align: left}
table {margin-top: 20px}
input {width: 400px;}

</style>
<?php
include 'formtop.php';
include '../inc/functions.php';

if (isset($_GET['sprint'])) {
	$admin_flag = 0;
	$supplier_flag = 0;
	$delivery_flag = 0;
}

if (isset($_GET['id'])) {
	$sql = "SELECT * FROM form_completion WHERE id=".$_GET['id'];
	generateOrderModal($conn, $sql, $admin_flag, $delivery_flag, $supplier_flag, 0, true, true);
}
?>