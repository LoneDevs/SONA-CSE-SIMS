<?php
function sessionTimer()
{
    if ($_SESSION['session_time'] < time()) {
        session_destroy();
        header("Location: ../../../student/login.php?expired=true");
    }
}
