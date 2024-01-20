<?php

//Get location name
function UserLocation($UserId)
{
  $UserSql = "SELECT UserMainUserId, UserEmpLocations FROM user_employment_details where UserMainUserId='$UserId'";
  $CheckUserlocation = CHECK($UserSql);

  if ($CheckUserlocation != null) {
    $GetLocationId = FETCH($UserSql, "UserEmpLocations");
    $GetLocationName = FETCH("SELECT * FROM config_locations where config_location_id='$GetLocationId'", "config_location_name");
    $return = $GetLocationName;
  } else {
    $return = null;
  }

  return $return;
}

//get user empid 
function GetUserEmpid($UserId)
{

  $UserSql = "SELECT UserMainUserId, UserEmpJoinedId FROM user_employment_details where UserMainUserId='$UserId'";
  $CheckUserlocation = CHECK($UserSql);

  if ($CheckUserlocation != null) {
    $EmpCode = FETCH($UserSql, "UserEmpJoinedId");
    $return = $EmpCode;
  } else {
    $return = null;
  }

  return $return;
}

//function for get User Employement Details
function UserEmpDetails($UserId, $column_name)
{
  if ($UserId == null) {
    $FetchValue = FETCH("SELECT $column_name FROM user_employment_details where UserMainUserId='$UserId'", "$column_name");
  } else {
    $FetchValue = null;
  }
  return $FetchValue;
}

//user details
function UserDetails($UserId)
{
  $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserId='" . $UserId . "' ORDER BY UserFullName ASC", true);
  if ($AllUsers == null) {
    NoData("No Users found!");
  } else {
    foreach ($AllUsers as $User) {
?>
      <p>
        <span class="h6 mt-0"><?php echo $User->UserFullName; ?></span><br>
        <span class="text-gray small">
          <span><?php echo $User->UserPhoneNumber; ?></span><br>
          <span><?php echo $User->UserEmailId; ?></span><br>
          <span>
            <span class="text-gray"><?php echo UserEmpDetails($User->UserId, "UserEmpJoinedId"); ?></span>
          </span>
        </span>
      </p>
<?php
    }
  }
}
//user image
function GetUserImage($UserId, $default = false)
{
  $UserProfileImage = FETCH("SELECT UserProfileImage FROM users where UserId='$UserId'", "UserProfileImage");
  if ($UserProfileImage == "default.png") {
    $UserProfileImg = STORAGE_URL_D . "/default.png";
  } else {
    $FilePath = DOMAIN . "/storage/users/" . $UserId . "/img/" . $UserProfileImage;
    if (file_exists($FilePath)) {
      $UserProfileImg = STORAGE_URL_U . "/" . $UserId . "/img/" . $UserProfileImage;
    } else {
     // UPDATE("UPDATE users SET UserProfileImage='default.png' where UserId='$UserId'");
      $UserProfileImage = FETCH("SELECT UserProfileImage FROM users where UserId='$UserId'", "UserProfileImage");
      $UserProfileImg = STORAGE_URL_U . "/" . $UserId . "/img/" . $UserProfileImage;
    }
  }

  //load default image
  if ($default == true) {
    $UserProfileImg = STORAGE_URL_D . "/default.png";
  }

  //return results
  return $UserProfileImg;
}

//app users
function GetUserRecords($UserId, $require)
{
  if (empty($UserId)) {
    return null;
  } else {
    $CheckUsers = CHECK("SELECT * FROM users where UserId='$UserId'");
    if ($CheckUsers == null) {
      return null;
    } else {
      $GetData = FETCH("SELECT * FROM users where UserId='$UserId'", "$require");
      if ($require == "UserProfileImage") {
        if ($GetData == "user.png") {
          return STORAGE_URL_D . "/default.png";
        } else {
          return STORAGE_URL_U . "/$UserId/img/$GetData";
        }
      } else {
        return $GetData;
      }
    }
  }
}
