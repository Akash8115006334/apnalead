<?php
$Dir = "../../";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Web-Hook Integrations";
$PageDescription = "Get Leads Direct Form Your Website";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta name="keywords" content="<?php echo APP_NAME; ?>">
    <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
    <?php include $Dir . "/assets/HeaderFilesLoader.php"; ?>
    <script type="text/javascript">
        function SidebarActive() {
            document.getElementById("configs").classList.add("active");
            document.getElementById("system_profile").classList.add("active");
        }
        window.onload = SidebarActive;
    </script>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper">
        <?php include $Dir . "/include/loader.php"; ?>
        <?php
        include $Dir . "/include/header.php";
        include $Dir . "/include/sidebar.php"; ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary new-bg-color">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php include "common.php"; ?>
                                        </div>
                                        <div class="col-md-12">
                                            <h4 class="app-heading"><?php echo $PageName; ?></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="app-sub-heading">Web-Hook Features</h5>
                                                </div>
                                                <div class="col-md-12 shadow-sm m-1 bg-light">
                                                    <div class="text-center mt-3 mb-4">
                                                        <img src="<?php echo STORAGE_URL . '/company/img/logo/logo.webp' ?>" style="box-shadow:none !important" alt="companylogo" class="w-50 ">
                                                    </div>
                                                    <hr>
                                                    <div class=" text-center p-1">
                                                        <p class="text-gray text-justify fs-15 mb-2 bold">A new feature has been introduced in ApnaLead called 'Webhook.' Now, you can seamlessly integrate your website with ApnaLead's CRM system.
                                                            This means that any inquiries made on your website will be automatically directed to your CRM, simplifying the lead generation process.
                                                            This feature enhances the interactivity of your website and ensures that all leads are promptly and directly transferred to your CRM for efficient management.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 ml-4">
                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <h5 class="app-sub-heading">How to Use</h5>
                                                </div>
                                                <div class="col-md-12 m-1 shadow-sm">
                                                    <div class="form-group mt-2 mb-2">
                                                        <label for="">Please copy this link and paste it into your website <code>head</code> tag</label>
                                                        <input type="text" class="form-control" value="<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>" readonly>
                                                    </div>

                                                    <div class="form-group mt-3 mb-2">
                                                        <label for="">Paste below code in <code>body</code> tags before closing</label>
                                                        <textarea class='form-control' rows='4' readonly><div id='MainEnquiryForm'></div><script src='<?php echo DOMAIN; ?>/api/app.js'></script><script>ApnaLeadEnquiryForm('<?php echo SECURE(CompanyId, 'e'); ?>');</script></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4 shadow-sm">
                                        <div class="col-md-12 mt-2">
                                            <h4 class="app-sub-heading">Preview</h4>
                                        </div>
                                        <div class="col-md-4 p-2">
                                            <div class="text-center">
                                                <img src="<?php echo STORAGE_URL; ?>/default/preview/step1.jpg" class="w-100" alt="step1">
                                            </div>
                                        </div>
                                        <div class="col-md-4 p-2">
                                            <div class="text-center">
                                                <img src="<?php echo STORAGE_URL; ?>/default/preview/step2.jpg" class="w-100" alt="step1">
                                            </div>
                                        </div>
                                        <div class="col-md-4 p-2">
                                            <div class="text-center">
                                                <img src="<?php echo STORAGE_URL; ?>/default/preview/step3.jpg" class="w-100" alt="step1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php
        include $Dir . "/include/forms/Add-Data-Counter.php";
        include $Dir . "/include/footer.php";
        ?>
    </div>

    <?php include $Dir . "/assets/FooterFilesLoader.php"; ?>

</body>

</html>