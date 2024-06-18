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
 <li><a href="dashboard.php">Home Page</a></li>
  <li class='dropdown'>
 <a href = 'javascript:void(0)' class='dropbtn'> Property</a>
 <div class='dropdown-content'>

 <a href='landlords.php'>landlord Details</a>
 
<a href='property.php'>Property Details</a>
<a href='houseunits.php'>Define Premises</a>
<a href='propstatus.php'>Property Status</a>

 </div>
 </li>
  <li class='dropdown'>
 <a href = 'javascript:void(0)' class='dropbtn'> Tenants</a>
 <div class='dropdown-content'>
<a href='tenants.php'>Register Tenants</a>  
<a href='moveout.php'>Moveout Tenant</a>
<a href='revmoveout.php'>Reverse Moveout</a>
<a href='transfer.php'>Transfer Tenant</a>
<a href='tenantlist.php'>Tenant Listing</a>
<a href='statement.php'>Tenant Statement</a>
<a href='allstatement.php'> Combined Statement</a>
 </div>
 </li>
 <li class='dropdown'>
 <a href = 'javascript:void(0)' class='dropbtn'> Billing</a>
 <div class='dropdown-content'>
<a href='bills.php'>Generate Rent Bill One Property</a>
<a href='billone.php'>Generate Rent Bill One Unit</a>
<a href='otherbills.php' >Generate Other Bills One Property</a>
<a href='otherbills1.php' >Generate Other Bills One Unit</a>
<a href='billothers.php'>Set up Other Bills</a>
<a href='meterbills.php'>Setup Meter Bills</a>
<a href='delebill.php'>Delete Month Bill</a>
<a href='mntbills.php'>List Month Bills</a>
 </div>
 </li>
  <li class='dropdown'>
 <a href = 'javascript:void(0)' class='dropbtn'> Receipts</a>
 <div class='dropdown-content'>
 <a href='receipt.php'>Receive Payment</a>
 <a href='recptcanx.php'>Cancel Receipt</a>
 <a href='adjustments.php'>Adjustments</a>
 <a href = 'javascript:void(0)'> Reports</a>
 <a href ='receipts.php'>Receipts per date posted</a>
 <a href ='recptdep.php'>receipts per date deposited</a>
 <a href ='receiptitems.php'>Itemised Receipts per date posted</a>
 <a href ='receiptbank.php'>receipts per Bank A/C</a>
 </div>
 </li>
  <li class='dropdown'>
 <a href = 'javascript:void(0)' class='dropbtn'>Disbursements</a>
 <div class='dropdown-content'>
  <a href="disbursement.php">Post Disbursements</a>
  <a href="disburseview.php">Amend Disbursements</a>
  <a href="payvoucher.php">Paymment Voucher</a>
  <a href="advance.php">Landlord Advance</a>
  <a href="disburses.php">Disbursement report</a>
  
</div>
 </li>
<li class='dropdown'>
 <a href = 'javascript:void(0)' class='dropbtn'>Remittance</a>
 <div class='dropdown-content'>
  <a href="rentremit.php">Remit Rent</a>
  <a href ="remittedrent.php">Remitted Rent</a>
  <a href="otheremit.php">Remit Others</a>
 <a href="otheremitted.php">Remitted Others</a>
<a href="revrent.php">Reverse Remittance</a>
 </div>
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
  <a href="debtors.php">Debtors per Item</a>
  <a href="alldebtors.php">Combined Debtors</a>
  <a href="dnote.php">Demand Note</a>
  <a href="invoices.php">Invoices</a>
  <a href="meterinvoice.php">Meter Bill</a>
  </div>
 </li>
 <li class='dropdown'>
 <a href = 'javascript:void(0)' class='dropbtn'>Administration</a>
 <div class='dropdown-content'>
  <a href="balancebf.php">Opening Balances</a>
  <a href="opendepo.php">Opening Deposits</a>
  <a href="mainmenu.php">Main Menu</a>
  <a href="submenu.php">Sub Menu</a>
   <a href="sysusers.php">System Users</a>
    <a href="userights.php">User Permissions</a>
 </div>
 </li>
 </ul>