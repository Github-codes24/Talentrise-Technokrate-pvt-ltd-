<?php
require_once ('../config/connection.inc.php');
require_once ('auth.php');

$site_name = null;
$site_email = null;
$site_logo = null;
$site_facebook_url = null;
$site_instagram_url = null;
$site_linkedin_url = null;
$site_twitter_url = null;
$site_youtube_url = null;
$site_contact_number = null;
$site_whatsapp_number = null;
$site_logo_url = null;
$folder_path = 'images/settings/';
$id = null;

$query = executeQuery("SELECT * FROM site_settings");
if (numRows($query) > 0) {
    while ($row = fetchObject($query)) {
        $site_name = $row->site_name;
        $site_email = $row->site_email;
        $site_logo = $row->site_logo;
        $site_facebook_url = $row->site_facebook_url;
        $site_instagram_url = $row->site_instagram_url;
        $site_linkedin_url = $row->site_linkedin_url;
        $site_twitter_url = $row->site_twitter_url;
        $site_youtube_url = $row->site_youtube_url;
        $site_contact_number = $row->site_contact_number;
        $site_whatsapp_number = $row->site_whatsapp_number;
        $id = $row->id;

        if (!empty($site_logo) && file_exists($folder_path . $site_logo)) {
            $site_logo_url = $folder_path . $site_logo;
        } else {
            $site_logo_url = null;
        }

    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name; ?> | Setting</title>
    <?php require_once ('include/base/links.php'); ?>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../assets/custom_alert/css/alert.css" />
</head>

<body class="font-montserrat">
    <?php require_once ('include/loader/page_loader.php'); ?>

    <div id="main_content">
        <!-- small bottom sidebar -->
        <?php require_once ('include/sidebar/small-bottom-sidebar.php'); ?>
        <!-- /small bottom sidebar -->

        <!-- setting sidebar -->
        <?php require_once ('include/sidebar/setting-sidebar.php'); ?>
        <!-- /setting sidebar -->

        <!-- profile sidebar -->
        <?php require_once ('include/sidebar/profile-sidebar.php'); ?>
        <!-- /profile sidebar -->

        <!-- sidebar -->
        <?php require_once ('include/sidebar/main-sidebar.php'); ?>
        <!-- /sidebar -->

        <div class="page">
            <!-- header -->
            <?php require_once ('include/header/header.php'); ?>
            <!-- /header -->
            <!-- alert -->
            <?php require_once ('../assets/custom_alert/alert.php'); ?>
            <!-- /alert -->
            <div class="section-body mt-3">
                <div class="container-fluid">
                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h6><i class="fa-solid fa-gear"></i> Settings</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Website Setting</h6>
                                </div>
                                <div class="card-body">
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="siteName">Site Name <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" id="siteName" name="site_name"
                                                value="<?php echo htmlspecialchars($site_name); ?>"
                                                placeholder="Enter site name">
                                        </div>
                                        <div class="form-group">
                                            <label for="siteEmail">Site Email <span style="color: red;">*</span></label>
                                            <input type="email" class="form-control" id="siteEmail" name="site_email"
                                                value="<?php echo htmlspecialchars($site_email); ?>"
                                                placeholder="Enter site email">
                                        </div>
                                        <?php
                                        if (!empty($site_logo) && file_exists($folder_path . $site_logo)) {
                                            ?>
                                            <div class="form-group">
                                                <img src="images/settings/<?php htmlspecialchars($site_logo_url); ?>"
                                                    alt="logo">
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div class="form-group">
                                            <label for="siteLogo">Site Logo <span style="color: red;">*</span></label>
                                            <input class="form-control" type="file" id="siteLogo" name="site_logo">
                                        </div>
                                        <div class="form-group">
                                            <label for="siteFacebookUrl">Site Facebook URL (Optional)</label>
                                            <input type="url" class="form-control" id="siteFacebookUrl"
                                                name="site_facebook_url"
                                                value="<?php echo htmlspecialchars($site_facebook_url) ?>"
                                                placeholder="Enter site Facebook URL">
                                        </div>
                                        <div class="form-group">
                                            <label for="siteInstagramUrl">Site Instagram URL (Optional)</label>
                                            <input type="url" class="form-control" id="siteInstagramUrl"
                                                name="site_instagram_url"
                                                value="<?php echo htmlspecialchars($site_instagram_url); ?>"
                                                placeholder="Enter site Instagram URL">
                                        </div>
                                        <div class="form-group">
                                            <label for="siteLinkedinUrl">Site LinkedIn URL (Optional)</label>
                                            <input type="url" class="form-control" id="siteLinkedinUrl"
                                                name="site_linkedin_url"
                                                value="<?php echo htmlspecialchars($site_linkedin_url); ?>"
                                                placeholder="Enter site LinkedIn URL">
                                        </div>
                                        <div class="form-group">
                                            <label for="siteTwitterUrl">Site Twitter URL (Optional)</label>
                                            <input type="url" class="form-control" id="siteTwitterUrl"
                                                name="site_twitter_url"
                                                value="<?php echo htmlspecialchars($site_twitter_url); ?>"
                                                placeholder="Enter site Twitter URL">
                                        </div>
                                        <div class="form-group">
                                            <label for="siteTwitterUrl">Site Youtube URL (Optional)</label>
                                            <input type="url" class="form-control" id="siteYoutubeUrl"
                                                name="site_youtube_url"
                                                value="<?php echo htmlspecialchars($site_youtube_url); ?>"
                                                placeholder="Enter site Youtube URL">
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="siteContactNumber">Site Contact Number (Optional)</label>
                                                <input type="tel" class="form-control" id="siteContactNumber"
                                                    name="site_contact_number"
                                                    value="<?php echo htmlspecialchars($site_contact_number); ?>"
                                                    placeholder="Enter site contact number">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="siteWhatsappNumber">Site WhatsApp Number (Optional)</label>
                                                <input type="tel" class="form-control" id="siteWhatsappNumber"
                                                    name="site_whatsapp_number"
                                                    value="<?php echo htmlspecialchars($site_whatsapp_number); ?>"
                                                    placeholder="Enter site WhatsApp number">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-info fw-bold" id="saveBtn" name="saveBtn"
                                            value="<?php echo htmlspecialchars($id); ?>">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php require_once ('include/footer/footer.php'); ?>
        </div>
    </div>
    <?php require_once ('include/base/scripts.php'); ?>
    <!-- custome alert -->
    <script src="../assets/custom_alert/js/alert.js"></script>
    <script src="js/appSettings.js"></script>
</body>

</html>