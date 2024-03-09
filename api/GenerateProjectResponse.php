<?php
require __DIR__ . "/../acm/SysFileAutoLoader.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['GetProjectOptions'])) {
  // Assuming you expect the ProjectFroAuthenticationKey as a query parameter
  $ProjectFroAuthenticationKey = $_GET['ProjectFroAuthenticationKey'];
  $CompanyMainId = FETCH("SELECT CompanyMainId FROM encripted_companies where Enc_CompanyMainId='$ProjectFroAuthenticationKey'", "CompanyMainId");

  // Fetch projects
  $Projects = "";

  $AllProjects = _DB_COMMAND_("SELECT * FROM projects where CompanyID='$CompanyMainId'", true);
  if ($AllProjects != NULL) {
    foreach ($AllProjects as $Project) {
      $Projects .= "<option value='" . $Project->ProjectsId . "'>" . $Project->ProjectName . "</option>";
    }
  } else {
    $Projects .= "<option value='0'>No Project Found!</option>";
  }

  echo $Projects;
} else {
  // Handle other cases (e.g., unsupported methods or missing parameters)
  http_response_code(400); // Bad Request
  echo json_encode(['error' => 'Invalid request']);
}
