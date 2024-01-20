 <div class='row'>
     <div class="col-md-12">
         <h6 class="app-sub-heading">Primary Info</h6>
     </div>
     <div class="col-md-12">
         <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST" enctype="multipart/form-data">
             <?php FormPrimaryInputs(true, [
                    "UserId" => $REQ_UserId
                ]); ?>
             <div class="row">
                 <div class="col-md-12">
                     <div class="row">
                         <div class="form-group col-lg-1 col-md-2 col-sm-6 col-12">
                             <label>Sal *</label>
                             <select class="form-control form-control-sm " name="UserSalutation" required="">
                                 <?php InputOptions(
                                        [
                                            "Mr." => "Mr.",
                                            "Mrs." => "Mrs.",
                                            "Miss." => "Miss.",
                                            "M/s" => "M/s",
                                            "Dr." => "Dr.",
                                            "Prof." => "Prof."
                                        ],
                                        FETCH($PageSqls, "UserSalutation")
                                    ); ?>
                             </select>
                         </div>
                         <div class="form-group col-lg-3 col-md-3 col-sm-6 col-12">
                             <label>User Full Name *</label>
                             <input type="text" name="UserFullName" value="<?php echo FETCH($PageSqls, "UserFullName"); ?>" class="form-control form-control-sm " required="" placeholder="Full Name">
                         </div>
                         <div class="form-group col-lg-3 col-md-4 col-sm-6 col-12">
                             <label>Primary Contact Number *</label>
                             <input type="phone" name="UserPhoneNumber" value="<?php echo FETCH($PageSqls, "UserPhoneNumber"); ?>" class="form-control form-control-sm " value="+91" placeholder="+91">
                         </div>
                         <div class="form-group col-lg-5 col-md-4 col-sm-6 col-12">
                             <label>Primary Contact Email-ID *</label>
                             <input type="email" name="UserEmailId" value="<?php echo FETCH($PageSqls, "UserEmailId"); ?>" class="form-control form-control-sm " required="">
                         </div>
                     </div>
                     <div class="row mb-10px">
                         <div class="form-group col-lg-12 col-lg-12 col-sm-12">
                             <label>Notes/Remarks</label>
                             <textarea class="form-control form-control-sm " rows="3" name="UserNotes"><?php echo SECURE(FETCH($PageSqls, "UserNotes"), "d"); ?></textarea>
                         </div>
                     </div>
                     <div class="row">
                         <div class="form-group col-lg-4 col-md-4 col-sm-12">
                             <label>User Status</label>
                             <select class="form-control form-control-sm " name="UserStatus">
                                 <?php
                                    if (FETCH($PageSqls, "UserStatus") == 1) { ?>
                                     <option value="1" selected>Active</option>
                                     <option value="0">Inactive</option>
                                 <?php } else { ?>
                                     <option value="1">Active</option>
                                     <option value="0" selected>Inactive</option>
                                 <?php } ?>
                             </select>
                         </div>
                         <div class="form-group col-lg-4 col-md-4 col-sm-12">
                             <label>User Type</label>
                             <select class="form-control form-control-sm " name="UserType">
                                 <?php
                                    $data = USER_ROLES;
                                    InputOptions($data, FETCH($PageSqls, "UserType")); ?>
                             </select>

                         </div>
                         <div class="form-group col-lg-4 col-md-4 col-sm-12">
                             <label>Date of Birth</label>
                             <input type="date" name="UserDateOfBirth" class="form-control form-control-sm " value="<?php echo FETCH($PageSqls, "UserDateOfBirth"); ?>">
                         </div>

                         <div class="col-md-12">
                             <button type="submit" name="UpdatePrimaryData" class="btn btn-md btn-success"><i class="fa fa-check-circle"></i> Update Details</button>
                         </div>
                     </div>
                 </div>
             </div>
         </form>
     </div>
     <hr>
 </div>

 <!-- UserEmp Deatils  -->
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
                 <div class="col-md-4 form-group">
                     <label>Current Empl ID</label>
                     <input type="text" class="form-control form-control-sm " value="<?php echo FETCH($EmpSql, "UserEmpJoinedId"); ?>" name="UserEmpJoinedId">
                 </div>
                 <div class="col-md-4 form-group">
                     <label>Background</label>
                     <input type="text" class="form-control form-control-sm " value="<?php echo FETCH($EmpSql, "UserEmpBackGround"); ?>" name="UserEmpBackGround">
                 </div>
                 <div class="col-md-4 form-group">
                     <label>Total Work Experience (in Years)</label>
                     <input type="text" class="form-control form-control-sm " value="<?php echo FETCH($EmpSql, "UserEmpTotalWorkExperience"); ?>" name="UserEmpTotalWorkExperience">
                 </div>
                 <div class="col-md-4 form-group">
                     <label>Previous Organisation</label>
                     <input type="text" class="form-control form-control-sm " value="<?php echo FETCH($EmpSql, "UserEmpPreviousOrg"); ?>" name="UserEmpPreviousOrg">
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
                 <div class="form-group col-md-4">

                     <label> User Project Type </label>

                     <select name="Project_Name" class="form-control form-control-sm">
                         <option value="">Select Projects Type</option>

                         <?php
                            $companyID = CompanyId;
                            $FetchProjectName = _DB_COMMAND_("SELECT * FROM projects where CompanyID='$companyID'", true);
                            $GetProjectId = FETCH("SELECT * FROM user_project_type where User_main_Id='" . FETCH($PageSqls, "UserId") . "'", "User_project_main_Id");
                            echo  $GetProjectId;
                            if ($FetchProjectName != null) {
                                foreach ($FetchProjectName as $Project) {
                                    if ($Project->ProjectsId == $GetProjectId) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                            ?>
                                 <option <?php echo $selected; ?> value="<?php echo $Project->ProjectsId; ?>"><?php echo $Project->ProjectName; ?></option>
                         <?php
                                }
                            } ?>
                     </select>
                 </div>
                 <div class="col-md-4 form-group">
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