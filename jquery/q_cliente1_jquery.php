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
             FROM Q_CLIENTE
            WHERE 1= 1 ";

            //$SQL_TOTAL .= " AND TIPO = $tipo_solicitud";

            $SQL_TOTAL .= $SQLFiltro;

            $cn->execute($SQL_TOTAL, 2);
            $nn        = $cn->datos();
            $TOTAL_ROW = $nn[0]["TOTAL_ROW"];

            $SQL = "
            SELECT *
            FROM Q_CLIENTE
            WHERE 1= 1 
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
                            "ID", 0, "NOMBRE", 1, "CIUDAD", 2, "DIRECCION", 3, "TELEFONO", 4,
                            "CORREO", 5, "TIPO", 6, "CREADO", 7
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
                            "ID", 0, "NOMBRE", 1, "CIUDAD", 2, "DIRECCION", 3, "TELEFONO", 4,
                            "CORREO", 5, "TIPO", 6, "CREADO", 7
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

            $PARAM_NOMBRE       = vd($_REQUEST["NOMBRE"], "text");
            $PARAM_CIUDAD     = vd($_REQUEST["CIUDAD"], "text");
            $PARAM_DIRECCION   = vd($_REQUEST["CIUDAD"], "text");
            $PARAM_TELEFONO       = vd($_REQUEST["TELEFONO"], "text");
            $PARAM_CORREO = vd($_REQUEST["CORREO"], "text");
            $PARAM_TIPO       = vd($_REQUEST["TIPO"], "text");

            $sql = "SP_SELECT_Q_CLIENTE_INSERT(
                $PARAM_NOMBRE,
                $PARAM_CIUDAD,
                $PARAM_DIRECCION,
                $PARAM_TELEFONO,
                $PARAM_CORREO,
                $PARAM_TIPO
            )";
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

            $PARAM_NOMBRE       = vd($_REQUEST["NOMBRE"], "text");
            $PARAM_CIUDAD     = vd($_REQUEST["CIUDAD"], "text");
            $PARAM_DIRECCION   = vd($_REQUEST["DIRECCION"], "text");
            $PARAM_TELEFONO       = vd($_REQUEST["TELEFONO"], "text");
            $PARAM_CORREO = vd($_REQUEST["CORREO"], "text");
            $PARAM_TIPO       = vd($_REQUEST["TIPO"], "text");

            $PARAM_ID = vd($_REQUEST["id"], "int");

            $SQL = "SP_SELECT_Q_CLIENTE_UPDATE(
            $PARAM_NOMBRE,
            $PARAM_CIUDAD,
            $PARAM_DIRECCION,
            $PARAM_TELEFONO,
            $PARAM_CORREO,
            $PARAM_TIPO,
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

            $SQL = "SP_SELECT_Q_CLIENTE_UPDATE_ESTADO(
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
