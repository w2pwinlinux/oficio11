<?php
if (isset($_SESSION)){}else{session_start();}

require_once('Connections/enlace.php');
require_once('../funciones/tools.php');
require_once('../model/class.medoogn.php');
$cn = new consumomedoo($cnq);




