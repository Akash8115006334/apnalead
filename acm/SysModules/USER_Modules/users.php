<?php
//get user address 
function UserFullAddress($CustomerId)
{
    $SQL = "SELECT * FROM user_addresses where UserAddressUserId='$CustomerId'";
    $UserStreetAddress = FETCH($SQL, "UserStreetAddress");
    $UserLocality = FETCH($SQL, "UserLocality");
    $UserCity = FETCH($SQL, "UserCity");
    $UserState = FETCH($SQL, "UserState");
    $UserCountry = FETCH($SQL, "UserCountry");
    $UserPincode = FETCH($SQL, "UserPincode");
    $UserAddressType = FETCH($SQL, "UserAddressType");

    $CompleteAddress = "($UserAddressType) <br> $UserStreetAddress $UserLocality $UserCity $UserState $UserCountry $UserPincode";

    return $CompleteAddress;
}
//user details
function GetUserDetails($UserId)
{
    $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserId='" . $UserId . "' ORDER BY UserFullName ASC", true);
    if ($AllUsers == null) {
        NoData("No Users found!");
    } else {
        foreach ($AllUsers as $User) {
            // echo "hii";
?>

            <label for="UserId34_<?php echo $User->UserId; ?>" class='record-data-65 m-b-3'>
                <div class="flex-s-b">
                    <div class="w-pr-25">
                        <img src="<?php echo GetUserImage($User->UserId); ?>" class="img-fluid">
                    </div>
                    <div class="text-left w-pr-75 pl-2">
                        <p class="mt-0">
                            <b class="h5 mt-0 m-t-0" style='font-weight:600 !important;'><?php echo $User->UserFullName; ?></b><br>
                            <span class="text-gray" style='font-weight:400 !important;'>
                                <span><?php echo $User->UserPhoneNumber; ?></span><br>
                                <span><?php echo $User->UserEmailId; ?></span><br>
                                <span>
                                    <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $User->UserId . "'"); ?></span>
                                    (<span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $User->UserId  . "'"); ?></span>)
                                    @
                                    <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpType", "UserMainUserId='" . $User->UserId  . "'"); ?></span>

                                </span>
                            </span>
                        </p>
                    </div>
                </div>
            </label>
<?php
        }
    }
}
