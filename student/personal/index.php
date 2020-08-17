<?php
require '../../cleaninput.php';
require 'process.php';
require 'sessionmanager.php';


session_start();
if (!isset($_SESSION['admnno'])) {
    header("Location: ../login.php");
}
sessionTimer();

// fetch personal info from db
$personal_info = fetchStudentPersonalInfo($_SESSION["admnno"]);
if ($personal_info["filled"] == false) { // if personal info not filled goto edit.php
    echo "<h1>Please wait your'e being redirected</h1>";
    header("Location: edit.php");
} else {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Personal Info </title>
        <?php

        include '../../inc/style.inc.php';

        ?>
    </head>

    <body>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Personal</li>
            </ol>
        </nav>

        <br>
        <section class="container-lg container-md container-sm ">
            <div class="cont">
                <div style="text-align: right;">
                    <h3><a href="edit.php"> <i class="fas fa-edit"></i> </a></h3>
                </div>
                <h1> <b> Personal Info : </b> </h1>
                <br>
                <h5> <b> Register Number : </b> <?php echo $personal_info['reg_no'] ?> </h5>
                <h5> <b> Section : </b> <?php echo $personal_info['section'] ?> </h5>
                <h5> <b> First Name : </b> <?php echo $personal_info['first_name'] ?> </h5>
                <h5> <b> Last Name : </b> <?php echo $personal_info['last_name'] ?> </h5>
                <h5> <b> DOB : </b> <?php echo $personal_info['dob'] ?> </h5>
                <h5> <b> Age : </b> <?php echo $personal_info['age'] ?> </h5>
                <h5> <b> Height ( In cm ) : </b> <?php echo $personal_info['height_cm'] ?> </h5>
                <h5> <b> Weight ( In Kg ) : </b> <?php echo $personal_info['weight_kg'] ?> </h5>
                <h5> <b> Blood Group : </b> <?php echo $personal_info['blood_group'] ?> </h5>
                <h5> <b> Identification Marks : </b> </h5>
                <p> <?php echo $personal_info['identification_marks'] ?> </p>

                <h5> <b> Communication Address : </b> </h5>
                <p> <?php echo $personal_info['communication_address'] ?> </p>

                <h5> <b> Permanent Address : </b></h5>
                <p> <?php echo $personal_info['permanent_address'] ?> </p>

                <h5> <b> District : </b> <?php echo $personal_info['district'] ?> </h5>
                <h5> <b> State : </b> <?php echo $personal_info['state'] ?> </h5>
                <h5> <b> Country : </b> <?php echo $personal_info['country'] ?> </h5>
                <h5> <b> Pincode : </b> <?php echo $personal_info['pincode'] ?> </h5>
                <h5> <b> Phone number: </b> <?php echo $personal_info['student_phone'] ?> </h5>
                <h5> <b> Mother's Phone number : </b> <?php echo $personal_info['mother_phone'] ?> </h5>
                <h5> <b> Father's Phone number : </b> <?php echo $personal_info['father_phone'] ?> </h5>
                <h5> <b> Residential Phone number : </b> <?php echo $personal_info['residential_phone'] ?> </h4>
                    <h5> <b> Hosteller : </b> <?php echo $personal_info['hosteller'] ?> </h5>
                    <hr>
                    <?php
                    if (strcmp($personal_info['hosteller'], "No") === 0) {
                        # Hosteller info 
                    ?>
                        <h5> <b> Mode of Transport : </b> <?php echo $personal_info['mode_of_transport'] ?> </h5>

                    <?php

                    } else {
                    ?>

                        <h5> <b> Local Guardian name : </b> <?php echo $personal_info['local_guardian_name'] ?> </h5>
                        <h5> <b> Local Guardian number : </b> <?php echo $personal_info['local_guardian_phone'] ?> </h5>
                        <h5> <b> Local Guardian address : </b>
                            <p> <?php echo $personal_info['local_guardian_address'] ?> </p>
                        </h5>

                    <?php
                    }
                    ?>
                    <hr>
                    <h5> <b> Community : </b> <?php echo $personal_info['community'] ?> </h5>
                    <h5> <b> Caste : </b> <?php echo $personal_info['caste'] ?> </h5>
                    <h5> <b> Religion : </b> <?php echo $personal_info['religion'] ?> </h5>
                    <h5> <b> Mother Tongue : </b> <?php echo $personal_info['mother_tongue'] ?> </h5>
                    <h5> <b> Known Languages : </b> <?php echo $personal_info['known_languages'] ?> </h5>
            </div>
        </section>
        <br>
    </body>

    </html>


<?php

}

?>