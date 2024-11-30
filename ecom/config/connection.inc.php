<?php
@session_start();

// $con = mysqli_connect("localhost", "root", "", "qprint");

$currentPage = basename($_SERVER['PHP_SELF'], ".php");

$con=mysqli_connect("localhost","u570873310_ecom","Arbaz123@#$","u570873310_ecom");

define("SITE", "Qprint");
$site_name = SITE;

define('SERVER_PATH', $_SERVER['DOCUMENT_ROOT'] . '/ecom/');
define('SITE_PATH', 'https://avestantechnologies.com/ecom/');

define('INSTAMOJO_REDIRECT', SITE_PATH . 'payment_complete.php');

define('PRODUCT_IMAGE_SERVER_PATH', SERVER_PATH . 'media/product/');
define('PRODUCT_IMAGE_SITE_PATH', SITE_PATH . 'media/product/');

define('PRODUCT_MULTIPLE_IMAGE_SERVER_PATH', SERVER_PATH . 'media/product_images/');
define('PRODUCT_MULTIPLE_IMAGE_SITE_PATH', SITE_PATH . 'media/product_images/');

define('BANNER_SERVER_PATH', SERVER_PATH . 'media/banner/');
define('BANNER_SITE_PATH', SITE_PATH . 'media/banner/');

define('INSTAMOJO_KEY', 'key');
define('INSTAMOJO_TOKEN', 'token');
//https://www.youtube.com/watch?v=zWLKQ_loJqI&list=PLWCLxMult9xfYlDRir2OGRZFK397f3Yeb&index=24


define('SMTP_EMAIL', 'email@gmail.com');
define('SMTP_PASSWORD', 'password');
//https://www.youtube.com/watch?v=aBbmo1pi5B0&list=PLWCLxMult9xfY_dsYicKGcCLhlZ6YXFMh&index=1


define('SMS_KEY', 'sms_key');
//https://www.youtube.com/watch?v=_XaaIJlkNV4&list=PLWCLxMult9xfYlDRir2OGRZFK397f3Yeb&index=27

/* functions */
function executeQuery($sql)
{
    global $con;
    return $con->query($sql); // Use object-oriented style for executing queries
}

// Function to fetch result as array
function fetchArray($result)
{
    return $result->fetch_array(MYSQLI_ASSOC); // Use object-oriented style for fetching array
}

// Function to fetch result as associative array
function fetchAssoc($result)
{
    return $result->fetch_assoc(); // Use object-oriented style for fetching associative array
}

// Function to get the last inserted ID
function getLastInsertedId()
{
    global $con;
    return $con->insert_id; // Use object-oriented style for getting last inserted ID
}

// Function to get the number of rows in a result set
function numRows($result)
{
    return $result->num_rows; // Use object-oriented style for getting number of rows
}

// Function to escape special characters in a string for use in an SQL statement
function escapeString($str)
{
    global $con;
    return $con->real_escape_string($str); // Use object-oriented style for escaping strings
}

// Function to fetch result as object
function fetchObject($result)
{
    return $result->fetch_object(); // Use object-oriented style for fetching object
}

// Function to close database conection
function closeDB()
{
    global $con;
    $con->close(); // Use object-oriented style for closing the conection
}

$siteQuery = executeQuery("SELECT site_name FROM site_settings");

if(numRows($siteQuery) > 0){
    $row = fetchObject($siteQuery);
    $site_name = htmlspecialchars($row->site_name);
}else{
    $site_name = SITE;
}

$current_page = basename($_SERVER['PHP_SELF']);

?>