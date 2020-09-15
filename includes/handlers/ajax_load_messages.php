<?php
include("../../config/config.php");
include("../classes/User.php");
include("../classes/Message.php");

$limit=7; //na 7 smo ogranicili

$message = new Message($con,$_REQUEST['userLoggedIn']);
echo $message->getConvosDropdown($_REQUEST,$limit);

?>