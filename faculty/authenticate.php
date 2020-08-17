<?php
require '../dbconn.php';
function authenticateFaculty($email,$password){
    global $connection;
    $details = array();
    $sql = "SELECT * FROM faculty_primary WHERE email = ? ";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_assoc($result);
    $stmt->close();
    if (isset($row['id'])) {
        $pwd_hash = $row['password'];
        if (password_verify($password, $pwd_hash)) {
            $details['message'] = "success";
            $details['id'] = $row['id'];
            $details['name'] = $row['name'];

            return $details;
        } else {
            $details['message'] = 'Incorrect Password !';
            return $details;
        }
    } else {
        $details['message'] = 'User does not exist !';
        return $details;
    }
}


function facultyPasswordReset($id, $current_password, $new_password)
{
    global $connection;
    $result = mysqli_query($connection, "SELECT password FROM faculty_primary WHERE id = '$id' ");
    $row =  mysqli_fetch_assoc($result);
    if (password_verify($current_password, $row['password'])) {
        $password = password_hash($new_password, PASSWORD_BCRYPT);
        $stmt = $connection->prepare("UPDATE faculty_primary SET password = ? WHERE id = ? ");
        $stmt->bind_param("ss", $password, $id);
        $stmt->execute();
        $stmt->close();
        return 'success';
    } else {
        return 'Incorrect Old Password !';
    }
}