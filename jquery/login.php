<?php
require_once 'autoload.php';

$opcion = db64d($_REQUEST['opcion']);
//$cn     = new consumomedoo($cnq);

if (isset($_REQUEST['opcion'])) {
    switch ($opcion) {
        case 0: //validacion de usuario
            if ((isset($_REQUEST['usuario'])) and (isset($_REQUEST['clave']))) {
                $aux1    = strtoupper(decry($_REQUEST['usuario']));
                $aux2    = strtoupper(decry($_REQUEST['clave']));
                $usuario = vd($aux1, "text");
                $clave   = vd(hash('sha256', $aux2), "text");

                /** se cambi a a hash sha256 */
                $SQL = "
                 SELECT  u.login,  u.nombrecompleto, u.nivel
                 FROM Q_usuario u
                 where u.login= $usuario
                 and u.clave = $clave
                 and u.eliminado =0
                 and u.estado ='ACTIVO'";

                $SQL = "SP_SELECT_Q_USUARIO_LOGIN($usuario,$clave)";

                $cn->execute($SQL, 0);

                if ($cn->filas_afectada() > 0) {
                    if ($cn->filas_afectada() == 1) {
                        $_matriz        = $cn->datos();
                        $usuario        = $_matriz[0]['LOGIN'];
                        $nombrecompleto = $_matriz[0]['NOMBRECOMPLETO'];
                        $nivel          = $_matriz[0]['NIVEL'];

                        if (true) {

                            $_matriz['fila_afectada'] = $cn->filas_afectada();
                            if (!isset($_SESSION)) {
                                session_start();
                            }
                            // CARGAR EL IVA COMO SESION
                            // FIN
                            $_SESSION['user']           = $usuario;
                            $_SESSION['level']          = $nivel;
                            $_SESSION['nombrecompleto'] = $nombrecompleto;
                            //$_SESSION['proyecto'] = $proyecto;

                            $_SESSION["app"] = "oficio11";

                            //$_SESSION["verifica_token"] = $VERIFICADO_TOKEN;

                            //$_SESSION["correo"]    = $CORREO;

                            //$mensaje = "ACCESO AL SISTEMA DE USUARIO " . $_SESSION['user'] . " con nivel de permisos  : " . $_SESSION['level'];
                            //$cnm = new consumomedoo($hostname,$database,$username,$password,$port);
                            //grabar_auditoria($mensaje,$cnm);

                            //pf($_SESSION,1);

                        } else {
                            $_matriz['mensaje']       = "DATOS ERRONEOS O USUARIO INACTIVO";
                            $_matriz['fila_afectada'] = -1;

                        }

                    } else {
                        $_matriz['fila_afectada'] = -1;
                        $_matriz['mensaje']       = "DATOS ERRONEOS f";
                    }
                } else {
                    $_matriz['mensaje']       = "DATOS ERRONEOS O USUARIO INACTIVO";
                    $_matriz['fila_afectada'] = $cn->filas_afectada();
                }
            }
            print json_encode($_matriz);
            break;

    }
}
