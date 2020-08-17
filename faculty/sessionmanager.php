<?php
function sessionTimer()
{
    if ($_SESSION['session_time'] < time()) {
        session_destroy();
        header("Location: login.php?expired=true");
    }
}
