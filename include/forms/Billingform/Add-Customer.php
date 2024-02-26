<section class="pop-section hidden" id="AddNewCustomer">
    <div class="action-window billing-bg-color">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='billing-app-heading'>Add New Costomer</h4>
                </div>
            </div>
            <form class="row" action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST">
                <?php FormPrimaryInputs(true); ?>
                <div class='col-md-12'>
                    <h6 class='billing-app-sub-heading'>Customer Details</h6>
                </div>
                <div class='col-md-2 form-group'>
                    <label>Solutaion <?php echo $req; ?></label>
                    <select name="UserSolutation" id="" class="form-control">
                        <option value="">Choose Solutation</option>
                        <?php echo InputOptions(["Mr", "Mrs", "Miss", "Ms", "Dr", "Prof", "Sir"], "Mr") ?>
                    </select>
                </div>
                <div class='col-md-5 form-group'>
                    <label>Customer Name <?php echo $req; ?></label>
                    <input type="text" name="UserFullName" class="form-control form-control-sm" placeholder="Enter Name" required="">
                </div>

                <div class='col-md-5 form-group'>
                    <label>Customer Phone <?php echo $req; ?> <span id='phonemsg'></span></label>
                    <input type="tel" placeholder="without +91" oninput="CheckExistingPhoneNumbers()" id="PhoneNumber" name="UserPhoneNumber" class="form-control form-control-sm" required="">
                </div>
                <div class='col-md-7 form-group'>
                    <label>Customer Email-ID <span id='emailmsg'></span></label>
                    <input type="email" oninput="CheckExistingMailId()" id="EmailId" placeholder="Enter Email-ID" name="UserEmailId" class="form-control form-control-sm">
                </div>
                <div class='col-md-5 form-group'>
                    <label>Lead Status <?php echo $req; ?> </label>
                    <select name="LeadPersonStatus" id="" class="form-control" required="">
                        <option value="">Select Status</option>
                        <?php $CallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values WHERE configs.ConfigsId=config_values.ConfigValueGroupId AND configs.ConfigsId='7' AND config_values.CompanyID='" . CompanyId . "' ORDER BY ConfigValueId ASC", true);
                        if ($CallStatus != null) {
                            foreach ($CallStatus as $Status) {
                                $configValueDetails = $Status->ConfigValueDetails; ?>
                                <option value="<?php echo $configValueDetails; ?>" name="LeadFollowStatus" onclick="checkFollowUp(this)"><?php echo $configValueDetails; ?></option>
                        <?php  }
                        } else {
                            NoData("Add Call Status!!");
                        } ?>
                    </select>
                </div>
                <div class='col-md-12'>
                    <h6 class='billing-app-sub-heading'>Customer Billing Address Details</h6>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">

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
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <a href="#" onclick="Databar('AddNewCustomer')" class="btn btn-sm btn-default">Cancel</a>
                    <button type="submit" id="subbtn" name="SaveCustomerRecord" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Save Record</button>
                </div>
            </form>
        </div>
    </div>
</section>