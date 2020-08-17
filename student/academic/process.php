<?php
require '../../dbconn.php';

function fetchStudentAcademicInfo($admnno)
{
    global $connection;
    $academic_info = array("filled" => false, "lateral_entry" => "No", "admission" => "SWS", "tenth_school_name" => "", "tenth_school_place" => "", "tenth_school_place" => "", "tenth_board" => "", "tenth_medium" => "", "tenth_completion_year" => "", "tenth_marks" => "", "hsc_instituition_name" => "NA", "hsc_instituition_place" => "NA", "hsc_board" => "NA", "hsc_medium" => "NA", "hsc_completion_year" => "2000", "hsc_group" => "NA", "hsc_marks" => "0", "diploma_instituition_name" => "NA", "diploma_instituition_place" => "NA", "diploma_degree" => "NA", "diploma_department" => "NA", "diploma_completion_year" => "0000", "diploma_percentage" => "0");
    $sql = "SELECT * FROM student_academic WHERE admission_number = '$admnno' ";
    $result = mysqli_query($connection, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $academic_info['filled'] = true;
        foreach ($row as $key => $value) {
            $academic_info[$key] = stripslashes($value);
        }
    }
    return $academic_info;
}

function insertStudentAcademicInfo($admnno, $academic)
{
    global $connection;
    $sql = "INSERT INTO student_academic (admission_number,admission,tenth_school_name,tenth_school_place,tenth_board,tenth_medium,tenth_completion_year,tenth_marks,lateral_entry,hsc_instituition_name,hsc_instituition_place,hsc_board,hsc_medium,hsc_completion_year,hsc_marks,hsc_group,diploma_instituition_name,diploma_instituition_place,diploma_degree,diploma_department,diploma_completion_year,diploma_percentage) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
    $stmt = $connection->prepare($sql);
    $bind = $stmt->bind_param("ssssssssssssssssssssss", $admnno, $academic['admission'], $academic['tenth_school_name'], $academic['tenth_school_place'], $academic['tenth_board'], $academic['tenth_medium'], $academic['tenth_completion_year'], $academic['tenth_marks'], $academic['lateral_entry'], $academic['hsc_instituition_name'], $academic['hsc_instituition_place'], $academic['hsc_board'], $academic['hsc_medium'], $academic['hsc_completion_year'], $academic['hsc_marks'], $academic['hsc_group'], $academic['diploma_instituition_name'], $academic['diploma_instituition_place'], $academic['diploma_degree'], $academic['diploma_department'], $academic['diploma_completion_year'], $academic['diploma_percentage']);
    if (!$bind) {
        return mysqli_error($connection);
    }
    if(!$stmt->execute()){
        return "Query Execution Failed ".mysqli_error($connection);
    }
    if($stmt->affected_rows === 0){
        return "Update Failed".mysqli_error($connection);
    }
    return "success";
}


function updateStudentAcademicInfo($admnno,$academic){
    global $connection;
    $sql = "UPDATE student_academic SET admission = ?,tenth_school_name = ?,tenth_school_place = ?,tenth_board = ?,tenth_medium = ?,tenth_completion_year = ?,tenth_marks = ?,lateral_entry = ?,hsc_instituition_name = ?,hsc_instituition_place = ?,hsc_board = ?,hsc_medium = ?,hsc_completion_year = ?,hsc_marks = ?,hsc_group = ?,diploma_instituition_name = ?,diploma_instituition_place = ?,diploma_degree = ?,diploma_department = ?,diploma_completion_year = ?,diploma_percentage = ? WHERE admission_number = ? ";
    $stmt = $connection->prepare($sql);
    $bind = $stmt->bind_param("ssssssssssssssssssssss",$academic['admission'], $academic['tenth_school_name'], $academic['tenth_school_place'], $academic['tenth_board'], $academic['tenth_medium'], $academic['tenth_completion_year'], $academic['tenth_marks'], $academic['lateral_entry'], $academic['hsc_instituition_name'], $academic['hsc_instituition_place'], $academic['hsc_board'], $academic['hsc_medium'], $academic['hsc_completion_year'], $academic['hsc_marks'], $academic['hsc_group'], $academic['diploma_instituition_name'], $academic['diploma_instituition_place'], $academic['diploma_degree'], $academic['diploma_department'], $academic['diploma_completion_year'], $academic['diploma_percentage'],$admnno);
    if (!$bind) {
        return mysqli_error($connection);
    }
    if (!$stmt->execute()) {
        return "Query Execution Failed " . mysqli_error($connection);
    }
    if ($stmt->affected_rows === 0) {
        return "No changes to update !" . mysqli_error($connection);
    }
    return "success";
}

function fetchStudentGPA($admnno){
    global $connection;
    $sql = "SELECT * FROM student_gpa WHERE admission_number = '$admnno' ";
    $result = mysqli_query($connection,$sql);
    if (!$result) {
        return "Query failed";
    }
    while ($row = mysqli_fetch_assoc($result)) {
        return $row;
    }
    return "Failed !";
}

function updateStudentGPA($admnno,$gpa){
    global $connection;
    $sql = "UPDATE student_gpa SET semester1 = ?,semester2 = ?,semester3 = ?,semester4 = ?,semester5 = ?,semester6 = ?,semester7 = ?,semester8 = ? WHERE admission_number = ? " ;
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssssssss",$gpa['semester1'], $gpa['semester2'], $gpa['semester3'], $gpa['semester4'], $gpa['semester5'], $gpa['semester6'], $gpa['semester7'], $gpa['semester8'],$admnno);
    if (!$stmt->execute()) {
        return "Execution Failed !";
    }else{
        return "success";
    }
}

