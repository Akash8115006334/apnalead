<section class="pop-section <?php echo $hidden; ?>" id="AddFollowUps">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Add Feedback</h4>
        </div>
      </div>
      <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST">
        <?php FormPrimaryInputs(true, [
          "LeadFollowMainId" => $REQ_LeadsId
        ]) ?>
        <input type="text" hidden id="leascurrentstatus" name="LeadFollowCurrentStatus" value="">
        <div class="row">
          <div class="col-md-12">
            <div class="row text-center">
              <div class="col-md-12 text-center">
                <p><b>Was Call Connected?</b></p>
              </div>
              <div class="form-group col-md-6 mt-2">
                <span id="call_not_connected" class="btn btn-default w-100">Not Connected?</span>
              </div>
              <div class="form-group col-md-6 mt-2">
                <span id="call_connected" class="btn btn-default w-100">Yes, Connected?</span>
              </div>
              <div class="row w-100 text-left hidden" id="call_not_connected_box">
                <div class="col-md-12">
                  <hr>
                  <p><b>Please specify the reason?</b></p>
                  <hr>
                </div>
                <div class="col-md-6  ml-3">

                  <label class="btn btn-default"><input type="Radio" value="Out Of Coverage Area" name="LeadFollowStatus"> Out Of Coverage Area</label><br>
                  <label class="btn btn-default"><input type="Radio" value="Switch Off" name="LeadFollowStatus"> Switch Off </label><br>
                  <label class="btn btn-default"><input type="Radio" value="Number Dose not Exist" name="LeadFollowStatus"> Number Dose not Exist </label><br>
                  <label class="btn btn-default"><input type="Radio" value="Out of Validity" name="LeadFollowStatus"> Out of Validity </label><br>
                  <label class="btn btn-default"><input type="Radio" value="Not Picked" name="LeadFollowStatus"> Not Picked</label><br>
                </div>

              </div>
              <div class="row w-100 text-left hidden" id="call_connected_box">
                <div class="col-md-12">
                  <hr>
                  <p><b>Please specify the reason?</b></p>
                  <hr>
                </div>
                <div class="col-md-5 ml-3">

                  <?php
                  $UserID = AuthAppUser("UserId");
                  $companyID = FETCH("SELECT * FROM company_users WHERE company_alloted_user_id='$UserID'", "company_main_id");
                  $CallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values WHERE configs.ConfigsId=config_values.ConfigValueGroupId AND configs.ConfigsId='7' AND config_values.CompanyID='$companyID' ORDER BY ConfigValueId ASC", true);
                  if ($CallStatus != null) {
                    foreach ($CallStatus as $Status) {
                      $configValueDetails = $Status->ConfigValueDetails;
                      echo '<label class="btn btn-default"><input type="radio" value="' . $configValueDetails . '" onclick="checkFollowUp(this)" name="LeadFollowStatus"> ' . $configValueDetails . '</label><br>';
                    }
                  } else {
                    NoData("Add Call Status!!");
                  }
                  ?>

                </div>

                <div class="col-md-12 m-2">
                  <label for="set_reminder" id="followup" class="btn btn-info hidden">
                    <input id="set_reminder" name="mycheckbtn" type="checkbox" style="display: none;">SET REMINDER
                  </label><span class="text-danger bold fs-10 ml-2" id="follow_request"></span>
                  <div class="col-md-12 hidden mt-3" id="reminder_box">
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
                    <span class="btn btn-default ml-1" id="Show_Time_Box">Other</span>
                    <label class=" m-1 hidden" id="Time_Box">
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
            </div>
            <div class="col-md-12 m-2">
              <div id="calldesc">
                <div class="form-group text-left">
                  <label>Notes/Remark</label>
                  <textarea class="form-control" name="LeadFollowUpDescriptions" rows="2" required></textarea>
                </div>
              </div>
            </div>
            <div class="col-md-12 text-left">
              <button type="submit" name="AddLeadStatus" class="btn btn-md btn-success">Add FeedBack</button>
              <a href="index.php" onclick="Databar('AddFollowUps')" class="btn btn-md btn-default mt-3">cancel</a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<script>
  function CallStatusFunction() {
    var statustype = document.getElementById("statustype");
    <?php
    $FetchCallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS' ORDER BY ConfigValueId DESC", true);
    if ($FetchCallStatus != null) {
      foreach ($FetchCallStatus as $CallStatus) { ?>
        if (statustype.value == <?php echo $CallStatus->ConfigValueId; ?>) {
          document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>").style.display = "block";

        } else {
          document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>").style.display = "none";
        }

        if (statustype.value == "50") {
          document.getElementById("call_schedule").style.display = "block";
          document.getElementById("calldesc").style.display = "none";
          document.getElementById("remindnote").setAttribute("required", true);
        } else {
          document.getElementById("call_schedule").style.display = "none";
          document.getElementById("calldesc").style.display = "block";
          document.getElementById("remindnote").removeAttribute("required");
        }
    <?php }
    } ?>
  }
  // call connected or not
  var Notconnected = document.getElementById("call_not_connected");
  var Connected = document.getElementById("call_connected");
  var NotconnectedBox = document.getElementById("call_not_connected_box");
  var ConnectedBox = document.getElementById("call_connected_box");
  var Reminder = document.getElementById("set_reminder");
  var ReminderBox = document.getElementById("reminder_box");
  Notconnected.addEventListener("click", function() {
    NotconnectedBox.classList.toggle("hidden");
    Notconnected.classList.remove("btn-default");
    Connected.classList.remove("btn-primary");
    Notconnected.classList.add("btn-primary");
    ConnectedBox.classList.add("hidden");
    Connected.classList.add("btn-default");
  });
  Connected.addEventListener("click", function() {
    // Remove the "hidden" class from ConnectedBox
    ConnectedBox.classList.toggle("hidden");
    Connected.classList.remove("btn-default");
    Notconnected.classList.remove("btn-primary");
    Connected.classList.add("btn-primary");
    NotconnectedBox.classList.add("hidden");
    Notconnected.classList.add("btn-default");
  });

  function checkFollowUp(radio) {
    if (radio.value.toUpperCase() === "FOLLOW-UP" || radio.value.toUpperCase() === "FOLLOW UP" || radio.value.toUpperCase() === "MEETING PLANNED" || radio.value.toUpperCase() === "MEETING PLAN" || radio.value.toUpperCase() === "SITE VISIT PLANNED") {
      var FollowUp = document.getElementById('followup');
      FollowUp.classList.remove("hidden");
      document.getElementById("follow_request").innerHTML = "*Please Schedule The Time To Get Reminder!!";
    } else {
      var FollowUp = document.getElementById('followup');
      FollowUp.classList.add("hidden");
      document.getElementById("follow_request").innerHTML = "";
    }
  }
  Reminder.addEventListener("click", function() {
    ReminderBox.classList.toggle("hidden");

    var ShowTimeBox = document.getElementById("Show_Time_Box");
    var TimeBox = document.getElementById("Time_Box");
    var radioButtons = document.getElementsByName("predefinetime");
    ShowTimeBox.addEventListener("click", function() {
      TimeBox.classList.toggle("hidden");
      if (!TimeBox.classList.contains("hidden")) {
        // If "Other" is clicked, uncheck all radio buttons
        radioButtons.forEach(function(radioButton) {
          radioButton.checked = false;
        });
      }

    });

  });
</script>