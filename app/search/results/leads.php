<div class="row">
  <div class="col-md-12">
    <?php
    if (AuthAppUser("UserType") == "Admin") {
      $LeadPersonManageBy = "";
    } else {
      $UserMainId = AuthAppUser("UserId");
      $LeadPersonManageBy = "And LeadPersonManagedBy='$UserMainId'";
    }
    $AllLeads = _DB_COMMAND_("SELECT * FROM leads WHERE CompanyID ='$companyid' $LeadPersonManageBy AND (LeadPersonEmailId LIKE '%$search%' OR LeadPersonPhoneNumber LIKE '%$search%' OR LeadPersonFullname LIKE '%$search%') ORDER BY LeadPersonFullname ASC", true);
    if ($AllLeads != null) { ?>
      <div class="shadow-sm p-1">
        <?php echo "<h2 class='app-sub-heading'><i class='fa fa-search'></i> Leads Search Results</h2>"; ?>
        <div class="row">
          <?php
          foreach ($AllLeads as $lead) {
          ?>
            <div class="data-list col-md-2 ml-4 m-1">
              <a href="<?php echo APP_URL; ?>/leads/details/?LeadsId=<?php echo SECURE($lead->LeadsId, "e"); ?>" class="text-primary bold">
                <b class="h6">
                  <?php echo $lead->LeadPersonFullname; ?>
                </b><br>
                <?php echo $lead->LeadPersonPhoneNumber; ?><br>
                <?php echo $lead->LeadPersonEmailId; ?>
              </a>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    <?php
    }
    ?>
  </div>
</div>