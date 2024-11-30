<?php error_reporting (E_ALL ^ E_NOTICE); ?> 
    
        <?php
 
    $host = "localhost";
    $username = "u570873310_AvestanDB";
    $password = "Avestan@2022";
    $dbname = "u570873310_avestan1";
   $fullname = $email = $phonenumber = $estimatedbudget =$enteryourmessage= "";
   

    $conn = new mysqli($host, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }else

   
       
    
        $fullname = $_REQUEST['fullname'];
        $email = $_REQUEST['email'];
        $phonenumber =  $_REQUEST['phonenumber'];
        $estimatedbudget = $_REQUEST['estimatedbudget'];
        $enteryourmessage = $_REQUEST['enteryourmessage'];
       
    
        $sql = "INSERT INTO hire_uiux VALUES ('$fullname',
            '$email','$phonenumber','$estimatedbudget','$enteryourmessage')";
    
    
      
        if(mysqli_query($conn, $sql)){
            echo '<script> window.alert("Data Saved Successfully")</script>';
 
            
        } else{
            echo '<script> window.alert("Data Did Not Saved")</script>';
        }
    
         
        // Close connection
        mysqli_close($conn);
        ?>