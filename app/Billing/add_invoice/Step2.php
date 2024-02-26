<?php

use Random\Engine\Secure;

$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';
//pagevariables
$PageName = "Add Invoice Step 2";
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
                            <div class="card card-primary billing-bg-color">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-9 col-sm-12">
                                            <h4 class="billing-app-heading"><?php echo $PageName; ?> <small class="text-gray"><?php echo $PageDescription; ?></small></h4>
                                        </div>
                                        <div class="col-md-3 col-sm-12 flex-s-b">
                                            <a href="./../index.php" class="btn btn-xs btn-billing m-1"><i class="fa fa-arrow-left fs-10" aria-hidden="true"></i> Billing Dashboard</a>
                                            <a href="#" class="btn btn-xs btn-billing m-1"><i class="fa fa-arrow-up fs-10" aria-hidden="true"></i> Create Invoice Template</a>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <div class="d-flex justify-content-around align-items-center">
                                                <a href="index.php" class="btn btn-success"><i class="fa fa-check bold"></i> Select Customer</a>
                                                <a href="Step2.php" class="btn btn-success">Select Items </a>
                                                <span class="btn btn-default">Invoice Review</span>
                                                <!-- <span class="btn btn-xs btn-billing m-1" onclick="Databar('AddNewCustomer')"> <i class="fa fa-plus"></i> Add New Customer</span>
                                                <span class="btn btn-xs btn-billing m-1" onclick="Databar('AddNewService')"><i class="fa fa-plus"></i> Add New Service</span>
                                                <span class="btn btn-xs btn-billing m-1" onclick="Databar('AddNewProduct')"><i class="fa fa-plus"></i> Add New Product</span> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="billing-app-heading">Invoice for </h5>
                                                </div>
                                            </div>
                                            <div class="data-display bg-light">
                                                <div class="row">
                                                    <div class="data-calling col-md-12 ">
                                                        <div class="form-group">
                                                            <label class="btn btn-default"><input type="checkbox" checked name="Product"> For Product</label>

                                                            <label class="btn btn-default"><input type="checkbox" name="Service"> For Service</label>

                                                            <label class="btn btn-default"><input type="checkbox" name="Subscription"> For Subscription</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <h6 class="billing-app-sub-heading">Select items</h6>
                                                    </div>
                                                    <div class="data-calling col-md-12">
                                                        <div class="data-list col-md-12">
                                                            <div class="flex-s-b">
                                                                <span class="text-info bold fs-15">Apnalead Base Varient</span>
                                                                <span class="btn btn-xs btn-default">Product</span>
                                                            </div>
                                                            <div class="flex-s-b align-items-center">
                                                                <span>
                                                                    <span class="text-gray fs-12">HSN CODE : <b>33736</b></span><br>
                                                                    <span class="text-gray fs-12">Category : <b>Software</b></span><br>
                                                                    <span class="text-gray fs-12">Sale Price : <b>25000</b></span><br>
                                                                    <span class="text-gray fs-12">GST: <b>18%</b></span><br>
                                                                </span>
                                                                <span>
                                                                    <span class="btn btn-md btn-success"><i class="fa fa-cart-plus" aria-hidden="true"></i> ADD</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="data-list col-md-12">
                                                            <div class="flex-s-b">
                                                                <span class="text-info bold fs-15">Apnalead Service</span>
                                                                <span class="btn btn-xs btn-default">Service</span>
                                                            </div>
                                                            <div class="flex-s-b align-items-center">
                                                                <span>
                                                                    <span class="text-gray fs-12">HSN CODE : <b>33736</b></span><br>
                                                                    <span class="text-gray fs-12">Category : <b>Software</b></span><br>
                                                                    <span class="text-gray fs-12">Sale Price : <b>25000</b></span><br>
                                                                    <span class="text-gray fs-12">GST: <b>18%</b></span><br>
                                                                </span>
                                                                <span>
                                                                    <span class="btn btn-md btn-success"><i class="fa fa-cart-plus" aria-hidden="true"></i> ADD</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="data-list col-md-12">
                                                            <div class="flex-s-b">
                                                                <span class="text-info bold fs-15">Apnalead Subscription</span>
                                                                <span class="btn btn-xs btn-default">Subscription</span>
                                                            </div>
                                                            <div class="flex-s-b align-items-center">
                                                                <span>
                                                                    <span class="text-gray fs-12">HSN CODE : <b>33736</b></span><br>
                                                                    <span class="text-gray fs-12">Time Period : <b>Monthly</b></span><br>
                                                                    <span class="text-gray fs-12">Service Price : <b>25000</b></span><br>
                                                                    <span class="text-gray fs-12">GST: <b>18%</b></span><br>
                                                                </span>
                                                                <span>
                                                                    <span class="btn btn-md btn-success"><i class="fa fa-cart-plus" aria-hidden="true"></i> ADD</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h5 class="billing-app-heading">Billing Preview</h5>
                                                </div>
                                            </div>
                                            <div class="data-list bg-light">
                                                <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST" enctype="multipart/form-data">
                                                    <?php
                                                    FormPrimaryInputs(true); ?>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="flex-s-b">
                                                                <span>
                                                                    <span class="bold"><b>Billing To</b></span><br>
                                                                    <span><i class="fa fa-user"></i>Akash Upadhyay</span><br>
                                                                    <span><i class="fa fa-phone"></i>+918115006335</span><br>
                                                                    <span><i class="fa fa-envelope"></i>akashupadhyay00786@gmail.com</span>
                                                                </span>
                                                                <span class="text-gray"><b>Note:</b> once you choose items <br> you will unable to edit or update <br>the item after submitting ..</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-5">

                                                            <div class="flex-s-b align-item-center billing-app-sub-heading ">
                                                                <span class="gray w-pr-5">Action</span>
                                                                <span class="gray w-pr-20">Name</span>
                                                                <span class="gray w-pr-10">Category</span>
                                                                <span class="gray w-pr-12">HSN Code</span>
                                                                <span class="w-pr-12">Sale Price</span>
                                                                <span class="w-pr-13">MRP Price</span>
                                                                <span class="w-pr-10">GST</span>
                                                                <span class="w-pr-13 text-center">Total With Tax</span>
                                                            </div>

                                                            <div class="data-list">
                                                                <div class="flex-s-b align-item-center">
                                                                    <span class=" w-pr-5"><span class="btn btn-xs btn-default"><i class="fa fa-trash text-danger"></i></span></span>
                                                                    <span class="gray w-pr-20">Apnalead Base Varient</span>
                                                                    <span class="gray w-pr-10">Software</span>
                                                                    <span class="gray w-pr-12">373627</span>
                                                                    <span class="w-pr-12">25000</span>
                                                                    <span class="w-pr-13">45000</span>
                                                                    <span class="w-pr-10">18%</span>
                                                                    <span class="w-pr-13 text-center">29000</span>
                                                                </div>
                                                            </div>
                                                            <div class="data-list">
                                                                <div class="flex-s-b align-item-center">
                                                                    <span class=" w-pr-5"><span class="btn btn-xs btn-default"><i class="fa fa-trash text-danger"></i></span></span>
                                                                    <span class="gray w-pr-20">Apnalead Service</span>
                                                                    <span class="gray w-pr-10">Training</span>
                                                                    <span class="gray w-pr-12">373627</span>
                                                                    <span class="w-pr-12">5000</span>
                                                                    <span class="w-pr-13">5000</span>
                                                                    <span class="w-pr-10">18%</span>
                                                                    <span class="w-pr-13 text-center">7000</span>
                                                                </div>
                                                            </div>
                                                            <div class="data-list">
                                                                <div class="flex-s-b align-item-center">
                                                                    <span class=" w-pr-5"><span class="btn btn-xs btn-default"><i class="fa fa-trash text-danger"></i></span></span>
                                                                    <span class="gray w-pr-20">Apnalead Subscription</span>
                                                                    <span class="gray w-pr-10">Maintanace</span>
                                                                    <span class="gray w-pr-12">373627</span>
                                                                    <span class="w-pr-12">500</span>
                                                                    <span class="w-pr-13">500</span>
                                                                    <span class="w-pr-10">18%</span>
                                                                    <span class="w-pr-13 text-center">700</span>
                                                                </div>
                                                            </div>
                                                            <div class="data-list billing-bg-color mt-3">
                                                                <div class="flex-s-b">
                                                                    <span class="gray w-pr-70"><b>Total</b></span>
                                                                    <span class="w-pr-15">Including GST</span>
                                                                    <span class="w-pr-15 text-center"><b>Rs. 48000</b></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 text-center mt-4">
                                                            <a href="invoice_review.php" type="submit" class="btn btn-primary">Confirm Item</a>
                                                            <button type="reset" class="btn btn-secondary">Back to user</button>
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
        <?php include $Dir . "/include/footer.php";
        include $Dir . "/include/forms/Billingform/AddNewService.php";
        include $Dir . "/include/forms/Billingform/AddNewProduct.php"; ?>
    </div>
    <?php include $Dir . "/assets/FooterFilesLoader.php"; ?>
    <script>
        function CheckExistingPhoneNumbers() {
            let SearchingFor = document.getElementById("PhoneNumber");
            var phonemsg = document.getElementById("phonemsg");
            var pattern = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
            var subbtn = document.getElementById("subbtn");
            let ExistingPhoneNumbers = [<?php
                                        $AllData = _DB_COMMAND_("SELECT LeadPersonPhoneNumber FROM leads WHERE CompanyID='" . CompanyId . "'", true);
                                        if ($AllData != null) {
                                            foreach ($AllData as $Data) {
                                                echo "'" . $Data->LeadPersonPhoneNumber . "', ";
                                            }
                                        }
                                        ?>];

            if (ExistingPhoneNumbers.includes(SearchingFor.value)) {
                phonemsg.classList.add("text-danger");
                phonemsg.classList.remove("text-warning");
                phonemsg.innerHTML = "<i class='fa fa-warning'></i> Phone Number Already Exits";
                subbtn.type = "button";
            } else if (pattern.test(SearchingFor.value) == false) {
                phonemsg.classList.add("text-warning");
                phonemsg.classList.remove("text-danger");
                phonemsg.innerHTML = "<i class='fa fa-warning'></i> Phone Number is not valid";
                subbtn.type = "button";
            } else {
                phonemsg.classList.remove("text-danger");
                phonemsg.classList.remove("text-warning");
                phonemsg.classList.add("text-success");
                phonemsg.innerHTML = "<i class='fa fa-check'></i> Phone Number is Ok";
                subbtn.type = "submit";
            }
        };
    </script>
    <script>
        function CheckExistingMailId() {
            let SearchingFor = document.getElementById("EmailId");
            var emailmsg = document.getElementById("emailmsg");
            var pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            var subbtn = document.getElementById("subbtn");
            let CheckExistingMailId = [<?php
                                        $AllData = _DB_COMMAND_("SELECT LeadPersonEmailId FROM leads where CompanyID='" . CompanyId . "'", true);
                                        if ($AllData != null) {
                                            foreach ($AllData as $Data) {
                                                echo "'" . $Data->LeadPersonEmailId . "', ";
                                            }
                                        } ?>];

            if (CheckExistingMailId.includes(SearchingFor.value)) {
                emailmsg.classList.add("text-danger");
                emailmsg.classList.remove("text-warning");
                emailmsg.innerHTML = "<i class='fa fa-warning'></i> Email-Id Already Exits";
                subbtn.type = "button";
            } else if (pattern.test(SearchingFor.value) == false) {
                emailmsg.classList.add("text-warning");
                emailmsg.classList.remove("text-danger");
                emailmsg.innerHTML = "<i class='fa fa-warning'></i> Email-ID is not valid";
                subbtn.type = "button";
            } else {
                emailmsg.classList.remove("text-danger");
                emailmsg.classList.remove("text-warning");
                emailmsg.classList.add("text-success");
                emailmsg.innerHTML = "<i class='fa fa-check'></i> Email-ID is Ok";
                subbtn.type = "submit";
            }
        }

        function CopyAddressdeatils() {
            var CopyAddress = document.getElementById("CopyAddress");
            if (CopyAddress.checked) {
                document.getElementById("street1").value = document.getElementById("street").value;
                document.getElementById("area1").value = document.getElementById("area").value;
                document.getElementById("city1").value = document.getElementById("city").value;
                document.getElementById("state1").value = document.getElementById("state").value;
                document.getElementById("country1").value = document.getElementById("country").value;
                document.getElementById("pincode1").value = document.getElementById("pincode").value;
            } else {
                document.getElementById("street1").value = "";
                document.getElementById("area1").value = "";
                document.getElementById("city1").value = "";
                document.getElementById("state1").value = "";
                document.getElementById("country1").value = "";
                document.getElementById("pincode1").value = "";
            }
        }

        function CopyAddressdeatils() {
            var CopyAddress = document.getElementById("CopyAddress");
            if (CopyAddress.checked) {
                document.getElementById("street1").value = document.getElementById("street").value;
                document.getElementById("area1").value = document.getElementById("area").value;
                document.getElementById("city1").value = document.getElementById("city").value;
                document.getElementById("state1").value = document.getElementById("state").value;
                document.getElementById("country1").value = document.getElementById("country").value;
                document.getElementById("pincode1").value = document.getElementById("pincode").value;
            } else {
                document.getElementById("street1").value = "";
                document.getElementById("area1").value = "";
                document.getElementById("city1").value = "";
                document.getElementById("state1").value = "";
                document.getElementById("country1").value = "";
                document.getElementById("pincode1").value = "";
            }
        }
    </script>
</body>

</html>