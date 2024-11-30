<?php
require_once ('../config/connection.inc.php');
require_once ('auth.php');

?>
<!doctype html>
<html lang="en" dir="ltr">

<!-- soccer/project/  07 Jan 2020 03:36:49 GMT -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="favicon.ico" type="image/x-icon" />

    <title><?php echo $site_name; ?> | Dashboard</title>

    <?php require_once ('include/base/links.php'); ?>
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
            <div class="section-body mt-3">
                <div class="container-fluid">
                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <div class="mb-4">
                                <h4>Welcome Peter Richards!</h4>
                                <small>Measure How Fast You’re Growing Monthly Recurring Revenue. <a href="#">Learn
                                        More</a></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php require_once ('include/footer/footer.php'); ?>
        </div>
    </div>
    <?php require_once ('include/base/scripts.php'); ?>
</body>

</html>