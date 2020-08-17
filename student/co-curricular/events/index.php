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
        <title>Events</title>

        <?php

        include '../../../inc/style.inc.php';
        ?>

    </head>

    <body>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/student/co-curricular">Co-Curricular</a></li>
                <li class="breadcrumb-item active" aria-current="page">Events</li>
            </ol>
        </nav>
        <center>
            <?php
            if (isset($_POST['intra']) || isset($_POST['inter'])) {
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

                $Msg = "Invalid Request ! ";

                if (isset($_POST['intra'])) {
                    $Msg = insertStudentIntraActivity($_SESSION['admnno'], $_POST);
                }

                if (isset($_POST['inter'])) {
                    $Msg = insertStudentInterActivity($_SESSION['admnno'], $_POST);
                }

                if (strcmp($Msg, 'success') == 0) {
                    echo '<div class="alert alert-success" role="alert"> Details Updated successfully</div><br>';
                    //header("Location: view.php");
                } else {
                    echo '<div class="alert alert-danger" role="alert"> Error ! ' . $Msg . ' </div><br>';
                }
            }


            ?>
        </center>

        <?php

        $intra = fetchStudentIntraActivities($_SESSION['admnno']);

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
        }
        ?>
        <br>
        <section class="container-lg container-md container-sm ">
            <div class="cont">
                <form action="" id="intraForm" method="post">
                    <input type="hidden" name='csrf' value="<?php echo $csrf ?>">
                    <h1>Add Intra College Activity :</h1>

                    <div class="form-group">
                        <label for="title">Title : </label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="" aria-describedby="helpId">
                        <small id="helpId" class="text-muted">Title of the intra college event</small>
                    </div>
                    <div class="form-group">
                        <label for="description">Description : </label>
                        <textarea class="form-control" name="description" id="" rows="5"></textarea>
                        <small id="helpId" class="text-muted">Event Description</small>
                    </div>
                    <div class="form-group">
                        <label for="role">Role : </label>
                        <select class="form-control" name="role" id="role">
                            <option value="Participant">Participant</option>
                            <option value="Organizer">Organizer</option>
                        </select>
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
                        <label for="certificate">Certificate / Prize ( image url ) :</label>
                        <input type="url" name="certificate" id="certificate" class="form-control" placeholder="" aria-describedby="helpId">
                        <small id="helpId" class="text-muted">Url of certificate image</small>
                    </div>

                    <button type="submit" name="intra" class="btn btn-primary">Add Activity</button>
                </form>
            </div>
        </section>


        <?php

        $inter = fetchStudentInterActivities($_SESSION['admnno']);

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
        }
        ?>


        <br>
        <center>
    <div class="alert alert-warning" role="alert">
    Please submit the above form before proceeding to fill the below form
</div>
</center>
        <section class="container-lg container-md container-sm ">
            <div class="cont">
                <form action="" id="interForm" method="post">
                    <input type="hidden" name='csrf' value="<?php echo $csrf ?>">
                    <h1>Add Inter College Activity :</h1>

                    <div class="form-group">
                        <label for="title">Title : </label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="" aria-describedby="helpId">
                        <small id="helpId" class="text-muted">Title of the inter college event</small>
                    </div>
                    <div class="form-group">
                        <label for="description">Description : </label>
                        <textarea class="form-control" name="description" id="" rows="5"></textarea>
                        <small id="helpId" class="text-muted">Event Description</small>
                    </div>

                    <div class="form-group">
                        <label for="instituition_name">Instituition Name : </label>
                        <input type="text" name="instituition_name" id="instituition_name" class="form-control" placeholder="" aria-describedby="helpId">
                        <small id="helpId" class="text-muted">Name of the host instituition </small>
                    </div>
                    <div class="form-group">
                        <label for="instituition_name">Instituition Place : </label>
                        <input type="text" name="instituition_place" id="instituition_place" class="form-control" placeholder="" aria-describedby="helpId">
                        <small id="helpId" class="text-muted">District / location of instituition</small>
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
                        <label for="certificate">Certificate / Prize ( image url ) :</label>
                        <input type="url" name="certificate" id="certificate" class="form-control" placeholder="" aria-describedby="helpId">
                        <small id="helpId" class="text-muted">Url of certificate / prize image</small>
                    </div>

                    <button type="submit" name="inter" class="btn btn-primary">Add Activity</button>
                </form>
            </div>
        </section>

        <br>

        <?php
        include '../../../inc/js.inc.php';
        ?>
        <script>
            $('.collapse').collapse();
            $("#intraForm").validate({
                rules: {
                    title: {
                        required: true,
                        rangelength: [2, 100]
                    },
                    description: {
                        required: true,
                        rangelength: [2, 300]
                    },
                    role: {
                        required: true
                    },
                    semester: {
                        required: true
                    },
                    certificate: {
                        url: true
                    }
                }

            });

            $("#interForm").validate({
                rules: {
                    title: {
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
                    },
                    instituition_name: {
                        required: true,
                        rangelength: [2, 100]

                    },
                    instituition_place: {
                        required: true,
                        rangelength: [2, 100]

                    }
                }

            });
        </script>


    </body>

    </html>