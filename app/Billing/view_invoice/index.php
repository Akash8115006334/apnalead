<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "User Dashboard";
$PageDescription = "";
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
                            <div class="card card-primary bg-light">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h6 class="app-heading"><?php echo $PageName; ?></h6>
                                        </div>
                                        <div class="col-md-12">
                                            <a href="../index.php" class="btn btn-default"> <i class="fa fa-arrow-left fs-12" aria-hidden="true"></i> Billing Dashboard</a>
                                            <a href="#" class="btn btn-default"><i class="fa fa-pencil-square-o fs-15 text-danger" aria-hidden="true"></i> Edit Profile</a>
                                            <a href="#" class="btn btn-default"> <i class="fa fa-inr text-success" aria-hidden="true"></i> Collect Payment</a>
                                            <a href="#" class="btn btn-default"> <i class="fa fa-plus text-danger" aria-hidden="true"></i> New Invoice</a>
                                            <a href="#" class="btn btn-default"> <i class="fa fa-envelope text-danger" aria-hidden="true"></i> Send Mail</a>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-md-3">
                                            <div class="card new-card-window_2">
                                                <div class="w-100 mt-3 text-center">
                                                    <img src="<?php echo STORAGE_URL; ?>/default/default.png" class="w-25" alt="userlogo">
                                                </div>
                                                <div class="w-100 mt-2 text-center">
                                                    <span class="text-info fs-20 bold">Mr. Akash Upadhyay</span>
                                                </div>
                                                <div class="w-100 text-left">
                                                    <span class="text-gray ml-2">Phone :</span>
                                                    <span class="text-black fs-12 bold"><i class="fa fa-phone-square text-success" aria-hidden="true"></i> 8115006334</span><br>
                                                    <span class="text-gray ml-2">Email :</span>
                                                    <span class="text-black fs-12 bold"><i class="fa fa-envelope text-danger" aria-hidden="true"></i> akashupadhyay@gmail.com</span><br>
                                                    <span class="text-gray ml-2">Address :</span>
                                                    <span class="text-black fs-12 bold"><i class="fa fa-map-marker text-warning fs-15" aria-hidden="true"></i> Pryagraj Uttar-Pradesh</span>
                                                    <hr>
                                                </div>
                                                <div class="w-100 m-b-2 text-center">
                                                    <span class="text-gray fs-12">Managed By</span><br>
                                                    <span class="text-black bold">Saurabh Singh</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9 ">
                                            <div class="card w-100">
                                                <div class="flex-s-b m-2">
                                                    <div class="w-pr-30 text-center mt-2 new-card-window  ">
                                                        <span class="text-gray fs-12">Net Amount</span><br>
                                                        <span class="text-info fs-25 bold"> <i class="fa fa-inr" aria-hidden="true"></i> 10,000</span>
                                                    </div>
                                                    <div class="w-pr-30 text-center new-card-window_4 mt-2 ">
                                                        <span class="text-gray fs-12">Paid Amount</span><br>
                                                        <span class="text-success fs-25 bold"> <i class="fa fa-inr" aria-hidden="true"></i> 10,000</span>
                                                    </div>
                                                    <div class="w-pr-30 text-center new-card-window_3 mt-2 ">
                                                        <span class="text-gray fs-12">Balance Amount</span><br>
                                                        <span class="text-danger fs-25 bold"> <i class="fa fa-inr" aria-hidden="true"></i> 0</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card w-100">
                                                <div class="flex-s-b m-2">
                                                    <span class="w-pr-20 ml-2 mt-2 text-left data-list">
                                                        <span class="text-gray fs-15">Intrested In</span><br>
                                                        <span class="btn btn-xs btn-warning mt-2">Project-1</span>
                                                    </span>
                                                    <span class="w-pr-20  mt-2 text-left data-list">
                                                        <span class="text-gray fs-15">Status</span><br>
                                                        <span class="btn btn-xs btn-success mt-2">Sales Close</span>
                                                    </span>
                                                    <span class="w-pr-20 mt-2 text-left data-list">
                                                        <span class="text-gray fs-15">Create Date</span><br>
                                                        <span class="btn btn-xs btn-default mt-2"> 29 May, 2023</span>
                                                    </span>
                                                    <span class="w-pr-20 mt-2 text-left data-list">
                                                        <span class="text-gray fs-15">Total Calls</span><br>
                                                        <span class="btn btn-xs btn-info mt-2"> 5 Calls</span>
                                                    </span>
                                                    <span class="w-pr-10 mt-2 text-left data-list">
                                                        <span class="text-gray fs-15">Priority</span><br>
                                                        <span class="btn btn-xs btn-dark mt-2">HIGH</span>
                                                    </span>

                                                </div>
                                                <div class="data-list m-2" style="margin-bottom: 1rem !important;">
                                                    <span class="text-black bold">Description :</span><br>
                                                    <span class="text-gray">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Molestiae impedit voluptate optio accusantium? Ipsum laudantium consectetur molestias quasi inventore ducimus?</span>
                                                </div>
                                            </div>
                                            <!-- <div class="d-flex justify-content-end mt-2">
                                                <span class="text-gray fs-12 mr-2">You Can Only Change Net Amount and Paid Amount
                                                    <span class="btn btn-xs btn-info"><i class="fa fa-pencil-square-o fs-15 text-light" aria-hidden="true"></i></span>
                                                </span>
                                            </div> -->
                                        </div>
                                        <div class="col-md-9 mt-3">
                                            <div class="card w-100">
                                                <div class=" flex-s-b m-2 app-sub-heading" style="margin-top: .6rem !important;">
                                                    <span class="w-pr-10">
                                                        <span>Sr. no</span>
                                                    </span>
                                                    <span class="w-pr-20">
                                                        <span>Time</span>
                                                    </span>
                                                    <span class="w-pr-20">
                                                        <span>View Invoice</span>
                                                    </span>
                                                    <span class="w-pr-50">
                                                        <span>Discription</span>
                                                    </span>
                                                </div>
                                                <div class=" flex-s-b m-2 data-list" style="margin-top: .6rem !important;">
                                                    <span class="w-pr-10">
                                                        <span class="count">01</span>
                                                    </span>
                                                    <span class="w-pr-30">
                                                        <span>11 May, 2023 11:00 Am</span>
                                                    </span>
                                                    <span class="w-pr-10">
                                                        <span class="btn btn-info"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span>
                                                    </span>
                                                    <span class="w-pr-70">
                                                        <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque sed hic consequuntur! Impedit, esse illo!</span>
                                                    </span>
                                                </div>
                                                <div class=" flex-s-b m-2 data-list" style="margin-top: .6rem !important;">
                                                    <span class="w-pr-10">
                                                        <span class="count">02</span>
                                                    </span>
                                                    <span class="w-pr-30">
                                                        <span>11 May, 2023 11:00 Am</span>
                                                    </span>
                                                    <span class="w-pr-10">
                                                        <span class="btn btn-info"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span>
                                                    </span>
                                                    <span class="w-pr-70">
                                                        <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque sed hic consequuntur! Impedit, esse illo!</span>
                                                    </span>
                                                </div>
                                                <div class=" flex-s-b m-2 data-list" style="margin-top: .6rem !important;">
                                                    <span class="w-pr-10">
                                                        <span class="count">03</span>
                                                    </span>
                                                    <span class="w-pr-30">
                                                        <span>11 May, 2023 11:00 Am</span>
                                                    </span>
                                                    <span class="w-pr-10">
                                                        <span class="btn btn-info"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span>
                                                    </span>
                                                    <span class="w-pr-70">
                                                        <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque sed hic consequuntur! Impedit, esse illo!</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <div class="card w-100">
                                                <div class="m-2 app-sub-heading" style="margin-top: .6rem !important;">
                                                    <span class="w-pr-10">
                                                        <span>Last Transactions</span>
                                                    </span>
                                                </div>
                                                <div class="data-list m-2">
                                                    29 May, 2023 11:00:00 Am
                                                </div>
                                                <div class="data-list m-2">
                                                    29 May, 2023 11:00:00 Am
                                                </div>
                                                <div class="data-list m-2">
                                                    29 May, 2023 11:00:00 Am
                                                </div>
                                                <div class="data-list m-2">
                                                    29 May, 2023 11:00:00 Am
                                                </div>
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
    <?php include $Dir . "/assets/FooterFilesLoader.php"; ?>
</body>

</html>