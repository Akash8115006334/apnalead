<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Billing Dashboard";
$PageDescription = "Manage Bills";
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
                            <div class="card card-primary ">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="app-heading"><?php echo $PageName; ?> | <small class="text-gray"><?php echo $PageDescription; ?></small></h4>
                                        </div>
                                    </div>
                                    <div class="card mt-2">
                                        <div class="row m-1">
                                            <div class="col-md-3 mt-1 col-6 mb-10px">
                                                <a href="#">
                                                    <div class="zoom new-card-window rounded-3">
                                                        <div class="flex-s-b align-items-center">
                                                            <div class="w-pr-30 p-2">
                                                                <span class="new_card_icon"><i class="fa fa-file-text" aria-hidden="true"></i></span>
                                                            </div>
                                                            <div class="w-pr-70 ">
                                                                <span class="text-gray">Total Invoices</span><br>
                                                                <span class="dashboard_content bold fs-20">10</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-md-3 mt-1 col-6 mb-10px">
                                                <a href="#">
                                                    <div class="zoom new-card-window_2 rounded-3">
                                                        <div class="flex-s-b align-items-center">
                                                            <div class="w-pr-30 p-2">
                                                                <span class="new_card_icon_2"><i class="fa fa-users" aria-hidden="true"></i></span>
                                                            </div>
                                                            <div class="w-pr-70">
                                                                <span class="text-gray">Unpaid</span><br>
                                                                <span class="dashboard_content bold fs-20">10</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-md-3 mt-1 col-6 mb-10px">
                                                <a href="#">
                                                    <div class="zoom new-card-window_3 rounded-3">
                                                        <div class="flex-s-b align-items-center">
                                                            <div class="w-pr-30 p-2">
                                                                <span class="new_card_icon_3"><i class="fa fa-users" aria-hidden="true"></i></span>
                                                            </div>
                                                            <div class="w-pr-70">
                                                                <span class="text-gray">Paid</span><br>
                                                                <span class="dashboard_content bold fs-20">10</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-md-3 mt-1 col-6 mb-10px">
                                                <a href="#">
                                                    <div class="zoom new-card-window_4 rounded-3">
                                                        <div class="flex-s-b align-items-center">
                                                            <div class="w-pr-30 p-2">
                                                                <span class="new_card_icon_4"><i class="fa fa-money" aria-hidden="true"></i></span>
                                                            </div>
                                                            <div class="w-pr-70">
                                                                <span class="text-gray">Recived Money</span><br>
                                                                <span class="dashboard_content bold fs-20">10</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <!-- Invoices Area -->
                                            <div class="w-100  mt-3 flex-s-b align-items-center ">
                                                <div class="col-md-8 mt-3 ">
                                                    <h6 class="app-sub-heading ">Recent Invoices</h6>
                                                </div>
                                                <div class="col-md-4  text-right">
                                                    <a href="add_invoice/" class="Invoice_button"><i class="fa fa-file-text mr-1" aria-hidden="true"></i> ADD NEW INVOICE</a>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">

                                                <div class="data-display bg-light">
                                                    <div class="data-list flex-s-b mb-2">
                                                        <div class="w-pr-5">
                                                            <span class="text-gray">Sr.No</span>
                                                        </div>
                                                        <div class="w-pr-20">
                                                            <span class="text-gray">User Details</span>
                                                        </div>
                                                        <div class="w-pr-15">
                                                            <span class="text-gray">Created Date</span>
                                                        </div>
                                                        <div class="w-pr-15">
                                                            <span class="text-gray">Net Amount</span>
                                                        </div>
                                                        <div class="w-pr-15">
                                                            <span class="text-gray">Paid</span>
                                                        </div>
                                                        <div class="w-pr-15">
                                                            <span class="text-gray">Balance</span>
                                                        </div>

                                                        <div class="w-pr-10">
                                                            <span class="text-gray">Status</span>
                                                        </div>
                                                        <div class="w-pr-5">
                                                            <span class="text-gray">View </span>
                                                        </div>

                                                    </div>
                                                    <ul class=" pt-0">
                                                        <?php
                                                        for ($i = 1; $i <= 30; $i++) {
                                                            echo ' <li class="data-list">
                                                                        <div class="flex-s-b align-items-center bg-light">
                                                                            <div class="w-pr-5">
                                                                                <span class="text-dark">' . $i . '</span>
                                                                            </div>
                                                                            <div class="w-pr-20">
                                                                                <a href="./view_invoice/"><span class="text-info bold">Mr. Akash Upadhyay</span></a><br>
                                                                                <span class="text-gray"><i class="fa fa-phone-square text-success" aria-hidden="true"></i> 8115006334</span>
                                                                            </div>
                                                                            <div class="w-pr-15">
                                                                                <span class="text-dark">2 Jan, 2024</span>
                                                                            </div>
                                                                            <div class="w-pr-15">
                                                                                <span class="text-primary"><i class="fa fa-inr" aria-hidden="true"></i> 10,000</span>
                                                                             </div>
                                                                         <div class="w-pr-15">
                                                                             <span class="text-success"><i class="fa fa-inr" aria-hidden="true"></i> 10000</span>
                                                                            </div>
                                                                            <div class="w-pr-15">
                                                                                <span class="text-danger"><i class="fa fa-inr" aria-hidden="true"></i> 0</span>
                                                                            </div>
                                                                          
                                                                            <div class="w-pr-10">
                                                                                <span class="btn btn-outline-success">Paid</span>
                                                                            </div>
                                                                            <div class="w-pr-5">
                                                                                <span class="btn btn-info"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </li>';
                                                        }
                                                        ?>
                                                    </ul>
                                                    <div class="data-list flex-s-b mb-2">
                                                        <div class="w-pr-25">
                                                            <span class="text-dark bold fs-15">Total</span>
                                                        </div>
                                                        <div class="w-pr-15">
                                                            <span class="text-gray bold fs-15 ">All Dates</span>
                                                        </div>
                                                        <div class="w-pr-15">
                                                            <span class="text-info bold fs-15"><i class="fa fa-inr" aria-hidden="true"></i> 10,00000</span>
                                                        </div>
                                                        <div class="w-pr-15">
                                                            <span class="text-success bold fs-15"><i class="fa fa-inr" aria-hidden="true"></i> 10,00000</span>
                                                        </div>
                                                        <div class="w-pr-15">
                                                            <span class="text-danger bold fs-15"><i class="fa fa-inr" aria-hidden="true"></i> 0</span>
                                                        </div>
                                                        <div class="w-pr-10">
                                                            <span class="text-gray"></span>
                                                        </div>
                                                        <div class="w-pr-5">
                                                            <span class="text-gray"> </span>
                                                        </div>

                                                    </div>
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