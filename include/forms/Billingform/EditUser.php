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
                <?php if (isset($_GET['customerid'])) {
                    $LeadsId = Secure($_GET['customerid'],"d"); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-lg-4 col-md-4 col-12">
                                    <input type="text" hidden value="<?php echo Secure($LeadsId, "e"); ?>" name="LeadsId">
                                    <label>User Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="LeadPersonFullName" value="<?php echo FETCH("SELECT LeadPersonFullName FROM leads where LeadsId='$LeadsId'", "LeadPersonFullName"); ?>" class="form-control" required="">
                                </div>
                                <div class="form-group col-lg-4 col-md-4 col-sm-4 col-6">
                                    <label> Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" name="LeadPersonPhoneNumber" placeholder="without +91" value="<?php echo FETCH("SELECT LeadPersonPhoneNumber FROM leads where LeadsId='$LeadsId'", "LeadPersonPhoneNumber"); ?>" class="form-control" required="">
                                </div>
                                <div class="form-group col-lg-4 col-md-4 col-sm-6 col-6">
                                    <label> Email Id <span class="text-danger">*</span></label>
                                    <input type="email" name="LeadPersonEmailId" value="<?php echo FETCH("SELECT LeadPersonEmailId FROM leads where LeadsId='$LeadsId'", "LeadPersonEmailId"); ?>" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-5px">
                                <div class="form-group col-md-12 col-lg-12 col-sm-12">
                                    <label for="notes">Person Notes (optional)</label>
                                    <textarea name="LeadPersonNotes" placeholder="Add some note" class="form-control" rows="3"><?php echo SECURE(FETCH("SELECT LeadPersonNotes FROM leads where LeadsId='$LeadsId'", "LeadPersonNotes"), "d"); ?></textarea>
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
                <?php } else {
                    NoData("Select user First");
                } ?>
            </form>
        </div>
    </div>
</section>