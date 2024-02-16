<section class="pop-section hidden" id="ServiceUpdate_<?php echo $item->ItemId; ?>">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading flex-s-b align-items-center'>Update Service <span class="btn btn-danger" onclick="Databar('ServiceUpdate_<?php echo $item->ItemId; ?>')">X</span></h4>
                </div>
            </div>
            <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST" enctype="multipart/form-data">
                <?php
                FormPrimaryInputs(true); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <input type="text" value="<?php echo $item->ItemId; ?>" hidden name="itemId">
                            <div class="form-group col-lg-7 col-md-7 col-sm-7 col-12">
                                <label>Service Name <span class="test-danger">*</span></label>
                                <input type="text" name="ServiceName" value="<?php echo $item->Item_Name; ?>" class="form-control" required="">
                            </div>
                            <div class="form-group col-lg-5 col-md-5 col-sm-5 col-6">
                                <label> Tax HSN Number <span class="test-danger">*</span></label>
                                <input type="text" name="HSN_Number" value="<?php echo $item->HSN_Number; ?>" class="form-control" required="">
                            </div>
                        </div>
                        <div class="row mb-5px">
                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-6">
                                <label> Sale Price <span class="test-danger">*</span></label>
                                <input type="text" name="ServiceSalePrice" value="<?php echo $item->ItemSalePrice; ?>" id="ServiceSalePrice_<?php echo $item->ItemId; ?>" oninput="ServiceGSTPrice_<?php echo $item->ItemId; ?>()" class="form-control">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-6">
                                <label> Application GST % <span class="test-danger">*</span></label>
                                <select class="form-control" name="ServiceApplicableTaxes" id="ServiceGstValue_<?php echo $item->ItemId; ?>" onchange="ServiceGSTPrice_<?php echo $item->ItemId; ?>()">
                                    <?php InputOptions(["0", "5", "7", "10", "12", "15", "18", "20", "25", "28", "30"], $item->ItemSaleGST); ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-6">
                                <label> Net Price With GST</label>
                                <input type="text" name="ServiceNetPayable" id="ServiceNetprice_<?php echo $item->ItemId; ?>" value="<?php echo $item->ItemNetPrice; ?>" class="form-control" readonly="">
                            </div>
                        </div>
                        <div class="row mb-5px">
                            <div class="form-group col-md-12">
                                <label>Other Information</label>
                                <textarea name="ServiceDescription" class="form-control editor" rows="5"><?php echo $item->Description; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-10px mb-20px">
                    <div class="form-group col-lg-12 col-md-12 col-12 text-right">
                        <button class="btn btn-md btn-success" type="submit" name="UpdateService"><i class="fa fa-check-circle"></i> Update Service</button>
                        <button class="btn btn-md btn-default" onclick="Databar('ServiceUpdate_<?php echo $item->ItemId; ?>')" type="reset"><i class="fa fa-refresh"></i> Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    function ServiceGSTPrice_<?php echo $item->ItemId; ?>() {
        var GstValue_<?php echo $item->ItemId; ?> = document.getElementById("ServiceGstValue_<?php echo $item->ItemId; ?>");
        var Netprice_<?php echo $item->ItemId; ?> = document.getElementById("ServiceNetprice_<?php echo $item->ItemId; ?>");
        var ProductSalePrice_<?php echo $item->ItemId; ?> = document.getElementById("ServiceSalePrice_<?php echo $item->ItemId; ?>");
        if (GstValue_<?php echo $item->ItemId; ?>.value == 0) {
            Netprice_<?php echo $item->ItemId; ?>.value = ProductSalePrice_<?php echo $item->ItemId; ?>.value;
        } else {
            Netprice_<?php echo $item->ItemId; ?>.value = (+ProductSalePrice_<?php echo $item->ItemId; ?>.value * (+GstValue_<?php echo $item->ItemId; ?>.value / 100)) + +ProductSalePrice_<?php echo $item->ItemId; ?>.value;
        }
    }
</script>