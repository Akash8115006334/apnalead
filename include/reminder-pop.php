<?php
$LeadFollowUpHandleBy = AuthAppUser("UserId");
$GetReminderdate = FETCH("SELECT * FROM lead_followups where LeadFollowUpRemindStatus='ACTIVE' and LeadFollowUpHandleBy='$LeadFollowUpHandleBy' ORDER BY LeadFollowUpId DESC", "LeadFollowUpDate");
$GetRemindertime = FETCH("SELECT * FROM lead_followups where LeadFollowUpRemindStatus='ACTIVE' and LeadFollowUpHandleBy='$LeadFollowUpHandleBy' ORDER BY LeadFollowUpId DESC", "LeadFollowUpTime");

if ($GetReminderdate == date("Y-m-d")) {
?>
  <section class="follow-up-reminder" style="display:none;" id="reminder_pop_up">
    <div class="reminder-box">
      <div class="container">
        <div class="card p-4">
          <div class="row">
            <div class="col-md-5 text-center">
              <h1 class="blink-data text-danger text-center">
                <img src="<?php echo STORAGE_URL_D; ?>/tool-img/bell.png" class="w-25 mt-5">
              </h1>
            </div>
            <div class="col-md-7">
              <h4 class="app-heading">You have <b class='text-white'><?php echo TOTAl("SELECT * FROM lead_followups where LeadFollowUpRemindStatus='ACTIVE' and LeadFollowUpHandleBy='$LeadFollowUpHandleBy' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' ORDER BY LeadFollowUpId DESC"); ?></b> Follows Up at the moment!</h4>
              <div style="overflow-y: scroll;">
                <h5 class="app-sub-heading">Current Follow Up</h5>
                <ul class="calling-list">
                  <?php
                  if (AuthAppUser("UserType") == "Admin") {
                    $fetclFollowUps = _DB_COMMAND_("SELECT * FROM lead_followups where LeadFollowUpRemindStatus='ACTIVE' and LeadFollowUpHandleBy='$LeadFollowUpHandleBy' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' ORDER BY LeadFollowUpId DESC", true);
                  } else {
                    $LoginId = AuthAppUser("UserId");
                    $fetclFollowUps = _DB_COMMAND_("SELECT * FROM lead_followups where LeadFollowUpRemindStatus='ACTIVE' and LeadFollowUpHandleBy='$LeadFollowUpHandleBy' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' and LeadFollowUpHandleBy='$LoginId' ORDER BY LeadFollowUpId DESC", true);
                  }
                  if ($fetclFollowUps != null) {
                    foreach ($fetclFollowUps as $F) { ?>
                      <li>

                        <span><?php echo CallTypes("" . $F->LeadFollowUpCallType . ""); ?></span>
                        <p>
                          <a href="<?php echo DOMAIN; ?>/app/leads/details/index.php?LeadsId=<?php echo SECURE($F->LeadFollowMainId, "e"); ?>&alert=false">
                            <span style="font-size:1rem !important;"><b><?php echo FETCH("SELECT * FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonFullname"); ?></b></span><br>
                            <span style="font-size:0.9rem;">
                              <span class="text-black"><?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpCreatedAt); ?></span> - <span class="text-grey" style="color:grey !important;"><?php echo $F->LeadFollowCurrentStatus; ?></span><br>
                              <?php if ($F->LeadFollowStatus == "Follow Up" or $F->LeadFollowStatus == "follow Up" || $F->LeadFollowStatus == "FollowUp" || $F->LeadFollowStatus == "FOLLOW UP") { ?>
                                <i class="fa fa-clock"></i>
                              <?php } ?> <span class="text-grey"><?php echo $F->LeadFollowStatus; ?>
                                <?php if (DATE_FORMATES("d M, Y", $F->LeadFollowUpDate) != "No Update") { ?>
                                  @ <span class="text-success"><?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpDate); ?> <?php echo $F->LeadFollowUpTime; ?></span>
                                <?php } ?>
                              </span>
                            </span><br>
                            <span style="font-size:1rem;">
                              <span class="text-gray"><?php echo $F->LeadFollowUpDescriptions; ?></span>
                              <br>
                              <i style="font-size:1rem;" class="text-grey">By <?php echo FETCH("SELECT * FROM users where UserId='" . $F->LeadFollowUpHandleBy . "'", "UserFullName"); ?></i>
                            </span>

                          </a>
                        </p>
                      </li>
                  <?php
                    }
                  }
                  ?>
                </ul>
                <h5 class="app-sub-heading">Pending Follow Ups</h5>
                <ul class=" calling-list">
                  <?php
                  if (AuthAppUser("UserType") == "Admin") {
                    $fetclFollowUps = _DB_COMMAND_("SELECT * FROM lead_followups where LeadFollowUpRemindStatus='ACTIVE' and DATE(LeadFollowUpDate)>='" . date('Y-m-d') . "' ORDER BY LeadFollowUpId DESC", true);
                  } else {
                    $LoginId = AuthAppUser("UserId");
                    $fetclFollowUps = _DB_COMMAND_("SELECT * FROM lead_followups where LeadFollowUpRemindStatus='ACTIVE' and DATE(LeadFollowUpDate)>='" . date('Y-m-d') . "' and LeadFollowUpHandleBy='$LoginId' ORDER BY LeadFollowUpId DESC", true);
                  }
                  if ($fetclFollowUps != null) {
                    foreach ($fetclFollowUps as $F) { ?>
                      <li>
                        <span><?php echo CallTypes("" . $F->LeadFollowUpCallType . ""); ?></span>
                        <p>
                          <a href="<?php echo DOMAIN; ?>/app/leads/details/index.php?LeadsId=<?php echo SECURE($F->LeadFollowMainId, "e"); ?>&alert=false">
                            <span style="font-size:1rem !important;"><b><?php echo FETCH("SELECT * FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonFullname"); ?></b></span><br>
                            <span style="font-size:0.9rem;">
                              <span class="text-black"><?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpCreatedAt); ?></span> - <span class="text-grey" style="color:grey !important;"><?php echo $F->LeadFollowCurrentStatus; ?></span><br>
                              <?php if ($F->LeadFollowStatus == "Follow Up" or $F->LeadFollowStatus == "follow Up" || $F->LeadFollowStatus == "FollowUp" || $F->LeadFollowStatus == "FOLLOW UP") { ?>
                                <i class="fa fa-clock"></i>
                              <?php } ?> <span class="text-grey"><?php echo $F->LeadFollowStatus; ?>
                                <?php if (DATE_FORMATES("d M, Y", $F->LeadFollowUpDate) != "No Update") { ?>
                                  @ <span class="text-success"><?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpDate); ?> <?php echo $F->LeadFollowUpTime; ?></span>
                                <?php } ?>
                              </span>
                            </span><br>
                            <span style="font-size:1rem;">
                              <span class="text-gray"><?php echo $F->LeadFollowUpDescriptions; ?></span>
                              <br>
                              <i style="font-size:1rem;" class="text-grey">By <?php echo FETCH("SELECT * FROM users where UserId='" . $F->LeadFollowUpHandleBy . "'", "UserFullName"); ?></i>
                            </span>
                          </a>
                        </p>
                      </li>
                  <?php
                    }
                  }
                  ?>
                </ul>
              </div>
              <br>
              <a href="?alert=true" class="btn btn-sm btn-danger pull-right">Skip & Continue <i class="fa fa-angle-right"></i></a>
            </div>
            <div class='col-md-12'>
              <audio src="<?php echo STORAGE_URL_D; ?>/sys-tone/info.mp3" hidden="" id="alert_sound" loop="loop">
              </audio>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php } else {
  $GetRemindertime = "";
} ?>