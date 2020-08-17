    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php
        session_start();

        require '../../cleaninput.php';
        require 'process.php';
        require 'sessionmanager.php';
        require '../csrf.php';


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
        <title>Extra Curricular</title>

        <?php

        include '../../inc/style.inc.php';
        ?>

    </head>

    <body>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/student/extra-curricular">Extra-Curricular</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>

<center>
        <?php
        if (isset($_POST['talent'])) {
            if (!hash_equals($csrf, $_POST['csrf'])) {
                csrfError();
                die();
            }
            foreach ($_POST as $key => $value) {
                $_POST[$key] = cleanInput($value);
            }
            if (empty($_POST['url'])) {
                $_POST['url'] = "unavailable.html";
            }
            $talentMsg = insertStudentTalent($_SESSION['admnno'], $_POST);
            if (strcmp($talentMsg, 'success') == 0) {
                echo '<div class="alert alert-success" role="alert"> Details Updated successfully</div>';
                //header("Location: index.php");
            } else {
                echo '<div class="alert alert-danger" role="alert"> Error ! ' . $talentMsg . ' </div>';
            }
        }

        if (isset($_POST['achievement'])) {
            if (!hash_equals($csrf, $_POST['csrf'])) {
                csrfError();
                die();
            }
            foreach ($_POST as $key => $value) {
                $_POST[$key] = cleanInput($value);
            }
            if (empty($_POST['url'])) {
                $_POST['url'] = "unavailable.html";
            }

            $achievementMsg = insertStudentAchievement($_SESSION['admnno'], $_POST);
            if (strcmp($achievementMsg, 'success') == 0) {
                echo '<div class="alert alert-success" role="alert"> Details Updated successfully</div>';
                //header("Location: index.php");
            } else {
                echo '<div class="alert alert-danger" role="alert"> Error ! ' . $achievementMsg . ' </div>';
            }
        }

        ?>

</center>
        <?php

        $talents = fetchStudentTalents($_SESSION['admnno']);

        if (strcmp('&nbsp', $talents) !== 0) {
            echo '
        <br>
        <section class="container-lg container-md container-sm ">
                <div class="cont">
                <h4>Talents</h4>
                    <div class="accordion" id="Talents">
                        ' . $talents . '
                    </div>
                </div>
            </section>
            ';
        }
        ?>
        <br>
        <section class="container-lg container-md container-sm ">
            <div class="cont">
                <form action="" id="talentForm" method="post">
                    <input type="hidden" name='csrf' value="<?php echo $csrf ?>">
                    <h1>Add Talent :</h1>
                    <div class="form-group">
                        <label for="title">Title : </label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="" aria-describedby="helpId">
                        <small id="helpId" class="text-muted">Title for your talent</small>
                    </div>
                    <div class="form-group">
                        <label for="description">Description : </label>
                        <textarea class="form-control" name="description" id="" rows="5"></textarea>
                        <small id="helpId" class="text-muted">Talent Description</small>
                    </div>
                    <div class="form-group">
                        <label for="url">Video / Image proof link of your talent ( optional ) :</label>
                        <input type="url" name="url"  class="form-control" placeholder="" aria-describedby="helpId">
                        <small id="helpId" class="text-muted">Link for talent proof</small>
                    </div>
                    <button type="submit" name="talent" class="btn btn-primary">Add Talent</button>
                </form>
            </div>
        </section>
        <br>


        <?php

        $achievements = fetchStudentAchievements($_SESSION['admnno']);

        if (strcmp('&nbsp', $achievements) !== 0) {
            echo '
        <br>
        <section class="container-lg container-md container-sm ">
                <div class="cont">
                <h4>Achievements : </h4>
                    <div class="accordion" id="Achievements">
                        ' . $achievements . '
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
                <form action="" id="achievementForm" method="post">
                    <input type="hidden" name='csrf' value="<?php echo $csrf ?>">
                    <h1>Add Achievement :</h1>
                    <div class="form-group">
                        <label for="title">Title : </label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="" aria-describedby="helpId">
                        <small id="helpId" class="text-muted">Title for your achievement</small>
                    </div>
                    <div class="form-group">
                        <label for="description">Description : </label>
                        <textarea class="form-control" name="description" id="" rows="5"></textarea>
                        <small id="helpId" class="text-muted">Achievement Description</small>
                    </div>
                    <div class="form-group">
                        <label for="url">Certificate Image link ( optional ) :</label>
                        <input type="url" name="url" id="url" class="form-control" placeholder="" aria-describedby="helpId">
                        <small id="helpId" class="text-muted">Link for achievement proof</small>
                    </div>
                    <button type="submit" name="achievement" class="btn btn-primary">Add Achievement</button>
                </form>
            </div>
        </section>
        <br>

        <?php
        include '../../inc/js.inc.php';
        ?>
        <script>
            $('.collapse').collapse();
            $("#talentForm").validate({
                rules: {
                    title: {
                        required: true,
                        rangelength: [2, 100]
                    },
                    description: {
                        required: true,
                        rangelength: [2, 300]
                    },
                    url: {
                        url: true
                    }
                }

            });

            $("#achievementForm").validate({
                rules: {
                    title: {
                        required: true,
                        rangelength: [2, 100]
                    },
                    description: {
                        required: true,
                        rangelength: [2, 300]
                    },
                    url: {
                        url: true
                    }
                }

            });
        </script>


    </body>

    </html>