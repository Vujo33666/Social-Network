<?php

ob_start(); // turns on output buffering , spremamo output svakog echo-a
session_start(); // start sesije u koju ce se snimiti varijable ukoliko dode do exceptiona prilikom validacije unesenih podataka

$timezone=date_default_timezone_set("Europe/Zagreb");
$con = mysqli_connect("localhost:3307","root","","social");

?>