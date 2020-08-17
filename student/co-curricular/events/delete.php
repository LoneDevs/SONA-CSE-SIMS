<?php
session_start();

require '../../../cleaninput.php';

if (isset($_SESSION['admnno'])) {
    if (isset($_GET['action'])) {
        if (strcmp($_GET['action'], "deleteIntra") === 0) {
            $msg = deleteStudentIntraActivity(cleanInput($_GET['id']));
        }

        if (strcmp($_GET['action'], "deleteInter") === 0) {
            $msg = deleteStudentInterActivity(cleanInput($_GET['id']));
        }

        if (strcmp($msg, "success")) {
            echo ' <h1>Deleted Successfully !</h1>';
        } else {
            echo '<h1>Deletion Failed !</h1>';
        }
    }
} else {
    echo "<h1>Forbidden Access </h1>";
}


function deleteStudentIntraActivity($id)
{
    global $connection;
    $sql = "DELETE FROM student_co_intra_college_events WHERE id = ? AND admission_number = '$_SESSION[admnno]'  ";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    if ($stmt->affected_rows === 0) {
        return "success";
    } else {
        return "failed";
    }
}

function deleteStudentInterActivity($id)
{
    global $connection;
    $sql = "DELETE FROM student_co_inter_college_events WHERE id = ? AND admission_number = '$_SESSION[admnno]'  ";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    if ($stmt->affected_rows === 0) {
        return "success";
    } else {
        return "failed";
    }
}
