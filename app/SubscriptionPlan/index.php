<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';
//pagevariables
$PageName = "Welcome to ApnaLead Subscription";
$PageDescription = "Manage teams";
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
</head>
<style>
    .current_plan {
        border-radius: 7px;
    }

    .upper_part {
        width: 100%;
        height: 50px;
        background-color: #322A7D;
        border-radius: 5px 5px 0 0;
        padding: 10px;
    }

    .lower_part {
        width: 100%;
        height: 50px;
        border-radius: 0px 0px 5px 5px;
        padding: 30px 10px !important;
    }

    .my-plan-border {
        border: 2px solid #322A7D;
        border-radius: 10px;
        flex-wrap: wrap !important;
    }

    .plan_amount {
        background-color: #322A7D;
        padding: 15px 1px;
        border-radius: 7px 7px 0 0;
    }

    .plan_discription p {
        padding: 10px 0;
    }
</style>

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
                            <div class="card card-primary " style="background-color: #f7f8fa !important;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <span class="image_logo">
                                                <img src="<?php echo STORAGE_URL . '/company/img/logo/logo.webp'; ?>" style="box-shadow:none !important;" alt="companylogo" class=" w-25 mb-5">
                                            </span>
                                            <span>
                                                <h4 class="app-sub-heading bold fs-20">CURRENT PLAN</h4>
                                            </span>
                                        </div>
                                        <div class="col-md-12 d-flex justify-content-center align-items-center">
                                            <div class="col-md-7">
                                                <div class="current_plan mt-2 shadow">
                                                    <div class="upper_part d-flex justify-content-between align-items-center">
                                                        <span class="fs-25 text-light bold">499 /-</span>
                                                        <span class="fs-20 text-light bold">Per User plan</span>
                                                        <span class="fs-20 text-light bold">1 Month</span>
                                                    </div>
                                                    <div class="lower_part pb-2 d-flex justify-content-between align-items-center">
                                                        <span class="text-center">
                                                            <span class="text-gray">Last Renewal Date</span><br>
                                                            <span class="bold mb-2">01 December 2023</span>
                                                        </span>
                                                        <span class="text-center">
                                                            <span class="text-gray">Expiry Date</span><br>
                                                            <span class="bold mb-2">01 January 2023</span>
                                                        </span>
                                                        <span class="text-center">
                                                            <span class="text-gray">Creation Date</span><br>
                                                            <span class="bold mb-2">01 july 2023</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 ">
                                                <div class="current_plan mt-2 shadow">
                                                    <div class="upper_part d-flex justify-content-between align-items-center">
                                                        <span class="fs-18 text-light bold"><i class="fa fa-user text-light"></i> Total User</span>
                                                        <span class="fs-23 text-light bold">5</span>

                                                    </div>
                                                    <div class="lower_part d-flex justify-content-between align-items-center">
                                                        <span class="text-center">
                                                            <span class="bold ">Add More User</span>
                                                        </span>
                                                        <span class="text-center">

                                                            <span class="btn btn-primary  ">ADD <i class="fa fa-plus"></i></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mt-4 mr-1 ml-1">
                                        <div class="row">
                                            <div class="col-md-8 mt-4">
                                                <div class="row m-2 mt-3">
                                                    <div class="col-md-12 text-center">
                                                        <h4 class="app-sub-heading m-2 bold fs-20">AVAILABLE PLANS</h4>
                                                    </div>
                                                    <div class="col-md-4 d-flex justify-content-center">
                                                        <span class="w-100 shadow-sm">
                                                            <div class="plan_amount">
                                                                <div class="row">
                                                                    <div class="col-md-6 text-center">
                                                                        <img src="<?php echo APP_LOGO_2; ?>" class="w-50 shadow-none" alt=""><br>
                                                                        <span class="text-light">Monthly Plan</span>
                                                                    </div>
                                                                    <div class="col-md-6 text-center">
                                                                        <span class="fs-30 text-light "><i class="fa fa-inr" aria-hidden="true"></i>499 </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="plan_discription text-center">
                                                                <p class="bold text-center text-info mt-4">Grow More Your Business With Our Special Plan</p>
                                                                <hr class="w-75">
                                                                <ul class="text-left pt-10" style="list-style: none !important;">
                                                                    <li><i class="fa fa-check text-success" aria-hidden="true"></i> 24*7 IT Support</li>
                                                                    <li><i class="fa fa-check text-success" aria-hidden="true"></i> Leads Security</li>
                                                                    <li><i class="fa fa-check text-success" aria-hidden="true"></i> Data Privacy</li>
                                                                    <li><i class="fa fa-check text-success" aria-hidden="true"></i> Customer Support</li>
                                                                    <li><i class="fa fa-check text-success" aria-hidden="true"></i> Real Time Analytics</li>
                                                                    <li><i class="fa fa-check text-success" aria-hidden="true"></i> Monthly Updates</li>
                                                                </ul>
                                                                <p class="text-gray fs-10"><b>Note:</b> Once installed, You will have to pay One Time Instalation charge</p>
                                                                <hr>

                                                                <div class="text-center">
                                                                    <button class="btn btn-primary mb-3">Upgrade</button>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </div>
                                                    <div class="col-md-4 d-flex justify-content-center">
                                                        <span class="w-100 shadow-sm">
                                                            <div class="plan_amount">
                                                                <div class="row">
                                                                    <div class="col-md-6 text-center">
                                                                        <img src="<?php echo APP_LOGO_2; ?>" class="w-50 shadow-none" alt=""><br>
                                                                        <span class="text-light">Yearly Plan</span>
                                                                    </div>
                                                                    <div class="col-md-6 text-center">
                                                                        <span class="fs-30 text-light "><i class="fa fa-inr" aria-hidden="true"></i>279 </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="plan_discription text-center">
                                                                <p class="bold text-center text-info mt-4">Grow More Your Business With Our Special Plan</p>
                                                                <hr class="w-75">
                                                                <ul class="text-left pt-10" style="list-style: none !important;">
                                                                    <li><i class="fa fa-check text-success" aria-hidden="true"></i> 24*7 IT Support</li>
                                                                    <li><i class="fa fa-check text-success" aria-hidden="true"></i> Leads Security</li>
                                                                    <li><i class="fa fa-check text-success" aria-hidden="true"></i> Data Privacy</li>
                                                                    <li><i class="fa fa-check text-success" aria-hidden="true"></i> Customer Support</li>
                                                                    <li><i class="fa fa-check text-success" aria-hidden="true"></i> Real Time Analytics</li>
                                                                    <li><i class="fa fa-check text-success" aria-hidden="true"></i> Monthly Updates</li>
                                                                </ul>
                                                                <p class="text-gray fs-10"><b>Note:</b> Once installed, You will have to pay One Time Instalation charge</p>
                                                                <hr>
                                                                <div class="text-center">
                                                                    <button class="btn btn-primary mb-3">Upgrade</button>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </div>
                                                    <div class="col-md-4 d-flex justify-content-center">
                                                        <span class="w-100 shadow-sm">
                                                            <div class="plan_amount">
                                                                <div class="row">
                                                                    <div class="col-md-6 text-center">
                                                                        <img src="<?php echo APP_LOGO_2; ?>" class="w-50 shadow-none" alt=""><br>
                                                                        <span class="text-light">Half-Yearly Plan</span>
                                                                    </div>
                                                                    <div class="col-md-6 text-center">
                                                                        <span class="fs-30 text-light "><i class="fa fa-inr" aria-hidden="true"></i>349 </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="plan_discription text-center">
                                                                <p class="bold text-center text-info mt-4">Grow More Your Business With Our Special Plan</p>
                                                                <hr class="w-75">
                                                                <ul class="text-left pt-10" style="list-style: none !important;">
                                                                    <li><i class="fa fa-check text-success" aria-hidden="true"></i> 24*7 IT Support</li>
                                                                    <li><i class="fa fa-check text-success" aria-hidden="true"></i> Leads Security</li>
                                                                    <li><i class="fa fa-check text-success" aria-hidden="true"></i> Data Privacy</li>
                                                                    <li><i class="fa fa-check text-success" aria-hidden="true"></i> Customer Support</li>
                                                                    <li><i class="fa fa-check text-success" aria-hidden="true"></i> Real Time Analytics</li>
                                                                    <li><i class="fa fa-check text-success" aria-hidden="true"></i> Monthly Updates</li>
                                                                </ul>
                                                                <p class="text-gray fs-10"><b>Note:</b> Once installed, You will have to pay One Time Instalation charge</p>
                                                                <hr>
                                                                <div class="text-center">
                                                                    <button class="btn btn-primary mb-3">Upgrade</button>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-4">
                                                <div class="row m-2 mt-3">
                                                    <div class="col-md-12 text-center">
                                                        <h4 class="app-sub-heading m-2 bold fs-20">Renewal History</h4>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="data-display">
                                                            <ul class=" pt-0">
                                                                <li class="bg-light d-flex justify-content-between data-list">
                                                                    <span class="W-50">
                                                                        <span class="fs-15 bold">
                                                                            Monthly Plan
                                                                        </span><br>
                                                                        <span class="text-gray">
                                                                            01 Apr 2023 , 11:30 Am
                                                                        </span><br>
                                                                        <span class="text-gray">
                                                                            Ref-No RJ934738929
                                                                        </span>
                                                                    </span>
                                                                    <span class=" text-right">
                                                                        <span class="text-success bold">Success</span><br>
                                                                        <span class="bold"> <b class="fs-20 text-info"><i class="fa fa-inr" aria-hidden="true"></i>2495</b></span><br>
                                                                        <span class="text-gray">for 5 user only</span>
                                                                    </span>
                                                                </li>
                                                                <li class="bg-light d-flex justify-content-between data-list mt-2">
                                                                    <span class="W-50">
                                                                        <span class="fs-15 bold">
                                                                            Yearly Plan
                                                                        </span><br>
                                                                        <span class="text-gray">
                                                                            01 Apr 2023 , 11:30 Am
                                                                        </span><br>
                                                                        <span class="text-gray">
                                                                            Ref-No RJ934738929
                                                                        </span>
                                                                    </span>
                                                                    <span class=" text-right">
                                                                        <span class="text-success bold">Success</span><br>
                                                                        <span class="bold"> <b class="fs-20 text-info"><i class="fa fa-inr" aria-hidden="true"></i>16,800</b></span><br>
                                                                        <span class="text-gray">for 5 user only</span>
                                                                    </span>
                                                                </li>
                                                                <li class="bg-light d-flex justify-content-between data-list mt-2">
                                                                    <span class="W-50">
                                                                        <span class="fs-15 bold">
                                                                            Half-Yearly Plan
                                                                        </span><br>
                                                                        <span class="text-gray">
                                                                            01 Apr 2023 , 11:30 Am
                                                                        </span><br>
                                                                        <span class="text-gray">
                                                                            Ref-No RJ934738929
                                                                        </span>
                                                                    </span>
                                                                    <span class=" text-right">
                                                                        <span class="text-success bold">Success</span><br>
                                                                        <span class="bold"> <b class="fs-20 text-info"><i class="fa fa-inr" aria-hidden="true"></i>11,400</b></span><br>
                                                                        <span class="text-gray">for 5 user only</span>
                                                                    </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="shadow-sm mt-5">
                                        <div class="row ">
                                            <div class="col-md-7 mt-2 ml-4 mr-2">
                                                <div class="mt-2 text-center">
                                                    <h5 class="app-heading">Pro Version</h5>
                                                </div>
                                                <div class="shadow">
                                                    hello
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-2 ml-2">
                                                <div class="mt-2 text-center">
                                                    <h5 class="app-heading">Premium Features</h5>
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

        <?php include $Dir . "/include/footer.php"; ?>
    </div>
    <?php
    include $Dir . "/assets/FooterFilesLoader.php"; ?>
</body>

</html>