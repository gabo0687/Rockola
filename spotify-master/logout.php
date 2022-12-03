<?php
session_start();
$placeId = $_SESSION['place_id'] ;
session_destroy();

header("Location: http://localhost/rockola/spotify-master/_inc/home.inc.php?place=".base64_encode(base64_encode($placeId)));