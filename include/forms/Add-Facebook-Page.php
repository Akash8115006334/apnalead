<section class="pop-section hidden" id="Add-Facebook-Page">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Add New Facebook Page</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>/ModuleHandler.php" enctype="multipart/form-data" method="POST">
        <?php FormPrimaryInputs(true); ?>
        <div class="form-group col-md-5">
          <label>Facebook Page Name</label>
          <input type="text" name="fb_page_name" list="fb_page_name" class="form-control" required="">
        </div>
        <div class="form-group col-md-7">
          <label>Facebook AdAccount Id</label>
          <input type="text" name="fb_adaccounts_id" list="fb_adaccounts_id" class="form-control" required="">
        </div>
        <div class="form-group col-md-5">
          <label>Facebook Campaigns Id</label>
          <input type="text" name="fb_campaigns_id" list="fb_campaigns_id" class="form-control" required="">
        </div>
        <div class="form-group col-md-7">
          <label>Facebook Campaigns Name</label>
          <input type="text" name="fb_campaigns_name" list="fb_campaigns_name" class="form-control" required="">
        </div>
        <div class="form-group col-md-5">
          <label>Facebook Adsets Id</label>
          <input type="text" name="fb_adsets_id" list="fb_adsets_id" class="form-control" required="">
        </div>
        <div class="form-group col-md-7">
          <label>Facebook Adsets Name</label>
          <input type="text" name="fb_adsets_name" list="fb_adsets_name" class="form-control" required="">
        </div>
        <div class="form-group col-md-5">
          <label>Facebook AdsId </label>
          <input type="text" name="fb_ads_id" list="fb_ads_id" class="form-control" required="">
        </div>
        <div class="form-group col-md-7">
          <label>Facebook Ads Name</label>
          <input type="text" name="fb_ads_name" list="fb_ads_name" class="form-control" required="">
        </div>
        <div class="form-group col-md-5">
          <label>Choose Project</label>
          <select name="Project_Name" class="form-control form-control-sm">
            <option value="">Select Projects</option>
            <?php
            $companyID = CompanyId;
            $FetchProjectName = _DB_COMMAND_("SELECT * FROM projects where CompanyID='$companyID'", true);
            if ($FetchProjectName != null) {
              foreach ($FetchProjectName as $Project) {

            ?>
                <option value="<?php echo $Project->ProjectsId; ?>"><?php echo $Project->ProjectName; ?></option>
            <?php
              }
            } ?>
          </select>
        </div>
        <div class='form-check form-check-inline  flex col-md-5 ml-2'>
          <input class='form-check-input radio-list mt-0' type='checkbox' name='Autodistribute' value='true'>
          <h6 class='form-check-label fs-16 mb-0'>Check for Auto-Distribute</h6>
        </div>
        <div class="form-group col-md-12">
          <label>Facebook API Access Token</label>
          <input type="text" name="fb_access_token" list="fb_access_token" class="form-control" required="">
        </div>
        <div class=" col-md-12 text-right">
          <button type="submit" name="SavePageDetails" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Save Details</button>
          <a href="#" onclick="Databar('Add-Facebook-Page')" class="btn btn-sm btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>