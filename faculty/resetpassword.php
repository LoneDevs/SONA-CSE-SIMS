<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Change Password</title>
    <?php

    include '../inc/style.inc.php';

    ?>
</head>

<body>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Change password</li>
        </ol>
    </nav>
    <center>
        <?php

        require '../cleaninput.php'; //clean form inputs
        require 'authenticate.php';
        require 'sessionmanager.php';
        require 'csrf.php';

        session_start();

        if (!isset($_SESSION['faculty'])) {
            header("Location: login.php");
        }else{
        sessionTimer();


        if (empty($_SESSION['key']))
            $_SESSION['key'] = getKey();

        $csrf = getToken($_SESSION['key']);

        $name = $_SESSION['name'];
        $id =$_SESSION['id'];
        if (isset($_POST['reset'])) {
            if (!hash_equals($csrf, $_POST['csrf'])) {
                csrfError();
                die();
            }
            $current_password = cleanInput($_POST['current_password']);
            $new_password = cleanInput($_POST['new_password']);

            $flag = facultyPasswordReset($id, $current_password, $new_password);
            if (strcmp($flag, 'success') == 0) {
                echo '<div class="alert alert-success" role="alert">  Password Reset Successful  </div>';
            } else {
                echo '<div class="alert alert-danger" role="alert"> ' . $flag . ' ! </div>';
            }
        }

    }
        ?>
    </center>
    <section class="container-fluid">
        <section class="row justify-content-center">
            <section class="col-12 col-sm-6 col-md-3 ">
                <form action="" class="form-container" method="post" id="resetForm">
                    <input type="hidden" name='csrf' value="<?php echo $csrf ?>">
                    <h5>Reset Password for <?php echo $name?></h5>
                    <div class="form-group">
                        <label for=""></label>
                        <input type="password" class="form-control" name="current_password" id="" placeholder="Old Password" required>
                    </div>

                    <div class="form-group">
                        <label for=""></label>
                        <input type="password" class="form-control" name="new_password" placeholder="New Password" required id="newPassword">
                    </div>


                    <div class="form-group">
                        <label for=""></label>
                        <input type="password" class="form-control" name="retype_password" placeholder="Retype New Password" required id="rePassword">
                    </div>


                    <button type="submit" class="btn btn-primary" name="reset">Submit</button>
                </form>
            </section>
        </section>
    </section>

    <?php

    include '../inc/js.inc.php';

    ?>

    <script>
        $("#resetForm").validate({
            rules: {
                current_password: {
                    required: true,
                    rangelength: [8, 64]
                },
                new_password: {
                    required: true,
                    rangelength: [8, 64],
                    equalTo: "#rePassword"


                },
                retype_password: {
                    required: true,
                    rangelength: [8, 64],
                    equalTo: "#newPassword"
                }
            },
            messages: {
                current_password: {
                    required: "Password cannot be left empty !",
                    rangelength: "Your password must be 8 to 64 characters in length !"
                },
                new_password: {
                    required: "Password cannot be left empty !",
                    rangelength: "Your password must be 8 to 64 characters in length !",
                    equalTo: "Passwords don\'t match !"


                },
                retype_password: {
                    required: "Password cannot be left empty !",
                    rangelength: "Your password must be 8 to 64 characters in length !",
                    equalTo: "Passwords don\'t match !"
                }
            }

        });
    </script>

</body>

</html>