<?php

require '../../../dbconn.php';

function generateRandomString($admnno)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    for ($i = 0; $i < 10; $i++) {
        $admnno .= $characters[rand(0, $charactersLength - 1)];
    }
    return $admnno;
}


function fetchStudentIntraActivities($admnno)
{
    global $connection;
    $response = "&nbsp";
    $count = 0;
    $sql = "SELECT * FROM student_co_intra_college_events WHERE admission_number = '$admnno' ";
    $result = mysqli_query($connection, $sql);
    if (!$result) {
        return "Query Failed";
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $response .= '<div class="card">
    <div class="card-header" id="h' . $count . '">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#intra' . $count . '" aria-expanded="true" aria-controls="intra' . $count . '">
          ' . stripslashes($row['title']) . '
        </button>
      </h2>
    </div>
        <div id="intra' . $count . '" class="collapse show" aria-labelledby="heading' . $count . '" data-parent="#IntraActs">
      <div class="card-body">
        <h5>Title : ' . stripslashes($row['title']) . '</h5>
        <h5><p>Description : </h5> <p>' . stripcslashes($row['description']) . '</p>
        <h5>Role : ' . stripslashes($row['role']) . '</h5>
        <h5>Semester : ' . stripslashes($row['semester']) . '</h5>
        <h5> Certificate or Prize : <a href="' . $row['certificate'] . '" target="_blank" ><u>View</u></a></h5>
          <small class="form-text text-muted"><a href="/student/co-curricular/events/delete.php?action=deleteIntra&id=' . $row['id'] . '">Delete</a></small>
      </div>
    </div>
  </div>';
        $count++;
    }
    return $response;
}


function insertStudentIntraActivity($admnno, $activity)
{
    global $connection;
    $sql = "INSERT INTO student_co_intra_college_events (id, admission_number,title,role,semester, description, certificate ) VALUES (?,?,?,?,?,?,?)";
    $stmt = $connection->prepare($sql);
    $id = generateRandomString($admnno);
    $stmt->bind_param("sssssss", $id, $admnno,$activity['title'],$activity['role'], $activity['semester'], $activity['description'], $activity['certificate']);

    if (!$stmt->execute()) {
        return "Update Failed !";
    }
    if ($stmt->affected_rows === 0) {
        return "Update Failed ! ";
    }
    return "success";
}



function fetchStudentInterActivities($admnno)
{
    global $connection;
    $response = "&nbsp";
    $count = 0;
    $sql = "SELECT * FROM student_co_inter_college_events WHERE admission_number = '$admnno' ";
    $result = mysqli_query($connection, $sql);
    if (!$result) {
        return "Query Failed";
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $response .= '<div class="card">
    <div class="card-header" id="h' . $count . '">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#inter' . $count . '" aria-expanded="true" aria-controls="inter' . $count . '">
          ' . stripslashes($row['title']) . '
        </button>
      </h2>
    </div>
        <div id="inter' . $count . '" class="collapse show" aria-labelledby="heading' . $count . '" data-parent="#InterActs">
      <div class="card-body">
        <h5>Title : ' . stripslashes($row['title']) . '</h5>
        <h5>Description :</h5> <p> ' . stripcslashes($row['description']) . '</p>
        <h5>Instituition Name : ' . stripslashes($row['instituition_name']) . '</h5>
        <h5>Instituition Place : ' . stripslashes($row['instituition_place']) . '</h5>
        <h5>Semester : ' . stripslashes($row['semester']) . '</h5>
        <h5> Certificate or Prize : <a href="' . $row['certificate'] . '" target="_blank" ><u>View</u></a></h5>
          <small class="form-text text-muted"><a href="/student/co-curricular/events/delete.php?action=deleteInter&id=' . $row['id'] . '">Delete</a></small>
      </div>
    </div>
  </div>';
        $count++;
    }
    return $response;
}


function insertStudentInterActivity($admnno, $activity)
{
    global $connection;
    $sql = "INSERT INTO student_co_inter_college_events (id, admission_number,title,instituition_name,instituition_place,semester, description, certificate ) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = $connection->prepare($sql);
    if ($stmt === false) {
        return "Error".mysqli_error($connection);
    }
    
    $id = generateRandomString($admnno);
    $bind = $stmt->bind_param("ssssssss", $id, $admnno, $activity['title'], $activity['instituition_name'], $activity['instituition_place'], $activity['semester'], $activity['description'], $activity['certificate']);
    if ($bind === false) {
        return "Bind Error" . mysqli_error($connection);
    }
    if (!$stmt->execute()) {
        return "Execution Failed !".mysqli_error($connection);
    }
    if ($stmt->affected_rows === 0) {
        return "Update Failed ! ";
    }
    return "success";
}
