<?php

require '../../dbconn.php';

function fetchStudentTalents($admnno){
    global $connection;
    $response ='&nbsp';$count=0;
    $sql = "SELECT * FROM student_extra_talents WHERE admission_number = '$admnno'";
    $result = mysqli_query($connection,$sql);
    if(!$result){
        return "DB error !";
    }
    while ($row = mysqli_fetch_assoc($result)) {
        
    $response.='<div class="card">
    <div class="card-header" id="h'.$count.'">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#tal'.$count.'" aria-expanded="true" aria-controls="tal'.$count.'">
          '.stripslashes($row['title']). '
        </button>
      </h2>
    </div>
        <div id="tal'.$count.'" class="collapse show" aria-labelledby="heading'.$count.'" data-parent="#Talents">
      <div class="card-body">
        <h5>Title : ' . stripslashes($row['title']) . '</h5>
        <h5>Description : </h5> <p>' .stripslashes($row['description']). '</p>
        <h5>Talent - Video : <a href="'.$row['url']. '" target="_blank" ><u>View</u></a></h5>
          <small class="form-text text-muted"><a href="/student/extra-curricular/delete.php?action=deleteTalent&id=' . $row['id'] . '">Delete</a></small>
      </div>
    </div>
  </div>';
  $count++;
    }

    return $response;

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

function insertStudentTalent($admnno,$talent){
    global $connection;
    $sql = "INSERT INTO student_extra_talents (id, admission_number, title,description,url) VALUES (?,?,?,?,?)";
    $stmt = $connection->prepare($sql);
    $id = generateRandomString($admnno);
    $stmt->bind_param("sssss",$id,$admnno,$talent['title'],$talent['description'],$talent['url']);
    $stmt->execute();
    if ($stmt->affected_rows === 0) {
        return "Query Failed !";
    }
    return "success";

}


function fetchStudentAchievements($admnno){

    global $connection;
    $response = '&nbsp';
    $count = 0;
    $sql = "SELECT * FROM student_extra_achievements WHERE admission_number = '$admnno'";
    $result = mysqli_query($connection, $sql);
    if (!$result) {
        return "DB error !";
    }
    while ($row = mysqli_fetch_assoc($result)) {

    $response .= '<div class="card">
    <div class="card-header" id="h' . $count . '">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#ach' . $count . '" aria-expanded="true" aria-controls="ach' . $count . '">
          ' .stripslashes($row['title']). '
        </button>
      </h2>
    </div>
        <div id="ach' . $count . '" class="collapse show" aria-labelledby="heading' . $count . '" data-parent="#Achievements">
      <div class="card-body">
        <h5>Title : ' . stripslashes($row['title']) . '</h5>
        <h5>Description : </h5><p>' .stripslashes($row['description']). '</p>
        <h5>Talent - Video : <a href="' . $row['url'] . '" target="_blank" ><u>View</u></a></h5>
          <small class="form-text text-muted"><a href="/student/extra-curricular/delete.php?action=deleteAchievement&id=' . $row['id'] . '">Delete</a></small>
      </div>
    </div>
  </div>';
        $count++;
    }

    return $response;


}



function insertStudentAchievement($admnno, $achievement)
{
    global $connection;
    $sql = "INSERT INTO student_extra_achievements (id, admission_number, title,description,url) VALUES (?,?,?,?,?)";
    $stmt = $connection->prepare($sql);
    $id = generateRandomString($admnno);
    $stmt->bind_param("sssss", $id, $admnno, $achievement['title'], $achievement['description'], $achievement['url']);
    $stmt->execute();
    if ($stmt->affected_rows === 0) {
        return "Query Failed !";
    }
    return "success";
}

