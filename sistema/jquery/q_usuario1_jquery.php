<?php
require_once 'autoload.php';

if (isset($_REQUEST["opcion"])) {
    $opcion = $_REQUEST["opcion"];

    switch ($opcion) {
        case 99: //SELECCION DE DATOS

            //pf($_REQUEST,1);

            $page = isset($_REQUEST["page"]) ? intval($_REQUEST["page"]) : 1;
            $ROWS = isset($_REQUEST["rows"]) ? intval($_REQUEST["rows"]) : 25;

            $report = isset($_REQUEST["report"]) ? intval($_REQUEST["report"]) : 0;
            $DESDE  = ($page - 1) * $ROWS;

            $dinamico = isset($_REQUEST["dinamico"]) ? intval($_REQUEST["dinamico"]) : 0;

            //$estado_pac_revision = isset($_REQUEST["estado_global_estado"]) ? vd($_REQUEST["estado_global_estado"], "text") : vd("APROBADO", "text");
            //$tipo_solicitud      = isset($_REQUEST["tipo_solicitud"]) ? vd($_REQUEST["tipo_solicitud"], "text") : vd("BIEN", "text");

            $filtros = isset($_REQUEST["FILTRO"]) ? $_REQUEST["FILTRO"] : '';

            //$PARAM_ID_SUBPROGRAMA = vd($_SESSION["codigosp"], "int");

            if ($report == 1) {
                $filtros = b64d($filtros);
            }
            $SQLFiltro = filtroDinamico($filtros);
            $SQL_TOTAL = "
            SELECT COUNT[[*]] as TOTAL_ROW
             FROM Q_USUARIO
            WHERE 1= 1 ";

            //$SQL_TOTAL .= " AND TIPO = $tipo_solicitud";

            $SQL_TOTAL .= $SQLFiltro;

            $cn->execute($SQL_TOTAL, 2);
            $nn        = $cn->datos();
            $TOTAL_ROW = $nn[0]["TOTAL_ROW"];

            $SQL = "
            SELECT
            LOGIN,NOMBRECOMPLETO,NIVEL,ESTADO,CREATED,MODIFIED,
            NOMBRES,APELLIDOS,ELIMINADO,DOCUMENTO,CORREO
            , LOGIN AS ID
            FROM Q_USUARIO
            WHERE 1= 1 AND LOGIN NOT IN ('ROOT')
            ";

            $SQL .= $SQLFiltro;
            $SQL .= " ORDER BY CREATED DESC ";
            if ($dinamico == 0) {
                $SQL .= " limit $DESDE,$ROWS";
            }

            $cn->execute($SQL, 2);
            if ($cn->filas_afectada() > 0) {
                if ($dinamico == 0) {
                    if ($report == 1) {
                        $matriz_columnas = array();
//                 MODIFICAR ESTE CODIGO PARA EL REPORTE EN ESPAÑOL

                        $matriz_columnas[0] = array(
                            "LOGIN", 0, "NOMBRECOMPLETO", 1, "NIVEL", 2, "ESTADO", 3, "CREADO", 4,
                            "MODIFICADO", 5, "NOMBRES", 6, "APELLIDOS", 7, "ELIMINADO", 8, "DOCUMENTO", 9,
                            "CORREO", 10,
                        );

                        $matriz = remove_columnas_array($matriz_columnas, $cn->datos());
                    } else {
                        $matriz["rows"]  = $cn->datos();
                        $matriz["total"] = $TOTAL_ROW;
                    }
                } else {
                    if ($report == 1) {
                        $matriz_columnas = array();
                        //                    MODIFICAR ESTE CODIGO PARA EL REPORTE EN ESPAÑOL

                        $matriz_columnas[0] = array(
                            "LOGIN", 0, "NOMBRECOMPLETO", 1, "NIVEL", 2, "ESTADO", 3, "CREADO", 4,
                            "MODIFICADO", 5, "NOMBRES", 6, "APELLIDOS", 7, "ELIMINADO", 8, "DOCUMENTO", 9,
                            "CORREO", 10,
                        );

                        $matriz = remove_columnas_array($matriz_columnas, $cn->datos());
                    } else {
                        $matriz["rows"]  = $cn->datos();
                        $matriz["total"] = $TOTAL_ROW;
                    }
                }
            } else {
                $matriz["total"]   = -1;
                $matriz["mensaje"] = $cn->mensaje();
            }
            echo json_encode($matriz);
            break;

        case 1:

            $PARAM_LOGIN       = vd($_REQUEST["LOGIN"], "text");
            $PARAM_NOMBRES     = vd($_REQUEST["NOMBRES"], "text");
            $PARAM_APELLIDOS   = vd($_REQUEST["APELLIDOS"], "text");
            $PARAM_CLAVE       = vd(hash("sha256", strtoupper($_REQUEST["CLAVE"])), "text");
            $PARAM_CLAVE_PLANA = vd(strtoupper($_REQUEST["CLAVE"]), "text");
            $PARAM_NIVEL       = vd($_REQUEST["NIVEL"], "text");

            $sql = "SP_SELECT_Q_USUARIO_INSERT(
                $PARAM_LOGIN,
                $PARAM_NOMBRES,
                $PARAM_APELLIDOS,
                $PARAM_CLAVE,
                $PARAM_NIVEL,
                $PARAM_CLAVE_PLANA)";
            $cn->execute($sql, 0);

            if ($cn->filas_afectada() > 0) {
                $cc                      = $cn->datos();
                $matriz["fila_afectada"] = $cc[0]["FILA_AFECTADA"];
                $matriz["mensaje"]       = $cc[0]["MENSAJE"];
            } else {
                $matriz["fila_afectada"] = -1;

                $matriz["mensaje"] = $cn->mensaje();
            }

            echo json_encode($matriz);
            break;

        case 3:

            $PARAM_LOGIN     = vd($_REQUEST["LOGIN"], "text");
            $PARAM_NOMBRES   = vd($_REQUEST["NOMBRES"], "text");
            $PARAM_APELLIDOS = vd($_REQUEST["APELLIDOS"], "text");
            $PARAM_NIVEL     = vd($_REQUEST["NIVEL"], "text");

            $PARAM_ID = vd($_REQUEST["id"], "text");

            $SQL = "SP_SELECT_Q_USUARIO_UPDATE(
            $PARAM_LOGIN,
            $PARAM_NOMBRES,
            $PARAM_APELLIDOS,
            $PARAM_NIVEL,
            $PARAM_ID
            )";
            $cn->execute($SQL, 0);
            if ($cn->filas_afectada() > 0) {
                $cc                      = $cn->datos();
                $matriz["fila_afectada"] = $cc[0]["FILA_AFECTADA"];
                $matriz["mensaje"]       = $cc[0]["MENSAJE"];

            } else {
                $matriz["total"]   = -1;
                $matriz["mensaje"] = $cn->mensaje();
            }
            echo json_encode($matriz);
            break;

        case 11:

            $PARAM_LOGIN  = vd($_REQUEST["ID"], "text");
            $PARAM_ESTADO = vd($_REQUEST["ESTADO"], "text");

            $SQL = "SP_SELECT_Q_USUARIO_UPDATE_ESTADO(
            $PARAM_LOGIN,
            $PARAM_ESTADO
            )";
            $cn->execute($SQL, 0);
            if ($cn->filas_afectada() > 0) {
                $cc                      = $cn->datos();
                $matriz["fila_afectada"] = $cc[0]["FILA_AFECTADA"];
                $matriz["mensaje"]       = $cc[0]["MENSAJE"];

            } else {
                $matriz["total"]   = -1;
                $matriz["mensaje"] = $cn->mensaje();
            }
            echo json_encode($matriz);
            break;
    }
}
