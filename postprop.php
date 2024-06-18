<?php
require "configure.php";
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
if($conn->connect_error){
  die("Error in DB connection: ".$conn->connect_errno." : ".$conn->connect_error);    
}
else
{
$plotcode = $_POST['plotcode'];
$plotname =$_POST['plotname'];
$town =$_POST['town'];
$estate = $_POST['estate'];
$lrno = $_POST['lrno'];
$units = $_POST['units'];
$ptype = $_POST['ptype'];
$lordcode = $_POST['lordcode'];
$mgtcom = $_POST['mgtcom'];
$mgtflat = $_POST['mgtflat'];
$rentvat = $_POST['rentvat'];
$lordvat = $_POST['lordvat'];
$xstat = $_POST['xstat'];

if ($xstat==1)
{
$sql=$conn->prepare("insert into plots(plotname,town,estate,lrno,units,ptype,mgtcom,lordcode,mgtflat,rentvat,lordvat) values(?,?,?,?,?,?,?,?,?,?,?)");
$sql->bind_param('ssssiiiiiii',$plotname,$town,$estate,$lrno,$units,$ptype,$mgtcom,$lordcode,$mgtflat,$rentvat,$lordvat);
$sql->execute(); 
} else {
$updt1 = "update plots set plotname='$plotname',town='$town',estate='$estate',lrno='$lrno',units='$units',ptype='$ptype', 
lordcode='$lordcode',mgtcom='$mgtcom',mgtflat='$mgtflat',rentvat='$rentvat',lordvat='$lordvat' where plotcode='$plotcode'";
$updt2 = $conn->query($updt1);
}
}
?>