<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Edit Family Info</title>

    <?php

    include '../../inc/style.inc.php';
    ?>
</head>

<body>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/student/family">Family</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>


    <?php
    session_start();

    require '../../cleaninput.php';
    require 'process.php';
    require 'sessionmanager.php';
    require '../csrf.php';


    if (!isset($_SESSION['admnno'])) {
        header("Location: ../login.php");
    }

    if (empty($_SESSION['key']))
        $_SESSION['key'] = getKey();

    $csrf = getToken($_SESSION['key']);


    sessionTimer();
    $family_info = fetchStudentFamilyInfo($_SESSION["admnno"]); // fetch student family details

    $siblings_info = fetchStudentSiblingsInfo($_SESSION['admnno']);

    ?>

    <?php
    if (isset($_POST['family'])) {
        if (!hash_equals($csrf, $_POST['csrf'])) {
            csrfError();
            die();
        }
        foreach ($_POST as $key => $value) {
            $_POST[$key] = cleanInput($value);
        }
        if ($_POST['filled'] == false) {
            $insertMsg = insertStudentFamilyInfo($_POST, $_SESSION['admnno']);
            if (strcmp($insertMsg, 'success') == 0) {
                echo '<div class="alert alert-success" role="alert"> Details Updated successfully</div>';
                header("Location: index.php");
            } else {
                echo '<div class="alert alert-danger" role="alert"> Error ! ' . $insertMsg . ' </div>';
            }
        } else {
            $updateMsg = updateStudentFamilyInfo($_POST, $_SESSION['admnno']);
            if (strcmp($updateMsg, 'success') == 0) {
                echo '<div class="alert alert-success" role="alert"> Details Updated successfully</div>';
                header("Location: index.php");
            } else {
                echo '<div class="alert alert-danger" role="alert"> Error ! ' . $updateMsg . ' </div>';
            }
        }
    }
    ?>

    <?php
    if (isset($_POST['add-sibling'])) {
        if (!hash_equals($csrf, $_POST['csrf'])) {
            csrfError();
            die();
        }
        foreach ($_POST as $key => $value) {
            $_POST[$key] = cleanInput($value);
        }
        $sibMsg = insertStudentSiblingInfo($_POST, $_SESSION['admnno']);
        header("Refresh:0");
    }
    ?>


    <br>
    <section class="container-lg container-md container-sm ">
        <div class="cont">
            <h4>Edit Family info</h4>
            <form action="" method="post" id="familyForm">
                <input type="hidden" name='csrf' value="<?php echo $csrf ?>">
                <input type="hidden" name="filled" value="<?php echo $family_info['filled'] ?>">
                <input type="hidden" id="family_members_hid" value="<?php echo $family_info['family_members'] ?>">
                <div class="form-group">
                    <label for="">No of members in family : </label>
                    <select class="form-control" name="family_members" id="family_members">
                        <option id="1" value="1">1</option>
                        <option id="2" value="2">2</option>
                        <option id="3" value="3">3</option>
                        <option id="4" value="4">4</option>
                        <option id="5" value="5">5</option>
                        <option id="6" value="6">6</option>
                        <option id="7" value="7">7</option>
                        <option id="8" value="8">8</option>
                        <option id="9" value="9">9</option>
                        <option id="10" value="10">10</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Father's Name : </label>
                    <input type="text" name="father_name" value="<?php echo $family_info['father_name'] ?>" class="form-control" placeholder="" aria-describedby="helpId">
                </div>

                <input type="hidden" id="father_dob_hid" value="<?php echo $family_info['father_dob'] ?>">
                <div class="form-group">
                    <label for="">Father's DOB : </label>
                    <input type="date" name="father_dob" id="father_dob">
                </div>

                <div class="form-group">
                    <label for="">Father's Occupation : </label>
                    <input type="text" name="father_occupation" value="<?php echo $family_info['father_occupation'] ?>" class="form-control" placeholder="" aria-describedby="helpId">
                </div>

                <input type="hidden" id="father_sector_hid" value="<?php echo $family_info['father_sector'] ?>">
                <div class="form-group">
                    <label for="">Father's Job Sector : </label>
                    <select class="form-control" name="father_sector" id="father_sector">
                        <option id="father-none" value="None">None</option>
                        <option id="father-private" value="Private">Private</option>
                        <option id="father-public" value="Public">Public</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Father's Work Place : </label>
                    <input type="text" name="father_work_place" value="<?php echo $family_info['father_work_place'] ?>" class="form-control" placeholder="" aria-describedby="helpId">
                    <small id="emailHelp" class="form-text text-muted">The district where he works.</small>
                </div>


                <div class="form-group">
                    <label for="">Mother's Name : </label>
                    <input type="text" name="mother_name" value="<?php echo $family_info['mother_name'] ?>" class="form-control" placeholder="" aria-describedby="helpId">
                </div>

                <input type="hidden" id="mother_dob_hid" value="<?php echo $family_info['mother_dob'] ?>">
                <div class="form-group">
                    <label for="">Mother's DOB : </label>
                    <input type="date" name="mother_dob" id="mother_dob">
                </div>

                <div class="form-group">
                    <label for="">Mother's Occupation : </label>
                    <input type="text" name="mother_occupation" value="<?php echo $family_info['mother_occupation'] ?>" class="form-control" placeholder="" aria-describedby="helpId">
                </div>

                <input type="hidden" id="mother_sector_hid" value="<?php echo $family_info['mother_sector'] ?>">
                <div class="form-group">
                    <label for="">Mother's Job Sector : </label>
                    <select class="form-control" name="mother_sector" id="mother_sector">
                        <option id="mother-none" value="None">None</option>
                        <option id="mother-private" value="Private">Private</option>
                        <option id="mother-public" value="Public">Public</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Mother's Work Place : </label>
                    <input type="text" name="mother_work_place" value="<?php echo $family_info['mother_work_place'] ?>" class="form-control" placeholder="" aria-describedby="helpId">
                    <small id="emailHelp" class="form-text text-muted">The district where she works.</small>
                </div>

                <div class="form-group">
                    <label for="">Annual Family Income ( inr ) : </label>
                    <input type="number" name="family_income" value="<?php echo $family_info['family_income'] ?>" class="form-control" placeholder="" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="">No of siblings : </label>
                    <input type="number" name="no_of_siblings" value="<?php echo $family_info['no_of_siblings'] ?>" class="form-control" placeholder="" aria-describedby="helpId">
                </div>

                <button type="submit" name="family" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </section>
    <br>
    <center>
    <div class="alert alert-warning" role="alert">
    Please submit the above form before proceeding to fill the below form
</div>
</center>
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
    <section class="container-lg container-md container-sm ">
        <div class="cont">
            <h4>Add Sibling Info( Optional)</h4>
            <form action="" method="post" id="siblingForm">
                <input type="hidden" name='csrf' value="<?php echo $csrf ?>">
                <div class="form-group">
                    <label for="">Name : </label>
                    <input type="text" name="name" id="" class="form-control" placeholder="" required>
                </div>

                <div class="form-group">
                    <label for="">Relationship : </label>
                    <select class="form-control" name="relationship" id="" required>
                        <option value="Elder Brother">Elder Brother</option>
                        <option value="Elder Sister">Elder Sister</option>
                        <option value="Younger Brother">Younger Brother</option>
                        <option value="Younger Sister">Younger Sister</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Age : </label>
                    <input type="text" name="age" id="" class="form-control" placeholder="" aria-describedby="helpId" required>
                </div>

                <div class="form-group">
                    <label for="">DOB : </label>
                    <input type="date" name="dob" required>
                </div>

                <div class="form-group">
                    <label for="">Status : </label>
                    <input type="text" name="status" id="" class="form-control" placeholder="" aria-describedby="helpId" required>
                </div>

                <div class="form-group">
                    <label for="">Associated with Sona ? </label>
                    <select class="form-control" name="associated_with_sona" id="" required>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Description : </label>
                    <textarea class="form-control" name="description" id="" rows="3"></textarea>
                </div>
                <button type="submit" name="add-sibling" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </section>

<br>


    <?php
    include '../../inc/js.inc.php';
    ?>
    <script>
        var family_members = document.getElementById("family_members_hid").value;
        switch (family_members) {
            case '1':
                document.getElementById("1").selected = "true";
                break;
            case '2':
                document.getElementById("2").selected = "true";
                break;
            case '3':
                document.getElementById("3").selected = "true";
                break;
            case '4':
                document.getElementById("4").selected = "true";
                break;
            case '5':
                document.getElementById("5").selected = "true";
                break;
            case '6':
                document.getElementById("6").selected = "true";
                break;
            case '7':
                document.getElementById("7").selected = "true";
                break;
            case '8':
                document.getElementById("8").selected = "true";
                break;
            case '9':
                document.getElementById("9").selected = "true";
                break;
            case '10':
                document.getElementById("10").selected = "true";
                break;
            default:
                document.getElementById("1").selected = "true";
                break;
        }
        document.getElementById("father_dob").defaultValue = document.getElementById("father_dob_hid").value;
        document.getElementById("mother_dob").defaultValue = document.getElementById("mother_dob_hid").value;

        switch (document.getElementById("father_sector_hid").value) {
            case "Public":
                document.getElementById("father-public").selected = true;
                break;
            case "Private":
                document.getElementById("father-private").selected = true;
                break;
            default:
                document.getElementById("father-none").selected = true;
                break;
        }

        switch (document.getElementById("mother_sector_hid").value) {
            case "Public":
                document.getElementById("mother-public").selected = true;
                break;
            case "Private":
                document.getElementById("mother-private").selected = true;
                break;
            default:
                document.getElementById("mother-none").selected = true;
                break;
        }
    </script>

    <script>
        $("#familyForm").validate({
            rules: {
                family_members: {
                    required: true
                },
                father_name: {
                    required: true,
                    rangelength: [2, 150]

                },
                father_dob: {
                    required: true
                },
                mother_name: {
                    required: true,
                    rangelength: [2, 150]

                },
                mother_dob: {
                    required: true
                },
                family_income: {
                    required: true,
                    number: true,
                    rangelength: [1, 10]
                },
                no_of_siblings: {
                    required: true,
                    number: true,
                    rangelength: [1, 2]
                }
            }
        });

        $("#siblingForm").validate({
            rules: {
                name: {
                    required: true,
                    rangelength: [2, 150]
                },
                relationship: {
                    required: true
                },
                age: {
                    required: true,
                    number: true
                },
                dob: {
                    required: true,
                }
            }
        });
    </script>
</body>

</html>