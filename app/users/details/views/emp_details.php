<div class="row">
    <div class="col-md-12">
        <h6 class="app-sub-heading">Employement Details</h6>
    </div>

    <div class="col-md-12">
        <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST" class="mt-3">
            <?php FormPrimaryInputs(true, [
                "UserId" => $REQ_UserId
            ]); ?>
            <div class="row">
                <!-- <div class="col-md-3 form-group">
                    <label>Current Empl ID</label>
                    <input type="text" class="form-control form-control-sm " value="<?php //echo FETCH($EmpSql, "UserEmpJoinedId"); 
                                                                                    ?>" name="UserEmpJoinedId">
                </div> -->
                <div class="col-md-4 form-group">
                    <label>Background</label>
                    <input type="text" class="form-control form-control-sm " value="<?php echo FETCH($EmpSql, "UserEmpBackGround"); ?>" name="UserEmpBackGround">
                </div>
                <div class="col-md-5 form-group">
                    <label>Total Work Experience (in Years)</label>
                    <input type="text" class="form-control form-control-sm " value="<?php echo FETCH($EmpSql, "UserEmpTotalWorkExperience"); ?>" name="UserEmpTotalWorkExperience">
                </div>
                <div class="col-md-4 form-group">
                    <label>Previous Organisation</label>
                    <input type="text" class="form-control form-control-sm " value="<?php echo FETCH($EmpSql, "UserEmpPreviousOrg"); ?>" name="UserEmpPreviousOrg">
                </div>
                <div class="col-md-4 form-group">
                    <label>Blood Groups</label>
                    <input type="text" class="form-control form-control-sm " value="<?php echo FETCH($EmpSql, "UserEmpBloodGroup"); ?>" name="UserEmpBloodGroup">
                </div>
                <div class="col-md-4 form-group">
                    <label>Rera ID (If Have)</label>
                    <input type="text" class="form-control form-control-sm " value="<?php echo FETCH($EmpSql, "UserEmpReraId"); ?>" name="UserEmpReraId">
                </div>
                <div class="form-group col-md-4">
                    <label>Reporting Manager</label>
                    <select class="form-control form-control-sm " name="UserEmpReportingMember">
                        <option value="0">Select Manager</option>
                        <?php
                        $UserID = AuthAppUser("UserId");
                        $companyId = FETCH("SELECT * FROM company_users where company_alloted_user_id='$UserID'", "company_main_id");
                        $Users = _DB_COMMAND_("SELECT * FROM users, company_users where users.UserId=company_users.company_alloted_user_id and company_users.company_main_id='$companyId' ORDER BY users.UserFullName ASC", true);
                        foreach ($Users as $User) {
                            if ($User->UserId == FETCH($EmpSql, "UserEmpReportingMember")) {
                                $selected = "selected";
                            } else {
                                $selected = "";
                            }
                            echo "<option value='" . $User->UserId . "' $selected>" . $User->UserFullName . " @ " . $User->UserPhoneNumber . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label>CRM Status</label>
                    <select class="form-control form-control-sm " name="UserEmpCRMStatus">
                        <?php InputOptions(["Yes" => "Yes", "No" => "No"], FETCH($EmpSql, "UserEmpCRMStatus")); ?>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label>Visiting Card</label>
                    <select class="form-control form-control-sm " name="UserEmpVisitingCard">
                        <?php InputOptions(["Yes" => "Yes", "No" => "No"], FETCH($EmpSql, "UserEmpVisitingCard")); ?>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label>Employee Group </label>
                    <select class="form-control form-control-sm " name="UserEmpGroupName">
                        <?php CONFIG_VALUES("WORK_GROUP", FETCH($EmpSql, "UserEmpGroupName")); ?>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label>Employement Type</label>
                    <select class="form-control form-control-sm " name="UserEmpType">
                        <?php InputOptions(["RA Direct" => "RA DIRECT", "Business Modal" => "Business Modal"], FETCH($EmpSql, "UserEmpType")); ?>
                    </select>
                </div>

                <div class="col-md-4 form-group">
                    <label>(OnRole/OffRole) Status</label>
                    <select class="form-control form-control-sm " name="UserEmpRoleStatus">
                        <?php InputOptions(["On Role" => "On Role", "Off Role" => "Off Role"], FETCH($EmpSql, "UserEmpRoleStatus")); ?>
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label>Work Email-ID</label>
                    <input type="text" class="form-control form-control-sm " value="<?php echo FETCH($EmpSql, "UserEmpWorkEmailId"); ?>" name="UserEmpWorkEmailId">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" name="UpdateEmployement" class="btn btn-md btn-success"><i class="fa fa-check-circle"></i> Update Details</button>
                </div>
            </div>
        </form>
    </div>
</div>