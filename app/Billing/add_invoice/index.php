<?php

use Random\Engine\Secure;

$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';
//pagevariables
$PageName = "Add Invoice Step 1";
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
                                                <a href="index.php" class="btn btn-success">Select Customer</a>
                                                <a href="Step2.php" class="btn btn-default">Select Items </a>
                                                <span class="btn btn-default">Invoice Review</span>
                                                <!-- <span class="btn btn-xs btn-billing m-1" onclick="Databar('AddNewCustomer')"> <i class="fa fa-plus"></i> Add New Customer</span>
                                                <span class="btn btn-xs btn-billing m-1" onclick="Databar('AddNewService')"><i class="fa fa-plus"></i> Add New Service</span>
                                                <span class="btn btn-xs btn-billing m-1" onclick="Databar('AddNewProduct')"><i class="fa fa-plus"></i> Add New Product</span> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-3 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="billing-app-heading">Select Customer (Optional) </h5>
                                                </div>
                                            </div>
                                            <div class="data-display bg-light">
                                                <form action="#" class="flex">
                                                    <div class="form-group col-md-12">
                                                        <input type="search" id="searching" oninput="SearchData('searching', 'customer-data')" class="form-control form-control-sm" placeholder="Search Customers">
                                                    </div>
                                                </form>
                                                <div class="data-calling ">
                                                    <ul class="pt-0">
                                                        <?php $AllLeads = _DB_COMMAND_("SELECT LeadsId,LeadSalutations,LeadPersonFullName,LeadPersonPhoneNumber FROM leads WHERE CompanyId='" . CompanyId . "' ORDER BY LeadsId DESC", true);
                                                        if ($AllLeads != null) {
                                                            // $count = 0;
                                                            foreach ($AllLeads as $leads) {
                                                                // $count++; 
                                                        ?>
                                                                <li class="data-list customer-data new-outline-hover bg-light">
                                                                    <a href="?customerid=<?php echo Secure($leads->LeadsId, "e"); ?>" class="flex align-items-center ">
                                                                        <span class=" w-pr-10">
                                                                            <span class=""><img src="<?php echo STORAGE_URL . "/default/default.png"; ?>" alt="" class="w-100 elevation-2"></span></span>
                                                                        <span class="w-pr-80 ml-3">
                                                                            <span class="text-info bold"><?php echo $leads->LeadSalutations . ' ' . $leads->LeadPersonFullName ?></span><br>
                                                                            <span class="text-gray"><?php echo $leads->LeadPersonPhoneNumber; ?></span>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                        <?php }
                                                        } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h5 class="billing-app-heading">Customer/Company Details</h5>
                                                </div>
                                            </div>
                                            <div class="data-list bg-light">
                                                <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST" enctype="multipart/form-data">
                                                    <?php
                                                    FormPrimaryInputs(true); ?>
                                                    <div class="row">
                                                        <?php
                                                        if (isset($_GET['customerid'])) {
                                                            $LeadsId = SECURE($_GET['customerid'], "d");
                                                            $name = FETCH("SELECT LeadPersonFullname FROM leads WHERE LeadsId='$LeadsId'", "LeadPersonFullname");
                                                            $phone = FETCH("SELECT LeadPersonPhoneNumber FROM leads WHERE LeadsId='$LeadsId'", "LeadPersonPhoneNumber");
                                                            $email = FETCH("SELECT LeadPersonEmailId FROM leads WHERE LeadsId='$LeadsId'", "LeadPersonEmailId");
                                                        } else {
                                                            $name = "";
                                                            $phone = "";
                                                            $email = "";
                                                        } ?>
                                                        <div class='col-md-6 form-group'>
                                                            <label>Customer/Company Name <?php echo $req; ?></label>
                                                            <input type="text" name="UserFullName" value="<?php echo $name; ?>" class="form-control form-control-sm" placeholder="Enter Person Name or Company Name" required="">
                                                        </div>
                                                        <div class='col-md-6 form-group'>
                                                            <label>Billing Name <?php echo $req; ?></label>
                                                            <input type="text" name="UserFullName" value="<?php echo $name; ?>" class="form-control form-control-sm" placeholder="Enter Billing Name" required="">
                                                        </div>
                                                        <div class='col-md-6 form-group'>
                                                            <label>Customer/Company Phone <?php echo $req; ?> <span id='phonemsg'></span></label>
                                                            <input type="tel" placeholder="without +91" value="<?php echo $phone; ?>" oninput="CheckExistingPhoneNumbers()" id="PhoneNumber" name="UserPhoneNumber" class="form-control form-control-sm" required="">
                                                        </div>
                                                        <div class='col-md-6 form-group'>
                                                            <label>Tel Phone (Optional) <span id='phonemsg'></span></label>
                                                            <input type="tel" placeholder="Teliphone number" name="UserTelNumber" class="form-control form-control-sm">
                                                        </div>
                                                        <div class='col-md-7 form-group'>
                                                            <label>Customer Email-ID <span id='emailmsg'></span></label>
                                                            <input type="email" oninput="CheckExistingMailId()" value="<?php echo $email; ?>" id="EmailId" placeholder="Enter Email-ID" name="UserEmailId" class="form-control form-control-sm">
                                                        </div>
                                                        <div class="col-md-5 form-group">
                                                            <label>GST Number (Optional) </label>
                                                            <input type="text" placeholder="GST Number" class="form-control from-control-sm" required="">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <h6 class="billing-app-sub-heading flex-s-b">Billing Address <span class="btn btn-xs btn-light" id="ShippingDetails" onclick="shipping();"><i class="fa fa-plus"></i> Add Shipping Address</span></h6>
                                                            <div class="row">
                                                                <div class="col-md-12 form-group">
                                                                    <label>House No/Flat No/Villa No <?php echo $req; ?></label>
                                                                    <textarea name="CustomerStreetAddress" id="street" class="form-control form-control-sm" rows="2" required></textarea>
                                                                </div>
                                                                <div class='col-md-7 form-group'>
                                                                    <label>Sector/Area Locality <?php echo $req; ?></label>
                                                                    <input type="text" name="CustomerAreaLocality" id="area" class="form-control form-control-sm" required="">
                                                                </div>
                                                                <div class='col-md-5 form-group'>
                                                                    <label>City <?php echo $req; ?></label>
                                                                    <input type="text" name="CustomerCity" id="city" class="form-control form-control-sm" required="">
                                                                </div>
                                                                <div class='col-md-4 form-group'>
                                                                    <label>State <?php echo $req; ?></label>
                                                                    <input type="text" name="CustomerState" id="state" class="form-control form-control-sm" required="">
                                                                </div>
                                                                <div class='col-md-4 form-group'>
                                                                    <label>Country <?php echo $req; ?></label>
                                                                    <input type="text" name="CustomerCountry" id="country" class="form-control form-control-sm" required="">
                                                                </div>
                                                                <div class='col-md-4 form-group'>
                                                                    <label>Pincode <?php echo $req; ?></label>
                                                                    <input type="text" name="CustomerPincode" id="pincode" class="form-control form-control-sm" required="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 hidden" id="shippingdetailsdiv">

                                                            <h6 class="billing-app-sub-heading">Shipping Address</h6>
                                                            <div class="row">
                                                                <div class="col-md-12 form-group">
                                                                    <label>House No/Flat No/Villa No <?php echo $req; ?></label>
                                                                    <textarea name="CustomerStreetAddress1" id="street1" class="form-control form-control-sm" rows="2" required></textarea>
                                                                </div>
                                                                <div class='col-md-7 form-group'>
                                                                    <label>Sector/Area Locality <?php echo $req; ?></label>
                                                                    <input type="text" name="CustomerAreaLocality1" id="area1" class="form-control form-control-sm" required="">
                                                                </div>
                                                                <div class='col-md-5 form-group'>
                                                                    <label>City <?php echo $req; ?></label>
                                                                    <input type="text" name="CustomerCity1" id="city1" class="form-control form-control-sm" required="">
                                                                </div>
                                                                <div class='col-md-4 form-group'>
                                                                    <label>State <?php echo $req; ?></label>
                                                                    <input type="text" name="CustomerState1" id="state1" class="form-control form-control-sm" required="">
                                                                </div>
                                                                <div class='col-md-4 form-group'>
                                                                    <label>Country <?php echo $req; ?></label>
                                                                    <input type="text" name="CustomerCountry1" id="country1" class="form-control form-control-sm" required="">
                                                                </div>
                                                                <div class='col-md-4 form-group'>
                                                                    <label>Pincode <?php echo $req; ?></label>
                                                                    <input type="text" name="CustomerPincode1" id="pincode1" class="form-control form-control-sm" required="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12" onclick="CopyAddressdeatils()">
                                                                <input type="checkbox" id="CopyAddress"> Shipping Address is same as Billing address
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 text-center mt-4">
                                                            <a href="Step2.php" class="btn btn-primary">Confirm user</a>
                                                            <button type="reset" class="btn btn-secondary">Reset user</button>
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
    <script>
        function shipping() {
            document.getElementById("shippingdetailsdiv").classList.toggle("hidden");
        }
    </script>
</body>

</html>