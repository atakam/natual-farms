<?php 

include '../inc/header.php';

?>

<div class="form-style-2-heading">Customers</div>
<a href="customer.php" class="button"><i class="fa fa-plus"> Add Customer</i></a>
<?php 

$sql = "SELECT * FROM customer";

$result = $conn->query($sql);
echo "<div class='container'><input type='search' class='input-field section-null' data-table='order-table' placeholder='Filtrer' />
		<table class='order-table'>";
echo "<thead><tr>";
echo "<td>ID</td><td>First Name</td><td>Last Name</td><td>Phone Number</td><td>Email</td><td>City</td><td>Province</td><td></td>";
echo "</tr></thead>";

while ($row = $result->fetch_assoc())
{
	echo "<tr>";
	echo "<td>".$row['id']."</td><td>".$row['firstname']."</td><td>".$row['lastname']."</td><td>".$row['phone']."</td><td>".$row['email'].
	     "</td><td>".$row['city']."</td><td>".$row['province']."</td><td><a href='customer.php?id=".$row['id']."'><i class='fa fa-edit'></i></a></td><td>
			<a href='../actions/delete.php?custid=".$row['id']."'><i class='fa fa-trash'></i></a></td>";
	echo "</tr>";
}
echo "</table></div>";

?>

<div class="row">
	<div class="space1"></div>
</div>

<div class="form-style-2-heading">Orders</div>
<a href="start.php" class="button"><i class="fa fa-plus"> Add Order</i></a>
<?php 

$sql = "SELECT * FROM form_completion";

$result = $conn->query($sql);
echo "<div class='container'><input type='search' class='input-field section-null' data-table='order-table' placeholder='Filtrer' />
		<table class='order-table'>";
echo "<thead><tr>";
echo "<td>Customer Name</td><td>Date</td><td>Total Points</td><td>Total Price</td><td>First Delivery Date</td><td>Sales Representative</td><td></td>";
echo "</tr></thead>";

while ($row = $result->fetch_assoc())
{
	$sql2 = "SELECT * FROM customer WHERE id=".$row['customer_id']." LIMIT 1";
	$result2 = $conn->query($sql2);
	$row2 = $result2->fetch_assoc();
	
	echo "<tr>";
	echo "<td>$row2[firstname] $row2[lastname]</td><td>$row[signature_date]</td><td>$row[total_points]</td><td>$row[price]</td><td>$row[conditions_firstdeliverydate]</td><td>".
					"$row[signature_merchant_name]</td><td><a href='edit.php?id=$row[id]'><i class='fa fa-edit'></i></a></td>".
					"<td><a title='View Contract' href='contract.php?id=$row[id]'><i class='fa fa-file-pdf-o'></i></a></td>
					<td><a title='Resend Emails' href='print.php?id=$row[id]&email=$row2[email]&name=$row2[firstname]$row2[lastname]'><i class='fa fa-send'></i></a>
					<td><a href='../actions/delete.php?formid=".$row['id']."'><i class='fa fa-trash'></i></a></td>";
	echo "</tr>";
}
echo "</table></div>";

?>

<script>
(function(document) {
	'use strict';

	var LightTableFilter = (function(Arr) {

		var _input;

		function _onInputEvent(e) {
			_input = e.target;
			var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
			Arr.forEach.call(tables, function(table) {
				Arr.forEach.call(table.tBodies, function(tbody) {
					Arr.forEach.call(tbody.rows, _filter);
				});
			});
		}

		function _filter(row) {
			var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
			row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
		}

		return {
			init: function() {
				var inputs = document.getElementsByClassName('light-table-filter');
				Arr.forEach.call(inputs, function(input) {
					input.oninput = _onInputEvent;
				});
			}
		};
	})(Array.prototype);

	document.addEventListener('readystatechange', function() {
		if (document.readyState === 'complete') {
			LightTableFilter.init();
		}
	});

})(document);
</script>
<?php 
echo "</div>";
?>