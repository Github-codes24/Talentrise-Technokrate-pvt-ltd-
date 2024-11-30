<?php
@session_start();
require_once ('../../config/connection.inc.php');
require_once ('../include/resizers/image_resizer.php');
header('Content-type: application/json');

if (isset($_POST['site_name'])) {
    $site_name = htmlspecialchars($_POST['site_name']);
} else {
    $site_name = '';
}

if (isset($_POST['site_email'])) {
    $site_email = htmlspecialchars($_POST['site_email']);
} else {
    $site_email = '';
}

if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] == 0) {
    $site_logo = $_FILES['site_logo'];
} else {
    $site_logo = null;
}

if (isset($_POST['site_facebook_url'])) {
    $site_facebook_url = htmlspecialchars($_POST['site_facebook_url']);
} else {
    $site_facebook_url = '';
}

if (isset($_POST['site_instagram_url'])) {
    $site_instagram_url = htmlspecialchars($_POST['site_instagram_url']);
} else {
    $site_instagram_url = '';
}

if (isset($_POST['site_linkedin_url'])) {
    $site_linkedin_url = htmlspecialchars($_POST['site_linkedin_url']);
} else {
    $site_linkedin_url = '';
}

if (isset($_POST['site_twitter_url'])) {
    $site_twitter_url = htmlspecialchars($_POST['site_twitter_url']);
} else {
    $site_twitter_url = '';
}

if (isset($_POST['site_youtube_url'])) {
    $site_youtube_url = htmlspecialchars($_POST['site_youtube_url']);
} else {
    $site_youtube_url = '';
}

if (isset($_POST['site_contact_number'])) {
    $site_contact_number = htmlspecialchars($_POST['site_contact_number']);
} else {
    $site_contact_number = '';
}

if (isset($_POST['site_whatsapp_number'])) {
    $site_whatsapp_number = htmlspecialchars($_POST['site_whatsapp_number']);
} else {
    $site_whatsapp_number = '';
}

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
} else {
    $response['status'] = 'error';
    $response['message'] = 'ID is missing.';
    echo json_encode($response);
    exit();
}

if ($site_logo) {
    $target_dir = "images/settings/";
    $name = rand(10000, 1000000);
    $extension = pathinfo($site_logo["name"], PATHINFO_EXTENSION);
    $new_name = $name . "." . $extension;
    $target_file = $target_dir . $new_name;

    $imageFileType = strtolower($extension);
    if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'webp'])) {
        $response['status'] = 'warning';
        $response['message'] = "Invalid image extension (Image extension must be .jpg, .png, .jpeg, .webp)";
        echo json_encode($response);
        exit();
    } else {
        move_uploaded_file($site_logo["tmp_name"], $target_file);

        $resizeObj = new resize($target_file);
        $sizes = [50, 100, 150, 300];
        foreach ($sizes as $size) {
            $resizeObj->resizeImage($size, $size, 'exact');
            $resizeObj->saveImage("images/settings/thumb-{$size}/" . $new_name, $size);
        }

        $updateQuery = executeQuery("UPDATE site_settings SET site_logo = '$new_name' WHERE id = $id");
    }
}

$updateQuery = executeQuery(
    "UPDATE site_settings SET 
    site_name = '$site_name',
    site_email = '$site_email',
    site_facebook_url = '$site_facebook_url',
    site_instagram_url = '$site_instagram_url',
    site_linkedin_url = '$site_linkedin_url',
    site_twitter_url = '$site_twitter_url',
    site_youtube_url = '$site_youtube_url',
    site_contact_number = '$site_contact_number',
    site_whatsapp_number = '$site_whatsapp_number' 
    WHERE id = $id"
);

if ($updateQuery) {
    $response['status'] = 'success';
    $response['message'] = 'Save changes successfully!';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error occurred while updating the data.';
}

echo json_encode($response);
?>