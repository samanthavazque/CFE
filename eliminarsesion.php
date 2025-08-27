<?php
    session_start();
    $dev=session_destroy();

    echo $dev;
?>