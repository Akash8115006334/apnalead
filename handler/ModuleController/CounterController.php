<?php

//start processing
if (isset($_POST['SaveCounterDetails'])) {
  // die($_POST['config_counter_primary_search']);


  $UserID = AuthAppUser("UserId");
  $companyID = FETCH("SELECT * FROM company_users WHERE company_alloted_user_id='$UserID'", "company_main_id");
  $config_lead_counters = [
    "config_counter_name" => $_POST['config_counter_name'],
    "config_counter_primary_search" => $_POST['config_counter_primary_search'],
    "CompanyID" =>   $companyID,
  ];

  $Save = INSERT("config_lead_counters", $config_lead_counters);
  RESPONSE($Save, "New data counter created successfully!", "Unable to create new data counter!");

  //remove counters
} elseif (isset($_GET['remove_data_counters'])) {
  DeleteReqHandler("remove_data_counters", [
    "config_lead_counters" => "config_lead_counter_id='" . SECURE($_GET['control_id'], "d") . "'",
  ], [
    "true" => "Counter removed successfully",
    "false" => "Unable to remove counter at the moment!"
  ]);
}
