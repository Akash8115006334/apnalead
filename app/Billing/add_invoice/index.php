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
                            <div class="card card-primary billing-bg-color">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-9 col-sm-12">
                                            <h4 class="billing-app-heading"><?php echo $PageName; ?> <small class="text-gray"><?php echo $PageDescription; ?></small></h4>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                        </div>
                                        <div class="col-md-12">
                                            <span class="flex">
                                                <a href="./../index.php" class="btn btn-xs btn-billing m-1"><i class="fa fa-arrow-left fs-10" aria-hidden="true"></i> Billing Dashboard</a>
                                                <a href="#" class="btn btn-xs btn-billing m-1"><i class="fa fa-arrow-up fs-10" aria-hidden="true"></i> Create Invoice Template</a>
                                                <span class="btn btn-xs btn-billing m-1" onclick="Databar('AddNewCustomer')"> <i class="fa fa-plus"></i> Add New Customer</span>
                                                <span class="btn btn-xs btn-billing m-1" onclick="Databar('AddNewService')"><i class="fa fa-plus"></i> Add New Service</span>
                                                <span class="btn btn-xs btn-billing m-1" onclick="Databar('AddNewProduct')"><i class="fa fa-plus"></i> Add New Product</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-3 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="billing-app-sub-heading">
                                                        <p class="text-light flex-s-b align-items-center">Select Customer </p>
                                                    </div>
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
                                                        <?php $AllLeads = _DB_COMMAND_("SELECT * FROM leads WHERE CompanyId='" . CompanyId . "' ORDER BY LeadsId DESC", true);
                                                        if ($AllLeads != null) {
                                                            // $count = 0;
                                                            foreach ($AllLeads as $leads) {
                                                                // $count++; 
                                                        ?>
                                                                <li class="data-list customer-data new-outline-hover bg-light">
                                                                    <a href="?customerid=<?php echo $leads->LeadsId; ?>" class="flex align-items-center ">
                                                                        <span class=" w-pr-10">
                                                                            <span class=""><img src="<?php echo STORAGE_URL . "/default/default.png"; ?>" alt="" class="w-100 elevation-2"></span></span>
                                                                        <span class="w-pr-80 ml-3">
                                                                            <span class="text-info bold"><?php echo $leads->LeadSalutations . ' ' . $leads->LeadPersonFullname ?></span><br>
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
                                        <div class="col-md-3 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="billing-app-sub-heading text-center ">
                                                        <p class="text-light flex-s-b">Select Sevice or Product</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if (isset($_GET['customerid'])) { ?>
                                                <div class="data-display bg-light">
                                                    <form action="#" class="flex">
                                                        <div class="form-group col-md-12">
                                                            <input type="search" id="searching1" oninput="SearchData('searching1', 'customer-item')" class="form-control form-control-sm" placeholder="Search Customers">
                                                        </div>
                                                    </form>
                                                    <div class="data-calling">
                                                        <ul class="pt-0">
                                                            <?php $AllItems = _DB_COMMAND_("SELECT * FROM invoice_items WHERE CompanyId='" . CompanyId . "' ORDER BY ItemId DESC", true);
                                                            if ($AllItems != null) {
                                                                // $count = 0;
                                                                foreach ($AllItems as $item) {
                                                                    // $count++; 
                                                            ?>
                                                                    <li class="data-list customer-item mt-1 bg-light">

                                                                        <?php if ($item->InvoiceType == "Service") { ?>
                                                                            <div class="flex-s-b align-items-center">
                                                                                <span class="fs-15 bold text-info"><?php echo $item->Item_Name; ?><a href='#' onclick="Databar('ServiceUpdate_<?php echo $item->ItemId; ?>')" class="bold text-danger"> <i class="fa fa-edit"></i></a></span>
                                                                                <span class="text-gray btn btn-xs btn-billing cursor-default"><?php echo $item->InvoiceType; ?></span>
                                                                            </div>
                                                                            <span class="text-gray fs-12">HSN Number <b><?php echo $item->HSN_Number; ?></b></span><br>
                                                                            <div class="flex-s-b">
                                                                                <span class="bold"><i class="fa fa-rupee-sign"></i> <?php echo $item->ItemSalePrice; ?> <span class="text-gray fs-12">| GST : <?php echo $item->ItemSaleGST . "%"; ?></span></span><br>
                                                                                <span class="fs-18"><b class=" text-success"><i class="fa fa-rupee-sign"></i> <?php echo $item->ItemNetPrice; ?></b></span>
                                                                            </div>
                                                                            <a href="?item=<?php echo $item->ItemId ?>" class="btn btn-xs btn-block btn-success"><i class="fa fa-cart-plus"></i> ADD</a>
                                                                        <?php
                                                                            include "./../../../include/forms/UpdateService.php";
                                                                        } elseif ($item->InvoiceType == "Product") { ?>
                                                                            <div class="flex-s-b align-items-center">
                                                                                <span class="fs-15 bold text-info"><?php echo $item->Item_Name; ?><a href="#" onclick="Databar('ProductUpdate_<?php echo $item->ItemId; ?>')" class="bold text-danger"> <i class="fa fa-edit"></i></a></span>
                                                                                <span class="text-gray btn btn-xs btn-billing cursor-default"><?php echo $item->InvoiceType; ?></span>
                                                                            </div>
                                                                            <span class="text-gray fs-12">Modal Number <b><?php echo $item->ModalNo; ?></b></span><br>
                                                                            <span class="text-gray fs-12">Brand <b><?php echo $item->Manufracturer; ?></b></span><br>
                                                                            <span class="text-gray fs-12">Type <b><?php echo $item->ItemType; ?></b></span><br>
                                                                            <div class="d-flex justify-content-between">

                                                                                <span class="bold"><i class="fa fa-rupee-sign"></i> <?php echo $item->ItemSalePrice; ?> <span class="text-gray fs-12">| GST : <?php echo $item->ItemSaleGST . "%"; ?></span></span><br>
                                                                                <span class="fs-18"><b class=" text-success"><i class="fa fa-rupee-sign"></i> <?php echo $item->ItemNetPrice; ?></b></span>
                                                                            </div>
                                                                            <a href="?item=<?php echo $item->ItemId ?>" class="btn btn-xs btn-block btn-success"><i class="fa fa-cart-plus"></i> ADD</a>
                                                                        <?php
                                                                            include "./../../../include/forms/UpdateProduct.php";
                                                                        } ?>
                                                                    </li>
                                                            <?php
                                                                }
                                                            } else {
                                                                NoData("No Service and Product Found!!");
                                                            } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            <?php } else {
                                                NoData("Please select user First");
                                            } ?>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="billing-app-sub-heading text-center">
                                                <p class="text-light">Invoice Preview</p>
                                            </div>
                                            <?php if (isset($_GET['customerid'])) { ?>
                                                <div class="data-list bg-light mt-2 ">
                                                    <div class="">
                                                        <b>Billing To:</b><br><br>
                                                        <?php if (isset($_GET['customerid'])) {
                                                            $LeadsId = $_GET['customerid'];
                                                        } else {
                                                            $LeadsId = "";
                                                        } ?>
                                                        <h5 class="bold"><i class="fa fa-user"></i> <?php echo FETCH("SELECT LeadPersonFullName FROM leads WHERE Leadsid='$LeadsId' and CompanyId='" . CompanyId . "'", "LeadPersonFullName"); ?></h5>
                                                        <p><span class="fs-15"><i class="fa fa-phone-square text-success " aria-hidden="true"></i> <?php echo FETCH("SELECT LeadPersonPhoneNumber FROM leads WHERE Leadsid='$LeadsId' and CompanyId='" . CompanyId . "'", "LeadPersonPhoneNumber"); ?></span><br>
                                                            <span class="fs-15"><i class="fa fa-envelope text-danger" aria-hidden="true"></i> <?php echo FETCH("SELECT LeadPersonEmailId FROM leads WHERE Leadsid='$LeadsId' and CompanyId='" . CompanyId . "'", "LeadPersonEmailId"); ?></span>
                                                        </p>
                                                        <p class="mt-2"><b><i class="fa fa-map-marker fs-15 text-info"></i> Billing Address :-</b>
                                                            <?php
                                                            $CheckAddress = CHECK("SELECT CustomerLeadMainId FROM invoice_address WHERE CustomerLeadMainId='$LeadsId'");
                                                            if ($CheckAddress) {
                                                                $GetAddress = _DB_COMMAND_("SELECT CustomerLeadMainId, CustomerStreetAddress, CustomerAreaLocality, CustomerCity, CustomerState, CustomerCountry, CustomerPincode FROM invoice_address WHERE CustomerLeadMainId='$LeadsId' AND CompanyID='" . CompanyId . "'", true);
                                                                if ($GetAddress != null) {
                                                                    foreach ($GetAddress as $add) {
                                                                        echo $add->CustomerStreetAddress . " " . $add->CustomerAreaLocality . " " . $add->CustomerCity . " " . $add->CustomerState . " " . $add->CustomerCountry . " " . $add->CustomerPincode;
                                                                    }
                                                                }
                                                            } else {
                                                                echo FETCH("SELECT LeadPersonAddress FROM leads WHERE LeadsId='$LeadsId' AND CompanyId='" . CompanyId . "'", "LeadPersonAddress");
                                                            }
                                                            ?></p>
                                                        <p class="mt-2">
                                                            <span class="btn btn-xs btn-dark m-1" onclick="Databar('EditUser')"><i class="fa fa-pencil"></i> Edit User</span>
                                                            <span class="btn btn-xs btn-dark m-1" onclick="Databar('EditAddress')"><i class="fa fa-pencil"></i> Edit Address</span>
                                                        </p>
                                                        <?php include "./../../../include/forms/EditUser.php"; ?>
                                                        <?php include "./../../../include/forms/EditAddress.php"; ?>
                                                    </div>
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
                                            <?php } else {
                                                NoData("Please select user First!");
                                            } ?>
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
        include $Dir . "/include/forms/AddNewService.php";
        include $Dir . "/include/forms/AddNewProduct.php"; ?>
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
    </script>
</body>

</html>