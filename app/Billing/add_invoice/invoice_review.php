<?php

use Random\Engine\Secure;

$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';
//pagevariables
$PageName = "Add Invoice Step 3";
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
                                                <a href="Step2.php" class="btn btn-success"><i class="fa fa-check bold"></i> Select Items </a>
                                                <span class="btn btn-success">Invoice Review</span>
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
                                                    <h5 class="billing-app-heading">Invoice Type </h5>
                                                </div>
                                            </div>
                                            <div class="data-display bg-light">
                                                <div class="row">
                                                    <div class="data-calling col-md-12 ">
                                                        <div class="form-group">
                                                            <label class="btn btn-default"><input type="checkbox" checked name="Performa Invoice"> Performa Invoice</label>
                                                            <label class="btn btn-default"><input type="checkbox" name="Invoice"> Invoice</label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Choose Invoice Date <?php echo $req; ?></label>
                                                            <input type="date" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <h6 class="billing-app-sub-heading">ADD Payment Details</h6>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="">GST NO</label>
                                                        <input type="text" placeholder="GST Number" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="">Pan</label>
                                                        <input type="text" placeholder="Pan Number" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="">Mobile</label>
                                                        <input type="text" placeholder="Mobile Number" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="">Email Id</label>
                                                        <input type="text" placeholder="Email Id" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="">Account Holder Name</label>
                                                        <input type="text" placeholder="Account Holder Name" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="">Bank Name</label>
                                                        <input type="text" placeholder="Bank Name" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="">Account Number</label>
                                                        <input type="text" placeholder="Account Number" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="">Branch Name</label>
                                                        <input type="text" placeholder="Branch Name" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="">IFSC Code</label>
                                                        <input type="text" placeholder="IFSC Code" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="">Branch Address</label>
                                                        <input type="text" placeholder="Branch Address" class="form-control">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <input type="checkbox"> Check For All Invoice
                                                    </div>
                                                    <div class="col-md-12 text-center mt-2">
                                                        <button type="submit" class="btn btn-primary">Add Deatils</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h5 class="billing-app-heading">Invoice Preview</h5>
                                                </div>
                                            </div>
                                            <div class="data-list bg-light">
                                                <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST" enctype="multipart/form-data">
                                                    <?php
                                                    FormPrimaryInputs(true); ?>
                                                    <div class="row">
                                                        <div class="col-md-12 text-center">
                                                            <span class="bold fs-20">INVOICE</span>
                                                            <hr>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="flex-s-b align-items-center m-2">
                                                                <div class="">
                                                                    <div>Date: <br> <b>25 FEB, 2024</b></div>

                                                                </div>
                                                                <div>
                                                                    <div>GST NO: <br> <b>2024-25/306/006</b></div>
                                                                </div>
                                                                <span>
                                                                    <span class="bold"><b>From</b></span><br>
                                                                    <span>Navix Consultancy Services</span><br>
                                                                    <span>Phone : <b>+918115006335</b></span><br>
                                                                    <span>Email-Id: <b>akashupadhyay00786@gmail.com</b></span><br>
                                                                    <span>A-199/A-Block Sector-63 Noida Uttar-Pradesh 110021</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 m-1">
                                                            <span>
                                                                <span class="bold"><b>Send To</b></span><br>
                                                                <span>Akash Upadhyay</span><br>
                                                                <span>Phone : <b>+918115006335</b></span><br>
                                                                <span>Email-Id: <b>akashupadhyay00786@gmail.com</b></span><br>
                                                                <span>GST No: <b> 20383/378/009 </b></span><br>
                                                                <span>A-199/A-Block Sector-63 Noida Uttar-Pradesh 110021</span>
                                                            </span>

                                                            <div class="flex-s-b align-item-center billing-app-sub-heading mt-4 m-1">

                                                                <span class="gray w-pr-20">Name</span>
                                                                <span class="gray w-pr-10">Category</span>
                                                                <span class="w-pr-12">Sale Price</span>
                                                                <span class="w-pr-13">MRP Price</span>
                                                                <span class="w-pr-10">GST</span>
                                                                <span class="w-pr-12 text-center">Total Without Tax</span>
                                                                <span class="w-pr-13 text-center">Total With Tax</span>
                                                                <span class="gray w-pr-10">Discount</span>
                                                                <span class="gray w-pr-5">Action</span>
                                                            </div>

                                                            <div class="data-list m-1">
                                                                <div class="flex-s-b align-item-center">
                                                                    <span class="gray w-pr-20">Apnalead Base Varient</span>
                                                                    <span class="gray w-pr-10">Software</span>
                                                                    <span class="w-pr-12">25000</span>
                                                                    <span class="w-pr-13">45000</span>
                                                                    <span class="w-pr-10">18%</span>
                                                                    <span class="w-pr-12 text-center">25000</span>
                                                                    <span class="w-pr-13 text-center">29000</span>
                                                                    <span class="w-pr-13 text-center">0</span>
                                                                    <span class=" w-pr-5"><span class="btn btn-xs btn-default"><i class="fa fa-plus text-success"></i></span></span>

                                                                </div>
                                                            </div>
                                                            <div class="data-list m-1">
                                                                <div class="flex-s-b align-item-center">
                                                                    <span class="gray w-pr-20">Apnalead Service</span>
                                                                    <span class="gray w-pr-10">Training</span>
                                                                    <span class="w-pr-12">5000</span>
                                                                    <span class="w-pr-13">5000</span>
                                                                    <span class="w-pr-10">18%</span>
                                                                    <span class="w-pr-12 text-center">5000</span>
                                                                    <span class="w-pr-13 text-center">7000</span>
                                                                    <span class="w-pr-13 text-center">0</span>
                                                                    <span class=" w-pr-5"><span class="btn btn-xs btn-default"><i class="fa fa-plus text-success"></i></span></span>
                                                                </div>
                                                            </div>
                                                            <div class="data-list m-1">
                                                                <div class="flex-s-b align-item-center">
                                                                    <span class="gray w-pr-20">Apnalead Subscription</span>
                                                                    <span class="gray w-pr-10">Maintanace</span>
                                                                    <span class="w-pr-12">500</span>
                                                                    <span class="w-pr-13">500</span>
                                                                    <span class="w-pr-10">18%</span>
                                                                    <span class="w-pr-12 text-center">500</span>
                                                                    <span class="w-pr-13 text-center">700</span>
                                                                    <span class="w-pr-13 text-center">0</span>
                                                                    <span class=" w-pr-5"><span class="btn btn-xs btn-default"><i class="fa fa-plus text-success"></i></span></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-3">
                                                            <div class="d-flex justify-content-end m-2">
                                                                <span>
                                                                    <span class="text-gray fs-15">Sub Total : <b>Rs.40000</b></span><br>
                                                                    <span class="text-gray fs-15">GST : <b> 18%</b></span><br>
                                                                    <span class="text-gray fs-15">Discount :<b> </b></span><br>
                                                                    <span class="text-gray fs-15"><b>Net Payable : Rs.48000</b></span><br>
                                                                    <span class="text-gray">Forty-eight thousand Only</span>
                                                                </span>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-8 ml-2"><span><b>Note:</b></span></div>
                                                        <div class="col-md-8 mt-3 flex-s-b ml-2">
                                                            <span>
                                                                <span>GST No </span><br>
                                                                <span>Pan </span><br>
                                                                <span>Mobile </span><br>
                                                                <span>Email-Id </span><br>
                                                                <span>Account Holder Name</span><br>
                                                                <span>Account Number </span><br>
                                                                <span>Bank Name </span><br>
                                                                <span>Branch Name </span><br>
                                                                <span>IFSC </span><br>
                                                                <span>Branch Address </span><br>
                                                            </span>
                                                            <span>
                                                                <span class="bold"> : 2024-25/300/006</span><br>
                                                                <span class="bold"> : AMEP8373UI</span><br>
                                                                <span class="bold"> : +918115006334</span><br>
                                                                <span class="bold"> : akashupadhyay00786@gmail.com</span><br>
                                                                <span class="bold"> : Akash Upadhyay</span><br>
                                                                <span class="bold"> : 21810100012599</span><br>
                                                                <span class="bold"> : Bank Of Baroda</span><br>
                                                                <span class="bold"> : Pipari</span><br>
                                                                <span class="bold"> : BARB0PIPARI</span><br>
                                                                <span class="bold"> : GROUND FLOOR TILKATH MARKET HANDIA PRAYAGRAJ</span><br>
                                                            </span>

                                                        </div>
                                                        <div class="col-md-12 text-center mt-4">
                                                            <button type="submit" class="btn btn-primary">Create Invoice</button>
                                                            <button class="btn btn-secondary">Save in Draft</button>
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

</body>

</html>