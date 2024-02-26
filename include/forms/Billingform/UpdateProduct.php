<section class="pop-section hidden" id="ProductUpdate_<?php echo $item->ItemId; ?>">
    <div class="action-window billing-bg-color">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='billing-app-heading flex-s-b align-items-center'>Update Product <span class="btn btn-danger" onclick="Databar('ProductUpdate_<?php echo $item->ItemId; ?>')">X</span></h4>
                </div>
            </div>
            <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST" enctype="multipart/form-data">
                <?php
                FormPrimaryInputs(true); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <input type="text" hidden value="<?php echo $item->ItemId; ?>" name="itemId">
                                <label>Product Name</label>
                                <input type="text" name="ProductName" value="<?php echo $item->Item_Name; ?>" class="form-control" required="">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-6">
                                <label> Manufacturer/Brand</label>
                                <input type="text" name="ProductBrandName" value="<?php echo $item->Manufracturer; ?>" list="ProductBrandName" class="form-control">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-6 col-6">
                                <label> Modal No</label>
                                <input type="modalno" name="ProductModalNo" value="<?php echo $item->ModalNo; ?>" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-5px">
                            <div class="form-group col-lg-4 col-md-4 col-sm-6 col-6">
                                <label> Type</label>
                                <input type="text" name="ProductType" value="<?php echo $item->ItemType; ?>" list="ProductType" class="form-control">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-6">
                                <label>Speciality</label>
                                <input type="text" value="<?php echo $item->Speciality; ?>" name="ProductCapacity" class="form-control">
                            </div>
                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-6">
                                <label> Life (In Years)</label>
                                <input type="number" value="<?php echo $item->ItemLife; ?>" name="ProductLife" class="form-control">
                            </div>
                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-6">
                                <label> Warranty in Months</label>
                                <input type="number" value="<?php echo $item->ItemWarranty; ?>" name="ProductWarrantyinMonths" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-5px">
                            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-6">
                                <label> Sale Price</label>
                                <input type="text" name="ProductSalePrice" value="<?php echo $item->ItemSalePrice; ?>" id="ProductSalePrice_<?php echo $item->ItemId; ?>" oninput="CalculateGSTPrice()" class="form-control">
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-6">
                                <label> MRP</label>
                                <input type="text" name="ProductMrp" value="<?php echo $item->ItemMRP; ?>" id="mrp_<?php echo $item->ItemId; ?>" class="form-control">
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-6">
                                <label> Application GST %</label>
                                <select class="form-control" name="ProductApplicableTaxes" id="GstValue_<?php echo $item->ItemId; ?>" onchange="CalculateGSTPrice_<?php echo $item->ItemId; ?>()">
                                    <?php InputOptions(["0", "5", "7", "10", "12", "15", "18", "20", "25", "28", "30"],  $item->ItemSaleGST); ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-6">
                                <label> Net Price With GST</label>
                                <input type="text" name="ProductNetPayable" id="Netprice_<?php echo $item->ItemId; ?>" value="<?php echo $item->ItemNetPrice; ?>" class="form-control" readonly="">
                            </div>
                        </div>
                        <div class="row mb-5px">
                            <div class="form-group col-md-12">
                                <label>Other Information</label>
                                <textarea name="ProductDescription" class="form-control editor" rows="5"><?php echo $item->Description; ?></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row mb-10px mb-20px">
                    <div class="form-group col-lg-12 col-md-12 col-12 text-right">
                        <button class="btn btn-md btn-success" type="submit" name="UpdateProduct"><i class="fa fa-check-circle"></i> Update Products</button>
                        <button onclick="Databar('ProductUpdate_<?php echo $item->ItemId; ?>')" class="btn btn-md btn-default" type="reset"><i class="fa fa-refresh"></i> Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    function CalculateGSTPrice_<?php echo $item->ItemId; ?>() {
        var GstValue_<?php echo $item->ItemId; ?> = document.getElementById("GstValue_<?php echo $item->ItemId; ?>");
        var Netprice_<?php echo $item->ItemId; ?> = document.getElementById("Netprice_<?php echo $item->ItemId; ?>");
        var ProductSalePrice_<?php echo $item->ItemId; ?> = document.getElementById("ProductSalePrice_<?php echo $item->ItemId; ?>");
        var mrp = document.getElementById("mrp_<?php echo $item->ItemId; ?>");

        if (GstValue_<?php echo $item->ItemId; ?>.value == 0) {
            Netprice_<?php echo $item->ItemId; ?>.value = ProductSalePrice_<?php echo $item->ItemId; ?>.value;
            mrp.value = +ProductSalePrice.value + 2599;
        } else {
            Netprice_<?php echo $item->ItemId; ?>.value = (+ProductSalePrice_<?php echo $item->ItemId; ?>.value * (+GstValue_<?php echo $item->ItemId; ?>.value / 100)) + +ProductSalePrice_<?php echo $item->ItemId; ?>.value;
            mrp_<?php echo $item->ItemId; ?>.value = +ProductSalePrice_<?php echo $item->ItemId; ?>.value + 2599;
        }
    }
</script>