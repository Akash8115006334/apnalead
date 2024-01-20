<?php

//start request processing
$UserID = AuthAppUser("UserId");
$MainCompanyId = FETCH("SELECT * FROM company_users WHERE company_alloted_user_id='$UserID'", "company_main_id");
$CompanyTableDetails = "SELECT * FROM config_companies WHERE company_id='$MainCompanyId'";
$ComapnyId = FETCH($CompanyTableDetails, "company_id");
if (isset($_POST['SaveNewProjects'])) {
    // inserting new project type


    if ($_POST['ProjectTypeId'] == "NEW") {


        $newData = [
            "ConfigValueGroupId" => 5,
            "ConfigValueDetails" => $_POST['ProjectType'],
            "CompanyID" => $ComapnyId,
        ];
        $NewProject = INSERT("config_values", $newData);
        $GetNewProjectId = _DB_COMMAND_("SELECT * FROM config_values ORDER BY ConfigValueId DESC LIMIT 1", true);
        foreach ($GetNewProjectId as $ProjectID) {
            $Project_Main_ID = $ProjectID->ConfigValueId;
        }
    } else {
        $Project_Main_ID = $_POST['ProjectTypeId'];
    }
    $data = array(
        "ProjectTypeId" => $Project_Main_ID,
        "ProjectName" => $_POST['ProjectName'],
        "ProjectDescriptions" => SECURE($_POST['ProjectDescriptions'], "e"),
        "ProjectCreatedAt" => CURRENT_DATE_TIME,
        "ProjectCreatedBy" => AuthAppUser("UserId"),
        "ProjectUpdatedAt" => CURRENT_DATE_TIME,
        "CompanyID" => $ComapnyId,
    );
    $SAVE = INSERT("projects", $data);
    RESPONSE($SAVE, "New Project Details are saved successfully!", "Unable to save new project details at the moment!");
    //remove project records
} elseif (isset($_GET['delete_project_records'])) {
    $access_url = SECURE($_GET['access_url'], "d");
    $delete_project_records = SECURE($_GET['delete_project_records'], "d");

    if ($delete_project_records == true) {
        $control_id = SECURE($_GET['control_id'], "d");
        $Delete = DELETE_FROM("projects", "ProjectsId='$control_id'");
    } else {
        $Delete = false;
    }

    RESPONSE($Delete, "Project Record deleted successfully", "Unable To remove project record at the moment!");

    //update projects details
} elseif (isset($_POST['UpdateProjectsDetails'])) {
    $ProjectsId = SECURE($_POST['ProjectsId'], "d");

    $DATA = array(
        "ProjectName" => $_POST['ProjectName'],
        "ProjectTypeId" => $_POST['ProjectTypeId'],
        "ProjectDescriptions" => SECURE($_POST['ProjectDescriptions'], "e"),
        "ProjectUpdatedAt" => CURRENT_DATE_TIME,
    );
    $Update = UPDATE_TABLE("projects", $DATA, "ProjectsId='$ProjectsId'");
    RESPONSE($Update, "Project Details Updated successfully!", "Unable to Update Project Details at the moment!");

    //uppload project media files
} elseif (isset($_POST['SaveProjectMediaFiles'])) {
    $ProjectMainId = SECURE($_POST['ProjectMainId'], "d");
    if ($_POST['ProjectMediaFileType'] == "u-links") {
        $ProjectMediaFileDocument = $_POST['ProjectMediaFileDocument'];
    } else {
        $ProjectMediaFileDocument = UPLOAD_FILES("../storage/projects/$ProjectMainId/media", "null", $_POST['ProjectMediaFileName'], "ProjectMediaFileDocument");
    }
    $data = array(
        "ProjectMainId" => SECURE($_POST['ProjectMainId'], "d"),
        "ProjectMediaFileName" => $_POST['ProjectMediaFileName'],
        "ProjectMediaFileType" => $_POST['ProjectMediaFileType'],
        "ProjectMediaFileDocument" => $ProjectMediaFileDocument
    );

    $Save = INSERT("project_media_files", $data);
    RESPONSE($Save, "Project Media Files are saved successfully!", "Unable to save project media files at the moment!");

    //remove project media files
} elseif (isset($_GET['remove_project_documents'])) {
    $access_url = SECURE($_GET['access_url'], "d");
    $remove_project_documents = SECURE($_GET['remove_project_documents'], "d");

    if ($remove_project_documents == true) {
        $control_id = SECURE($_GET['control_id'], "d");
        $Delete = DELETE_FROM("project_media_files", "ProjectMediaFileId='$control_id'");
    } else {
        $Delete = false;
    }
    RESPONSE($Delete, "Project Media Files deleted successfully!", "Unable to remove project media files at the moment!");
}
