<style>
    .disabled{
        cursor: default;
        pointer-events: none;        
        text-decoration: none;
        color: white;
		background-color: grey;
    }
</style>
<?php
//session_start();
//$useraccess=$_session['login'];
?>
<ul>
 <li><a href="index.php">Home Page</a></li>
  <li class='dropdown'>
 <a href = 'javascript:void(0)' class='dropbtn'> Property</a>
 <div class='dropdown-content'>
 <?php
 if (substr($useraccess,1,1)=='0')
 {
  echo "<a href='landlords.php' class='disabled'>landlord Details</a>";
 } else {
 echo "<a href='landlords.php'>landlord Details</a>";
 } 
if (substr($useraccess,2,1)=='0')
{	
 echo  "<a href='property.php' class='disabled'>Property Details</a>";
} else {
echo  "<a href='property.php'>Property Details</a>";
}
if (substr($useraccess,3,1)=='0')
{
	echo "<a href='houseunits.php' class='disabled'>Define Premises</a>";
} else {
echo "<a href='houseunits.php'>Define Premises</a>";
} ?>	
  </div>
 </li>
  <li class='dropdown'>
 <a href = 'javascript:void(0)' class='dropbtn'> Tenants</a>
 <div class='dropdown-content'>
  <?php
if (substr($useraccess,4,1)=='0')
{	
  echo "<a href='tenants.php' class='disabled'>Register Tenants</a>";
  } else {
 echo "<a href='tenants.php'>Register Tenants</a>";  
  }
 if (substr($useraccess,5,1)=='0')
{ 
echo  "<a href='moveout.php' class='disabled'>Moveout Tenant</a>";
} else {
echo  "<a href='moveout.php'>Moveout Tenant</a>";
}
 if (substr($useraccess,6,1)=='0')
{ 	
 echo "<a href='revmoveout.php' class='disabled'>Reverse Moveout</a>";
} else {
echo "<a href='revmoveout.php'>Reverse Moveout</a>";
}	
if (substr($useraccess,7,1)=='0')
{ 
 echo "<a href='transfer.php' class='disabled'>Transfer Tenant</a>";
} else {
echo "<a href='transfer.php'>Transfer Tenant</a>";
}
if (substr($useraccess,8,1)=='0')
{ 
echo "<a href='tenantlist.php' class='disabled'>Tenant Listing</a>";
} else {
echo "<a href='tenantlist.php'>Tenant Listing</a>";
}
if (substr($useraccess,9,1)=='0')
{ 
echo "<a href='statement.php' class='disabled'>Tenant Statement</a>";
} else {
echo "<a href='statement.php'>Tenant Statement</a>";
}	
if (substr($useraccess,10,1)=='0')
{ 
echo "<a href='allstatement.php' class='disabled'> Combined Statement</a>";
} else {
echo "<a href='allstatement.php'> Combined Statement</a>";
} ?>	
 </div>
 </li>
 <li class='dropdown'>
 <a href = 'javascript:void(0)' class='dropbtn'> Billing</a>
 <div class='dropdown-content'>
 <?php
	if (substr($useraccess,11,1)=='0')
	{
	echo "<a href='bills.php' class='disabled'>Generate Rent Bill</a>";
	} else {
	echo "<a href='bills.php'>Generate Rent Bill</a>";
	}
	if (substr($useraccess,12,1)=='0')
	{
  echo "<a href='otherbills.php' class='disabled'>Generate Other Bills</a>";
	} else {
  echo "<a href='otherbills.php'>Generate Other Bills</a>";
	}
	if (substr($useraccess,13,1)=='0')
	{	
   echo "<a href='billothers.php' class='disabled'>Set up Other Bills</a>";
	} else {
	echo "<a href='billothers.php'>Set up Other Bills</a>";
	}
	if (substr($useraccess,14,1)=='0')
	{
   echo "<a href='meterbills.php' class='disabled'>Setup Meter Bills</a>";
	} else {
 echo "<a href='meterbills.php'>Setup Meter Bills</a>";
	}
	if (substr($useraccess,15,1)=='0')
	{
  echo "<a href='delebill.php' class='disabled'>Delete Month Bill</a>";
	} else {
	echo "<a href='delebill.php'>Delete Month Bill</a>";
	}
?>	
 </div>
 </li>
  <li class='dropdown'>
 <a href = 'javascript:void(0)' class='dropbtn'> Receipts</a>
 <div class='dropdown-content'>
 <?php
 if (substr($useraccess,16,1)=='0')
 {
  echo "<a href='receipt.php' class='disabled'>Receive Payment</a>";
 } else {
  echo "<a href='receipt.php'>Receive Payment</a>";
 }
 if (substr($useraccess,17,1)=='0')
 {
  echo "<a href='recptcanx.php' class='disabled'>Cancel Receipt</a>";
 } else {
echo "<a href='recptcanx.php'>Cancel Receipt</a>";
 } 
 if (substr($useraccess,18,1)=='0')
 {
 echo "<a href='adjustments.php' class='disabled'>Adjustments</a>";
 } else {
echo "<a href='adjustments.php'>Adjustments</a>";
 } ?>	 
  </div>
 </li>
  <li class='dropdown'>
 <a href = 'javascript:void(0)' class='dropbtn'>Disbursements</a>
 <div class='dropdown-content'>
  <a href="disbursement.php">Post Disbursements</a>
  <a href="disburseview.php">Amend Disbursements</a>
  <a href="payvoucher.php">Paymment Voucher</a> 
<ul class='ul1'>
<li class='dropdown1'>
 <a href = 'javascript:void(0)' class='dropbtn1'>Reports</a>
 <div class='dropdown-content1'>
  <a href="disbursement.php">Post Disbursements</a>
  <a href="disburseview.php">Amend Disbursements</a>
</div>
</li>
</ul>
</div>
 </li>
<li class='dropdown'>
 <a href = 'javascript:void(0)' class='dropbtn'>Remittance</a>
 </li>
 <li class='dropdown'>
 <a href = 'javascript:void(0)' class='dropbtn'> Reference Files</a>
 <div class='dropdown-content'>
  <a href="companydtls.php">Company Details</a>
  <a href="unitcat.php">Unit Categories</a>
  <a href="receivables.php">Receivables</a>
  <a href="rentschedule.php">Rent Schedule</a>
  </div>
 </li>
 <li class='dropdown'>
 <a href = 'javascript:void(0)' class='dropbtn'>Debtors</a>
 <div class='dropdown-content'>
  <a href="debtors.php">Debtors</a>
  <a href="invoices.php">Invoices</a>
  </div>
 </li>
 <li class='dropdown'>
 <a href = 'javascript:void(0)' class='dropbtn'>Administration</a>
 <div class='dropdown-content'>
  <a href="balancebf.php">Opening Balances</a>
  <a href="opendepo.php">Opening Deposits</a>
 </div>
 </li>
 </ul>