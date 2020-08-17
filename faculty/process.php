<?php
require '../dbconn.php';

function fetchStudentPrimary($admnno){
    global $connection;
    $details = array();
    $sql = "SELECT * FROM student_primary WHERE admission_number = ? ";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $admnno);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_assoc($result);
    $stmt->close();
    if (isset($row['admission_number'])) {
        $row['message'] = 'success';
        return $row;
    } else {
        $details['message'] = 'Invalid Admission Number !';
        return $details;
    }

}

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

function fetchStudentFamilyInfo($admnno)
{
    global $connection;

    $family_info = array("filled" => false, "family_members" => 0, "father_name" => "", "father_occupation" => "", "father_dob" => "", "father_sector" => "", "mother_name" => "", "mother_occupation" => "", "mother_dob" => "", "mother_sector" => "", "mother_work_place" => "", "father_work_place" => "", "family_income" => 0, "no_of_siblings" => 0);
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


function fetchStudentSiblingsInfo($admnno)
{
    global $connection;

    $response = '&nbsp';
    $sql = "SELECT * FROM student_siblings WHERE admission_number = '$admnno' ";
    $result = mysqli_query($connection, $sql);
    $count = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $response .= '
        <div class="card">
    <div class="card-header" id="h' . $count . '">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#sib' . $count . '" aria-expanded="true" aria-controls="sib' . $count . '">
          ' . $row['name'] . '
        </button>
      </h2>
    </div>
        <div id="sib' . $count . '" class="collapse show" aria-labelledby="heading' . $count . '" data-parent="#Siblings">
      <div class="card-body">
        Name : ' . $row['name'] . '
        Relationship : ' . $row['relationship'] . '<br>
        Age : ' . $row['age'] . '<br>
        DOB : ' . $row['dob'] . '<br>
        Status : ' . $row['status'] . '<br>
        Associated with sona : ' . $row['associated_with_sona'] . '<br>
        <p>Description : ' . $row['description'] . '</p><br>
      </div>
    </div>
  </div>
        
        ';
        $count++;
    }
    return $response;
}


function fetchStudentAcademicInfo($admnno)
{
    global $connection;
    $academic_info = array("filled" => false, "lateral_entry" => "No", "admission" => "SWS", "tenth_school_name" => "", "tenth_school_place" => "", "tenth_school_place" => "", "tenth_board" => "", "tenth_medium" => "", "tenth_completion_year" => "", "tenth_marks" => "", "hsc_instituition_name" => "NA", "hsc_instituition_place" => "NA", "hsc_board" => "NA", "hsc_medium" => "NA", "hsc_completion_year" => "0000", "hsc_group" => "NA", "hsc_marks" => "0", "diploma_instituition_name" => "NA", "diploma_instituition_place" => "NA", "diploma_degree" => "NA", "diploma_department" => "NA", "diploma_completion_year" => "0000", "diploma_percentage" => "0");
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

function fetchStudentGPA($admnno)
{
    global $connection;
    $sql = "SELECT * FROM student_gpa WHERE admission_number = '$admnno' ";
    $result = mysqli_query($connection, $sql);
    if (!$result) {
        return "Query failed";
    }
    while ($row = mysqli_fetch_assoc($result)) {
        return $row;
    }
    return "Failed !";
}

function fetchStudentTalents($admnno)
{
    global $connection;
    $response = '&nbsp';
    $count = 0;
    $sql = "SELECT * FROM student_extra_talents WHERE admission_number = '$admnno'";
    $result = mysqli_query($connection, $sql);
    if (!$result) {
        return "DB error !";
    }
    while ($row = mysqli_fetch_assoc($result)) {

        $response .= '<div class="card">
    <div class="card-header" id="h' . $count . '">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#tal' . $count . '" aria-expanded="true" aria-controls="tal' . $count . '">
          ' . stripslashes($row['title']) . '
        </button>
      </h2>
    </div>
        <div id="tal' . $count . '" class="collapse show" aria-labelledby="heading' . $count . '" data-parent="#Talents">
      <div class="card-body">
        <h5>Title : ' . stripslashes($row['title']) . '</h5>
        <h5>Description : </h5> <p>' . stripslashes($row['description']) . '</p>
        <h5>Talent - Video : <a href="' . $row['url'] . '" target="_blank" ><u>View</u></a></h5>
      </div>
    </div>
  </div>';
        $count++;
    }

    return $response;
}


function fetchStudentAchievements($admnno)
{

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
          ' . stripslashes($row['title']) . '
        </button>
      </h2>
    </div>
        <div id="ach' . $count . '" class="collapse show" aria-labelledby="heading' . $count . '" data-parent="#Achievements">
      <div class="card-body">
        <h5>Title : ' . stripslashes($row['title']) . '</h5>
        <h5>Description : </h5><p>' . stripslashes($row['description']) . '</p>
        <h5>Talent - Video : <a href="' . $row['url'] . '" target="_blank" ><u>View</u></a></h5>
      </div>
    </div>
  </div>';
        $count++;
    }

    return $response;
}


function fetchStudentClubs($admnno)
{
    global $connection;
    $response = "&nbsp";
    $count = 0;
    $sql = "SELECT * FROM student_co_clubs WHERE admission_number = '$admnno' ";
    $result = mysqli_query($connection, $sql);
    if (!$result) {
        return "Query Failed";
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $response .= '<div class="card">
    <div class="card-header" id="h' . $count . '">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#club' . $count . '" aria-expanded="true" aria-controls="club' . $count . '">
          ' . stripslashes($row['title']) . '
        </button>
      </h2>
    </div>
        <div id="club' . $count . '" class="collapse show" aria-labelledby="heading' . $count . '" data-parent="#Clubs">
      <div class="card-body">
        <h5>Club : ' . stripslashes($row['club']) . '</h5>
        <h5>Role : ' . stripslashes($row['role']) . '</h5>
        <h5>Semester : ' . stripslashes($row['semester']) . '</h5>
        <h5>Description :</h5><p> ' . stripcslashes($row['description']) . '</p>
        <h5> Certificate or Prize : <a href="' . $row['certificate'] . '" target="_blank" ><u>View</u></a></h5>
      </div>
    </div>
  </div>';
        $count++;
    }
    return $response;
}


function fetchStudentCourses($admnno)
{
    global $connection;
    $response = '&nbsp';
    $count = 0;
    $sql = "SELECT * FROM student_co_courses WHERE admission_number = '$admnno' ";
    $result = mysqli_query($connection, $sql);
    if (!$result) {
        return "DB Error !";
    }
    while ($row = mysqli_fetch_assoc($result)) {

        $response .= '<div class="card">
    <div class="card-header" id="h' . $count . '">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#cou' . $count . '" aria-expanded="true" aria-controls="cou' . $count . '">
          ' . stripslashes($row['title']) . '
        </button>
      </h2>
    </div>
        <div id="cou' . $count . '" class="collapse show" aria-labelledby="heading' . $count . '" data-parent="#Courses">
      <div class="card-body">
        <h5>Title : ' . stripslashes($row['title']) . '</h5>
        <h5>Description :</h5> <p>' . stripslashes($row['description']) . '</p>
        <h5>Semester : ' . stripslashes($row['semester']) . '</h5>
        <h5>Mode : ' . stripslashes($row['mode']) . '</h5>
        <h5>Instituition : ' . stripslashes($row['instituition']) . '</h5>
        <h5>Domain : ' . stripslashes($row['domain']) . '</h5>
        <h5> Certificate or Prize : <a href="' . $row['certificate'] . '" target="_blank" ><u>View</u></a></h5>
      </div>
    </div>
  </div>';
        $count++;
    }

    return $response;
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
      </div>
    </div>
  </div>';
        $count++;
    }
    return $response;
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
      </div>
    </div>
  </div>';
        $count++;
    }
    return $response;
}


function fetchAllStudents(){
    global $connection;
    $response = "";
    $count=1;
    $sql = "SELECT admission_number,name,email FROM student_primary ORDER BY name ASC ";
    $result = mysqli_query($connection, $sql);
    if (!$result) {
        return "failed";
    }else{
        while ($row = mysqli_fetch_assoc($result)) {
            $response.= '
                    <tr>
                        <th scope="row">'.$count. '</th>
                        <td><a href="view-student.php?admnno='.$row['admission_number'].'" target="_blank" >'.$row['admission_number'].'</a></td>
                        <td>' . $row['name'] . '</td>
                        <td>'. $row['email'] .'</td>
                    </tr>
            
            ';
            $count++;
        }
    }
   return $response; 
}


function getStudents($arg){
    global $connection;
    $arg = mysqli_escape_string($connection,$arg);
    $arg = '%'.$arg.'%';
    $sql="SELECT name,admission_number FROM student_primary WHERE admission_number LIKE ? OR name LIKE ? ";
    $response="";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss",$arg,$arg);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = mysqli_fetch_assoc($result)) {
        $response.= '
        <a href="view-student.php?admnno='.$row['admission_number'].' " target="_blank">'.$row['admission_number']. '</a>&nbsp;&nbsp;'.$row['name'].'<hr>
        ';
    }
    return $response;
    
}


function getStudentImage($admnno){
    global $connection;
    $admnno = mysqli_escape_string($connection,$admnno);
    $sql = "SELECT image FROM student_primary WHERE admission_number = '$admnno'";
    $result = mysqli_query($connection,$sql);
    if($result){
        $row = mysqli_fetch_assoc($result);
        return $row['image'];
    }else{
        return "failed";
    }
}

