<section class="pop-section hidden" id="AddNewService">
    <div class="action-window billing-bg-color">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='billing-app-heading flex-s-b align-items-center'>Add New Service <span class="btn btn-danger" onclick="Databar('AddNewService')">X</span></h4>
                </div>
            </div>
            <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST" enctype="multipart/form-data">
                <?php
                FormPrimaryInputs(true); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                <label>Service Name <span class="test-danger">*</span></label>
                                <input type="text" name="ServiceName" class="form-control" placeholder="Service Name" required="">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-6">
                                <label> HSN Code <span class="test-danger">*</span></label>
                                <input type="text" name="ServiceHSNCode" placeholder="eg: HSN Code" class="form-control" required="">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-6">
                                <label> Provider <span class="test-danger">*</span></label>
                                <input type="text" name="ServiceProvider" placeholder="eg: Provider Name" class="form-control" required="">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-6">
                                <label> Category <span class="test-danger">*</span></label>
                                <input type="text" name="ServiceCategory" placeholder="eg: Maintenance,Consulting,Training" class="form-control" required="">
                            </div>
                        </div>
                        <div class="row mb-5px">
                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-6">
                                <label> Sale Price <span class="test-danger">*</span></label>
                                <input type="text" name="ServiceSalePrice" id="ServiceSalePrice" oninput="ServiceGSTPrice()" class="form-control" require>
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-6">
                                <label> Application GST % <span class="test-danger">*</span></label>
                                <select class="form-control" name="ServiceApplicableTaxes" id="ServiceGstValue" onchange="ServiceGSTPrice()" require>
                                    <?php InputOptions(["0", "5", "7", "10", "12", "15", "18", "20", "25", "28", "30"], "18"); ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-6">
                                <label> Net Price With GST</label>
                                <input type="text" name="ServiceNetPayable" id="ServiceNetprice" class="form-control" readonly="">
                            </div>
                        </div>

                        <div class="row mb-5px">
                            <div class="form-group col-md-12">
                                <label>Other Information</label>
                                <textarea name="ServiceDescription" class="form-control editor" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-10px mb-20px">
                    <div class="form-group col-lg-12 col-md-12 col-12 text-right">
                        <button class="btn btn-md btn-success" type="submit" name="SaveService"><i class="fa fa-check-circle"></i> Save Service</button>
                        <button class="btn btn-md btn-default" type="reset"><i class="fa fa-refresh"></i> Reset</button>
                        <button class="btn btn-md btn-default" onclick="Databar('AddNewService')"><i class="fa fa-refresh"></i> Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    function ServiceGSTPrice() {
        var GstValue = document.getElementById("ServiceGstValue");
        var Netprice = document.getElementById("ServiceNetprice");
        var ProductSalePrice = document.getElementById("ServiceSalePrice");
        if (GstValue.value == 0) {
            Netprice.value = ProductSalePrice.value;
        } else {
            Netprice.value = (+ProductSalePrice.value * (+GstValue.value / 100)) + +ProductSalePrice.value;
        }
    }
</script>