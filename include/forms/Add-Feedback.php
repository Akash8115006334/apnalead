<section class="pop-section <?php echo $hidden; ?>" id="AddFollowUps">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Add Feedback</h4>
        </div>
      </div>
      <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST">
        <?php
        // Replace the following line with your actual PHP code for FormPrimaryInputs
        FormPrimaryInputs(true, ["LeadFollowMainId" => $REQ_LeadsId]);
        ?>
        <input type="text" hidden id="leascurrentstatus" name="LeadFollowCurrentStatus" value="">
        <div class="row">
          <div class="col-md-12 text-center">
            <p><b>Was Call Connected?</b></p>
          </div>

          <div class="form-group col-md-6 mt-2">
            <span id="call_not_connected" class="btn btn-default w-100">Not Connected?</span>
          </div>
          <div class="form-group col-md-6 mt-2">
            <span id="call_connected" class="btn btn-default w-100">Yes, Connected?</span>
          </div>
        </div>
        <input type="text" name="currentURL" hidden id="urlInput" class="w-100 custom-input" placeholder="Current URL" value="" readonly>
        <div class="row w-100 text-left hidden mt-0 shadow-sm p-2" id="call_not_connected_box">

          <div class="col-md-6">
            <p class=""><b>Please specify the reason?</b>
              <hr>
            </p>
            <label class="btn btn-default"><input required type="Radio" value="Out Of Coverage Area" name="LeadFollowStatus"> Out Of Coverage Area</label><br>
            <label class="btn btn-default"><input required type="Radio" value="Switch Off" name="LeadFollowStatus"> Switch Off </label><br>
            <label class="btn btn-default"><input required type="Radio" value="Number Dose not Exist" name="LeadFollowStatus"> Number Does not Exist </label><br>
            <label class="btn btn-default"><input required type="Radio" value="Out of Validity" name="LeadFollowStatus"> Out of Validity </label><br>
            <label class="btn btn-default"><input required type="Radio" value="Not Picked" name="LeadFollowStatus"> Not Picked</label><br>
          </div>
          <div class="col-md-6">
            <p class="text-center"><b>Add Reminder</b>
              <hr>
            </p>
            <p class="text-center">
              <label for="set_reminder" id="followup" class="btn btn-info">
                <input id="set_reminder" name="mycheckbtn" type="checkbox" style="display: none;"> <i class="fa fa-bell" aria-hidden="true"></i> SET REMINDER
              </label><span class="text-danger bold fs-10 ml-2" id="follow_request"></span>
            </p>
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
              <label class="m-1 hidden " id="Time_Box">
                <span class="flex-s-b feedbackspan text-center">
                  <input type="date" name="LeadFollowUpDate" class="form-control form-control-sm mr-2" value="<?php echo date("Y-m-d"); ?>">
                  <input type="time" name="LeadFollowUpTime" value="<?php echo DATE("H:i", strtotime("+5 min")); ?>" class="form-control form-control-sm"></span>
              </label>
            </div>
          </div>

        </div>
        <div class="row w-100 text-left hidden shadow-sm p-2" id="call_connected_box">

          <div class="col-md-6">
            <p class=""><b>Please specify the reason?</b>
              <hr>
            </p>
            <?php
            // Replace the following lines with your actual PHP code for fetching CallStatus

            $UserID = AuthAppUser("UserId");
            $companyID = CompanyId;
            $CallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values WHERE configs.ConfigsId=config_values.ConfigValueGroupId AND configs.ConfigsId='7' AND config_values.CompanyID='$companyID' ORDER BY ConfigValueId ASC", true);
            if ($CallStatus != null) {
              foreach ($CallStatus as $Status) {
                $configValueDetails = $Status->ConfigValueDetails;
                echo '<label class="btn btn-default"><input type="radio" required  value="' . $configValueDetails . '" name="LeadFollowStatus"> ' . $configValueDetails . '</label><br>';
              }
            } else {
              NoData("Add Call Status!!");
            }

            ?>
          </div>
          <div class="col-md-6">
            <p class="text-center"><b>Add Reminder</b>
              <hr>
            </p>
            <p class="text-center">
              <label for="set_reminder2" id="followup" class="btn btn-info">
                <input id="set_reminder2" name="mycheckbtn" type="checkbox" style="display: none;"> <i class="fa fa-bell" aria-hidden="true"></i> SET REMINDER
              </label><span class="text-danger bold fs-10 ml-2" id="follow_request2"></span>
            </p>
            <div class="col-md-12 hidden mt-3" id="reminder_box2">
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
              <span class="btn btn-default ml-1" id="Show_Time_Box2">Other</span>
              <label class="m-1 hidden " id="Time_Box2">
                <span class="flex-s-b feedbackspan text-center">
                  <input type="date" name="LeadFollowUpDate" class="form-control form-control-sm mr-2" value="<?php echo date("Y-m-d"); ?>">
                  <input type="time" name="LeadFollowUpTime" value="<?php echo DATE("H:i", strtotime("+5 min")); ?>" class="form-control form-control-sm"></span>
              </label>
            </div>
            <div class="form-group mt-3">
              <hr>
              <p class="text-center">
                <b>Lead Priority level </b>
                <hr>
              </p>
              <p class="text-center">
                <?php
                $Allpriority = _DB_COMMAND_("SELECT * FROM configs, config_values WHERE configs.ConfigsId=config_values.ConfigValueGroupId AND configs.ConfigsId='6' AND config_values.CompanyID='$companyID' ORDER BY ConfigValueId ASC", true);
                if ($Allpriority != null) {
                  foreach ($Allpriority as $priority) {
                    if ($priority->ConfigValueDetails == FETCH($PageSqls, "LeadPriorityLevel")) {
                      $checked = "checked";
                    } else {
                      $checked = "";
                    }

                    echo '<label class="btn btn-default ml-1"><input type="radio" required ' . $checked . '  value="' . $priority->ConfigValueDetails . '" name="LeadPriorityLevel"> ' . $priority->ConfigValueDetails . '</label>';
                  }
                } ?>
              </p>
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
        <div class="col-md-12 text-center">
          <button type="submit" name="AddLeadStatus" class="btn btn-md btn-success">Add FeedBack</button>
          <a href="#" onclick="Databar('AddFollowUps')" class="btn btn-md btn-default mt-3">cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>

<script>
  // call connected or not
  var Notconnected = document.getElementById("call_not_connected");
  var Connected = document.getElementById("call_connected");
  var NotconnectedBox = document.getElementById("call_not_connected_box");
  var ConnectedBox = document.getElementById("call_connected_box");
  var Reminder = document.getElementById("set_reminder");
  var ReminderBox = document.getElementById("reminder_box");
  var Reminder2 = document.getElementById("set_reminder2");
  var ReminderBox2 = document.getElementById("reminder_box2");
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

  Reminder.addEventListener("click", function() {
    ReminderBox.classList.toggle("hidden");

    var ShowTimeBox = document.getElementById("Show_Time_Box");
    var TimeBox = document.getElementById("Time_Box");
    var radioButtons = document.getElementsByName("predefinetime");
    ShowTimeBox.addEventListener("click", function() {
      TimeBox.classList.toggle("hidden");
      if (!TimeBox.classList.contains("hidden")) {
        radioButtons.forEach(function(radioButton) {
          radioButton.checked = false;
        });
      }
    });
  });
  Reminder2.addEventListener("click", function() {
    ReminderBox2.classList.toggle("hidden");
    var ShowTimeBox2 = document.getElementById("Show_Time_Box2");
    var TimeBox2 = document.getElementById("Time_Box2");
    var radioButtons = document.getElementsByName("predefinetime");
    ShowTimeBox2.addEventListener("click", function() {
      TimeBox2.classList.toggle("hidden");
      if (!TimeBox2.classList.contains("hidden")) {
        radioButtons.forEach(function(radioButton) {
          radioButton.checked = false;
        });
      }
    });
  });
</script>
<script>
  let currentUrl = window.location.href;
  document.getElementById("urlInput").value = currentUrl;
</script>