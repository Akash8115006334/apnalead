<section class="pop-section hidden" id="AddNewProduct">
    <div class="action-window billing-bg-color">
        <div class='container '>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='billing-app-heading flex-s-b align-items-center'>Add New Product <span class="btn btn-danger" onclick="Databar('AddNewProduct')">X</span></h4>
                </div>
            </div>
            <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST" enctype="multipart/form-data">
                <?php
                FormPrimaryInputs(true); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label>Product Name</label>
                                <input type="text" name="ProductName" class="form-control" required="">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-6">
                                <label> Manufacturer/Brand</label>
                                <input type="text" name="ProductBrandName" list="ProductBrandName" class="form-control" required="">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-6 col-6">
                                <label> Modal No</label>
                                <input type="modalno" name="ProductModalNo" class="form-control" required="">
                            </div>
                        </div>
                        <div class="row mb-5px">
                            <div class="form-group col-lg-4 col-md-4 col-sm-6 col-6">
                                <label> Type</label>
                                <input type="text" name="ProductType" list="ProductType" class="form-control" required="">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-6">
                                <label>Speciality</label>
                                <input type="text" name="ProductCapacity" class="form-control">
                            </div>
                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-6">
                                <label> Life (In Years)</label>
                                <input type="number" name="ProductLife" class="form-control">
                            </div>
                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-6">
                                <label> Warranty in Months</label>
                                <input type="number" name="ProductWarrantyinMonths" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-5px">
                            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-6">
                                <label> Sale Price</label>
                                <input type="text" name="ProductSalePrice" id="ProductSalePrice" oninput="CalculateGSTPrice()" class="form-control" required="">
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-6">
                                <label> MRP</label>
                                <input type="text" name="ProductMrp" id="mrp" class="form-control">
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-6">
                                <label> Application GST %</label>
                                <select class="form-control" name="ProductApplicableTaxes" id="GstValue" onchange="CalculateGSTPrice()" required="">
                                    <?php InputOptions(["0", "5", "7", "10", "12", "15", "18", "20", "25", "28", "30"], "18"); ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-6">
                                <label> Net Price With GST</label>
                                <input type="text" name="ProductNetPayable" id="Netprice" class="form-control" readonly="">
                            </div>
                        </div>
                        <div class="row mb-5px">
                            <div class="form-group col-md-12">
                                <label>Other Information</label>
                                <textarea name="ProductDescription" class="form-control editor" rows="5"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row mb-10px mb-20px">
                    <div class="form-group col-lg-12 col-md-12 col-12 text-right">
                        <button class="btn btn-md btn-success" type="submit" name="SaveProducts"><i class="fa fa-check-circle"></i> Save Products</button>
                        <button class="btn btn-md btn-default" type="reset"><i class="fa fa-refresh"></i> Reset</button>
                        <button class="btn btn-md btn-default" onclick="Databar('AddNewProduct')"><i class="fa fa-refresh"></i> Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    function CalculateGSTPrice() {
        var GstValue = document.getElementById("GstValue");
        var Netprice = document.getElementById("Netprice");
        var ProductSalePrice = document.getElementById("ProductSalePrice");
        var mrp = document.getElementById("mrp");

        if (GstValue.value == 0) {
            Netprice.value = ProductSalePrice.value;
            mrp.value = +ProductSalePrice.value + 2599;
        } else {
            Netprice.value = (+ProductSalePrice.value * (+GstValue.value / 100)) + +ProductSalePrice.value;
            mrp.value = +ProductSalePrice.value + 2599;
        }
    }
</script>