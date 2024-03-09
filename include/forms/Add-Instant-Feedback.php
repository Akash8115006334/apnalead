<section class="pop-section hidden" id="Lead_Update_<?php echo $LeadsId; ?>">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Add Feedback </h4>
                </div>
            </div>
            <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST">
                <?php FormPrimaryInputs(true, [
                    "LeadFollowMainId" => $LeadsId
                ]);
                $PageSqls = "SELECT * FROM leads where LeadsId='$LeadsId'"; ?>
                <input type="text" hidden id="leascurrentstatus_<?php echo $LeadsId; ?>" name="LeadFollowCurrentStatus" value="">
                <input type="text" hidden id='displayTime_<?php echo $LeadsId; ?>' name="StartTime" value=''>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <p><b>Was Call Connected?</b></p>
                            </div>
                            <div class="form-group col-md-6 mt-2">
                                <span id="call_not_connected_<?php echo $LeadsId; ?>" class="btn btn-default w-100">Not Connected?</span>
                            </div>
                            <div class="form-group col-md-6 mt-2">
                                <span id="call_connected_<?php echo $LeadsId; ?>" class="btn btn-default w-100">Yes, Connected?</span>
                            </div>
                        </div>
                        <div class="row w-100 text-left hidden" id="call_not_connected_box_<?php echo $LeadsId; ?>">
                            <div class="col-md-12">
                                <hr>
                                <p><b>Please specify the reason?</b></p>
                                <hr>
                            </div>
                            <div class="col-md-6 ml-3">
                                <label class="btn btn-default"><input required type="Radio" value="Out Of Coverage Area" name="LeadFollowStatus"> Out Of Coverage Area</label><br>
                                <label class="btn btn-default"><input required type="Radio" value="Switch Off" name="LeadFollowStatus"> Switch Off </label><br>
                                <label class="btn btn-default"><input required type="Radio" value="Number Dose not Exist" name="LeadFollowStatus"> Number Does not Exist </label><br>
                                <label class="btn btn-default"><input required type="Radio" value="Out of Validity" name="LeadFollowStatus"> Out of Validity </label><br>
                                <label class="btn btn-default"><input required type="Radio" value="Not Picked" name="LeadFollowStatus"> Not Picked</label><br>
                            </div>
                        </div>
                        <div class="row w-100 text-left hidden" id="call_connected_box_<?php echo $LeadsId; ?>">
                            <div class="col-md-12">
                                <hr>
                                <p><b>Please specify the reason?</b></p>
                                <hr>
                            </div>
                            <div class="col-md-5 ml-3">
                                <!-- <small>Your Added Status</small> -->
                                <?php
                                $UserID = AuthAppUser("UserId");
                                $companyID = FETCH("SELECT * FROM company_users WHERE company_alloted_user_id='$UserID'", "company_main_id");
                                $Industry = _DB_COMMAND_("SELECT * FROM configs, config_values WHERE configs.ConfigsId=config_values.ConfigValueGroupId AND configs.ConfigsId='7' AND config_values.CompanyID='$companyID' ORDER BY ConfigValueId ASC", true);

                                if ($Industry != null) {
                                    foreach ($Industry as $Industry_Name) {
                                        echo '<label class="btn btn-default"><input type="radio" required value="' . $Industry_Name->ConfigValueDetails . '" name="LeadFollowStatus" onclick="checkFollowUp_' . $LeadsId . '(this)"> ' . $Industry_Name->ConfigValueDetails . '</label><br>';
                                    }
                                } else {
                                    NoData("Add more Call Status!!");
                                }
                                ?>
                            </div>

                            <div class="col-md-12 m-2">
                                <span onclick="Databar('reminder_<?php echo $LeadsId; ?>')" id="mycheckbtnspan_<?php echo $LeadsId; ?>" class="btn btn-info hidden">
                                    <input id="set_reminder_<?php echo $LeadsId; ?>" name="mycheckbtn" type="checkbox" style="display: none;">Set Reminder
                                </span>
                                <div class="w-100 p-1 hidden mt-3" id="reminder_<?php echo $LeadsId; ?>">
                                    <label class="btn btn-default m-1">
                                        <input type="radio" name="predefinetime" value="15min">
                                        <span>15 min</span>
                                    </label>
                                    <label class=" btn btn-default m-1">
                                        <input type="radio" name="predefinetime" value="Tomorrow">
                                        <span>Tomorrow</span>
                                    </label>
                                    <label class="btn btn-default m-1">
                                        <input type="radio" name="predefinetime" value="NextWeek">
                                        <span>Next Week</span>
                                    </label>
                                    <span class="btn btn-default ml-1" id="Show_Time_Box_<?php echo $LeadsId; ?>">Other</span>
                                    <label class="m-1 hidden" id="Time_Box_<?php echo $LeadsId; ?>">
                                        <span class="d-flex feedbackspan">
                                            <input type="date" name="LeadFollowUpDate" class="form-control form-control-sm" value="<?php echo date("Y-m-d"); ?>">
                                            <input type="time" name="LeadFollowUpTime" value="<?php echo DATE("H:i", strtotime("+5 min")); ?>" class="form-control form-control-sm"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 m-2">
                                <div class="form-group">
                                    <label>Lead Priority level </label>
                                    <select class="form-control form-control-sm" name="LeadPriorityLevel">
                                        <?php CONFIG_VALUES("LEAD_PERIORITY_LEVEL", FETCH($PageSqls, "LeadPriorityLevel")); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <style>

                        </style>
                        <div class="row ">

                            <div class="col-md-12 mt-3">
                                <div id="calldesc">
                                    <input type="text" name="currentURL" hidden id="urlInput" class="w-100 custom-input " placeholder="Current URL" value="<?php echo $CurrentUrl; ?>" readonly>
                                    <div class="form-group text-left">
                                        <label>Notes/Remark</label>
                                        <textarea class="form-control" name="LeadFollowUpDescriptions" rows="2" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">


                        <button type="submit" name="AddLeadStatus" class="btn btn-md btn-success">Add Status</button>
                        <a href="#" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')" class="btn btn-md btn-default mt-3">cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    function CallStatusFunction_<?php echo $LeadsId; ?>() {
        var statustype_<?php echo $LeadsId; ?> = document.getElementById("statustype_<?php echo $LeadsId; ?>");
        <?php
        $FetchCallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS' ORDER BY ConfigValueId DESC", true);
        if ($FetchCallStatus != null) {
            foreach ($FetchCallStatus as $CallStatus) { ?>
                if (statustype_<?php echo $LeadsId; ?>.value == <?php echo $CallStatus->ConfigValueId; ?>) {
                    document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>_<?php echo $LeadsId; ?>").style.display = "block";
                } else {
                    document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>_<?php echo $LeadsId; ?>").style.display = "none";
                }
                if (statustype_<?php echo $LeadsId; ?>.value == "50") {
                    document.getElementById("call_schedule_<?php echo $LeadsId; ?>").style.display = "block";
                    document.getElementById("calldesc_<?php echo $LeadsId; ?>").style.display = "none";
                    document.getElementById("remindnote_<?php echo $LeadsId; ?>").setAttribute("required", true);
                } else {
                    document.getElementById("call_schedule_<?php echo $LeadsId; ?>").style.display = "none";
                    document.getElementById("calldesc_<?php echo $LeadsId; ?>").style.display = "block";
                    document.getElementById("remindnote_<?php echo $LeadsId; ?>").removeAttribute("required");
                }
        <?php }
        } ?>
    }
    // call connected or not
    var Notconnected_<?php echo $LeadsId; ?> = document.getElementById("call_not_connected_<?php echo $LeadsId; ?>");
    var Connected_<?php echo $LeadsId; ?> = document.getElementById("call_connected_<?php echo $LeadsId; ?>");
    var NotconnectedBox_<?php echo $LeadsId; ?> = document.getElementById("call_not_connected_box_<?php echo $LeadsId; ?>");
    var ConnectedBox_<?php echo $LeadsId; ?> = document.getElementById("call_connected_box_<?php echo $LeadsId; ?>");
    var Reminder_<?php echo $LeadsId; ?> = document.getElementById("set_reminder_<?php echo $LeadsId; ?>");
    var ReminderSpan_<?php echo $LeadsId; ?> = document.getElementById("mycheckbtnspan_<?php echo $LeadsId; ?>");

    // console.log(ConnectedBox);
    Notconnected_<?php echo $LeadsId; ?>.addEventListener("click", function() {
        NotconnectedBox_<?php echo $LeadsId; ?>.classList.remove("hidden");
        Notconnected_<?php echo $LeadsId; ?>.classList.remove("btn-default");
        Connected_<?php echo $LeadsId; ?>.classList.remove("btn-primary");
        Notconnected_<?php echo $LeadsId; ?>.classList.add("btn-primary");
        ConnectedBox_<?php echo $LeadsId; ?>.classList.add("hidden");
        Connected_<?php echo $LeadsId; ?>.classList.add("btn-default");
    });

    Connected_<?php echo $LeadsId; ?>.addEventListener("click", function() {
        // Remove the "hidden" class from ConnectedBox
        ConnectedBox_<?php echo $LeadsId; ?>.classList.remove("hidden");
        Connected_<?php echo $LeadsId; ?>.classList.remove("btn-default");
        Notconnected_<?php echo $LeadsId; ?>.classList.remove("btn-primary");
        Connected_<?php echo $LeadsId; ?>.classList.add("btn-primary");
        NotconnectedBox_<?php echo $LeadsId; ?>.classList.add("hidden");
        Notconnected_<?php echo $LeadsId; ?>.classList.add("btn-default");
    });

    function checkFollowUp_<?php echo $LeadsId; ?>(radio) {
        if (radio.value.toUpperCase() === "FOLLOW-UP" || radio.value.toUpperCase() === "FOLLOW UP" || radio.value.toUpperCase() === "MEETING PLAN" || radio.value.toUpperCase() === "MEETING PLANNED" || radio.value.toUpperCase() === "SITE VISIT PLANNED") {
            ReminderSpan_<?php echo $LeadsId; ?>.classList.remove("hidden");
        } else {
            ReminderSpan_<?php echo $LeadsId; ?>.classList.add("hidden");
        }
    }

    ReminderSpan_<?php echo $LeadsId; ?>.addEventListener("click", function() {
        Reminder_<?php echo $LeadsId; ?>.checked = !Reminder_<?php echo $LeadsId; ?>.checked;
    });
    var ShowTimeBox_<?php echo $LeadsId; ?> = document.getElementById("Show_Time_Box_<?php echo $LeadsId; ?>");
    var TimeBox_<?php echo $LeadsId; ?> = document.getElementById("Time_Box_<?php echo $LeadsId; ?>");
    var radioButtons_<?php echo $LeadsId; ?> = document.getElementsByName("predefinetime_<?php echo $LeadsId; ?>");
    ShowTimeBox_<?php echo $LeadsId; ?>.addEventListener("click", function() {
        TimeBox_<?php echo $LeadsId; ?>.classList.toggle("hidden");
        if (!TimeBox_<?php echo $LeadsId; ?>.classList.contains("hidden")) {
            // If "Other" is clicked, uncheck all radio buttons
            radioButtons_<?php echo $LeadsId; ?>.forEach(function(radioButton) {
                radioButton.checked = false;
            });
        }

    });
</script>