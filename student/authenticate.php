<?php
require '../dbconn.php';

    function authenticateStudent($email,$password)
    {
        global $connection;
        $details =array();
        $sql = "SELECT * FROM student_primary WHERE email = ? ";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        $stmt->close();
        if (isset($row['admission_number'])) {
            $pwd_hash = $row['password'];
            if(password_verify($password,$pwd_hash)){
                $details['message'] = "success";
                $details['admnno'] = $row['admission_number'];
                $details['name'] = $row['name'];
                $details['image'] = $row['image'];

                return $details ;
            }else {
                $details['message'] = 'Incorrect Password !';
                return $details;

            }
        }else{
           $details['message'] = 'Email does not exist !';
           return $details;

        }
    }

    function studentPasswordReset($admnno,$current_password,$new_password){
        global $connection;
        $result = mysqli_query($connection,"SELECT password FROM student_primary WHERE admission_number = '$admnno' ");
        $row =  mysqli_fetch_assoc($result);
        if (password_verify($current_password,$row['password'])) {
            $password = password_hash($new_password,PASSWORD_BCRYPT);
            $stmt=$connection->prepare("UPDATE student_primary SET password = ? WHERE admission_number = ? ");
            $stmt->bind_param("ss",$password,$admnno);
            $stmt->execute();
            $stmt->close();
            return 'success';
        } else {
            return 'Incorrect Old Password !';
        }
        
        
    }

    function studentForgotPasswordReset($selector,$validator,$newpassword){
        global $connection;

        $currentTime = time();

        $sql = "SELECT * FROM student_reset_passwords WHERE reset_selector = ? AND reset_expires >= ? ";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ss",$selector,$currentTime);
        $stmt->execute();

        $result = $stmt->get_result();

        if (!$row = mysqli_fetch_assoc($result)) {
            return "Token has expired !";
            $stmt->close();
        }else{

            $tokenBin = hex2bin($validator);
            if (password_verify($tokenBin,$row['reset_token']) === true) {
                $useremail = $row['reset_email'];
                $hashedPassword = password_hash($newpassword,PASSWORD_BCRYPT);
                $sql = "UPDATE student_primary set password = ? WHERE email = ? ";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param("ss",$hashedPassword,$useremail);
                $stmt->execute();
                $stmt->close();

                return "success";

            }else{
                return "Invalid Reset Token ! ";
            }            
        }


    }
    
    function generateRandomString() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i <20; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;

}
    
function studentImageUpload($admnno, $imageName, $path)
{
    global $connection;
    $newImageName = $admnno . md5(generateRandomString()) . md5(generateRandomString()) . '.jpg';
    if (strcmp($imageName, "default.jpg") !== 0) {
        $delete_image = $path.$imageName;
        unlink($delete_image);
    }
    $sql = "UPDATE student_primary SET image = '$newImageName' WHERE admission_number = '$admnno' ";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $_SESSION['image'] = $newImageName;
        return $newImageName;
    } else {
        return "failed";
    }
}