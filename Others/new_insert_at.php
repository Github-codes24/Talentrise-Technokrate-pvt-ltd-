
        <?php error_reporting(E_ALL ^ E_NOTICE); ?>
        <?php
    $host = "localhost";
    $username = "u570873310_AvestanDB";
    $password = "Avestan@2022";
    $dbname="u570873310_avestan1";
		
		$fname = $email = $sub = $msg ="";
        

        // Create Connection
            $conn = new mysqli ($host, $username, $password, $dbname);

        //Check Connection
            if ($conn->connect_error)
            {
                die("Connection Failed. " .$conn->connect_error);
            }else

        //Taking Values form User
        $fname = $_REQUEST['fname'];
        $email = $_REQUEST['email'];
        $sub = $_REQUEST['sub'];
        $msg = $_REQUEST['msg'];
        
        //Performing Insert
        $sql = "INSERT INTO contact_us VALUES ('$fname','$email','$sub','$msg')";

        if(mysqli_query($conn, $sql)){
            echo '<script> window.alert("Data Saved Successfully")</script>';
 
            
        } else{
            echo '<script> window.alert("Data Did Not Saved")</script>';
        }
    
         
        // Close connection
        mysqli_close($conn);
        ?>