<?php

//Save Page details
// if (isset($_POST['CreateLeads']) or isset($_POST['SavePageDetails'])) 
if (isset($_POST['SavePageDetails'])) {
  if (isset($_POST['Autodistribute'])) {
    if ($_POST['Autodistribute'] != null) {
      $autodistribute = $_POST['Autodistribute'];
    } else {
      $autodistribute = "false";
    }
  } else {
    $autodistribute = "false";
  }

  $facebookAccountDetails = [
    "fb_page_name" => $_POST['fb_page_name'],
    "fb_adaccounts_id" => $_POST['fb_adaccounts_id'],
    "fb_campaigns_id" => $_POST['fb_campaigns_id'],
    "fb_campaigns_name" => $_POST['fb_campaigns_name'],
    "fb_adsets_id" => $_POST['fb_adsets_id'],
    "fb_adsets_name" => $_POST['fb_adsets_name'],
    "fb_ads_id" => $_POST['fb_ads_id'],
    "fb_ads_name" => $_POST['fb_ads_name'],
    "fb_access_token" => $_POST['fb_access_token'],
    "created_at" => CURRENT_DATE_TIME,
    "created_by" => AuthAppUser("UserId"),
    "updated_at" => CURRENT_DATE_TIME,
    "updated_by" => AuthAppUser("UserId"),
    "fb_access_token" => $_POST["fb_access_token"],
    "fb_project_Id" => $_POST["Project_Name"],
    "CompanyID" => CompanyId,
    "Autodistribute" => $autodistribute,
  ];
  $Save = INSERT("config_facebook_accounts", $facebookAccountDetails);
  RESPONSE($Save, "Facebook account details successfully saved", "Something went wrong! Please try again later");

  //update facebook account details
} elseif (isset($_POST['UpdateFacebookDetails'])) {
  $id = SECURE($_POST['id'], "d");
  if (isset($_POST['Autodistribute'])) {
    if ($_POST['Autodistribute'] != null) {
      $autodistribute = $_POST['Autodistribute'];
    } else {
      $autodistribute = "false";
    }
  } else {
    $autodistribute = "false";
  }

  $facebookAccountDetails = [
    "fb_page_name" => $_POST['fb_page_name'],
    "fb_adaccounts_id" => $_POST['fb_adaccounts_id'],
    "fb_campaigns_id" => $_POST['fb_campaigns_id'],
    "fb_campaigns_name" => $_POST['fb_campaigns_name'],
    "fb_adsets_id" => $_POST['fb_adsets_id'],
    "fb_adsets_name" => $_POST['fb_adsets_name'],
    "fb_ads_id" => $_POST['fb_ads_id'],
    "fb_ads_name" => $_POST['fb_ads_name'],
    "fb_access_token" => $_POST['fb_access_token'],
    "fb_project_Id" => $_POST["Project_Name"],
    "created_at" => CURRENT_DATE_TIME,
    "updated_at" => CURRENT_DATE_TIME,
    "updated_by" => AuthAppUser("UserId"),
    "Autodistribute" => $autodistribute,
  ];
  $Save = UPDATE_TABLE("config_facebook_accounts", $facebookAccountDetails, "id='$id'");
  RESPONSE($Save, "Facebook account details successfully updated!", "Something went wrong! Please try again later");

  //remove facebook account details
} elseif (isset($_GET['remove_facebook_pages'])) {
  DeleteReqHandler(
    "remove_facebook_pages",
    [
      "config_facebook_accounts" => "id='" . SECURE($_GET['control_id'], 'd') . "'",
    ],
    [
      "true" => "Facebook pages successfully removed!",
      "false" => "Unable to remove facebook pages! Please try again later",
    ]
  );
}
