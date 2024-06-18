 <?php  
require 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
 if(isset($_POST["name"]))  
 {  
      $name = mysqli_real_escape_string($conn, $_POST["name"]);  
      $message = mysqli_real_escape_string($conn, $_POST["message"]);  
      $query = "INSERT INTO tbl_form(name, message) VALUES ('".$name."', '".$message."')";  
      if(mysqli_query($conn, $query))  
      {  
           echo '<p>You have entered</p>';  
           echo '<p>Name:'.$name.'</p>';  
           echo '<p>Message : '.$message.'</p>';  
      }  
 }  
 ?>  