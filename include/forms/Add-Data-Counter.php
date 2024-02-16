<section class="pop-section hidden" id="Add-Counter">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Add New Counters</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST">
        <?php FormPrimaryInputs(true); ?>
        <input type="text" hidden id="leascurrentstatus" name="config_counter_secondary_search" value="">
        <div class='col-md-4 form-group'>
          <label>Counter Name <?php echo $req; ?></label>
          <input type="text" name="config_counter_name" class="form-control form-control-sm " required="">
        </div>
        <div class="form-group col-md-4">
          <label>Primary Select</label>
          <select class="form-control form-control-sm" name="config_counter_primary_search" id="statustype" onchange="CallStatusFunction()">
            <option value="">Select Status</option>
            <?php
            $UserID = AuthAppUser("UserId");
            $companyID = FETCH("SELECT * FROM company_users WHERE company_alloted_user_id='$UserID'", "company_main_id");

            $FetchCallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and config_values.CompanyID='$companyID' and configs.ConfigGroupName='CALL_STATUS' ORDER BY ConfigValueId DESC", true);
            if ($FetchCallStatus != null) {
              foreach ($FetchCallStatus as $CallStatus) { ?>
                <option value="<?php echo $CallStatus->ConfigValueDetails; ?>"><?php echo $CallStatus->ConfigValueDetails; ?></option>
            <?php
              }
            } ?>
          
          </select>
        </div>
        <div class='col-md-12 text-right'>
          <a onclick="Databar('Add-Counter')" class="btn btn-md btn-default mt-3 mr-3">Cancel</a>
          <button type="submit" name="SaveCounterDetails" class='btn btn-md btn-success'>Create Counter <i class='fa fa-check'></i></button>
        </div>
      </form>
    </div>
  </div>
</section>

<script>
  function CallStatusFunction() {
    var statustype = document.getElementById("statustype");
    <?php
    $FetchCallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and config_values.CompanyID='$companyID'  and configs.ConfigGroupName='CALL_STATUS' ORDER BY ConfigValueId DESC", true);
    if ($FetchCallStatus != null) {
      foreach ($FetchCallStatus as $CallStatus) { ?>
        if (statustype.value == <?php echo $CallStatus->ConfigValueId; ?>) {
          document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>").style.display = "block";
        } else {
          document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>").style.display = "none";
        }
    <?php }
    } ?>
  }
</script>