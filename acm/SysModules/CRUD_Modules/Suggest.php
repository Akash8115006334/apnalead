<?php
//Suggestion List
function SUGGEST($table = "false", $column, $order, $companyId = null, $enc = null)
{
   if ($table != "false") {
      if ($companyId == null) {
         $com = "";
      } else {
         $com = "WHERE CompanyID='$companyId'";
      }
      $CHECK_project_tags = CHECK("SELECT * FROM $table $com");
      if ($CHECK_project_tags != 0) {
         echo "<datalist id='$column'>";
         $SQL_project_tags = SELECT("SELECT * FROM $table $com GROUP by $column ORDER BY $column $order");
         while ($FetchTags = mysqli_fetch_array($SQL_project_tags)) {
            if ($enc == null) {
               echo "<option value='" . $FetchTags["$column"] . "'>";
            } else { ?>
               <option value='<?php echo SECURE($FetchTags["$column"], "$enc"); ?>'></option>
<?php }
         }
         echo "</datalist>";
      }
   } else {
   }
}

function SQL_SUGGEST($table = "false", $column)
{
   if ($table != "false") {
      $CHECK_project_tags = CHECK("$table");
      if ($CHECK_project_tags != 0) {
         echo "<datalist id='$column'>";
         $SQL_project_tags = SELECT("$table");
         while ($FetchTags = mysqli_fetch_array($SQL_project_tags)) {
            echo "<option value='" . $FetchTags["$column"] . "'>";
         }
         echo "</datalist>";
      }
   } else {
   }
}
