<?php 
ob_start();
session_start();

if(isset($_SESSION['userid'])) {
	include 'publicHeader.php';
	$user_id = $_SESSION['userid'];
	$user_name = $_SESSION['fullname'];
	$admin_flag = $_SESSION['adminflag'];
	$customer_flag = $_SESSION['customerflag'];
	$user_email = $_SESSION['email'];
	$supplier_flag = $_SESSION ['supplierflag'];
	$delivery_flag = $_SESSION ['deliveryflag'];
}
else if (!isset($_GET['sprint'])) {
	include 'login.php';
	exit();
}
include 'functions.php';
?>