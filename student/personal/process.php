<?php
require '../../dbconn.php';

function fetchStudentPersonalInfo($admnno)
{
    global $connection;
    $personal_info = array(
        "filled" => false, "admission_no" => "", "reg_no" => "", "section" => "A", "first_name" => "", "last_name" => "", "dob" => "2000-01-01", "age" => "", "height_cm" => "", "weight_kg" => "",
        "blood_group" => "A +ve", "identification_marks" => "", "communication_address" => "", "permanent_address" => "", "district" => "", "state" => "", "country" => "", "pincode" => "",
        "student_phone" => "", "mother_phone" => "", "father_phone" => "", "residential_phone" => "", "hosteller" => "no", "local_guardian_name" => "NA", "local_guardian_address" => "NA",
        "local_guardian_phone" => "NA", "community" => "", "caste" => "", "religion" => "", "mode_of_transport" => "NA", "mother_tongue" => "", "known_languages" => ""
    );
    $sql = "SELECT * FROM student_personal WHERE admission_number = ? ";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('s', $admnno);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        foreach ($row as $key => $value) {
            $personal_info[$key] = stripslashes($value);
        }
        $personal_info['filled'] = true;
    }
    return $personal_info;
}

function insertStudentPersonalInfo($personal_info, $admnno)
{
    global $connection;
    $sql = "INSERT INTO student_personal (admission_number,reg_no,section,first_name,last_name,dob,age,height_cm,weight_kg,blood_group,identification_marks,communication_address,
            permanent_address,district,state,country,pincode,student_phone,mother_phone,father_phone,residential_phone,hosteller,local_guardian_name,local_guardian_address,local_guardian_phone,
            community,caste,religion,mode_of_transport,mother_tongue,known_languages) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param(
        'sssssssssssssssssssssssssssssss',
        $admnno,
        $personal_info['reg_no'],
        $personal_info['section'],
        $personal_info['first_name'],
        $personal_info['last_name'],
        $personal_info['dob'],
        $personal_info['age'],
        $personal_info['height_cm'],
        $personal_info['weight_kg'],
        $personal_info['blood_group'],
        $personal_info['identification_marks'],
        $personal_info['communication_address'],
        $personal_info['permanent_address'],
        $personal_info['district'],
        $personal_info['state'],
        $personal_info['country'],
        $personal_info['pincode'],
        $personal_info['student_phone'],
        $personal_info['mother_phone'],
        $personal_info['father_phone'],
        $personal_info['residential_phone'],
        $personal_info['hosteller'],
        $personal_info['local_guardian_name'],
        $personal_info['local_guardian_address'],
        $personal_info['local_guardian_phone'],
        $personal_info['community'],
        $personal_info['caste'],
        $personal_info['religion'],
        $personal_info['mode_of_transport'],
        $personal_info['mother_tongue'],
        $personal_info['known_languages']
    );

    $stmt->execute();
    $stmt->close();
    if ($stmt->affected_rows === 0) {
        return mysqli_error($connection);
    } else {
        return "success";
    }
}


function updateStudentPersonalInfo($personal_info, $admnno)
{
    global $connection;
    $sql = "UPDATE student_personal SET reg_no = ?,section = ?,first_name = ?,last_name = ?,dob = ?,age = ?,height_cm = ?,weight_kg = ? ,blood_group = ? ,identification_marks = ? ,communication_address = ? ,
            permanent_address = ? ,district = ? ,state = ? ,country = ? ,pincode = ? ,student_phone = ? ,mother_phone = ? ,father_phone = ? ,residential_phone = ? ,hosteller = ? ,local_guardian_name = ? ,local_guardian_address = ? ,local_guardian_phone = ? ,
            community = ? ,caste = ? ,religion = ? ,mode_of_transport = ? ,mother_tongue = ? ,known_languages = ?  WHERE admission_number = ? ";
    $stmt = $connection->prepare($sql);
    if ($stmt == false) {
        return "Error preparing stmt ! ".mysqli_error($connection);
    }
    $bind = $stmt->bind_param(
        'sssssssssssssssssssssssssssssss',
        $personal_info['reg_no'],
        $personal_info['section'],
        $personal_info['first_name'],
        $personal_info['last_name'],
        $personal_info['dob'],
        $personal_info['age'],
        $personal_info['height_cm'],
        $personal_info['weight_kg'],
        $personal_info['blood_group'],
        $personal_info['identification_marks'],
        $personal_info['communication_address'],
        $personal_info['permanent_address'],
        $personal_info['district'],
        $personal_info['state'],
        $personal_info['country'],
        $personal_info['pincode'],
        $personal_info['student_phone'],
        $personal_info['mother_phone'],
        $personal_info['father_phone'],
        $personal_info['residential_phone'],
        $personal_info['hosteller'],
        $personal_info['local_guardian_name'],
        $personal_info['local_guardian_address'],
        $personal_info['local_guardian_phone'],
        $personal_info['community'],
        $personal_info['caste'],
        $personal_info['religion'],
        $personal_info['mode_of_transport'],
        $personal_info['mother_tongue'],
        $personal_info['known_languages'],
        $admnno
    );
    if ($bind == false) {
        return "Error binding param ! ".mysqli_error($connection);
    }
    if(!$stmt->execute()){
        return "Error executing ! ".mysqli_error($connection);
    }
    if ($stmt->affected_rows === 0) {
        return "No changes To Update ! ".mysqli_error($connection);
    } else {
        return "success";
    }
}
