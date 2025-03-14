
<?php
require_once "autoload.php";

if (isset($_REQUEST["opcion"])) {
    $opcion = $_REQUEST["opcion"];

    switch ($opcion) {
        case 99: //SELECCION DE DATOS
            $page     = isset($_REQUEST["page"]) ? intval($_REQUEST["page"]) : 1;
            $ROWS     = isset($_REQUEST["rows"]) ? intval($_REQUEST["rows"]) : 10;
            $report   = isset($_REQUEST["report"]) ? intval($_REQUEST["report"]) : 0;
            $DESDE    = ($page - 1) * $ROWS;
            $dinamico = isset($_REQUEST["dinamico"]) ? intval($_REQUEST["dinamico"]) : 0;
            if ($dinamico == 0) {
                $SQL = "SP_SELECT_ITEMS_PRESUPUESTARIOS_FULL($DESDE,$ROWS)";
                $cn->execute($SQL, 0);
            } else {
                $filtros = isset($_REQUEST["FILTRO"]) ? $_REQUEST["FILTRO"] : '';
                if ($report == 1) {
                    $filtros = b64d($filtros);
                }
                $SQLFiltro = filtroDinamico($filtros);
                $SQL_TOTAL = " SELECT COUNT[[*]] as TOTAL_ROW ";
                $SQL_TOTAL .= " FROM items_presupuestarios ";
                $cn->execute($SQL_TOTAL, 2);
                $nn  = $cn->datos();
                $SQL = " SELECT * ";
                $SQL .= "FROM items_presupuestarios ";
                $SQL .= "WHERE 1= 1 AND NIVEL = 4 ";
                $SQL .= $SQLFiltro;
                $cn->execute($SQL, 2);
            }
            if ($cn->filas_afectada() > 0) {
                if ($dinamico == 0) {
                    if ($report == 1) {
                        $matriz_columnas = array();
//                 MODIFICAR ESTE CODIGO PARA EL REPORTE EN ESPAÑOL
                        $matriz_columnas[0] = array("ITEM_PRESUPUESTARIO", 0, "DESCRIPCION", 1, "GRUPO_CUENTA", 2, "NIVEL", 3);
                        $matriz             = remove_columnas_array($matriz_columnas, $cn->datos());
                    } else {
                        $matriz["rows"]  = $cn->datos();
                        $matriz["total"] = $matriz["rows"][0]["TOTAL_ROW"];
                    }
                } else {
                    if ($report == 1) {
                        $matriz_columnas = array();
                        //                    MODIFICAR ESTE CODIGO PARA EL REPORTE EN ESPAÑOL
                        $matriz_columnas[0] = array("ITEM_PRESUPUESTARIO", 0, "DESCRIPCION", 1, "GRUPO_CUENTA", 2, "NIVEL", 3);
                        $matriz             = remove_columnas_array($matriz_columnas, $cn->datos());
                    } else {
                        $matriz["rows"]  = $cn->datos();
                        $matriz["total"] = $nn[0]["TOTAL_ROW"];
                    }
                }
            } else {
                $matriz["total"]   = -1;
                $matriz["mensaje"] = $cn->mensaje();
            }
            echo json_encode($matriz);
            break;

        case 5: // APROBADO ADMINISTRATIVO , FINANCIEO
            if (count($_REQUEST) > 0) {
            	// SE APLICA EL FILTRO PARA MEJORAR EL SELECT EN LA CREACION DE NUEVO

                $sql = "
                SELECT id,NOMBRE
                FROM Q_CATEGORIA
                WHERE 1= 1  AND ESTADO = 1
                ";
                


                $cn->execute($sql, 2);

                if ($cn->filas_afectada() >= 0) {
                    $_matriz = $cn->datos();
                    for ($i=0; $i <count($_matriz) ; $i++) { 
                        if ($i==0){
                            $_matriz[$i]["selected"]=true;

                        }else{
                            $_matriz[$i]["selected"]=false;
                        }
                        // code...
                    }

                } else {
                    $_matriz["fila_afectada"] = -1;
                    $_matriz["mensaje"]       = $cn->mensaje();
                }
            } else {
                $_matriz["fila_afectada"] = -1;
                $_matriz["mensaje"]       = "ERROR EN PARAMETROS";
            }

            echo json_encode($_matriz);
            break;

    }
}