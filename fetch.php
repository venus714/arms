<?php
    include 'configure.php';
	$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
    $query = "SELECT * FROM users ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<body>
    <div class="container">
        <table class="table text-center table-striped table-bordered">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>mobile</th>
                <th>message</th>
            </tr>
            <?php 
                while($row = mysqli_fetch_array($result)){
                    echo "<tr>";
                        echo "<td>".$row["name"]."</td>";
                        echo "<td>".$row["email"]."</td>";
                        echo "<td>".$row["mobile"]."</td>";
                        echo "<td class='text-start'>".$row["message"]."</td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </div>
</body>
</html