<?php
require '../cleaninput.php';
require 'process.php';
require 'sessionmanager.php';

session_start();
if (isset($_SESSION['faculty']) && isset($_GET['admnno'])) {
    sessionTimer();

    $admnno = cleanInput($_GET['admnno']);
    $image = getStudentImage($admnno);
    $student = fetchStudentPrimary($admnno);
    if (strcmp($student['message'], 'success') !== 0) {
        echo "<h1>" . $student['message'] . "</h1>";
        die();
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $student['name'] ?> </title>
        <?php

        include '../inc/style.inc.php';

        ?>
        <style>
        .avatar {
            vertical-align: middle;
            width: 20vh;
            height: 20vh;
            border-radius: 50%;
            border: 2px solid black;
        }
        </style>
    </head>

    <body>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Student</li>
        </ol>
    </nav>
        <br>
        <center><img src="/student/profile/<?php echo $image ?>" alt="" class="avatar"></center>
        <br>
        <section class="container-lg container-md container-sm ">
            <div class="cont">
                <h1> <b> Personal Info : </b> </h1>
                <br>
                <?php
                $personal_info = fetchStudentPersonalInfo($admnno);
                if ($personal_info["filled"] == false) { // if personal info not filled goto edit.php
                    echo "<center><h1>Not available !</h1></center>";
                } else {

                ?>

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
                    <?php
                }
                    ?>
            </div>
        </section>
        <br>
        <section class="container-lg container-md container-sm ">
            <div class="cont">
                <?php
                $family_info = fetchStudentFamilyInfo($admnno);
                if ($family_info["filled"] == false) { // if family info not filled goto edit.php
                    echo "<h1>Not available ! </h1>";
                } else {

                ?>
                    <h1> <b> View Family info </b> </h1>
                    <br>
                    <h5> <b> Father's Name : </b> <?php echo $family_info['father_name'] ?> </h5>
                    <h5> <b> Father's DOB : </b> <?php echo $family_info['father_dob'] ?> </h5>
                    <h5> <b> Father's Occupation : </b> <?php echo $family_info['father_occupation'] ?> </h5>
                    <h5> <b> Father's Job Sector : </b> <?php echo $family_info['father_sector'] ?> </h5>
                    <h5> <b> Father's Work Place : </b> <?php echo $family_info['father_work_place'] ?> </h5>
                    <hr>
                    <h5> <b> Mother's Name : </b> <?php echo $family_info['mother_name'] ?> </h5>
                    <h5> <b> Mother's DOB : </b> <?php echo $family_info['mother_dob'] ?> </h5>
                    <h5> <b> Mother's Occupation : </b> <?php echo $family_info['mother_occupation'] ?> </h5>
                    <h5> <b> Mother's Job Sector : </b> <?php echo $family_info['mother_sector'] ?> </h5>
                    <h5> <b> Mother's Work Place : </b> <?php echo $family_info['mother_work_place'] ?> </h5>
                    <hr>
                    <h5> <b>Annual Family Income ( inr ) : </b> <?php echo $family_info['family_income'] ?> </h5>
                    <h5> <b> No of Siblings: </b> <?php echo $family_info['no_of_siblings'] ?> </h5>
                <?php
                }
                ?>
            </div>
        </section>
        <br>
        <?php

        $siblings_info = fetchStudentSiblingsInfo($admnno);

        if (strcmp('&nbsp', $siblings_info) !== 0) {
            echo '
        <section class="container-lg container-md container-sm ">
                <div class="cont">
                <h4>Siblings</h4>
                    <div class="accordion" id="Siblings">
                        ' . $siblings_info . '
                    </div>
                </div>
            </section>
            <br>
            ';
        } else {
            echo "<center><h1>No Sibling info available !</h1></center><br>";
        }
        ?>
        <br>
        <section class="container-lg container-md container-sm ">
            <div class="cont">
                <?php
                $academic = fetchStudentAcademicInfo($admnno);
                $gpa = fetchStudentGPA($admnno);
                if ($academic['filled'] === false) {
                    echo "<center><h1>No Academic info available !</h1></center><br>";
                } else {
                ?>
                    <h1> <b> Academic Info : </b> </h1> <br>
                    <h5> <b> Admission : </b> <?php echo $academic['admission'] ?> </h5>
                    <h5><b>Tenth School Name :</b> <?php echo $academic['tenth_school_name'] ?></h5>
                    <h5><b>Tenth School Place : </b><?php echo $academic['tenth_school_place'] ?></h5>
                    <h5><b>Tenth Board :</b> <?php echo $academic['tenth_board'] ?></h5>
                    <h5><b>Tenth Medium :</b> <?php echo $academic['tenth_medium'] ?></h5>
                    <h5><b>Tenth Year of completion :</b> <?php echo $academic['tenth_completion_year'] ?></h5>
                    <h5><b>Tenth Marks :</b> <?php echo $academic['tenth_marks'] ?>%</h5>
                    <hr>
                    <?php
                    if (strcmp($academic['lateral_entry'], "No") === 0) {

                    ?>
                        <h5><b>HSC instituition name : </b><?php echo $academic['hsc_instituition_name'] ?></h5>
                        <h5><b>HSC instituition place : </b><?php echo $academic['hsc_instituition_place'] ?></h5>
                        <h5><b>HSC Board :</b> <?php echo $academic['hsc_board'] ?></h5>
                        <h5><b>HSC Medium : </b><?php echo $academic['hsc_medium'] ?></h5>
                        <h5><b>HSC Group : </b><?php echo $academic['hsc_group'] ?></h5>
                        <h5><b>HSC year of completion :</b> <?php echo $academic['hsc_completion_year'] ?></h5>
                        <h5><b>HSC Marks : </b><?php echo $academic['hsc_marks'] ?>%</h5>

                    <?php
                    } else {
                    ?>
                        <h5><b>Diploma instituition name : </b><?php echo $academic['diploma_instituition_name'] ?></h5>
                        <h5><b>Diploma instituition place : </b><?php echo $academic['diploma_instituition_place'] ?></h5>
                        <h5><b>Diploma degree : </b><?php echo $academic['diploma_degree'] ?></h5>
                        <h5><b>Diploma department : </b><?php echo $academic['diploma_department'] ?></h5>
                        <h5><b>Diploma year of completion : </b><?php echo $academic['diploma_completion_year'] ?></h5>
                        <h5><b>Diploma percentage : </b><?php echo $academic['diploma_percentage'] ?>%</h5>

                    <?php
                    }
                    ?>
                    <hr>
                    <h5><b>GPASemster 1 : </b><?php echo $gpa['semester1'] ?></h5>
                    <h5><b>GPASemster 2 : </b><?php echo $gpa['semester2'] ?></h5>
                    <h5><b>GPASemster 3 : </b><?php echo $gpa['semester3'] ?></h5>
                    <h5><b>GPASemster 4 : </b><?php echo $gpa['semester4'] ?></h5>
                    <h5><b>GPASemster 5 : </b><?php echo $gpa['semester5'] ?></h5>
                    <h5><b>GPASemster 6 : </b><?php echo $gpa['semester6'] ?></h5>
                    <h5><b>GPASemster 7 : </b><?php echo $gpa['semester7'] ?></h5>
                    <h5><b>GPASemster 8 : </b><?php echo $gpa['semester8'] ?></h5>
                <?php
                }
                ?>
            </div>
        </section>
        <br>

        <?php
        $talents = fetchStudentTalents($admnno);
        if (strcmp($talents, '&nbsp') === 0) { // if Talent info not filled goto edit.php
            echo "<center><h1>No Talent info available !</h1></center><br>";
        } else {

            echo '
            <br>
            <section class="container-lg container-md container-sm ">
                    <div class="cont">
                    <h1>Talents</h1>
                        <div class="accordion" id="Talents">
                            ' . $talents . '
                        </div>
                    </div>
                </section>
                ';
        }
        ?>

        <?php
        $achievements = fetchStudentAchievements($admnno);
        if (strcmp($achievements, '&nbsp') !== 0) {
            echo '
                <br>
                <section class="container-lg container-md container-sm ">
                        <div class="cont">
                        <h1>Achievements : </h1>
                            <div class="accordion" id="Achievements">
                                ' . $achievements . '
                            </div>
                        </div>
                    </section>
                    <br>
                    ';
        } else {
            echo "<center><h1>No Achievement info available !</h1></center><br>";
        }

        ?>

        <?php

        $clubs = fetchStudentClubs($admnno);

        if (strcmp('&nbsp', $clubs) !== 0) {
            echo '
        <br>
        <section class="container-lg container-md container-sm ">
                <div class="cont">
                <h4>Club Activities</h4>
                    <div class="accordion" id="Clubs">
                        ' . $clubs . '
                    </div>
                </div>
            </section>
            ';
        } else {
            echo "<center><h1>No Club info available !</h1></center><br>";
        }
        ?>


        <?php

        $courses = fetchStudentCourses($admnno);

        if (strcmp('&nbsp', $courses) !== 0) {
            echo '
        <br>
        <section class="container-lg container-md container-sm ">
                <div class="cont">
                <h4>Extra Courses</h4>
                    <div class="accordion" id="Courses">
                        ' . $courses . '
                    </div>
                </div>
            </section>
            ';
        } else {
            echo "<center><h1>No Course info available !</h1></center><br>";
        }
        ?>

        <?php

        $intra = fetchStudentIntraActivities($admnno);

        if (strcmp('&nbsp', $intra) !== 0) {
            echo '
        <br>
        <section class="container-lg container-md container-sm ">
                <div class="cont">
                <h4>Intra College Activities</h4>
                    <div class="accordion" id="IntraActs">
                        ' . $intra . '
                    </div>
                </div>
            </section>
            ';
        } else {
            echo "<center><h1>No Intra College activity info available !</h1></center><br>";
        }
        ?>

        <?php

        $inter = fetchStudentInterActivities($admnno);

        if (strcmp('&nbsp', $inter) !== 0) {
            echo '
        <br>
        <section class="container-lg container-md container-sm ">
                <div class="cont">
                <h4>Inter College Activities</h4>
                    <div class="accordion" id="InterActs">
                        ' . $inter . '
                    </div>
                </div>
            </section>
            ';
        } else {
            echo "<center><h1>No Inter College activity info available !</h1></center><br>";
        }
        ?>
        <br>
        <?php
        include '../inc/js.inc.php';
        ?>
        <script>
            $('.collapse').collapse();
        </script>
    </body>

    </html>
<?php
} else if (!isset($_SESSION['faculty'])) {
    echo "<h1>Access Denied</h1>";
} else {
    echo "<h1>Invalid Request</h1>";
}
?>