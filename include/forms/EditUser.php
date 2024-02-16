<section class="pop-section hidden" id="EditUser">
    <div class="action-window billing-bg-color">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h3 class='billing-app-heading flex-s-b align-items-center'>Edit User <span class="btn btn-danger" onclick="Databar('EditUser')">X</span></h3>
                </div>
            </div>
            <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST" enctype="multipart/form-data">
                <?php
                FormPrimaryInputs(true); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <input type="text" hidden value="<?php echo $LeadsId; ?>" name="itemId">
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
                    </div>

                </div>
                <div class="row mb-10px mb-20px">
                    <div class="form-group col-lg-12 col-md-12 col-12 text-right">
                        <button class="btn btn-md btn-success" type="submit" name="EditUser"><i class="fa fa-check-circle"></i> Update User</button>
                        <button onclick="Databar('EditUser')" class="btn btn-md btn-default" type="reset"><i class="fa fa-refresh"></i> Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>