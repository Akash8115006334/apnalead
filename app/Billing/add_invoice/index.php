<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Add Invoice";
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
                            <div class="card card-primary ">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-9 col-sm-12">
                                            <h4 class="app-heading"><?php echo $PageName; ?> <small class="text-gray"><?php echo $PageDescription; ?></small></h4>
                                        </div>
                                        <div class="col-md-3 col-sm-12">

                                        </div>
                                        <div class="col-md-12">
                                            <span class="flex">
                                                <a href="./../index.php" class="btn btn-md btn-default mr-1"><i class="fa fa-arrow-left fs-10" aria-hidden="true"></i> Billing Dashboard</a>
                                                <a href="#" class="btn btn-md btn-default ml-2"><i class="fa fa-arrow-up fs-10" aria-hidden="true"></i> Create Invoice Template</a>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-5 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="data-list bg-info">
                                                        <p class="text-light">Select In Existing Leads</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="data-display bg-light">
                                                <form action="#" class="flex">
                                                    <div class="form-group col-md-10">
                                                        <input type="text" class="form-control" placeholder="search">
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <input type="submit" class="btn btn-warning" value="Search">
                                                    </div>
                                                </form>
                                                <div class="data-list flex m-1">
                                                    <span class="w-pr-10">
                                                        <span class="text-gray">Sr.no</span>
                                                    </span>
                                                    <span class="w-pr-35">
                                                        <span class="text-gray">Name</span>
                                                    </span>
                                                    <span class="w-pr-30">
                                                        <span class="text-gray">Phone</span>
                                                    </span>
                                                    <span class="w-pr-25">
                                                        <span class="text-gray">Managed Person</span>
                                                    </span>
                                                </div>
                                                <div class="data-calling">
                                                    <ul class="pt-0">
                                                        <?php $AllLeads = _DB_COMMAND_("SELECT * FROM leads WHERE CompanyId='" . CompanyId . "' ORDER BY LeadsId DESC", true);
                                                        if ($AllLeads != null) {
                                                            $count = 0;
                                                            foreach ($AllLeads as $leads) {
                                                                $count++; ?>
                                                                <li class="data-list">
                                                                    <a href="#" class="flex">
                                                                        <span class=" w-pr-10">
                                                                            <span class="count fs-10"><?php echo $count; ?></span></span>
                                                                        <span class="w-pr-35">
                                                                            <span class="text-info bold"><?php echo $leads->LeadSalutations . ' ' . $leads->LeadPersonFullname ?></span><br>
                                                                        </span>
                                                                        <span class="w-pr-30 text-left">
                                                                            <span class="text-gray"><?php echo $leads->LeadPersonPhoneNumber; ?></span>
                                                                        </span>
                                                                        <span class="w-pr-25 text-left">
                                                                            <span class="text-gray"><?php echo FETCH("SELECT UserFullName FROM users WHERE UserId='" . $leads->LeadPersonManagedBy . "'", "UserFullName"); ?></span>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                        <?php }
                                                        } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7 col-sm-12">
                                            <div class="data-list bg-info text-center">
                                                <p class="text-light">Fill the Invoice Deatils</p>
                                            </div>
                                            <div class="data-list mt-2">
                                                <p class="text-gray mt-1 p-2">*You have to enter Total Amount and Total Paid then You will automatic get left Balence in Invoice, also you can add discount and Gst Amount. <br>
                                                    Remember You Can Create Invoice Template via clicking on Create Invoice Template</p>
                                                <hr>
                                                <form action="">
                                                    <div class="row mt-2">
                                                        <div class="col-md-6 form-group mt-2">
                                                            <label for="">Net Payable Amount <span class="text-danger">*</span></label>
                                                            <input type="text" name="Net_Amount" class="form-control">
                                                        </div>
                                                        <div class="col-md-6 form-group mt-2">
                                                            <label for="">Paid <span class="text-danger">*</span></label>
                                                            <input type="text" name="Net_Amount" class="form-control">
                                                        </div>
                                                        <div class="col-md-6 form-group mt-2">
                                                            <label for="">GST <span class="text-danger">*</span></label>
                                                            <input type="text" name="Net_Amount" class="form-control">
                                                        </div>
                                                        <div class="col-md-6 form-group mt-2">
                                                            <label for="">Discount <span class="text-danger">*</span></label>
                                                            <input type="text" name="Net_Amount" class="form-control">
                                                        </div>
                                                        <div class="col-md-12 text-center mt-4">
                                                            <input type="submit" value="Create Invoice" name="submit" class="btn btn-danger">
                                                            <input type="reset" class="btn btn-outline-dark">
                                                        </div>
                                                    </div>
                                                </form>
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