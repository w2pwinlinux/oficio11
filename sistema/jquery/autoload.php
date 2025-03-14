<?php
require_once '../Connections/enlace.php';
require_once '../../funciones/tools.php';
require_once '../../model/class.medoogn.php';
require_once '../../model/class.medoogn_normal.php';

$cn = new consumomedoo($cnq);

//require_once '../../funciones/sesiones.php';

if (isset($_SESSION["user"])) {

    $user    = $_SESSION["user"];
    $user_vd = vd($user, "text");

    $level    = $_SESSION["user"];
    $level_vd = vd($level, "text");

    $nombrecompleto    = $_SESSION["nombrecompleto"];
    $nombrecompleto_vd = vd($nombrecompleto, "text");

    //pf($_SESSION,1);

}

