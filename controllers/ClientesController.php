<?php
namespace Controllers;

use DateTime;
use MVC\Router;
use Model\Estados;
use Model\Usuario;
use Model\Clientes;
use Model\Deudores;
use Model\Operaciones;
use Model\Temp_cartera;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ClientesController {
    public static function index(Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        $resultado = $_GET['resultado'] ?? null;
        $clientes=Clientes::all();
        $usuarios=Usuario::all();
        
        $router->render('clientes/clientes', [
            'titulo'=> 'Clientes',
            'alertas'=>$alertas,
            'resultado'=> $resultado,
            'clientes'=>$clientes,
            'usuarios'=>$usuarios
        ]);
    }

    public static function crear(Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        $cliente = new Clientes;
        $usuarioId=$_SESSION['id'];
                
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST['usuarios_id'] = $_SESSION['id'];
            $cliente->sincronizar($_POST);
            
            $alertas = $cliente->validarCrearCliente();
            if(empty($alertas)) {
                //Crear un nuevo usuario
                $resultado= $cliente->guardar();
                if($resultado) {
                    header ('Location: /clientes?resultado=2'); 
                }
            }
        }

        $router->render('clientes/crear-cliente', [
            'titulo'=> 'Crear cliente',
            'alertas'=>$alertas,
            'cliente'=>$cliente,
            'usuarioId'=>$usuarioId
        ]);
    }    

    public static function editar(Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        $id=$_GET['id'];
        filter_var($id, FILTER_VALIDATE_INT);
        if(!$id) {
            header('Location: /clientes');
        }
        $cliente = Clientes::find($id);
        $usuario = Usuario::find($id);
        $usuarioId=$_SESSION['id'];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST['usuarios_id'] = $_SESSION['id'];
            $cliente->ultModificacion = date('Y-m-d');
            $cliente->sincronizar($_POST);
            $alertas = $cliente->validarCrearCliente();
            if(!$alertas) {
                $resultado=$cliente->guardar();
            }
            if ($resultado) {
                // Redireccionar al usuario NUNCA ANTES DEL HTML
                header('Location: /clientes?resultado=2');
            }
        }
        
        $router->render('clientes/editar-cliente', [
            'titulo'=> 'Editar cliente',
            'cliente'=> $cliente,
            'usuario'=> $usuario,
            'usuarioId'=> $usuarioId,
            'alertas'=> $alertas
        ]);
    }

    public static function perfil(Router $router) {
        session_start();
        isAuth();
        $clienteId = $_GET['id'];
        if (!filter_var($clienteId, FILTER_VALIDATE_INT)) {
            header('Location: /clientes');
            exit();
        }
        $cliente = Clientes::find($clienteId);
        $resultado = $_GET['resultado'] ?? null;
        
        $carteraCliente = Operaciones::getByClienteId($clienteId);
        $totalCasos = count($carteraCliente);
        $deudores = Deudores::all();
        $estados = Estados::all();

        $dniUnicos = [];
        foreach ($carteraCliente as $cartera) {
            $dni = $cartera->nro_doc;
            if (!in_array($dni, $dniUnicos)) {
                $dniUnicos[] = $dni; // Agrega el DNI a la lista de DNI únicos
            }
        }
        $cantidadDniUnicos = count($dniUnicos);

        $deudaTotal = 0;

        // Itera sobre los resultados de la tabla y suma las deudas
        foreach ($carteraCliente as $cartera) {
            // Elimina los puntos de los miles y reemplaza la coma decimal por un punto
            $deuda = str_replace('.', '', $cartera->deuda_activa);
            $deuda = str_replace(',', '.', $deuda);
            
            // Convierte la deuda en un número
            $deuda = floatval($deuda);
            
            // Suma la deuda al total
            $deudaTotal += $deuda;
        }

        $deudaActivaTotal = 0;
        foreach ($carteraCliente as $cartera) {
            // Obtén el estado directamente de la tabla Cartera
            $estado = $cartera->estados_id;
            // Verifica si el estado es "activo" (1) antes de sumar la deuda
            if ($estado === 1) {
                // Elimina los puntos de los miles y reemplaza la coma decimal por un punto
                $deuda = str_replace('.', '', $cartera->deuda_activa);
                $deuda = str_replace(',', '.', $deuda);
                // Convierte la deuda en un número
                $deuda = floatval($deuda);
                // Suma la deuda activa
                $deudaActivaTotal += $deuda;
            }
        }

        $casosActivosTotal = 0;

        // Itera sobre los resultados de la tabla y cuenta los casos activos
        foreach ($carteraCliente as $cartera) {
            // Verifica si el estado es "Activo" antes de contar
            foreach ($estados as $estado) {
                if ($estado->id === $cartera->estados_id && $estado->estado === "Activo") {
                    $casosActivosTotal++;
                    break; // Rompe el bucle una vez que se encuentra una coincidencia activa
                }
            }
        }



        $router->render('clientes/perfil-cliente', [
            'titulo' => 'Perfil del cliente',
            'cliente' => $cliente,
            'id' => $clienteId,
            'resultado' => $resultado,
            'carteraCliente' => $carteraCliente,
            'deudores' => $deudores,
            'estados' => $estados,
            'cantidadDniUnicos' => $cantidadDniUnicos,
            'deudaTotal' => $deudaTotal,
            'deudaActivaTotal' => $deudaActivaTotal,
            'totalCasos' => $totalCasos,
            'casosActivosTotal' => $casosActivosTotal
        ]);
    }

    public static function importar(Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        $resultado = $_GET['resultado'] ?? null;
        $clienteId = $_GET['id'];
        if (!$clienteId) {
            header('Location: /clientes');
            exit();
        }
        $cliente = Clientes::find($clienteId);
        $temp_cartera = New Temp_cartera;
        $nuevoTempCartera = New Temp_cartera;
        $rutaFinal = '';
        
        
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $temp_cartera->sincronizarCartera($_POST);
            $alertas = $temp_cartera->validarImportacion();
        
            if (empty($alertas)) {
                //Paso 1: Se renombra el archivo y se indica donde almacenarlo
                $nombreNuevoArchivo = uniqid() . '_' . $_FILES['importar']['name'];
                $archivoTemporal = $_FILES['importar']['tmp_name'];
                $carpetaDestino = __DIR__ . '/../archivosSubidos/carteras/';
                $rutaFinal = $carpetaDestino . $nombreNuevoArchivo;
        
                //Paso 2: Subir el archivo y leer e indicar que se debe omitir primer fila
                if (move_uploaded_file($archivoTemporal, $rutaFinal)) {
                    $spreadsheet = IOFactory::load($rutaFinal);
                    $worksheet = $spreadsheet->getActiveSheet();
                    $primeraFila = true;
                
                    foreach ($worksheet->getRowIterator() as $row) {
                        if ($primeraFila) {
                            $primeraFila = false;
                            continue;
                        }
                    // Paso 3: Procesar los datos de la fila actual y crear nueva instancia Temp_cartera
                    $rowData = [];
                        foreach ($row->getCellIterator() as $cell) {
                            $rowData[] = $cell->getValue();
                        }

                    $nuevoTempCartera = new Temp_cartera();
                    $nuevoTempCartera->segmento = trim($rowData[0]);
                    $nuevoTempCartera->producto = trim($rowData[1]);
                    $nuevoTempCartera->operacion = trim($rowData[2]);
                    $nuevoTempCartera->nombre = trim(ucwords(strtolower($rowData[3])));
                    $nuevoTempCartera->tipo_doc = trim($rowData[4]);
                    $nuevoTempCartera->nro_doc = trim($rowData[5]);
                    $nuevoTempCartera->domicilio = trim(ucwords(strtolower($rowData[6])));
                    $nuevoTempCartera->localidad = trim(ucwords(strtolower($rowData[7])));
                    $nuevoTempCartera->codigo_postal = trim($rowData[8]);
                    $nuevoTempCartera->telefono = trim($rowData[9]);

                    // Formatear la fecha de apertura
                    $excelDateValue = (int)$rowData[10]; 
                    $excelBaseDate = new \DateTime('1900-01-01'); 
                    $excelDate = clone $excelBaseDate;
                    $excelDate->modify("+" . ($excelDateValue - 2) . " days");
                    $fechaApertura = $excelDate->format('d/m/Y'); 
                    $nuevoTempCartera->fecha_apertura = $fechaApertura;
                    
                    $nuevoTempCartera->moneda = trim($rowData[11]);
                    $nuevoTempCartera->cant_cuotas = trim($rowData[12]);
                    $nuevoTempCartera->sucursal = trim($rowData[13]);
                    
                    //Formatear Fecha Atraso
                    $excel_fecha_atraso = (int)$rowData[14]; 
                    $excel_base_fecha_atraso = new \DateTime('1900-01-01'); 
                    $excel_fecha = clone $excel_base_fecha_atraso;
                    $excel_fecha->modify("+" . ($excel_fecha_atraso - 2) . " days");
                    $fechaAtraso = $excel_fecha->format('d/m/Y'); 
                    $nuevoTempCartera->fecha_atraso = $fechaAtraso;

                    // Verificar si la celda de fecha de castigo está vacía o contiene una fecha válida
                    $excelDateValueCastigo = trim($rowData[16]);if (empty($excelDateValueCastigo)) {
                        $nuevoTempCartera->fecha_castigo = ''; // Deja la celda como vacía
                    } else {
                        // Formatear fecha castigo
                        $excelDateValueCastigo = intval($excelDateValueCastigo);
                        $fechaCastigo = date('d/m/Y', strtotime('1899-12-30 +' . $excelDateValueCastigo . ' days'));
                        $nuevoTempCartera->fecha_castigo = $fechaCastigo;
                    }

                    // Formatear deuda total
                    $deudaTotal = (float)$rowData[17];
                    $deudaTotalFormateada = number_format($deudaTotal, 2, ',', '.'); 
                    $nuevoTempCartera->deuda_total = $deudaTotalFormateada;

                    //Formatear monto castigo
                    $montoCastigo = (float)$rowData[18];
                    $montoCastigoFormateado = number_format($montoCastigo, 2, ',', '.'); 
                    $nuevoTempCartera->monto_castigo = $montoCastigoFormateado;

                    // Formatear deuda capital
                    $deudaCapital = (float)$rowData[19];
                    $deudaCapitalFormateada = number_format($deudaCapital, 2, ',', '.'); 
                    $nuevoTempCartera->deuda_capital = $deudaCapitalFormateada;

                    // Formatear deuda activa
                    $deudaActiva = (float)$rowData[20];
                    $deudaActivaFormateada = number_format($deudaActiva, 2, ',', '.'); 
                    $nuevoTempCartera->deuda_activa = $deudaActivaFormateada;

                    // Formatear fecha de último pago
                    $fechaUltimoPago = $rowData[21]; 
                    if (!empty($fechaUltimoPago)) {
                        $excelDateValuePago = (float)$fechaUltimoPago;
                        $unixTimestamp = ($excelDateValuePago - 25569) * 86400;
                        $fechaPago = gmdate('d/m/Y', $unixTimestamp);
                        $nuevoTempCartera->fecha_ult_pago = $fechaPago;
                    } else {
                        $nuevoTempCartera->fecha_ult_pago = ''; // Dejar la celda como vacía
                    }

                    $nuevoTempCartera->estado = trim($rowData[22]);

                    // Formatear fecha de asignacion
                    $nuevoTempCartera->fecha_asignacion = $rowData[24];
                    $excelDateValueAsignacion = intval($nuevoTempCartera->fecha_asignacion);
                    $fechaAsignacion = date('d/m/Y', strtotime('1899-12-30 +' . $excelDateValueAsignacion . ' days'));
                    $nuevoTempCartera->fecha_asignacion = $fechaAsignacion;

                    $nuevoTempCartera->ciclo = trim($rowData[25]);
                    $nuevoTempCartera->acuerdo = trim($rowData[26]);
                    $nuevoTempCartera->reingreso_en_tramite = trim($rowData[27]);
                    $nuevoTempCartera->demanda_de_terceros = trim($rowData[28]);
                    $nuevoTempCartera->concurso = trim($rowData[29]);
                    $nuevoTempCartera->quiebra = trim($rowData[30]);
                    $nuevoTempCartera->demanda = trim($rowData[31]);
                    $nuevoTempCartera->importe_tasacion = trim($rowData[32]);
                    $nuevoTempCartera->cliente_id = trim($_POST['cliente_id']);
                    $nuevoTempCartera->operacion_cliente = trim($rowData[2] . $nuevoTempCartera->cliente_id);
                    $resultado = $nuevoTempCartera->guardar();
                    }
                }
            }
            // Paso 4: crea las instancias de deudores a partir de info de Temp_cartera
            $registrosTempCartera = Temp_cartera::allTemp(['nombre', 'tipo_doc', 'nro_doc', 'domicilio', 'localidad', 'codigo_postal', 'telefono']);
            
            $nros_doc_procesados = [];

            foreach ($registrosTempCartera as $registro) {
                $nro_doc = $registro->nro_doc;
                //Verifica si durante el procesamiento ya se registro en nro_doc
                if (in_array($nro_doc, $nros_doc_procesados)) {
                    echo "El número de documento $nro_doc ya ha sido procesado. Se omite.<br>";
                    continue; // 
                }
                //Verifica si ya existe en la tabla Deudores
                $nros_doc_procesados[] = $nro_doc;
                $existeEnDeudores = Deudores::existePorNroDoc($nro_doc);
                if ($existeEnDeudores) {
                    echo "El número de documento $nro_doc ya existe en la tabla Deudores. Se omite.<br>";
                    continue; // Saltar al siguiente registro
                }

                $deudor = new Deudores();
                $deudor->nombre = $registro->nombre;
                $deudor->tipo_doc = $registro->tipo_doc;
                $deudor->nro_doc = $registro->nro_doc;
                $deudor->domicilio = $registro->domicilio;
                $deudor->localidad = $registro->localidad;
                $deudor->codigo_postal = $registro->codigo_postal;
                $deudor->telefono = $registro->telefono;
                $resultado = $deudor->guardar();
            }
            //Paso 5: Crear o actualiza las instancias de Operaciones a partir de Temp_cartera
            $registrosOperaciones = Temp_cartera::allTemp(['segmento', 'producto', 'operacion', 'nro_doc',
            'fecha_apertura', 'moneda','cant_cuotas', 'sucursal', 'fecha_atraso', 'fecha_castigo',
            'deuda_total', 'monto_castigo', 'deuda_capital', 'deuda_activa', 'fecha_ult_pago', 'estado',
            'fecha_asignacion', 'ciclo', 'acuerdo', 'reingreso_en_tramite', 'demanda_de_terceros', 'concurso',
            'quiebra', 'demanda', 'importe_tasacion', 'cliente_id','estados_id', 'operacion_cliente']);
            
            foreach ($registrosOperaciones as $filas) {
                $operacion_cliente = $filas->operacion_cliente;
                $operacionExistente = Operaciones::buscarPorOperacionCliente($operacion_cliente);
                if ($operacionExistente) {
                $operacionExistente->segmento = $filas->segmento;
                $operacionExistente->producto = $filas->producto;
                $operacionExistente->operacion = $filas->operacion;
                $operacionExistente->nro_doc = $filas->nro_doc;
                $operacionExistente->fecha_apertura = $filas->fecha_apertura;
                $operacionExistente->moneda = $filas->moneda;
                $operacionExistente->cant_cuotas = $filas->cant_cuotas;
                $operacionExistente->sucursal = $filas->sucursal;
                $operacionExistente->fecha_atraso = $filas->fecha_atraso;
                $operacionExistente->fecha_castigo = $filas->fecha_castigo;
                $operacionExistente->deuda_total = $filas->deuda_total;
                $operacionExistente->monto_castigo = $filas->monto_castigo;
                $operacionExistente->deuda_capital = $filas->deuda_capital;
                $operacionExistente->deuda_activa = $filas->deuda_activa;
                $operacionExistente->fecha_ult_pago = $filas->fecha_ult_pago;
                $operacionExistente->estado = $filas->estado;
                $operacionExistente->fecha_asignacion = $filas->fecha_asignacion;
                $operacionExistente->ciclo = $filas->ciclo;
                $operacionExistente->acuerdo = $filas->acuerdo;
                $operacionExistente->reingreso_en_tramite = $filas->reingreso_en_tramite;
                $operacionExistente->demanda_de_terceros = $filas->demanda_de_terceros;
                $operacionExistente->concurso = $filas->concurso;
                $operacionExistente->quiebra = $filas->quiebra;
                $operacionExistente->demanda = $filas->demanda;
                $operacionExistente->importe_tasacion = $filas->importe_tasacion;
                $operacionExistente->cliente_id = $filas->cliente_id;
                $operacionExistente->estados_id = $filas->estados_id;
                $operacionExistente->operacion_cliente = $filas->operacion_cliente;
                $resultado = $operacionExistente->guardar();                        
                } else {
                $operacion = new Operaciones;
                $operacion->segmento = $filas->segmento;
                $operacion->producto = $filas->producto;
                $operacion->operacion = $filas->operacion;
                $operacion->nro_doc = $filas->nro_doc;
                $operacion->fecha_apertura = $filas->fecha_apertura;
                $operacion->moneda = $filas->moneda;
                $operacion->cant_cuotas = $filas->cant_cuotas;
                $operacion->sucursal = $filas->sucursal;
                $operacion->fecha_atraso = $filas->fecha_atraso;
                $operacion->fecha_castigo = $filas->fecha_castigo;
                $operacion->deuda_total = $filas->deuda_total;
                $operacion->monto_castigo = $filas->monto_castigo;
                $operacion->deuda_capital = $filas->deuda_capital;
                $operacion->deuda_activa = $filas->deuda_activa;
                $operacion->fecha_ult_pago = $filas->fecha_ult_pago;
                $operacion->estado = $filas->estado;
                $operacion->fecha_asignacion = $filas->fecha_asignacion;
                $operacion->ciclo = $filas->ciclo;
                $operacion->acuerdo = $filas->acuerdo;
                $operacion->reingreso_en_tramite = $filas->reingreso_en_tramite;
                $operacion->demanda_de_terceros = $filas->demanda_de_terceros;
                $operacion->concurso = $filas->concurso;
                $operacion->quiebra = $filas->quiebra;
                $operacion->demanda = $filas->demanda;
                $operacion->importe_tasacion = $filas->importe_tasacion;
                $operacion->cliente_id = $filas->cliente_id;
                $operacion->estados_id = $filas->estados_id;
                $operacion->operacion_cliente = $filas->operacion_cliente;
                $resultado = $operacion->guardar();
                }
            }
            
            //Paso 5: desactivar las operaciones que corresponden al cliente_id que se esta importando
            $cliente_idActual = $nuevoTempCartera->cliente_id;
            $operacionesCliente = Operaciones::whereColumnaValor('cliente_id', $cliente_idActual);
            $tempCartera = Temp_cartera::all();

            foreach ($operacionesCliente as $operacionCliente) {
                $operacionClienteExistente = false;
            
                foreach ($tempCartera as $tempRegistro) {
                    if ($operacionCliente->operacion_cliente === $tempRegistro->operacion_cliente) {
                        $operacionClienteExistente = true;
                        break;
                    }
                }
            
                if (!$operacionClienteExistente) {
                    // La operación no está en la importación actual, cambia su estado a 2
                    $operacionCliente->estados_id = 2;
                    $operacionCliente->guardar(); // Actualiza la operación en la base de datos
                }
            }
                  
            $deudores = Deudores::all();
            $operaciones = Operaciones::all();
            foreach ($operaciones as $operacion) {
                // Obtiene el nro_doc de la operación
                $nro_doc_operacion = $operacion->nro_doc;
                // Busca el nro_doc en la tabla de deudores
                foreach ($deudores as $deudor) {
                    $nro_doc_deudor = $deudor->nro_doc;
                    if ($nro_doc_deudor === $nro_doc_operacion) {
                        // Actualiza el deudor_id con el id correspondiente
                        $operacion->deudor_id = $deudor->id;
                        $operacion->guardar();
                        break; // Rompe el bucle una vez que se encuentra una coincidencia
                    }
                }
            }
            Temp_cartera::eliminarTodos();
            if (file_exists($rutaFinal)) {
                unlink($rutaFinal);
                header("Location: /perfil-cliente?id=$clienteId");
            }        
        }
    

        $router->render('clientes/importar-operaciones-cliente', [
            'titulo' => 'Importar cartera de cliente',
            'resultado' => $resultado,
            'alertas' => $alertas,
            'cliente' => $cliente
        ]);
        
    }
}