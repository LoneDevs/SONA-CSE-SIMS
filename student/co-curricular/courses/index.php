    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php
        session_start();

        require '../../../cleaninput.php';
        require 'process.php';
        require '../sessionmanager.php';
        require '../../csrf.php';


        if (!isset($_SESSION['admnno'])) {
            header("Location: ../login.php");
        }

        sessionTimer();

        if (empty($_SESSION['key']))
            $_SESSION['key'] = getKey();

        $csrf = getToken($_SESSION['key']);
        ?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Extra Courses</title>

        <?php

        include '../../../inc/style.inc.php';
        ?>

    </head>

    <body>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/student/co-curricular">Co-Curricular</a></li>
            <li class="breadcrumb-item active" aria-current="page">Courses</li>
        </ol>
        </nav>
        <center><?php
        if (isset($_POST['course'])) {
            if (!hash_equals($csrf, $_POST['csrf'])) {
                csrfError();
                die();
            }
            foreach ($_POST as $key => $value) {
                $_POST[$key] = cleanInput($value);
            }
            if (empty($_POST['certificate'])) {
                $_POST['certificate'] = "unavailable.html";
            }
            $Msg = insertStudentCourse($_SESSION['admnno'], $_POST);
            if (strcmp($Msg, 'success') == 0) {
                echo '<div class="alert alert-success" role="alert"> Details Updated successfully</div>';
                //header("Location: view.php");
            } else {
                echo '<div class="alert alert-danger" role="alert"> Error ! ' . $Msg . ' </div>';
            }
        }


        ?>
        </center>
        <?php

        $courses = fetchStudentCourses($_SESSION['admnno']);

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
        }
        ?>
        <br>
        <section class="container-lg container-md container-sm ">
            <div class="cont">
                <form action="" id="courseForm" method="post" onsubmit="return confirm('Are you sure you want to submit ?');">
                    <input type="hidden" name='csrf' value="<?php echo $csrf ?>">
                    <h1>Add Course :</h1>

                    <div class="form-group">
                        <label for="title">Title : </label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="" aria-describedby="helpId">
                        <small id="helpId" class="text-muted">Name of course / certification </small>
                    </div>
                    <div class="form-group">
                        <label for="description">Description : </label>
                        <textarea class="form-control" name="description" id="" rows="5"></textarea>
                        <small id="helpId" class="text-muted">Event Description</small>
                    </div>

                    <div class="form-group">
                        <label for="semester">Semester : </label>
                        <select class="form-control" name="semester" id="role">
                            <option value="I">I</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                            <option value="IV">IV</option>
                            <option value="V">V</option>
                            <option value="VI">VI</option>
                            <option value="VII">VII</option>
                            <option value="vIII">VIII</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="mode">Mode : </label>
                        <select class="form-control" name="mode" id="role">
                            <option value="Online">Online</option>
                            <option value="Offline">Offline</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="instituition">Instituition : </label>
                        <input type="text" name="instituition" id="instituition" class="form-control" placeholder="eg : Udemy " aria-describedby="helpId">
                        <small id="helpId" class="text-muted">Name of the course providing instituition </small>
                    </div>

                    <div class="form-group">
                        <label for="domain">Domain : </label>
                        <input type="text" name="domain" id="domain" class="form-control" placeholder="eg : AI , ML" aria-describedby="helpId">
                        <small id="helpId" class="text-muted">The domain which this course belongs to </small>
                    </div>

                    <div class="form-group">
                        <label for="certificate">Certificate / Prize ( image url ) :</label>
                        <input type="url" name="certificate" id="certificate" class="form-control" placeholder="" aria-describedby="helpId">
                        <small id="helpId" class="text-muted"> Url of certificate image</small>
                    </div>
                    <button type="submit" name="course" class="btn btn-primary">Add Course</button>
                </form>
            </div>
        </section>
        <br>

        <?php
        include '../../../inc/js.inc.php';
        ?>
        <script>
            $('.collapse').collapse();
            $("#courseForm").validate({
                rules: {
                    title: {
                        required: true,
                        rangelength: [2, 100]
                    },
                    domain: {
                        required: true,
                        rangelength: [2, 100]
                    },
                    instituition: {
                        required: true,
                        rangelength: [2, 100]
                    },
                    description: {
                        required: true,
                        rangelength: [2, 300]
                    },
                    semester: {
                        required: true
                    },
                    certificate: {
                        url: true
                    }
                }

            });
        </script>


    </body>

    </html>