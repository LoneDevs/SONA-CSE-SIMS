<?php
require '../../cleaninput.php';
require 'process.php';
require 'sessionmanager.php';


session_start();
if (!isset($_SESSION['admnno'])) {
    header("Location: ../login.php");
}
sessionTimer();

// fetch family info from db
$family_info = fetchStudentFamilyInfo($_SESSION['admnno']);
$siblings_info = fetchStudentSiblingsInfo($_SESSION['admnno']);
if ($family_info["filled"] == false) { // if family info not filled goto edit.php
    echo "<h1>Please wait your'e being redirected </h1>";
    header("Location: edit.php");
} else {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> View Family Info </title>
        <?php

        include '../../inc/style.inc.php';
        ?>
    </head>

    <body>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Family</li>
            </ol>
        </nav>

        <br>
        <section class="container-lg container-md container-sm ">
            <div class="cont">
                <div style="text-align: right;">
                    <h3><a href="edit.php"> <i class="fas fa-edit"></i> </a></h3>
                </div>
                <h1> <b> View Family info </b> </h1>
                <br>
                <h5> <b> No of members in family : </b> <?php echo $family_info['family_members'] ?> </h5>
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
                <h5> <b> Annual Family Income ( inr ) : </b> <?php echo $family_info['family_income'] ?> </h5>
                <h5> <b> No of Siblings: </b> <?php echo $family_info['no_of_siblings'] ?> </h5>
            </div>
        </section>
        <br>

        <?php
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
        }
        ?>

        <?php
        include '../../inc/js.inc.php';
        ?>
        <script>
            $('.collapse').collapse();
        </script>

    </body>

    </html>

<?php
}
?>