<?php
//CONFIG data sql
function CONFIG_DATA_SQL($DATA_TYPE)
{
    global $DBConnection;
    $UserID = AuthAppUser("UserId");
    $MainCompanyId = FETCH("SELECT * FROM company_users WHERE company_alloted_user_id='$UserID'", "company_main_id");
    $CompanyTableDetails = "SELECT * FROM config_companies WHERE company_id='$MainCompanyId'";
    $companyId = FETCH($CompanyTableDetails, "company_id");


    $Sql = "SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='$DATA_TYPE' AND config_values.CompanyID='$companyId' ORDER BY ConfigValueId ASC";
    $mysqli_query = mysqli_query($DBConnection, $Sql);
    if ($mysqli_query == true) {
        return $Sql;
    } else {
        return false;
    }
}

//function get config valaus as option for select input
function CONFIG_VALUES($CONFIG_GROUP_NAME, $default = null)
{
    $leadStages = _DB_COMMAND_(CONFIG_DATA_SQL($CONFIG_GROUP_NAME), true);
    if ($leadStages != null) {
        foreach ($leadStages as $lstages) {
            if ($lstages->ConfigValueDetails == $default) {
                $selected = "selected";
            } else {
                $selected = "";
            }
            echo '<option value="' . $lstages->ConfigValueDetails . '"' . $selected . '>' . $lstages->ConfigValueDetails . '</option>';
        }
    } else {
        echo "<option value='Null'>No Data Found!</option>";
    }
}
