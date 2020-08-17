<?php
session_start();

require '../../cleaninput.php';

if (isset($_SESSION['admnno'])) {
    if (isset($_GET['action'])) {
        $get_id = cleanInput($_GET['id']);
        $msg = deleteStudentSiblingInfo($get_id);
        if (strcmp($msg, "success")) {
            echo '<div class="alert alert-success" role="alert"> Deleted Successfully  ! </div>';
        } else {
            echo '<div class="alert alert-danger" role="alert"> Deletion Failed ! </div>';
        }
    }
} else {
    echo "<h1>Forbidden Access </h1>";
}



function deleteStudentSiblingInfo($id){
global $connection;

$sql = "DELETE FROM student_siblings WHERE sibling_id = ? AND admission_number = '$_SESSION[admnno]'  ";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s",$id);
$stmt->execute();
if($stmt->affected_rows === 0){
return "success";
}else{
return "failed";
}
}

?>