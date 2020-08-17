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


function fetchStudentClubs($admnno){
    global $connection;
    $response ="&nbsp"; 
    $count = 0;
    $sql = "SELECT * FROM student_co_clubs WHERE admission_number = '$admnno' ";
    $result = mysqli_query($connection,$sql);
    if (!$result) {
        return "Query Failed";
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $response .= '<div class="card">
    <div class="card-header" id="h' . $count . '">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#club' . $count . '" aria-expanded="true" aria-controls="club' . $count . '">
          ' .stripslashes($row['title']). '
        </button>
      </h2>
    </div>
        <div id="club' . $count . '" class="collapse show" aria-labelledby="heading' . $count . '" data-parent="#Clubs">
      <div class="card-body">
        <h5>Club : ' .stripslashes($row['club']). '</h5>
        <h5>Role : ' .stripslashes($row['role']). '</h5>
        <h5>Semester : ' .stripslashes($row['semester']) . '</h5>
        <h5>Description :</h5><p> ' .stripcslashes($row['description']) . '</p>
        <h5> Certificate or Prize : <a href="' . $row['certificate'] . '" target="_blank" ><u>View</u></a></h5>
          <small class="form-text text-muted"><a href="/student/co-curricular/clubs/delete.php?action=deleteClub&id=' . $row['id'] . '">Delete</a></small>
      </div>
    </div>
  </div>';
        $count++;
    }
    return $response;
}


function insertStudentClubActivity($admnno,$activity){
    global $connection;
    $sql = "INSERT INTO student_co_clubs (id, admission_number, club, title, role, semester, description, certificate ) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = $connection->prepare($sql);
    $id = generateRandomString($admnno);
    $stmt->bind_param("ssssssss",$id,$admnno,$activity['club'], $activity['title'], $activity['role'], $activity['semester'], $activity['description'], $activity['certificate']);

    if(!$stmt->execute()){
        return "Update Failed";
    }
    if ($stmt->affected_rows === 0) {
        return "Update Failed ! ";
    }
    return "success";
}