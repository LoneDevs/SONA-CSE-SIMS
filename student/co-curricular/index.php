<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Co-Curricular</title>
    <?php

    include '../../inc/style.inc.php';

    ?>
    <style>
        .menu {
            margin-top: 10%;
        }
    </style>
</head>

<body>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Co-Curricular</li>
        </ol>
    </nav>
    <div style="text-align:center;" class="menu">
        <section class="container-lg container-md container-sm ">
            <div class="cont">
                <a href="/student/co-curricular/clubs" style="text-decoration: none;">
                    <button type="button" class="btn btn-outline-secondary btn-lg btn-block">Clubs &nbsp;&nbsp;&nbsp;<i class="fas fa-edit"></i></button>
                </a>
                <br>
                <a href="/student/co-curricular/courses" style="text-decoration: none;">
                    <button type="button" class="btn btn-outline-secondary btn-lg btn-block">Courses&nbsp;&nbsp;&nbsp; <i class="fas fa-edit"></i></button>
                </a>
                <br>
                <a href="/student/co-curricular/events" style="text-decoration: none;">
                    <button type="button" class="btn btn-outline-secondary btn-lg btn-block">Events&nbsp;&nbsp;&nbsp; <i class="fas fa-edit"></i></button>
                </a>
            </div>
        </section>
    </div>
    <br>

</body>

</html>