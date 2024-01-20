<?PHP
//file uploader and directory maker 
function UPLOAD_FILES($dir, $checkfile = false, $FilName, $NewFile, array $allowedfiles = null)
{

  $pre = str_replace(" ", "_", $FilName);
  $ref = "";

  //check if directory exists
  if ($checkfile == true) {
    if (file_exists("$dir/$checkfile")) {
      unlink("$dir/$checkfile");
    }
  }

  //check if directory exists
  if (!file_exists("$dir/")) {
    mkdir("$dir/", 0777, true);
  }

  //files allowed by default
  $Folder = "$dir/";
  $temp = explode(".", $_FILES["$NewFile"]["name"]);
  $Uploadedfile = $_FILES["$NewFile"]["name"];
  $UploadFileType = pathinfo($Uploadedfile, PATHINFO_EXTENSION);

  //check files allowed for upload
  if ($allowedfiles == null) {

    //files allowed by default
    $allowedfiles = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'zip', 'rar', 'gz', 'tar', '7z');

    //check files allowed for upload
    if (!in_array($UploadFileType, $allowedfiles)) {
      return false;

      //files allowed by default
    } else {
      $newfilename = "$pre" . "_" . $ref . "_" . date("d_M_Y_h_m_s_") . rand(0, 99999999999) . '_' . '.' . end($temp);
      move_uploaded_file($_FILES["$NewFile"]['tmp_name'], $Folder . $newfilename);
      return $newfilename;
    }

    //files allowed by user
  } else {

    //check files allowed for upload
    if (!in_array($UploadFileType, $allowedfiles)) {
      return false;

      //files allowed by default
    } else {
      $newfilename = "$pre" . "_" . $ref . "_" . date("d_M_Y_h_m_s_") . rand(0, 99999999999) . '_' . '.' . end($temp);
      move_uploaded_file($_FILES["$NewFile"]['tmp_name'], $Folder . $newfilename);
      return $newfilename;
    }
  }
}

//upload multiple files
function UPLOAD_MULTIPLE_FILES($path, $postfilename, $SaveIntoDBColumnName, $RelationColumnName, $RelationColumnNameId,  $AllowedFiles = "default")
{
  $total_count = count($_FILES["$postfilename"]['name']);
  for ($i = 0; $i < $total_count; $i++) {
    $UploadDir = $path;
    $WallPaperImageFile = $_FILES["$postfilename"]['name'][$i];
    $ProImageType = $_FILES["$postfilename"]['type'][$i];
    $ProImageSize = $_FILES["$postfilename"]['size'][$i];
    $ProImageTmpName = $_FILES["$postfilename"]['tmp_name'][$i];
    $ProImageExt = pathinfo($WallPaperImageFile, PATHINFO_EXTENSION);

    $WallPaperImageFile = $ProImageType . "_" . $ProImageSize . "_" . $i . date("d_m_Y_h_m_s_a_") . "." . $ProImageExt;
    $ProImagePath = $UploadDir . $WallPaperImageFile;

    //runn allowed files only
    if ($AllowedFiles == "default") {
      $AllowedFiles = array("jpb", "png", "jpeg", "gif", "pdf");
    } else {
      $AllowedFiles = $AllowedFiles;
    }

    //upload files if allowed
    if (in_array($AllowedFiles, $ProImageExt)) {
      if (!file_exists("$UploadDir/")) {
        mkdir("$UploadDir/", 0777, true);
      }
      move_uploaded_file($ProImageTmpName, $ProImagePath);

      $UploadFiles = array(
        "$RelationColumnName" => "$RelationColumnNameId",
        "$postfilename" => $WallPaperImageFile
      );
      $SaveImages = INSERT("$SaveIntoDBColumnName", $UploadFiles);
    } else {
      $SaveImages = false;
    }
  }

  return $SaveImages;
}
