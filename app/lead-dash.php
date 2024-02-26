<div class="row">
  <div class="col-md-12">
    <div class='flex-s-b'>
      <h3 class="app-heading w-pr-80 m-t-0"><i class="fa fa-home"></i> Lead Dashboard </h3>
      <?php
      $UserID = AuthAppUser("UserId");
      $companyID = CompanyId;
      if (AuthAppUser("UserType") == 'Admin') { ?>
        <form>
          <select name="view" onchange="form.submit()" class="form-control form-control-sm">
            <?php InputOptions(["Admin Dashboard", 'Lead Dashboard', 'Digital Dashboard'], IfRequested('GET', 'view', 'Admin Dashboard', false)); ?>
          </select>
        </form>
      <?php }
      $TDate = date("Y-m-d");
      $YDate = date("Y-m-d", strtotime("-1 days"));
      if (AuthAppUser("UserType") == "Admin" || AuthAppUser("UserType") == "Digital") {
        $AllData = TOTAL("SELECT LeadsId FROM leads where CompanyID='$companyID'");
        $AllDataToday = TOTAL("SELECT LeadsId FROM leads where CompanyID='$companyID' and Date(LeadPersonCreatedAt)='$TDate'");
        $AllDataYesterday = TOTAL("SELECT LeadsId FROM leads where CompanyID='$companyID' and Date(LeadPersonCreatedAt)='$YDate'");
        $AllUploaded = TOTAL("SELECT leadsUploadId FROM  lead_uploads where CompanyID='$companyID' and LeadStatus='UPLOADED'");
        $AllUploadedToday = TOTAL("SELECT leadsUploadId FROM lead_uploads where CompanyID='$companyID'and LeadStatus='UPLOADED' and Date(UploadedOn)='$TDate'");
        $AllUploadedYesterday = TOTAL("SELECT leadsUploadId FROM lead_uploads where CompanyID='$companyID'and LeadStatus='UPLOADED' and Date(UploadedOn)='$YDate'");
        $AllFreshLeads = TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%Fresh Lead%' and CompanyID='$companyID'");
        $AllFreshLeadToday = TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%Fresh Lead%' and Date(LeadPersonCreatedAt)='$TDate' and CompanyID='$companyID'");
        $AllFreshLeadYesterday = TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%Fresh Lead%' and Date(LeadPersonCreatedAt)='$YDate' and CompanyID='$companyID'");
        $AllFacebookLeads = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonSource like '%Facebook%' and CompanyID='$companyID'");
        $AllFacebookLeadsToday = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonSource like '%Facebook%' and CompanyID='$companyID' and Date(LeadPersonCreatedAt)='$TDate'");
        $AllFacebookLeadsYesterday = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonSource like '%Facebook%' and CompanyID='$companyID' and Date(LeadPersonCreatedAt)='$YDate'");
        $AllWebhookLeads = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonSource like '%WEBSITE_API%' and CompanyID='$companyID'");
        $AllWebhookLeadsToday = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonSource like '%WEBSITE_API%' and CompanyID='$companyID' and Date(LeadPersonCreatedAt)='$TDate'");
        $AllWebhookLeadsYesterday = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonSource like '%WEBSITE_API%' and CompanyID='$companyID' and Date(LeadPersonCreatedAt)='$YDate'");
        $AllFacebookUpload = TOTAL("SELECT * FROM lead_uploads WHERE CompanyID='$companyID' and LeadsSource LIKE '%Facebook%' and LeadStatus LIKE '%UPLOADED%' GROUP BY leadsUploadId ORDER BY leadsUploadId ASC ");
        $AllFacebookUploadToday = TOTAL("SELECT * FROM lead_uploads WHERE CompanyID='$companyID' and LeadsSource LIKE '%Facebook%' and LeadStatus LIKE '%UPLOADED%' and Date(UploadedOn)='$TDate' GROUP BY leadsUploadId ORDER BY leadsUploadId ASC");
        $AllFacebookUploadYesterday = TOTAL("SELECT * FROM lead_uploads WHERE CompanyID='$companyID' and LeadsSource LIKE '%Facebook%' and LeadStatus LIKE '%UPLOADED%' and Date(UploadedOn)='$YDate' GROUP BY leadsUploadId ORDER BY leadsUploadId ASC");
      } else {
        $LOGIN_UserViewId = AuthAppUser("UserId");
        $AllData = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and CompanyID='$companyID'");
        $AllDataToday = TOTAL("SELECT LeadsId FROM leads where CompanyID='$companyID' and LeadPersonManagedBy='$LOGIN_UserViewId' and Date(LeadPersonCreatedAt)='$TDate'");
        $AllDataYesterday = TOTAL("SELECT LeadsId FROM leads where CompanyID='$companyID' and LeadPersonManagedBy='$LOGIN_UserViewId' and Date(LeadPersonCreatedAt)='$YDate'");
        $AllUploaded = TOTAL("SELECT leadsUploadId FROM  lead_uploads where CompanyID='$companyID'");
        $AllUploadedToday = TOTAL("SELECT leadsUploadId FROM lead_uploads where CompanyID='$companyID' and LeadsUploadedfor='$LOGIN_UserViewId' and Date(UploadedOn)='$TDate'");
        $AllUploadedYesterday = TOTAL("SELECT leadsUploadId FROM lead_uploads where CompanyID='$companyID' and LeadsUploadedfor='$LOGIN_UserViewId' and Date(UploadedOn)='$YDate'");
        $AllFreshLeads = TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%Fresh Lead%' and LeadPersonManagedBy='$LOGIN_UserViewId' and CompanyID='$companyID'");
        $AllFreshLeadToday = TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%Fresh Lead%' and LeadPersonManagedBy='$LOGIN_UserViewId' and Date(LeadPersonCreatedAt)='$TDate' and CompanyID='$companyID'");
        $AllFreshLeadYesterday = TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%Fresh Lead%' and LeadPersonManagedBy='$LOGIN_UserViewId' and Date(LeadPersonCreatedAt)='$YDate' and CompanyID='$companyID'");
        // die("SELECT LeadsId FROM leads where LeadPersonStatus like '%Fresh Lead%' and LeadPersonManagedBy='$LOGIN_UserViewId' and Date(LeadPersonCreatedAt)='$YDate' and CompanyID='$companyID'");
      } ?>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-3 col-6 mb-10px">
    <a href="<?PHP echo APP_URL; ?>/leads/">
      <div class="card card-window card-body rounded-3 p-1 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo $AllData ?>
          </h2>
          <span class="pull-right text-grey" style="line-height:1rem;">
            <span class="fs-11">Today : </span><span class="fs-13 count">
              <?php echo $AllDataToday; ?>
            </span><br>
            <span class="fs-11">Yesterday : </span><span class="fs-13 count">
              <?php echo $AllDataYesterday; ?>
            </span>
          </span>
        </div>
        <p class="mb-0 fs-14 text-black bold"> <i class="fa fa-male text-black fs-20" aria-hidden="true"></i> All Leads</p>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-6 mb-10px">
    <a href="<?php echo APP_URL; ?>/leads/index.php?sub_status=FRESH LEAD">
      <div class="card card-window card-body rounded-3 p-1 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo $AllFreshLeads; ?>
          </h2>
          <span class="pull-right text-grey" style="line-height:1rem;">
            <span class="fs-11">Today : </span><span class="fs-13 count">
              <?php echo $AllFreshLeadToday; ?>
            </span><br>
            <span class="fs-11">Yesterday : </span><span class="fs-13 count">
              <?php echo $AllFreshLeadYesterday; ?>
            </span>
          </span>
        </div>
        <p class="mb-0 fs-14 text-black bold"><i class="fa fa-newspaper-o text-success fs-20" aria-hidden="true"></i> Fresh Leads</p>
      </div>
    </a>
  </div>
  <?php
  $AllCounters = _DB_COMMAND_("SELECT * FROM config_lead_counters  where CompanyID='$companyID' ORDER by config_lead_counter_id ASC", true);
  if ($AllCounters != null) {
    foreach ($AllCounters as $Counter) {
      $TDate = date("Y-m-d");
      $YDate = date("Y-m-d", strtotime("-1 days"));
      if (AuthAppUser("UserType") == "Admin") {
        $AllDataRecords = TOTAL("SELECT * FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonStatus like '%" . $Counter->config_counter_primary_search . "%' and CompanyID='$companyID' GROUP BY LeadsId");
        $AllDataRecordsToday = TOTAL("SELECT LeadsId FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonStatus like '%" . $Counter->config_counter_primary_search . "%' and Date(LeadPersonLastUpdatedAt)='$TDate' and CompanyID='$companyID'");
        $AllDataRecordsYesterday = TOTAL("SELECT LeadsId FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonStatus like '%" . $Counter->config_counter_primary_search . "%' and Date(LeadPersonLastUpdatedAt)='$YDate' and CompanyID='$companyID'");
      } else {
        $LOGIN_UserViewId = AuthAppUser("UserId");
        $AllDataRecords = TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%" . $Counter->config_counter_primary_search . "%' and LeadPersonManagedBy='$LOGIN_UserViewId' and CompanyID='$companyID'");
        $AllDataRecordsToday = TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%" . $Counter->config_counter_primary_search . "%' and LeadPersonManagedBy='$LOGIN_UserViewId' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d") . "' and CompanyID='$companyID'");
        $AllDataRecordsYesterday = TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%" . $Counter->config_counter_primary_search . "%' and LeadPersonManagedBy='$LOGIN_UserViewId' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "' and CompanyID='$companyID'");
      }
  ?>
      <div class="col-md-3 col-6 mb-10px">

        <a href="<?php echo APP_URL; ?>/leads/index.php?sub_status=<?php echo $Counter->config_counter_primary_search; ?>">
          <div class="card card-window card-body rounded-3 p-1 shadow-lg">
            <div class="flex-s-b">
              <h2 class="count mb-0 m-t-5 h1">
                <?php echo $AllDataRecords; ?>
              </h2>
              <span class="pull-right text-grey" style="line-height:1rem;">

                <span class="fs-11">Today : </span><span class="fs-13 count">
                  <?php echo $AllDataRecordsToday; ?>
                </span><br>
                <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                  <?php echo $AllDataRecordsYesterday; ?>
                </span>
              </span>
            </div>
            <p class="mb-0 fs-14 text-black bold"> <i class="fa fa-calendar-check-o text-pink fs-20" aria-hidden="true"></i> <?php echo UpperCase($Counter->config_counter_name); ?>
            </p>
          </div>
        </a>
      </div>
  <?php
    }
  }
  ?>
  <?php if (AuthAppUser("UserType") == "Admin" || AuthAppUser("UserType") == "Digital") { ?>

    <div class="col-md-3 col-6 mb-10px">
      <a href="<?PHP echo APP_URL; ?>/leads/uploaded/">
        <div class="card card-window card-body rounded-3 p-1 shadow-lg">
          <div class="flex-s-b">
            <h2 class="count mb-0 m-t-5 h1">
              <?php echo $AllUploaded; ?>
            </h2>
            <span class="pull-right text-grey" style="line-height:1rem;">
              <span class="fs-11">Today : </span><span class="fs-13 count">
                <?php echo $AllUploadedToday; ?>
              </span><br>
              <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                <?php echo $AllUploadedYesterday; ?>
              </span>
            </span>
          </div>
          <p class="mb-0 fs-14 text-black bold"><i class="fa fa-upload text-warning fs-20" aria-hidden="true"></i> All Uploaded Data</p>
        </div>
      </a>
    </div>
    <div class="col-md-3 col-6 mb-10px">
      <a href="<?PHP echo APP_URL; ?>/leads/uploaded/">
        <div class="card card-window card-body rounded-3 p-1 shadow-lg">
          <div class="flex-s-b">
            <h2 class="count mb-0 m-t-5 h1">
              <?php echo $AllFacebookUpload; ?>
            </h2>
            <span class="pull-right text-grey" style="line-height:1rem;">
              <span class="fs-11">Today : </span><span class="fs-13 count">
                <?php echo $AllFacebookUploadToday; ?>
              </span><br>
              <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                <?php echo $AllFacebookUploadYesterday; ?>
              </span>
            </span>
          </div>
          <p class="mb-0 fs-14 text-black bold"><i class="fa fa-upload text-warning fs-20" aria-hidden="true"></i> All Facebook Uploaded </p>
        </div>
      </a>
    </div>

    <div class="col-md-3 col-6 mb-10px">
      <a href="<?php echo APP_URL; ?>/leads/index.php?sub_status=Facebook">
        <div class="card card-window card-body rounded-3 p-1 shadow-lg">
          <div class="flex-s-b">
            <h2 class="count mb-0 m-t-5 h1">
              <?php echo $AllFacebookLeads; ?>
            </h2>
            <span class="pull-right text-grey" style="line-height:1rem;">
              <span class="fs-11">Today : </span><span class="fs-13 count">
                <?php echo $AllFacebookLeadsToday; ?>
              </span><br>
              <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                <?php echo $AllFacebookLeadsYesterday; ?>
              </span>
            </span>
          </div>
          <p class="mb-0 fs-14 text-black bold"> <i class="fa fa-facebook-square text-primary fs-20" aria-hidden="true"></i> Leads From Facebook</p>
        </div>
      </a>
    </div>
    <div class="col-md-3 col-6 mb-10px">
      <a href="<?php echo APP_URL; ?>/leads/index.php?sub_status=WEBSITE_API">
        <div class="card card-window card-body rounded-3 p-1 shadow-lg">
          <div class="flex-s-b">
            <h2 class="count mb-0 m-t-5 h1">
              <?php echo $AllWebhookLeads; ?>
            </h2>
            <span class="pull-right text-grey" style="line-height:1rem;">
              <span class="fs-11">Today : </span><span class="fs-13 count">
                <?php echo $AllWebhookLeadsToday; ?>
              </span><br>
              <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                <?php echo $AllWebhookLeadsYesterday; ?>
              </span>
            </span>
          </div>
          <p class="mb-0 fs-14 text-black bold"><i class="fa fa-table text-success fs-20" aria-hidden="true"></i> Leads From Website</p>

        </div>
      </a>
    </div>
  <?php } ?>
  <!-- <div class="col-md-3 col-6 mb-10px">
    <a href="<?php echo APP_URL; ?>/leads/index.php?sub_status=WEBSITE_API">
      <div class="card card-window card-body rounded-3 p-1 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1 ">
            <?php echo $AllMissedFollowups; ?>
          </h2>
          <span class="pull-right text-grey" style="line-height:1rem;">
            <span class="fs-11 ">Today : </span><span class="fs-13 count text-danger">
              <?php echo $AllMissedTodayFollowups; ?>
            </span><br>
            <span class="fs-11">Yesterday : </span><span class="fs-13 count">
              <?php echo $AllMissedYesterdayFollowups; ?>
            </span>
          </span>
        </div>
        <p class="mb-0 fs-14 text-black bold"><i class="fa fa-phone-square text-danger fs-20" aria-hidden="true"></i> Missed Follow-ups</p>

      </div>
    </a>
  </div> -->
</div>
<?php if (AuthAppUser("UserType") == "Admin") { ?>
  <div class="row">
    <div class="col-lg col-sm-12">
      <div class="card p-2 m-2">
        <?php include "lead_graph.php"; ?>
        <div id="chartContainer" class="chart" style="height: 370px; width: 100%;"></div>
      </div>
    </div>
  </div>
<?php } ?>
<div class="row">
  <div class="col-lg col-sm-12">
    <a href="leads/?sub_status=follow&date=date">
      <h5 class="app-heading d-flex justify-content-between align-items-center">Today's FollowUps <span class="bg-white p-1  rounded pull-right" style="font-size:0.9rem;">
          <?php

          if (AuthAppUser("UserType") == "Admin") {
            echo TOTAL("SELECT * FROM lead_followups, leads where leads.LeadsId=lead_followups.LeadFollowMainId and leads.CompanyID='$companyID' and lead_followups.LeadFollowCurrentStatus like '%FOLLOW-UP%' and DATE( lead_followups.LeadFollowUpDate)='$TDate' and  lead_followups.LeadFollowUpRemindStatus='ACTIVE' ORDER BY lead_followups.LeadFollowUpId DESC");
          } else {
            echo TOTAL("SELECT * FROM lead_followups where LeadFollowUpHandleBy='" . AuthAppUser("UserId") . "' and DATE(LeadFollowUpDate)='$TDate' and LeadFollowCurrentStatus like '%FOLLOW-UP%'  and LeadFollowUpRemindStatus='ACTIVE' ORDER BY LeadFollowUpId DESC");
          } ?> Follow Ups</span>
      </h5>
    </a>
    <div class="data-display bg-light">
      <ul class="calling-list">
        <?php

        if (AuthAppUser("UserType") == "Admin") {
          $fetclFollowUps = _DB_COMMAND_("SELECT * FROM lead_followups, leads where leads.LeadsId=lead_followups.LeadFollowMainId and lead_followups.LeadFollowCurrentStatus like '%FOLLOW-UP%' and leads.CompanyID='$companyID' and DATE(LeadFollowUpDate)='$TDate' and lead_followups.LeadFollowUpRemindStatus='ACTIVE' ORDER BY lead_followups.LeadFollowUpId DESC", true);
        } else {
          $fetclFollowUps = _DB_COMMAND_("SELECT * FROM lead_followups, leads  where leads.LeadsId=lead_followups.LeadFollowMainId and lead_followups.LeadFollowCurrentStatus like '%FOLLOW-UP%' and leads.CompanyID='$companyID' and lead_followups.LeadFollowUpHandleBy='" . AuthAppUser("UserId") . "' and DATE(lead_followups.LeadFollowUpDate)='$TDate' and lead_followups.LeadFollowUpRemindStatus='ACTIVE' ORDER BY lead_followups.LeadFollowUpId DESC", true);
        }
        if ($fetclFollowUps != null) {
          foreach ($fetclFollowUps as $F) { ?>
            <li>
              <span class='text-center bg-warning text-black rounded'>
                <span class=''>
                  <?php if (DATE_FORMATES("h:i A", $F->LeadFollowUpUpdatedAt) == "NA") { ?>
                    <span class='h5'>No Call</span><br>
                  <?php } else { ?>
                    <span class="p-t-3">
                      <span class='h4 text-success'><i class='fa fa-phone'></i></span><br>
                      <span class='small'>scheduled for </span><br>
                      <span class='h5'> <?php echo DATE_FORMATES("h:i A", $F->LeadFollowUpTime); ?></span><br>
                      <span> <?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpDate); ?></span><br>
                      <span>
                        <?php
                        $GetSeconds = GetLeadsFollowUpDurations($F->LeadFollowUpId);
                        $CallDuration = GetDurations($GetSeconds);
                        echo $CallDuration; ?>
                      </span>
                    </span>
                  <?php } ?>
                </span>
              </span>
              <p style='line-height:1.1rem !important;margin-top:0.7rem !important;'>
                <a href="<?php echo DOMAIN; ?>/app/leads/details/index.php?LeadsId=<?php echo SECURE($F->LeadFollowMainId, "e"); ?>&alert=true">
                  <span>
                    <span style="font-size:1.1rem !important;font-weight:600 !important;">
                      <?php echo FETCH("SELECT * FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadSalutations"); ?>
                      <?php echo FETCH("SELECT * FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonFullname"); ?><br>

                      <span style="font-size:0.95rem !important;font-weight:500 !important;" class='text-info'>
                        <i class='fa fa-phone-square'></i> <?php echo FETCH("SELECT * FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonPhoneNumber"); ?>
                      </span><br>
                      <span style="font-size:0.95rem !important;font-weight:500 !important;">
                        <?php echo FETCH("SELECT * FROM projects where ProjectsId='" . FETCH("SELECT * FROM lead_requirements WHERE LeadMainId='" . $F->LeadFollowMainId . "'", "LeadRequirementDetails") . "'", "ProjectName"); ?>
                      </span>
                    </span><br>
                    <span class='text-danger bold h6'>
                      <span class='pull-left w-50' style="padding-top:0px !important;"><?php echo $F->LeadFollowStatus; ?></span>
                      <span class='pull-right w-50 text-right small' style="padding-top:0px !important;">
                        <i class='fa fa-clock text-warning'></i> <?php echo GetMinutes($F->LeadFollowUpTime, date("h:i A")); ?>
                      </span>
                    </span>
                    <br><br>
                    <?php if ($F->LeadFollowStatus == "Follow Up" or $F->LeadFollowStatus == "follow Up" || $F->LeadFollowStatus == "FollowUp" || $F->LeadFollowStatus == "FOLLOW-UP") { ?>
                      <?php if (DATE_FORMATES("d M, Y", $F->LeadFollowUpDate) != "No Update") { ?>
                        <span class='fs-11 text-grey'>
                          <?php echo $F->LeadFollowCurrentStatus; ?> @
                          <span class="text-success"><?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpDate); ?>
                            <?php echo $F->LeadFollowUpTime; ?>
                          </span>
                        </span>
                      <?php } ?>
                      <span class="text-grey">
                      <?php } else { ?>
                        <span class="text-grey"><?php echo $F->LeadFollowStatus; ?>
                        <?php } ?>
                        </span>
                      </span><br>
                      <span style="font-size:0.9rem;">
                        <span class="text-black"><?php echo $F->LeadFollowUpDescriptions; ?></span>
                        <br>
                        <i style="font-size:0.8rem;" class='text-warning pull-right'>By
                          <?php echo FETCH("SELECT * FROM users where UserId='" . $F->LeadFollowUpHandleBy . "'", "UserFullName"); ?> -
                          <?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $F->LeadFollowUpHandleBy . "'", "UserEmpJoinedId"); ?>
                        </i>
                      </span>
                  </span>
                </a>
              </p>
            </li>
        <?php
          }
        } else {
          echo NoData("No FollowUps Found!!!");
        }
        ?>
      </ul>
    </div>
    <a href="<?php echo APP_URL; ?>/leads/?sub_status=follow&date=" class="btn btn-md btn-primary pull-right mt-3 mb-2">View All Today's Follow Ups <i class='fa fa-angle-right'></i></a>
  </div>
  <div class="col-lg col-sm-12">
    <a href="leads/?sub_status=Meeting plan&date=">
      <h5 class="app-heading app-heading d-flex justify-content-between align-items-center">Today's Meeting Planned <span class="bg-white p-1 rounded pull-right" style="font-size:0.9rem;">
          <?php
          if (AuthAppUser("UserType") == "ADMIN") {
            echo TOTAL("SELECT * FROM lead_followups, company_users where company_users.company_alloted_user_id=lead_followups.LeadFollowUpHandleBy and company_users.company_main_id='$companyID'  and LeadFollowCurrentStatus like '%MEETING PLANNED%' AND DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' and LeadFollowUpRemindStatus='ACTIVE' ORDER BY LeadFollowUpId DESC");
          } else {
            echo TOTAL("SELECT * FROM lead_followups where LeadFollowCurrentStatus like '%MEETING PLANNED%' AND LeadFollowUpHandleBy='" . AuthAppUser("UserId") . "' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' and LeadFollowUpRemindStatus='ACTIVE' ORDER BY LeadFollowUpId DESC");
          } ?> Meetings</span>
      </h5>
    </a>
    <div class="data-display bg-light">
      <ul class="calling-list">
        <?php
        if (AuthAppUser("UserType") == "ADMIN") {
          $fetclFollowUps = _DB_COMMAND_("SELECT * FROM lead_followups, company_users where company_users.company_alloted_user_id=lead_followups.LeadFollowUpHandleBy and company_users.company_main_id='$companyID' and LeadFollowCurrentStatus like '%MEETING PLANNED%' AND DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' and LeadFollowUpRemindStatus='ACTIVE' ORDER BY LeadFollowUpId DESC", true);
        } else {
          $fetclFollowUps = _DB_COMMAND_("SELECT * FROM lead_followups where LeadFollowCurrentStatus like '%MEETING PLANNED%' AND LeadFollowUpHandleBy='" . AuthAppUser("UserId") . "' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' and LeadFollowUpRemindStatus='ACTIVE' ORDER BY LeadFollowUpId DESC", true);
        }
        if ($fetclFollowUps != null) {
          foreach ($fetclFollowUps as $F) { ?>
            <li>
              <span class='text-center bg-warning text-black rounded'>
                <span class=''>
                  <?php if (DATE_FORMATES("h:i A", $F->LeadFollowUpUpdatedAt) == "NA") { ?>
                    <span class='h5'>No Call</span><br>
                  <?php } else { ?>
                    <span class="p-t-3">
                      <span class='h4 text-success'><i class='fa fa-phone'></i></span><br>
                      <span class='small'>scheduled for </span><br>
                      <span class='h5'> <?php echo DATE_FORMATES("h:i A", $F->LeadFollowUpTime); ?></span><br>
                      <span> <?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpDate); ?></span><br>
                      <span>
                        <?php
                        $GetSeconds = GetLeadsFollowUpDurations($F->LeadFollowUpId);
                        $CallDuration = GetDurations($GetSeconds);
                        echo $CallDuration; ?>
                      </span>
                    </span>
                  <?php } ?>
                </span>
              </span>
              <p style='line-height:1.1rem !important;margin-top:0.7rem !important;'>
                <a href="<?php echo DOMAIN; ?>/app/leads/details/index.php?LeadsId=<?php echo SECURE($F->LeadFollowMainId, "e"); ?>&alert=true">
                  <span>
                    <span style="font-size:1.1rem !important;font-weight:600 !important;">
                      <?php echo FETCH("SELECT * FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadSalutations"); ?>
                      <?php echo FETCH("SELECT * FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonFullname"); ?><br>

                      <span style="font-size:0.95rem !important;font-weight:500 !important;" class='text-info'>
                        <i class='fa fa-phone-square'></i> <?php echo FETCH("SELECT * FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonPhoneNumber"); ?>
                      </span><br>
                      <span style="font-size:0.95rem !important;font-weight:500 !important;">
                        <?php echo FETCH("SELECT * FROM projects where ProjectsId='" . FETCH("SELECT * FROM lead_requirements WHERE LeadMainId='" . $F->LeadFollowMainId . "'", "LeadRequirementDetails") . "'", "ProjectName"); ?>
                      </span>
                    </span><br>
                    <span class='text-danger bold h6'>
                      <span class='pull-left w-50' style="padding-top:0px !important;"><?php echo $F->LeadFollowStatus; ?></span>
                      <span class='pull-right w-50 text-right small' style="padding-top:0px !important;">
                        <i class='fa fa-clock text-warning'></i> <?php echo GetMinutes($F->LeadFollowUpTime, date("h:i A")); ?>
                      </span>
                    </span>
                    <br><br>
                    <?php if ($F->LeadFollowStatus == "Follow Up" or $F->LeadFollowStatus == "follow Up" || $F->LeadFollowStatus == "FollowUp" || $F->LeadFollowStatus == "MEETING PLANNED") { ?>
                      <?php if (DATE_FORMATES("d M, Y", $F->LeadFollowUpDate) != "No Update") { ?>
                        <span class='fs-11 text-grey'>
                          <?php echo $F->LeadFollowCurrentStatus; ?> @
                          <span class="text-success"><?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpDate); ?>
                            <?php echo $F->LeadFollowUpTime; ?>
                          </span>
                        </span>
                      <?php } ?>
                      <span class="text-grey">
                      <?php } else { ?>
                        <span class="text-grey"><?php echo $F->LeadFollowStatus; ?>
                        <?php } ?>
                        </span>
                      </span><br>
                      <span style="font-size:0.9rem;">
                        <span class="text-black"><?php echo $F->LeadFollowUpDescriptions; ?></span>
                        <br>
                        <i style="font-size:0.8rem;" class='text-warning pull-right'>By
                          <?php echo FETCH("SELECT * FROM users where UserId='" . $F->LeadFollowUpHandleBy . "'", "UserFullName"); ?> -
                          <?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $F->LeadFollowUpHandleBy . "'", "UserEmpJoinedId"); ?>
                        </i>
                      </span>
                  </span>
                </a>
              </p>
            </li>

        <?php
          }
        } else {
          NoData("No Meetings Found!!!");
        }
        ?>
      </ul>
    </div>
    <a href="<?php echo APP_URL; ?>/leads/?sub_status=meeting plan&date=" class="btn btn-md btn-primary pull-right mt-3 mb-2">View All Today's Meetings <i class='fa fa-angle-right'></i></a>
  </div>

  <div class="col-lg col-sm-12">

    <h5 class="app-heading app-heading d-flex justify-content-between align-items-center">Current Activity <span class="bg-white p-1 rounded pull-right" style="font-size:0.9rem;">
        <?php
        if (AuthAppUser("UserType") == "Admin") {
          echo TOTAL("SELECT * FROM lead_followups, company_users  where company_users.company_alloted_user_id=lead_followups.LeadFollowUpHandleBy and company_users.company_main_id='$companyID' and Date(lead_followups.LeadFollowUpCreatedAt)='" . CURRENT_DATE . "' ORDER BY lead_followups.LeadFollowUpId DESC");
        } else {
          echo TOTAL("SELECT * FROM lead_followups, company_users  where company_users.company_alloted_user_id=lead_followups.LeadFollowUpHandleBy and company_users.company_main_id='$companyID' and lead_followups.LeadFollowUpHandleBy='" . AuthAppUser('UserId') . "' and Date(lead_followups.LeadFollowUpCreatedAt)='" . CURRENT_DATE . "' ORDER BY lead_followups.LeadFollowUpId DESC");
        } ?> Activity</span>
    </h5>
    <div class="data-display bg-light">
      <ul class="calling-list pt-0">
        <?php
        if (AuthAppUser("UserType") == "Admin") {
          $fetclFollowUps = _DB_COMMAND_("SELECT * FROM lead_followups, company_users  where company_users.company_alloted_user_id=lead_followups.LeadFollowUpHandleBy and company_users.company_main_id='$companyID' and Date(lead_followups.LeadFollowUpCreatedAt)='" . CURRENT_DATE . "'  ORDER BY LeadFollowUpId DESC limit 0, 25", true);
        } else {
          $fetclFollowUps = _DB_COMMAND_("SELECT * FROM lead_followups, company_users  where company_users.company_alloted_user_id=lead_followups.LeadFollowUpHandleBy and company_users.company_main_id='$companyID' and lead_followups.LeadFollowUpHandleBy='" . AuthAppUser('UserId') . "' and Date(lead_followups.LeadFollowUpCreatedAt)='" . CURRENT_DATE . "'  ORDER BY LeadFollowUpId DESC limit 0, 25", true);
        }
        if ($fetclFollowUps != null) {
          foreach ($fetclFollowUps as $F) { ?>
            <a href="<?php echo APP_URL; ?>/leads/details/index.php?LeadsId=<?php echo SECURE($F->LeadFollowMainId, "e"); ?>">
              <li class="new-outline-hover">

                <span class='text-center bg-light text-black rounded'>
                  <span class=''>
                    <?php if (DATE_FORMATES("h:i A", $F->LeadFollowUpUpdatedAt) == "NA") { ?>
                      <span class='h5'>No Call</span><br>
                    <?php } else { ?>
                      <span class="p-t-3">
                        <span class='h4 text-success'><i class='fa fa-phone'></i></span><br>
                        <span class='small'>calling done at</span><br>
                        <span class='h5'> <?php echo DATE_FORMATES("h:i A", $F->LeadFollowUpUpdatedAt); ?></span><br>
                        <span> <?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpUpdatedAt); ?></span><br>
                        <span>
                          <?php
                          $GetSeconds = GetLeadsFollowUpDurations($F->LeadFollowUpId);
                          $CallDuration = GetDurations($GetSeconds);
                          echo $CallDuration; ?>
                        </span>
                      </span>
                    <?php } ?>
                  </span>
                </span>
                <p style='line-height:1.1rem !important;margin-top:0.7rem !important;'>
                  <span>
                    <span style="font-size:1.1rem !important;font-weight:600 !important;">
                      <?php echo FETCH("SELECT * FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadSalutations"); ?>
                      <?php echo FETCH("SELECT * FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonFullname"); ?><br>
                      <span style="font-size:0.95rem !important;font-weight:500 !important;" class='text-info'>
                        <i class='fa fa-phone-square'></i> <?php echo FETCH("SELECT * FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonPhoneNumber"); ?>
                      </span>
                    </span><br>
                    <span class='text-danger bold h6'><?php echo $F->LeadFollowStatus; ?></span>
                    <br>
                    <?php if ($F->LeadFollowStatus == "Follow Up" or $F->LeadFollowStatus == "follow Up" || $F->LeadFollowStatus == "FollowUp" || $F->LeadFollowStatus == "FOLLOW-UP") { ?>
                      <?php if (DATE_FORMATES("d M, Y", $F->LeadFollowUpDate) != "No Update") { ?>
                        <span class='fs-11 text-grey'>
                          <?php echo $F->LeadFollowCurrentStatus; ?> @
                          <span class="text-success"><?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpDate); ?>
                            <?php echo $F->LeadFollowUpTime; ?>
                          </span>
                        </span>
                      <?php } ?>
                      <span class="text-grey">
                      <?php } else { ?>
                        <span class="text-grey"><?php echo $F->LeadFollowStatus; ?>
                        <?php } ?>
                        </span>
                      </span><br>
                      <span style="font-size:0.9rem;">
                        <span class="text-black"><?php echo $F->LeadFollowUpDescriptions; ?></span>
                        <br>
                        <i style="font-size:0.8rem;" class='text-warning pull-right'>By
                          <?php echo FETCH("SELECT * FROM users where UserId='" . $F->LeadFollowUpHandleBy . "'", "UserFullName"); ?> -
                          <?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $F->LeadFollowUpHandleBy . "'", "UserEmpJoinedId"); ?>
                        </i>
                      </span>
                  </span>
                </p>
              </li>
            </a>
        <?php
          }
        } else {
          NoData("No FollowUps or History Found!");
        } ?>
      </ul>
    </div>
  </div>
</div>
<?php if (AuthAppUser("UserType") == "Admin") { ?>
  <div class="row">
    <div class="col-md-12 mt-2">
      <h5 class="app-heading"> <i class="fa fa-history" aria-hidden="true"></i> User Call History</h5>
    </div>
    <div class="col-md-12 ">
      <?php $Users = _DB_COMMAND_("SELECT * FROM users, company_users where users.UserId=company_users.company_alloted_user_id and users.UserStatus='1' and company_users.company_main_id='" . CompanyId . "'", true);
      if ($Users != null) {
        foreach ($Users as $users) {

      ?>
          <div class="data-list bg-light">
            <div class="row">

              <div class="col-md-11">
                <div class="d-flex justify-content-between align-items-center pt-2 mb-0">
                  <div class=" col-md-3 shadow-none rounded-2 new-light-bg-color data-list m-1 mr-4">
                    <p class="mb-0 flex-s-b">
                      <a href="<?php echo APP_URL; ?>/teams/details/?uid=<?php echo SECURE($users->UserId, "e"); ?>" class="bold">
                        <span class='flex-s-b'>
                          <span class="w-pr-15">
                            <img src="<?php echo GetUserImage($users->UserId); ?>" class='img-fluid w-100'>
                          </span>
                          <span class="w-pr-85 pt-1 pl-1 lh-1-2">
                            <span class="lh-0-0">
                              <bold class="bold h6">
                                <?php echo StatusView(FETCH("SELECT UserStatus FROM users where UserId='$users->UserId'", "UserStatus")); ?>
                                <?php echo FETCH("SELECT UserSalutation FROM users where UserId='$users->UserId'", "UserSalutation"); ?>
                                <?php echo FETCH("SELECT UserFullName FROM users where UserId='$users->UserId'", "UserFullName"); ?>
                              </bold>
                              <br>
                              <span class="lh-0-0">
                                <?php echo FETCH("SELECT UserPhoneNumber FROM users where UserId='$users->UserId'", "UserPhoneNumber"); ?><br>
                                <?php echo FETCH("SELECT UserEmailId FROM users where UserId='$users->UserId'", "UserEmailId"); ?><br>
                                <span class="text-info"> <?php echo FETCH("SELECT UserType FROM users where UserId='$users->UserId'", "UserType"); ?></span>
                              </span>
                            </span>
                          </span>
                        </span>
                      </a>
                    </p>
                  </div>
                  <div class="col-md-2 shadow-none rounded-2 new-light-bg-color data-list m-1">
                    <div class="pt-3 mb-0 text-center">
                      <h5 class="fs-25 text-gray"><?php echo  TOTAL("SELECT LeadFollowUpId FROM lead_followups WHERE LeadFollowUpHandleBy='$users->UserId' AND DATE(LeadFollowUpUpdatedAt) = '" . date("Y-m-d") . "'");

                                                  ?></h5>
                      <p class="text-gray"> <i class="fa fa-phone text-success" aria-hidden="true"></i> TODAY CALLS</p>
                    </div>
                  </div>
                  <div class="col-md-2 shadow-none rounded-2 new-light-bg-color data-list m-1">
                    <div class="pt-3 mb-0 text-center">
                      <h5 class="fs-25 text-gray"><?php echo  $total = TOTAL("SELECT LeadFollowUpId FROM lead_followups WHERE LeadFollowUpHandleBy ='$users->UserId' AND LeadFollowUpUpdatedAt >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
                                                  ?></h5>
                      <p class="text-gray"> <i class="fa fa-phone text-success" aria-hidden="true"></i> WEEKLY CALLS</p>
                    </div>
                  </div>
                  <div class="col-md-2 shadow-none rounded-2 new-light-bg-color data-list m-1">
                    <div class="pt-3 mb-0 text-center">
                      <h5 class="fs-25 text-gray"><?php echo $total = TOTAL("SELECT LeadFollowUpId FROM lead_followups WHERE LeadFollowUpHandleBy ='$users->UserId' AND YEAR(LeadFollowUpUpdatedAt) = YEAR(CURDATE()) AND MONTH(LeadFollowUpUpdatedAt) = MONTH(CURDATE())");
                                                  ?></h5>
                      <p class="text-gray"> <i class="fa fa-phone text-success" aria-hidden="true"></i> MONTHLY CALLS</p>
                    </div>
                  </div>
                  <div class="col-md-3 shadow-none rounded-2 new-light-bg-color data-list m-1">
                    <div class="pt-3 mb-0 text-center">
                      <h5 class="fs-25 text-gray"><?php echo  TOTAL("SELECT LeadFollowUpId FROM lead_followups WHERE LeadFollowUpHandleBy='$users->UserId'"); ?></h5>
                      <p class="text-gray"><i class="fa fa-phone text-success" aria-hidden="true"></i> TOTAL CALLS</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
      <?php
        }
      }
      ?>

    </div>
  </div>
<?php } ?>