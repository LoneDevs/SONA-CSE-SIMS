<?php

require 'dbconn.php';

function cleanInput($fieldvalue){
    global $connection;
    $fieldvalue=strip_tags($fieldvalue);
    return mysqli_escape_string($connection,$fieldvalue);
}
