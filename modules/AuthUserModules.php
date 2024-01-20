<?php

/**
 * @SystemUserModule
 */

//app users
function AuthAppUser($require)
{
    $UserId = $_SESSION['APP_LOGIN_USER_ID'];
    if (empty($UserId)) {
        return null;
    } else {
        $CheckUsers = CHECK("SELECT * FROM users where UserId='$UserId'");
        if ($CheckUsers == null) {
            return null;
        } else {
            $GetData = FETCH("SELECT * FROM users where UserId='$UserId'", "$require");
            if ($require == "UserProfileImage") {
                if ($GetData == "user.png" || $GetData == "") {
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
//user address
function UserAddress($UserId, $ColumnName)
{
    $CheckUsers = CHECK("SELECT * FROM user_addresses where MainUserId='$UserId'");
    if ($CheckUsers == null) {
        return null;
    } else {
        $GetData = FETCH("SELECT * FROM user_addresses where MainUserId='$UserId'", "$ColumnName");
        if ($GetData == null) {
            return 'NA';
        } else {
            return $GetData;
        }
    }
}
