<?php

    $connect = mysqli_connect("localhost", "root", "", "aatman");

    if(isset($_POST["name"]))
    {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $mobile = $_POST["mobile"];
        $message = $_POST["message"];
        $query = '';
       
        for($count = 0; $count<count($name); $count++){
            $name_clean = mysqli_real_escape_string($connect, $name[$count]);
            $email_clean = mysqli_real_escape_string($connect, $email[$count]);
            $mobile_clean = mysqli_real_escape_string($connect, $mobile[$count]);
            $message_clean = mysqli_real_escape_string($connect, $message[$count]);
          
            if($name_clean != '' && $email_clean != '' && $mobile_clean != '' && $message_clean != ''){
                $query .= 'INSERT INTO users(name, email, mobile, message) VALUES("'.$name_clean.'", "'.$email_clean.'", "'.$mobile_clean.'", "'.$message_clean.'");';
            }
        }

        if($query != ''){
                
            if(mysqli_multi_query($connect, $query)){
                echo 'Users Data Inserted successfully';
            }else{
                echo 'Error';
            }
        }else{
            echo 'All Fields are Required';
        }
    }
?>