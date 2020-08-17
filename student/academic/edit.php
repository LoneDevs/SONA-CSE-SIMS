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


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Edit Academic Info</title>
</head>
<?php

include '../../inc/style.inc.php';

?>

<body>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/student/academic">Academic</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>

    <?php

    $academic = fetchStudentAcademicInfo($_SESSION['admnno']);

    ?>
    <br>
    <center>
        <?php
        if (isset($_POST['academic'])) {
            if (!hash_equals($csrf, $_POST['csrf'])) {
                csrfError();
                die();
            }
            foreach ($_POST as $key => $value) {
                $_POST[$key] = cleanInput($value);
            }
            if ($academic['filled'] === false) {
                $insertMsg = insertStudentAcademicInfo($_SESSION['admnno'], $_POST);
                if (strcmp($insertMsg, 'success') == 0) {
                    echo '<div class="alert alert-success" role="alert"> Details Updated successfully</div>';
                    header("Location: index.php");
                } else {
                    echo '<div class="alert alert-danger" role="alert"> Error ! ' . $insertMsg . ' </div>';
                }
            } else {
                $updateMsg = updateStudentAcademicInfo($_SESSION['admnno'], $_POST);
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
        $gpa = fetchStudentGPA($_SESSION['admnno']);
        if (isset($_POST['gpa'])) {
            if (!hash_equals($csrf, $_POST['csrf'])) {
                csrfError();
                die();
            }
            foreach ($_POST as $key => $value) {
                $_POST[$key] = cleanInput($value);
            }
            $Msg = updateStudentGPA($_SESSION['admnno'], $_POST);
            if (strcmp($Msg, "success") === 0) {
                echo '<div class="alert alert-success" role="alert"> Details Updated successfully</div>';
                header("Location: index.php");
            } else {
                echo '<div class="alert alert-danger" role="alert"> Error ! ' . $Msg . ' </div>';
            }
        }
        ?>
        
    </center>
    <br>
    <section class="container-lg container-md container-sm ">
        <div class="cont">
            <h4>Academic Info</h4>
            <!-- Form -->
            <form action="" method="post" id="academicForm">

                <input type="hidden" name="filled" value="<?php echo $academic['filled'] ?>">
                <input type="hidden" name='csrf' value="<?php echo $csrf ?>">

                <input type="hidden" id="admission_hid" value="<?php echo $academic['admission'] ?>">
                <div class="form-group">
                    <label for="admission">Admission : </label>
                    <select class="form-control" name="admission" id="admission">
                        <option value="Management" id="Management">Management</option>
                        <option value=" SWS" id="SWS">SWS</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tenth_school_name">Tenth School Name : </label>
                    <input type="text" name="tenth_school_name" id="" class="form-control" value="<?php echo $academic['tenth_school_name'] ?>" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="tenth_school_place">Tenth School Place : </label>
                    <input type="text" name="tenth_school_place" id="" class="form-control" value="<?php echo $academic['tenth_school_place'] ?>" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="tenth_board">Tenth Board : </label>
                    <input type="text" name="tenth_board" id="" class="form-control" value="<?php echo $academic['tenth_board'] ?>" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="tenth_medium">Tenth Medium : </label>
                    <input type="text" name="tenth_medium" id="" class="form-control" value="<?php echo $academic['tenth_medium'] ?>" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="tenth_completion_year">Tenth Year of Completion : </label>
                    <input type="text" name="tenth_completion_year" id="" class="form-control" value="<?php echo $academic['tenth_completion_year'] ?>" aria-describedby="helpId">
                </div>

                <div class="form-group">
                    <label for="tenth_marks">Tenth Marks ( in % ): </label>
                    <input type="text" name="tenth_marks" id="" class="form-control" placeholder="eg 90.21" value="<?php echo $academic['tenth_marks'] ?>" aria-describedby="helpId">
                </div>

                <input type="hidden" id="lateral_entry_hid" value="<?php echo $academic['lateral_entry'] ?>">
                <div class="form-group">
                    <label for="lateral_entry">Are you a lateral entry ? </label>
                    <select class="form-control" name="lateral_entry" onchange="selectHigher(this.value)" id="">
                        <option value="Yes" id="Yes">Yes</option>
                        <option value="No" id="No">No</option>
                    </select>
                </div>

                <div id="hscForm" style="display:none;">

                    <div class="form-group">
                        <label for="hsc_instituition_name">HSC Instituition Name : </label>
                        <input type="text" name="hsc_instituition_name" id="hsc_instituition_name" class="form-control" value="<?php echo $academic['hsc_instituition_name'] ?>" aria-describedby="helpId">
                    </div>


                    <div class="form-group">
                        <label for="hsc_instituition_place">HSC Instituition Place: </label>
                        <input type="text" name="hsc_instituition_place" id="hsc_instituition_place" class="form-control" value="<?php echo $academic['hsc_instituition_place'] ?>" aria-describedby="helpId">
                    </div>

                    <div class="form-group">
                        <label for="hsc_board">HSC Board : </label>
                        <input type="text" name="hsc_board" id="hsc_board" class="form-control" value="<?php echo $academic['hsc_board'] ?>" aria-describedby="helpId">
                    </div>

                    <div class="form-group">
                        <label for="hsc_medium">HSC Medium : </label>
                        <input type="text" name="hsc_medium" id="hsc_medium" class="form-control" value="<?php echo $academic['hsc_medium'] ?>" aria-describedby="helpId">
                    </div>

                    <div class="form-group">
                        <label for="hsc_group">HSC Group : </label>
                        <input type="text" name="hsc_group" id="hsc_group" class="form-control" value="<?php echo $academic['hsc_group'] ?>" aria-describedby="helpId">
                    </div>

                    <div class="form-group">
                        <label for="hsc_completion_year">HSC Year of Completion : </label>
                        <input type="text" name="hsc_completion_year" id="hsc_completion_year" class="form-control" value="<?php echo $academic['hsc_completion_year'] ?>" aria-describedby="helpId">
                    </div>

                    <div class="form-group">
                        <label for="hsc_marks">HSC Marks ( in % ) : </label>
                        <input type="text" name="hsc_marks" id="hsc_marks" placeholder="eg : 85.54 " class="form-control" value="<?php echo $academic['hsc_marks'] ?>" aria-describedby="helpId">
                    </div>

                </div>
                <!---End of HSC -->
                <div id="diplomaForm" style="display:none;">

                    <div class="form-group">
                        <label for="diploma_instituition_name">Diploma Instituition Name : </label>
                        <input type="text" name="diploma_instituition_name" id="diploma_instituition_name" value="<?php echo $academic['diploma_instituition_name'] ?>" class="form-control" placeholder="" aria-describedby="helpId">
                    </div>

                    <div class="form-group">
                        <label for="diploma_instituition_place">Diploma Instituition Place : </label>
                        <input type="text" name="diploma_instituition_place" id="diploma_instituition_place" value="<?php echo $academic['diploma_instituition_place'] ?>" class="form-control" placeholder="" aria-describedby="helpId">
                    </div>

                    <div class="form-group">
                        <label for="diploma_degree">Diploma Degree : </label>
                        <input type="text" name="diploma_degree" id="diploma_degree" value="<?php echo $academic['diploma_degree'] ?>" class="form-control" placeholder="" aria-describedby="helpId">
                    </div>

                    <div class="form-group">
                        <label for="diploma_department">Diploma Department : </label>
                        <input type="text" name="diploma_department" id="diploma_department" value="<?php echo $academic['diploma_department'] ?>" class="form-control" placeholder="" aria-describedby="helpId">
                    </div>

                    <div class="form-group">
                        <label for="diploma_completion_year">Diploma Completion Year : </label>
                        <input type="text" name="diploma_completion_year" id="diploma_completion_year" value="<?php echo $academic['diploma_completion_year'] ?>" class="form-control" placeholder="" aria-describedby="helpId">
                    </div>

                    <div class="form-group">
                        <label for="diploma_percentage">Diploma Percentage : </label>
                        <input type="text" name="diploma_percentage" id="diploma_percentage" value="<?php echo $academic['diploma_percentage'] ?>" class="form-control" placeholder="" aria-describedby="helpId">
                    </div>

                </div>

                <button type="submit" name="academic" class="btn btn-primary">Submit</button>

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
    <section class="container-lg container-md container-sm ">
        <div class="cont">
            <div style="text-align: right;">
                <h3><a href="https://cgpa-calc-2019.web.app/" target="_blank" > <i class="fas fa-life-ring"></i> </a></h3>
            </div>
            <form action="" id="gpaForm" method="post">
                <h1>GPA : </h1>
                <input type="hidden" name='csrf' value="<?php echo $csrf ?>" >
                <div class="form-group">
                    <label for="">Semester-1 GPA : </label>
                    <input type="text" name="semester1" id="" class="form-control" value="<?php echo $gpa['semester1'] ?>" placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="">Semester-2 GPA : </label>
                    <input type="text" name="semester2" id="" class="form-control" value="<?php echo $gpa['semester2'] ?>" placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="">Semester-3 GPA : </label>
                    <input type="text" name="semester3" id="" class="form-control" value="<?php echo $gpa['semester3'] ?>" placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="">Semester-4 GPA : </label>
                    <input type="text" name="semester4" id="" class="form-control" value="<?php echo $gpa['semester4'] ?>" placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="">Semester-5 GPA : </label>
                    <input type="text" name="semester5" id="" class="form-control" value="<?php echo $gpa['semester5'] ?>" placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="">Semester-6 GPA : </label>
                    <input type="text" name="semester6" id="" class="form-control" value="<?php echo $gpa['semester6'] ?>" placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="">Semester-7 GPA : </label>
                    <input type="text" name="semester7" id="" class="form-control" value="<?php echo $gpa['semester7'] ?>" placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="">Semester-8 GPA : </label>
                    <input type="text" name="semester8" id="" class="form-control" value="<?php echo $gpa['semester8'] ?>" placeholder="" aria-describedby="helpId">
                </div>
                <button type="submit" name="gpa" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </section>
<br>
    <?php
    include '../../inc/js.inc.php';
    ?>

    <script>
        //validation
        switch (document.getElementById('admission_hid').value) {
            case "Management":
                document.getElementById('Management').selected = true;
                break;

            default:
                document.getElementById('SWS').selected = true;
                break;
        }

        function selectHigher(choice) {

            switch (choice) {
                case "Yes":
                    document.getElementById('Yes').selected = true;
                    document.getElementById('hscForm').style.display = "none";
                    document.getElementById('diplomaForm').style.display = "block";
                    document.getElementById('hsc_instituition_name').value = "NA";
                    document.getElementById('hsc_instituition_place').value = "NA";
                    document.getElementById('hsc_board').value = "NA";
                    document.getElementById('hsc_medium').value = "NA";
                    document.getElementById('hsc_group').value = "NA";
                    document.getElementById('hsc_marks').value = 0;
                    document.getElementById('hsc_completion_year').value = "2000";
                    /*document.getElementById('diploma_instituition_name').value = "NA";
                    document.getElementById('diploma_instituition_place').value = "NA";
                    document.getElementById('diploma_degree').value = "NA";
                    document.getElementById('diploma_department').value = "NA";
                    document.getElementById('diploma_percentage').value = 0;
                    document.getElementById('diploma_completion_year').value = 0;*/
                    break;

                default:
                    document.getElementById('No').selected = true;
                    document.getElementById('hscForm').style.display = "block";
                    document.getElementById('diplomaForm').style.display = "none";
                    document.getElementById('diploma_instituition_name').value = "NA";
                    document.getElementById('diploma_instituition_place').value = "NA";
                    document.getElementById('diploma_degree').value = "NA";
                    document.getElementById('diploma_department').value = "NA";
                    document.getElementById('diploma_percentage').value = 0;
                    document.getElementById('diploma_completion_year').value = 0;
                    /*document.getElementById('hsc_instituition_name').value = "NA";
                    document.getElementById('hsc_instituition_place').value = "NA";
                    document.getElementById('hsc_board').value = "NA";
                    document.getElementById('hsc_medium').value = "NA";
                    document.getElementById('hsc_group').value = "NA";
                    document.getElementById('hsc_marks').value = 0;
                    document.getElementById('hsc_completion_year').value = 0;*/
                    break;
            }

        }
        var lateral = document.getElementById('lateral_entry_hid').value;
        selectHigher(lateral);
    </script>
    <!-- Validation Script -->
    <script>
        $("#academicForm").validate({
            rules: {
                admission: {
                    required: true,
                },
                tenth_school_name: {
                    required: true,
                    rangelength: [2, 200]
                },
                tenth_school_place: {
                    required: true,
                    rangelength: [2, 200]

                },
                tenth_board: {
                    required: true,
                    rangelength: [2, 200]

                },
                tenth_medium: {
                    required: true,
                    rangelength: [2, 200]

                },
                tenth_place: {
                    required: true,
                    rangelength: [2, 200]

                },
                tenth_marks: {
                    required: true,
                    number:true,
                    range: [0,100]
                },
                tenth_completion_year: {
                    required: true,
                    number: true,
                    rangelength: [4, 4]

                },
                lateral_entry: {
                    required: true
                },
                hsc_instituition_name: {
                    required: true,
                    rangelength: [2, 200]

                },
                hsc_instituition_place: {
                    required: true,
                    rangelength: [2, 200]

                },
                hsc_board: {
                    required: true,
                    rangelength: [2, 200]

                },
                hsc_group: {
                    required: true,
                    rangelength: [2, 200]

                },
                hsc_medium: {
                    required: true,
                    rangelength: [2, 200]

                },
                hsc_completion_year: {
                    required: true,
                    number: true,
                    rangelength: [4, 4]
                },
                hsc_marks: {
                    required: true,
                    range: [0,100],
                    number:true
                },
                diploma_instituition_name: {
                    required: true,
                    rangelength: [0, 200]


                },
                diploma_instituition_place: {
                    required: true,
                    rangelength: [0, 200]


                },
                diploma_degree: {
                    required: true,
                    rangelength: [0, 200]


                },
                diploma_department: {
                    required: true,
                    rangelength: [0, 200]
                },
                diploma_percentage: {
                    required: true,
                    range: [0, 100]
                },
                diploma_completion_year: {
                    required: true,
                    rangelength: [4, 4]
                }


            }

        });
        
        $("#gpaForm").validate({
            rules: {
                semester1: {
                    required: true,
                    number: true,
                    range: [0, 10]
                },
                semester2: {
                    required: true,
                    number: true,
                    range: [0, 10]
                },
                semester3: {
                    required: true,
                    number: true,
                    range: [0, 10]
                },
                semester4: {
                    required: true,
                    number: true,
                    range: [0, 10]
                },
                semester5: {
                    required: true,
                    number: true,
                    range: [0, 10]
                },
                semester6: {
                    required: true,
                    number: true,
                    range: [0, 10]
                },
                semester7: {
                    required: true,
                    number: true,
                    range: [0, 10]
                },
                semester8: {
                    required: true,
                    number: true,
                    range: [0, 10]
                }
            }
        });
    </script>
</body>

</html>