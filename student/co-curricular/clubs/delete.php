<?php
session_start();

require '../../../cleaninput.php';

if (isset($_SESSION['admnno'])) {
    if (isset($_GET['action'])) {
        if (strcmp($_GET['action'], "deleteClub") === 0) {
            $msg = deleteStudentClub(cleanInput($_GET['id']));
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


function deleteStudentClub($id)
{
    global $connection;
    $sql = "DELETE FROM student_co_clubs WHERE id = ? AND admission_number = '$_SESSION[admnno]'  ";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    if ($stmt->affected_rows === 0) {
        return "success";
    } else {
        return "failed";
    }
}


