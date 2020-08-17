<?php

require '../../../dbconn.php';

function fetchStudentCourses($admnno){
    global $connection;
    $response = '&nbsp';
    $count = 0;
    $sql = "SELECT * FROM student_co_courses WHERE admission_number = '$admnno' ";
    $result = mysqli_query($connection,$sql);
    if (!$result) {
        return "DB Error !";
    }
    while ($row = mysqli_fetch_assoc($result)) {

        $response .= '<div class="card">
    <div class="card-header" id="h' . $count . '">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#cou' . $count . '" aria-expanded="true" aria-controls="cou' . $count . '">
          ' .stripslashes($row['title']). '
        </button>
      </h2>
    </div>
        <div id="cou' . $count . '" class="collapse show" aria-labelledby="heading' . $count . '" data-parent="#Courses">
      <div class="card-body">
        <h5>Title : ' .stripslashes($row['title']). '</h5>
        <h5>Description :</h5> <p>' .stripslashes($row['description']) . '</p>
        <h5>Semester : ' .stripslashes($row['semester']) . '</h5>
        <h5>Mode : ' .stripslashes($row['mode']) . '</h5>
        <h5>Instituition : ' .stripslashes($row['instituition']). '</h5>
        <h5>Domain : ' .stripslashes($row['domain']) . '</h5>
        <h5> Certificate or Prize : <a href="' . $row['certificate'] . '" target="_blank" ><u>View</u></a></h5>
          <small class="form-text text-muted"><a href="/student/co-curricular/courses/delete.php?action=deleteCourse&id=' . $row['id'] . '">Delete</a></small>
      </div>
    </div>
  </div>';
        $count++;

    }

    return $response ;
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


function insertStudentCourse($admnno,$course){
    global $connection;

    $sql = "INSERT INTO student_co_courses (id, admission_number, title, description, semester, mode, instituition, domain, certificate ) VALUES (?,?,?,?,?,?,?,?,?) ";
    $id = generateRandomString($admnno);
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssssssss",$id,$admnno,$course['title'], $course['description'], $course['semester'], $course['mode'], $course['instituition'], $course['domain'], $course['certificate']);
    if(!$stmt->execute()){
        return "Update Failed !";
    }

    if ($stmt->affected_rows === 0) {
        return "Update Failed !";
    }

    return "success" ;

}