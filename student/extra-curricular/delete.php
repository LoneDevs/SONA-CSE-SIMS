<?php
session_start();

require '../../cleaninput.php';

if (isset($_SESSION['admnno'])) {
    if (isset($_GET['action'])) {
        if (strcmp($_GET['action'],"deleteTalent") === 0) {
            $msg = deleteStudentTalent($_GET['id']);
        }

        if (strcmp($_GET['action'], "deleteAchievement") === 0) {
            $msg = deleteStudentAchievement($_GET['id']);
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


function deleteStudentTalent($id)
{
    global $connection;

    $sql = "DELETE FROM student_extra_talents WHERE id = ? AND admission_number = '$_SESSION[admnno]'  ";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    if ($stmt->affected_rows === 0) {
        return "success";
    } else {
        return "failed";
    }
}

function deleteStudentAchievement($id)
{
    global $connection;

    $sql = "DELETE FROM student_extra_achievements WHERE id = ? AND admission_number = '$_SESSION[admnno]'  ";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    if ($stmt->affected_rows === 0) {
        return "success";
    } else {
        return "failed";
    }
}
