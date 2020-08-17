<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Create new Password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0,user-scalable=no,scrollable:yes ">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .form-container {
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px black;
            position: absolute;
            top: 25vh;
        }

        .title {
            text-align: center;
            align-content: center;
            position: relative;
            top: 5vh;
        }

        .alert {
            text-align: center;
            align-content: center;
            position: relative;
            top: 7vh;


        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Password ?</li>
        </ol>
    </nav>
    <center>
        <?php

        require '../cleaninput.php'; //clean form inputs
        require 'authenticate.php';
        require 'csrf.php';

        session_start();
        // if  user in session
        if (isset($_SESSION["admnno"])) {
            header("Location: dashboard.php");
        }

        if (empty($_SESSION['key']))
            $_SESSION['key'] = getKey();

        $csrf = getToken($_SESSION['key']);



        if (isset($_POST['create-new-password'])) {
            if (!hash_equals($csrf, $_POST['csrf'])) {
                csrfError();
                die();
            }
            $selector = $_POST['selector'];
            $validator = $_POST['validator'];
            $new_password = cleanInput($_POST['new_password']);
            $message = studentForgotPasswordReset($selector, $validator, $new_password);
            if (strcmp($message, "success") == 0) {
                echo '<div class="alert alert-success" role="alert">
                Password Updated successfully !</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
            }
        }


        ?>

        <?php
        $selector = $_GET["selector"];
        $validator = $_GET["validator"];

        if (empty($selector) || empty($validator)) {
            echo "<h1>Invalid Request ! </h1>";
        } else if (ctype_xdigit($selector) === true && ctype_xdigit($validator) == true) {

        ?>
    </center>
    <section class="container-fluid">
        <section class="row justify-content-center">
            <section class="col-12 col-sm-6 col-md-3 ">
                <div class="title">
                    <h1>Sona CSE SIMS </h1>
                </div>
                <form action="" class="form-container" method="post" id="createPasswordForm">
                    <input type="hidden" name='csrf' value="<?php echo $csrf ?>">
                    <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                    <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                    <div class="">
                        <h4>Create new Password</h4>
                    </div>
                    <div class=" form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" name="new_password" placeholder="New Password" required id="newPassword">
                    </div>


                    <div class="form-group">
                        <label for="retype_password">Retype password</label>
                        <input type="password" class="form-control" name="retype_password" placeholder="Retype New Password" required id="rePassword">
                    </div>


                    <button type="submit" class="btn btn-primary" name="create-new-password">Reset</button>
                </form>
                </form>
            </section>
        </section>
    </section>

<?php

        }
?>
<?php

include '../inc/js.inc.php';

?>

<script>
    $("#createPasswordForm").validate({
        rules: {
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