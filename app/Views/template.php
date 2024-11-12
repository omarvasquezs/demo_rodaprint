<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guía de Remisión <?= $num_guia ?></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html {
            margin: 20px 24.5px;
        }

        body {
            color: black !important;
        }

        p {
            font-size: 13px;
            letter-spacing: 0.8px;
        }

        .bg-secondary {
            background-color: #eeeeee;
        }

        .fw-bold {
            font-weight: bold;
            padding-top: 2.5px;
            padding-bottom: 2.5px;
            padding-right: 5px;
            padding-left: 5px;
        }

        .bg-opacity-25 {
            background-color: #eeeeee;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row" style="margin-bottom: 15px;margin-right: 20px;">
            <div class="col-xs-2" style="padding: 0;">
                <img width="250px" class="img-responsive" src="<?= base_url() ?>assets/uploads/images/<?= $logo ?>"
                    alt="">
            </div>
            <div class="col-xs-5" style="margin-top: -15px;">
                <h4 style="font-weight: bold;font-size:20px;"><?= $razon_social_remitente ?></h4>
                <p style="line-height: 1.2;margin-bottom: 6px;" class="text-uppercase">PRINCIPAL »
                    <?php echo $direccion_remitente . ' URB. ' . $urbanizacion_remitente . ' - ' . $departamento_remitente . ' ' . $provincia_remitente . ' ' . $distrito_remitente; ?>
                </p>
                <p style="margin-bottom: -2px;">Contacto:</p>
                <p style="margin-bottom: -2px;">Email: <?= $email_remitente ?></p>
                <p style="margin-bottom: -2px;">Fijo: <?= $tel_fijo_remitente ?> Cel.: <?= $tel_cel_remitente ?></p>
            </div>
            <div class="col-xs-5 text-center" style="border: 1.5px solid black;padding-right: 0;padding-left:0;">
                <h4 style="font-weight: 400;">RUC <?= $ruc_remitente ?></h4>
                <h5 class="fw-bold bg-secondary bg-opacity-25"
                    style="line-height: 22px;padding-right: 0;padding-left:0;padding-top:10px;padding-bottom:10px;font-size:16px;">
                    GUIA DE REMISIÓN
                    REMITENTE ELECTRONICA</h5>
                <h4 style="font-weight: 400;" class="py-1"><?= $num_guia ?></h4>
            </div>
        </div>
        <div class="row"
            style="margin-bottom: -8px;border-top: 1.5px solid black;border-left: 1.5px solid black;border-right: 1.5px solid black;">
            <h5 class="fw-bold bg-secondary bg-opacity-25" style="margin-top: 0;">DESTINATARIO</h5>
        </div>
        <div class="row" style="margin-bottom: -12px;border-left: 1.5px solid black;border-right: 1.5px solid black;">
            <div style="padding-left:5px;" class="col-xs-2">
                <p class="mb-0 mt-0"><b>RUC/DNI</b></p>
            </div>
            <div class="col-xs-5">
                <p class="mb-0 mt-0"><?= $ruc_cliente ?></p>
            </div>
            <div class="col-xs-4">
                <p class="mb-0 mt-0"><b>FECHA EMISIÓN</b><?php echo ' ' . $fecha_emision; ?></p>
            </div>
        </div>
        <div class="row" style="margin-bottom: -12px;border-left: 1.5px solid black;border-right: 1.5px solid black;">
            <div style="padding-left:5px;" class="col-xs-2">
                <p><b>RAZON SOCIAL</b></p>
            </div>
            <div class="col-xs-10">
                <p><?= $razon_social_cliente ?></p>
            </div>
        </div>
        <div class="row"
            style="border-left: 1.5px solid black;border-right: 1.5px solid black;border-bottom: 1.5px solid black;margin-bottom: 15px;">
            <div style="padding-left:5px;" class="col-xs-2">
                <p class="mb-0 mt-0"><b>DIRECCIÓN</b></p>
            </div>
            <div class="col-xs-10">
                <p class="mb-0 mt-0"><?= $direccion_destino ?></p>
            </div>
        </div>
        <div class="row"
            style="margin-bottom: -8px;border-top: 1.5px solid black;border-left: 1.5px solid black;border-right: 1.5px solid black;">
            <h5 class="fw-bold pb-1 mb-0 bg-secondary bg-opacity-25" style="margin-top: 0;">ENVIO</h5>
        </div>
        <div class="row" style="margin-bottom: -12px;border-left: 1.5px solid black;border-right: 1.5px solid black;">
            <div style="padding-left:5px;" class="col-xs-3">
                <p class="mb-0 mt-0"><b>TIPO ENVIO</b></p>
            </div>
            <div class="col-xs-4">
                <p class="mb-0 mt-0">VENTA</p>
            </div>
            <div class="col-xs-4">
                <p class="mb-0 mt-0"><b>FECHA DE ENVÍO</b><?php echo ' ' . $fecha_envio; ?></p>
            </div>
        </div>
        <div class="row" style="margin-bottom: -12px;border-left: 1.5px solid black;border-right: 1.5px solid black;">
            <div style="padding-left:5px;" class="col-xs-3">
                <p class="mb-0 mt-0"><b>PESO BRUTO TOTAL</b></p>
            </div>
            <div class="col-xs-4">
                <p class="mb-0 mt-0">
                    <?php echo $peso_total . ' ' . $pesoUnidad; ?>
                </p>
            </div>
            <div class="col-xs-4">
                <p class="mb-0 mt-0"><b>N° DE BULTOS</b><?php echo ' ' . $num_bultos; ?></p>
            </div>
        </div>
        <div class="row" style="margin-bottom: -12px;border-left: 1.5px solid black;border-right: 1.5px solid black;">

            <div style="padding-left:5px;" class="col-xs-3">
                <p class="mb-0 mt-0"><b>PUNTO DE PARTIDA</b></p>
            </div>
            <div class="col-xs-9">
                <p class="text-uppercase">
                    <?php echo $ubigeo_remitente . ' - ' . $distrito_remitente . '/' . $provincia_remitente . '/' . $departamento_remitente . ' ' . $direccion_remitente; ?>
                </p>
            </div>
        </div>
        <div class="row" style="margin-bottom: -12px;border-left: 1.5px solid black;border-right: 1.5px solid black;">
            <div style="padding-left:5px;" class="col-xs-3">
                <p class="mb-0 mt-0"><b>PUNTO DE LLEGADA</b></p>
            </div>
            <div class="col-xs-9">
                <p class="text-uppercase mb-0 mt-0">
                    <?php echo $ubigeo_destino . ' - ' . $distrito_destino . '/' . $provincia_destino . '/' . $departamento_destino . ' ' . $direccion_destino; ?>
                </p>
            </div>
        </div>
        <div class="row"
            style="border-left: 1.5px solid black;border-right: 1.5px solid black;border-bottom: 1.5px solid black;">
            <div style="padding-left:5px;" class="col-xs-3">
                <p class="mb-0 mt-0"><b>TIPO DE TRANSPORTE</b></p>
            </div>
            <div class="col-xs-9">
                <p class="mb-0 mt-0">TRANSPORTE PRIVADO</p>
            </div>
        </div>
        <div class="row"
            style="margin-top: 14px;margin-bottom: -8px;border-top: 1.5px solid black;border-left: 1.5px solid black;border-right: 1.5px solid black;">
            <h5 class="fw-bold pb-1 mb-0 bg-secondary bg-opacity-25" style="margin-top: 0;">CONDUCTORES</h5>
        </div>
        <div class="row"
            style="border-left: 1.5px solid black;border-right: 1.5px solid black;border-bottom: 1.5px solid black;margin-bottom: 15px;">
            <p style="padding-right: 15px;padding-left:5px;">
                <?php echo $conductor_nombres . ' (' . $conductor_dni . ') -  Número de licencia de conducir: ' . $conductor_licencia; ?>
            </p>
        </div>
        <div class="row"
            style="margin-top: 14px;margin-bottom: -8px;border-top: 1.5px solid black;border-left: 1.5px solid black;border-right: 1.5px solid black;">
            <h5 class="fw-bold pb-1 mb-0 bg-secondary bg-opacity-25" style="margin-top: 0;">VEHICULOS</h5>
        </div>
        <div class="row"
            style="border-left: 1.5px solid black;border-right: 1.5px solid black;border-bottom: 1.5px solid black;margin-bottom: 15px;">
            <p style="padding-right: 15px;padding-left:5px;">Número de placa: <?php echo $conductor_num_placa; ?></p>
        </div>
        <div class="row">
            <table class="table borderless" style="border: 1.5px solid black;">
                <thead class="text-uppercase">
                    <tr>
                        <th style="background-color: #eeeeee;padding-top: 0.25rem; padding-bottom: 0.25rem;border-bottom:transparent;"
                            scope="col">N°</th>
                        <th style="background-color: #eeeeee;padding-top: 0.25rem; padding-bottom: 0.25rem;border-bottom:transparent;"
                            scope="col">Unidad</th>
                        <th style="background-color: #eeeeee;padding-top: 0.25rem; padding-bottom: 0.25rem;border-bottom:transparent;"
                            scope="col">Descripción</th>
                        <th style="background-color: #eeeeee;padding-top: 0.25rem; padding-bottom: 0.25rem;border-bottom:transparent;"
                            scope="col">Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                        <!-- Add rows here -->
                        <?php
                        if (!empty($productos)) {
                            foreach ($productos as $index => $producto) {
                                echo '<tr>';
                                echo '<td style="padding-top: 0.25rem;padding-bottom: 0.25rem;">' . ($index + 1) . "</td>";
                                echo '<td style="padding-top: 0.25rem;padding-bottom: 0.25rem;">UNIDADES</td>';
                                echo '<td style="padding-top: 0.25rem;padding-bottom: 0.25rem;">' . $producto['descripcion'] . "</td>";
                                echo '<td style="padding-top: 0.25rem;padding-bottom: 0.25rem;" class="text-right">' . $producto['cantidad'] . "</td>";
                                echo '</tr>';
                            }
                        } else {
                            echo "<p>No hay productos encontrados.</p>";
                        }
                        ?>
                </tbody>
            </table>
        </div>
        <div class="row" style="margin-top: 14px;margin-bottom: -8px;border: 1.5px solid black;padding-left:5px;">
            <p><b>OBSERVACIONES</b><?php echo ' ' . $observaciones; ?></p>
        </div>
    </div>
</body>

</html>