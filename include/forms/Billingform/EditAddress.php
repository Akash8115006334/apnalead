<section class="pop-section hidden" id="EditAddress">
    <div class="action-window billing-bg-color">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h3 class='billing-app-heading flex-s-b align-items-center'>Edit Address <span class="btn btn-danger" onclick="Databar('EditAddress')">X</span></h3>
                </div>
            </div>
            <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST" enctype="multipart/form-data">
                <?php
                FormPrimaryInputs(true); ?>
                <?php if (isset($_GET['customerid'])) {
                    $LeadsId = Secure($_GET['customerid'], "d"); ?>
                    <input type="text" hidden value="<?php echo $_GET['customerid']; ?>" name="LeadsId">
                    <div class="row">
                        <div class="col-md-12">
                            <?php $CheckAddress = CHECK("SELECT CustomerLeadMainId FROM invoice_address WHERE CustomerLeadMainId='$LeadsId' and CompanyID='" . CompanyId . "'");
                            if ($CheckAddress) {
                                $Address = _DB_COMMAND_("SELECT * FROM invoice_address WHERE CustomerLeadMainId='$LeadsId' and CompanyID='" . CompanyId . "'", true);
                                foreach ($Address as $add) {
                                    $CustomerStreetAddress = $add->CustomerStreetAddress;
                                    $CustomerAreaLocality = $add->CustomerAreaLocality;
                                    $CustomerCity = $add->CustomerCity;
                                    $CustomerState = $add->CustomerState;
                                    $CustomerCountry = $add->CustomerCountry;
                                    $CustomerPincode = $add->CustomerPincode;
                                }
                            } else {
                                $CustomerStreetAddress = "";
                                $CustomerAreaLocality = "";
                                $CustomerCity = "";
                                $CustomerState = "";
                                $CustomerCountry = "";
                                $CustomerPincode = "";
                            } ?>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label>House No/Flat No/Villa No <?php echo $req; ?></label>
                                    <textarea name="CustomerStreetAddress" id="street" class="form-control form-control-sm" rows="2" required><?php echo $CustomerStreetAddress; ?></textarea>
                                </div>
                                <div class='col-md-7 form-group'>
                                    <label>Sector/Area Locality <?php echo $req; ?></label>
                                    <input type="text" name="CustomerAreaLocality" value=" <?php echo $CustomerAreaLocality; ?>" id="area" class="form-control form-control-sm" required="">
                                </div>
                                <div class='col-md-5 form-group'>
                                    <label>City <?php echo $req; ?></label>
                                    <input type="text" name="CustomerCity" value=" <?php echo $CustomerCity; ?>" id="city" class="form-control form-control-sm" required="">
                                </div>
                                <div class='col-md-4 form-group'>
                                    <label>State <?php echo $req; ?></label>
                                    <input type="text" name="CustomerState" value=" <?php echo $CustomerState; ?>" id="state" class="form-control form-control-sm" required="">
                                </div>
                                <div class='col-md-4 form-group'>
                                    <label>Country <?php echo $req; ?></label>
                                    <input type="text" name="CustomerCountry" value=" <?php echo $CustomerCountry; ?>" id="country" class="form-control form-control-sm" required="">
                                </div>
                                <div class='col-md-4 form-group'>
                                    <label>Pincode <?php echo $req; ?></label>
                                    <input type="text" name="CustomerPincode" value=" <?php echo $CustomerPincode; ?>" id="pincode" class="form-control form-control-sm" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-10px mb-20px">
                        <div class="form-group col-lg-12 col-md-12 col-12 text-right">
                            <button class="btn btn-md btn-success" type="submit" name="EditAddress"><i class="fa fa-check-circle"></i> Update Address</button>
                            <button onclick="Databar('EditAddress')" class="btn btn-md btn-default" type="reset"><i class="fa fa-refresh"></i> Cancel</button>
                        </div>
                    </div>
                <?php } else {
                    NoData("Select user First");
                } ?>
            </form>
        </div>
    </div>
</section>