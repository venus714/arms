<?php
session_start();
$useraccess = $_SESSION['login'];
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Welcome</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="mystyle.css">
<style>
.disabled{
        cursor: default;
        pointer-events: none;        
        text-decoration: none;
        color: grey;
		background-color: green;
    }
 .gallery {
  margin: 5px;
  border: 1px solid #ccc;
  float: left;
  padding: 5px;
  width: 100%;
  height: auto;
  text-align: center;
  background-color: green;
}
		
</style>
</head>
<body>
<div>
<?php include "mymenu.php";?>
</div>
<?php include "myheader4.php";?>
<div class='row'>
<div class='col4'>
<div class='hz'>
<?php
if (substr($useraccess,1,1)=='0')
{
echo "<p><a href='landlords.php' class='disabled'><img src='../images/landlord2.jfif' alt='LANDLORD DETAILS' style='max-width: 100%;height: auto;'></a></p>"; 
} ELSE {
echo "<p><a href='landlords.php'><img src='../images/landlord2.jfif' alt='LANDLORD DETAILS' style='max-width: 100%;height: auto;'></a></p>"; 
}
?>
<div class='desc'>LANDLORD DETAILS</div>
 </div>
<div class='hz'>
<?php 
if (substr($useraccess,2,1)=='0')
{
echo "<p><a href='property.php' class='disabled'><img src='../images/property1.png' alt='Property Details' style='max-width: 100%;height: auto;'></a></p>";
} else {
echo "<p><a href='property.php'><img src='../images/property1.png' alt='Property Details' style='max-width: 100%;height: auto;'></a></p>";	
}
?>
<div class='desc'>PROPERTY DETAILS</div>
</div>
<div class='hz'>
<?php 
if (substr($useraccess,3,1)==0)
{
echo "<p><a href='houseunits.php' class='disabled'><img src='../images/premise2.png' alt='Premises Details' style='max-width: 100%;height: auto;'></a></p>";
} else {
echo "<p><a href='houseunits.php'><img src='../images/premise2.png' alt='Premises Details' style='max-width: 100%;height: auto;'></a></p>";
}	
?>
<div class='desc'>DEFINE PREMISES</div>
</div>
</div>
<div  class='col4'>
<div class='hz'>
<?php 
if (substr($useraccess,4,1)==0)
{
echo "<p><a href='tenants.php' class='disabled'><img src='../images/tenant1.png' alt='Register Tenant' style='max-width: 100%;height: auto;'></a></p>"; 
} else {
echo "<p><a href='tenants.php'><img src='../images/tenant1.png' alt='Register Tenant' style='max-width: 100%;height: auto;'></a></p>";
}
?>	
<div class='desc'>REGISTER NEW TENANT</div>
</div>
<div class='hz'>
<?php 
if (substr($useraccess,5,1)==0)
{
echo "<p><a href='moveout.php' class='disabled'><img src='../images/tenant2.png' alt='Move Out Tenant' style='max-width: 100%;height: auto;'></a></p>";
} else {
echo "<p><a href='moveout.php'><img src='../images/tenant2.png' alt='Move Out Tenant' style='max-width: 100%;height: auto;'></a></p>";
}
?>	
<div class='desc'>MOVEOUT TENANT</div>
</div>
<div class='hz'>
<?php 
if (substr($useraccess,6,1)==0)
{
echo "<p><a href='transfer.php' class='disabled'><img src='../images/tenant3.png' alt='Transfer Tenant' style='max-width: 100%;height: auto;'></a></p>";
} else {
echo "<p><a href='transfer.php'><img src='../images/tenant3.png' alt='Transfer Tenant' style='max-width: 100%;height: auto;'></a></p>";
}
?>	
<div class='desc'>TRANSFR TENANT</div>
</div>
</div>
<div class='col4'>
<div class='hz'>
<?php 
if (substr($useraccess,7,1)==0)
{
echo "<p><a href='bills.php' class='disabled'><img src='../images/bill1.jfif' alt='Generate Rent Bill' style='max-width: 100%;height: auto;'></a></p>";
} else {
echo "<p><a href='bills.php'><img src='../images/bill1.jfif' alt='Generate Rent Bill' style='max-width: 100%;height: auto;'></a></p>";
}
?>	
<div class='desc'>GENERATE RENT BILL</div>
</div>
<div class='hz'>
<?php
if (substr($useraccess,8,1)==0)
{
echo "<p><a href='otherbills.php' class='disabled'><img src='../images/bill2.jfif' alt='GenerateOther Bills' style='max-width: 100%;height: auto;'></a></p>";
} else {
echo "<p><a href='otherbills.php'><img src='../images/bill2.jfif' alt='GenerateOther Bills' style='max-width: 100%;height: auto;'></a></p>";
}
?>
<div class='desc'>GENERATE OTHER BILLS</div>
</div>
<div class='hz'>
<?php
if (substr($useraccess,9,1)==0)
{
echo "<p><a href='billothers.php' class='disabled'><img src='../images/bill3.jfif' alt='Set up otherbills' style='max-width: 100%;height: auto;'></a></p>";
} else {
echo "<p><a href='billothers.php'><img src='../images/bill3.jfif' alt='Set up otherbills' style='max-width: 100%;height: auto;'></a></p>";
} ?>	
<div class='desc'>SETUP OTHER BILLS</div>
</div>
</div>
<div class='col4'>
<div class='hz'>
<?php
if (substr($useraccess,10,1)==0)
{
echo "<p><a href='receipt.php' class='disabled'><img src='../images/receipt1.png' alt='Post Receipts' style='max-width: 100%;height: auto;'></a></p>";
} else {
echo "<p><a href='receipt.php'><img src='../images/receipt1.png' alt='Post Receipts' style='max-width: 100%;height: auto;'></a></p>";
} ?>
	
<div class='desc'>RECEIVE PAYMENTS</div>
</div>
<div class='hz'>
<?php
if (substr($useraccess,11,1)==0)
{
echo "<p><a href='invoices.php' class='disabled'><img src='../images/invoice2.jfif' alt='Generate Invoices' style='max-width: 100%;height:auto;'></a></p>";
} else {
echo "<p><a href='invoices.php'><img src='../images/invoice2.jfif' alt='Generate Invoices' style='max-width: 100%;height:auto;'></a></p>";
} ?>	
<div class='desc'>LIST INVOICES</div>
</div>
<div class='hz'>
<?php
if (substr($useraccess,12,1)==0)
{
echo "<p><a href='debtors.php' class='disabled'><img src='../images/debtorS1.png' alt='List Debtors' style='max-width: 100%;height: auto;'></a></p>";
} else {
echo "<p><a href='debtors.php'><img src='../images/debtorS1.png' alt='List Debtors' style='max-width: 100%;height: auto;'></a></p>";
} ?>	
<div class='desc'>LIST DEBTORS</div>
</div>
</div>
</div>
</body>
</html>