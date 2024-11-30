<?php error_reporting (E_ALL ^ E_NOTICE); ?> 
    
       <?php
$host = "localhost";
$username = "u570873310_AvestanDB";
$password = "Avestan@2022";
$dbname="u570873310_avestan1";


    $con_name = $lname = $email = $mno = $Visiting = $con_message="";
   

   // Create connection
$conn = new mysqli($host, $username, $password,$dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }else

   
       
    
        $con_name = $_REQUEST['con_name'];
        $lname = $_REQUEST['lname'];
        $email =  $_REQUEST['email'];
        $mno = $_REQUEST['mno'];
        $Visiting = $_REQUEST['Visiting'];
        $con_message = $_REQUEST['con_message'];
       
    
        $sql = "INSERT INTO enquiry VALUES ('$con_name',
            '$lname','$email','$mno','$Visiting','$con_message')";
      
        if(mysqli_query($conn, $sql)){
            echo '<script> window.alert("Data Saved Successfully")</script>';
 
            
        } else{
            echo '<script> window.alert("Data Did Not Saved")</script>';
        }
    
         
        // Close connection
        mysqli_close($conn);
        ?>

