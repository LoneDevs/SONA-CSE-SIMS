<?php

require '../../dbconn.php';


function fetchStudentFamilyInfo($admnno)
{
    global $connection;

    $family_info = array("filled" => false, "family_members" => 0, "father_name" => "", "father_occupation" => "", "father_dob" => "", "father_sector" => "", "mother_name" => "", "mother_occupation" => "", "mother_dob" => "", "mother_sector" => "","mother_work_place"=>"","father_work_place"=>"","family_income"=>0,"no_of_siblings"=>0);
    $sql = "SELECT * FROM student_family WHERE admission_number = '$admnno' ";
    $result = mysqli_query($connection, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        foreach ($row as $key => $value) {
            $family_info[$key] = stripslashes($value);
        }
        $family_info['filled'] = true;
    }

    return $family_info;
}

function insertStudentFamilyInfo($family_info, $admnno)
{
    global $connection;

    $sql = "INSERT INTO student_family (admission_number,family_members,father_name,father_occupation,father_dob,father_sector,mother_name,mother_occupation,mother_dob,mother_sector,mother_work_place,father_work_place,family_income,no_of_siblings) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('sissssssssssii', $admnno, $family_info['family_members'], $family_info['father_name'], $family_info['father_occupation'], $family_info['father_dob'], $family_info['father_sector'], $family_info['mother_name'], $family_info['mother_occupation'], $family_info['mother_dob'], $family_info['mother_sector'],$family_info['mother_work_place'],$family_info['father_work_place'],$family_info['family_income'],$family_info['no_of_siblings']);
    $stmt->execute();
    if ($stmt->affected_rows === 0) {
        return "Error !".mysqli_error($connection);
    }else{
        return 'success';
    }
}

function updateStudentFamilyInfo($family_info,$admnno){
    global $connection;

    $sql = "UPDATE student_family set family_members = ?,father_name = ?,father_occupation = ?,father_dob = ?,father_sector = ?,mother_name = ?,mother_occupation = ?,mother_dob = ?,mother_sector = ?,mother_work_place = ?,father_work_place = ?,family_income = ?,no_of_siblings = ? WHERE admission_number = ? ";
    $stmt = $connection->prepare($sql);
    if($stmt === false)
    {echo mysqli_error($connection);}
    $stmt->bind_param('issssssssssiis',$family_info['family_members'], $family_info['father_name'], $family_info['father_occupation'], $family_info['father_dob'], $family_info['father_sector'], $family_info['mother_name'], $family_info['mother_occupation'], $family_info['mother_dob'], $family_info['mother_sector'],$family_info['mother_work_place'],$family_info['father_work_place'],$family_info['family_income'],$family_info['no_of_siblings'],$admnno);
    $stmt->execute();
    if ($stmt->affected_rows === 0) {
        return "No changes to update" . mysqli_error($connection);
    } else {
        return 'success';
    }

}

function generateRandomString($admnno)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    for ($i = 0; $i < 10; $i++) {
        $admnno .= $characters[rand(0, $charactersLength - 1)];
    }
    return $admnno;
}

function fetchStudentSiblingsInfo($admnno){
    global $connection;

    $response ='&nbsp';
    $sql = "SELECT * FROM student_siblings WHERE admission_number = '$admnno' ";
    $result = mysqli_query($connection,$sql);
    $count = 0;
    while($row = mysqli_fetch_assoc($result)){
        $response.= '
        <div class="card">
    <div class="card-header" id="h'.$count.'">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#sib'.$count.'" aria-expanded="true" aria-controls="sib'.$count.'">
          '.$row['name']. '
        </button>
      </h2>
    </div>
        <div id="sib'.$count.'" class="collapse show" aria-labelledby="heading'.$count.'" data-parent="#Siblings">
      <div class="card-body">
        Name : ' . $row['name'] . '<br>
        Relationship : ' . $row['relationship'] . '<br>
        Age : ' . $row['age'] . '<br>
        DOB : ' . $row['dob'] . '<br>
        Status : ' . $row['status'] . '<br>
        Associated with sona : ' . $row['associated_with_sona'] . '<br>
        <p>Description : ' . $row['description'] . '</p><br>
        <h5><a href="/student/family/delete.php?action=delete&id=' . $row['sibling_id'] . '"><u>Delete</u></a></h5>
      </div>
    </div>
  </div>
        
        ';
        $count++;
    }
    return $response;
}

function insertStudentSiblingInfo($sibling_info,$admnno){
    global $connection;

    $sql = "INSERT INTO student_siblings (sibling_id,admission_number,relationship,name,age,dob,status,associated_with_sona,description) VALUES (?,?,?,?,?,?,?,?,?) " ;
    $stmt = $connection->prepare($sql);
    if ($stmt === false) {
        return  mysqli_error($connection);
    }
    $sibling_id = generateRandomString($admnno);
    $bind = $stmt->bind_param("sssssssss",$sibling_id,$admnno,$sibling_info['relationship'], $sibling_info['name'], $sibling_info['age'], $sibling_info['dob'], $sibling_info['status'], $sibling_info['associated_with_sona'], $sibling_info['description']);
    if ($bind === false) {
        return  mysqli_error($connection);
    }
    $exec = $stmt->execute();
    if ($exec === false) {
        return  mysqli_error($connection);
    }
    if ($stmt->affected_rows === 0) {
        return "No changes to update !" . mysqli_error($connection);
    } else {
        return 'success';
    }
}

