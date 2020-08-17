<?php
require 'authenticate.php';
require 'sessionmanager.php';
session_start();

define('SITE_ROOT', realpath(dirname(__FILE__)));

$path = SITE_ROOT . '/profile/';

sessionTimer();
//echo $path;
if (!isset($_SESSION['admnno'])) {
    header("Location: login.php");
} else {
    $admnno = $_SESSION['admnno'];
    $image = $_SESSION['image'];
    if (isset($_FILES['profile_image'])) {
        $errors = array();
        $file_name = $_FILES['profile_image']['name'];
        $file_size = $_FILES['profile_image']['size'];
        $file_tmp = $_FILES['profile_image']['tmp_name'];
        $file_type = $_FILES['profile_image']['type'];
        $file_ext = strtolower(end(explode('.', $file_name)));

        $extensions = array("jpeg", "jpg");

        if (in_array($file_ext, $extensions) === false) {
            $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
        }

        if ($file_size > 2097152) {
            $errors[] = 'File size must be less than 2 MB';
        }

        if (empty($errors) == true) {
            $newImage = studentImageUpload($admnno, $image, $path);
            move_uploaded_file($file_tmp, SITE_ROOT . "/profile/" . $newImage);
            header("Refresh:0");
        } else {
            foreach($errors as $error){
                echo "<h1>".$error."</h1>";
            }
        }
    }

?>
    <html>
    <?php

    include '../inc/style.inc.php';

    ?>
    <style>
        .avatar {
            vertical-align: middle;
            width: 20vh;
            height: 20vh;
            border-radius: 50%;
            border:2px solid black;
        }
    </style>

    <body>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Change Profile Picture</li>
        </ol>
    </nav>
        <br>
        <center> <img src="profile/<?php echo $image ?>" alt="" class="avatar"> </center>
        <section class="container-fluid">
            <section class="row justify-content-center">
                <section class="col-12 col-sm-6 col-md-3 ">
                    <form action="" class="form-container" method="POST" enctype="multipart/form-data">
                        <h1>Upload Profile Pic</h1>
                        <div class="form-check">
                            <label class="form-check-label">Choose Image</label>
                            <input type="file" name="profile_image" id="" accept="image/jpg,image/jpeg" required>
                        </div>
                        <br>
                        <button name="file" type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </section>
            </section>
        </section>
    </body>
    </html>
<?php
}
?>