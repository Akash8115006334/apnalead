<?php
//foreach loop html tag attribute display
function LOOP_TagsAttributes($data)
{
 foreach ($data as $key => $values) {
  echo "$key='$values'";
 }
}
