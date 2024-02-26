<?php
//INsert new data
function INSERT($tablename, array  $RequestedData, $die = false, $ShowResults = false)
{
    $TableValues = "";
    $Datatables = "";

    $table_columns = array_keys($RequestedData);
    $arraycount = count($table_columns);
    $mainarray = $arraycount - 1;
    $countkeys = 0;

    if ($ShowResults == true) {
        echo "<br><b style='color:green;'>• REQUESTING </b> -> <b>[$tablename]</b> ---- <b style='color:green;'>Sent!</b> <br><b style='color:red'><i> Data Received</i></b> <b>[$tablename]</b> @ [<br>";
    }
    foreach ($RequestedData as $key => $data) {
        $countkeys++;
        $$data = $data;
        global $$data;
        if ($ShowResults == true) {
            echo "&nbsp;&nbsp; <b style='color:grey;'> Index:</b> $countkeys ( <b> " . $key . "</b> : " . $data . " ) <br>";
        }
        if ($countkeys <= $mainarray) {
            $TableValues .= "'" . htmlentities($data) . "', ";
        } else {
            $TableValues .= "'" . htmlentities($data) . "' ";
        }

        if ($countkeys <= $mainarray) {
            $Datatables .= "$key, ";
        } else {
            $Datatables .= "$key ";
        }
    }
    if ($ShowResults == true) {
        echo "]<br> ---<b style='color:primary;'>END</b><br><hr>---";
    }

    $InsertNewData = "INSERT INTO $tablename ($Datatables) VALUES ($TableValues)";
    //die entry
    if ($die == true) {
        die($InsertNewData);
    }
    $Query = mysqli_query(DBConnection, $InsertNewData);
    if ($Query == true) {
        return true;
    } else {
        return false;
    }
}
function entryExists($DataPhone, $companyId)
{
    $query = "SELECT COUNT(LeadsPhone) AS count FROM lead_uploads WHERE LeadsPhone = '$DataPhone' and CompanyID='$companyId'";
    $result = DBConnection->query($query);

    // Get the count from the result
    $count = $result->fetch_assoc()['count'];

    // If the count is greater than 0, the entry exists
    return $count > 0;
}
