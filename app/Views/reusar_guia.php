<div class="col-lg-6 col-md-12 mx-auto my-5">
    <!-- TABS -->
    <ul class="nav nav-tabs mb-4 px-4" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link text-uppercase text-center" id="informacion-tab" data-bs-toggle="tab"
                href="#informacion" role="tab" aria-controls="informacion" aria-selected="true"><i
                    class="fab fa-wpforms" aria-hidden="true"></i><br>Información Básica</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link text-uppercase text-center" id="envio-tab" data-bs-toggle="tab" href="#envio" role="tab"
                aria-controls="envio" aria-selected="false"><i class="fa fa-truck" aria-hidden="true"></i><br>Datos del
                Envío</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active text-uppercase text-center" id="productos-tab" data-bs-toggle="tab" href="#productos"
                role="tab" aria-controls="productos" aria-selected="false"><i class="fa fa-shopping-basket"
                    aria-hidden="true"></i><br>Productos</a>
        </li>
    </ul>
    <!-- TABS END -->
    <form method="post" id="guiaSubmission" action="/submit_guia">
        <!-- TABS CONTENT -->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade px-4" id="informacion" role="tabpanel"
                aria-labelledby="informacion-tab">
                <!-- FIRST CONTENT -->
                <div class="row mb-3">
                    <div class="col">
                        <label for="serie" class="form-label">Serie</label>
                        <select class="form-select" disabled>
                            <option value="T001" selected>T001</option>
                            <!-- Add more options here -->
                        </select>
                        <input type="hidden" name="serie" value="T001">
                    </div>
                    <div class="col">
                        <label for="fechaEmision" class="form-label">Fecha de emisión</label>
                        <input type="date" class="form-control" value="<?=$fecha_emision?>" disabled>
                        <input type="hidden" name="fechaEmision" id="fechaEmision" value="<?=$fecha_emision?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="clienteDropdown" class="form-label">Cliente*</label>
                    <input type="text" class="form-control" value="<?=$razonSocialCliente?>" disabled>
                    <input type="hidden" name="clienteDropdown" value="<?=$id_cliente?>">
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="ClienteDestinoDropdown" class="form-label">Dirección de destino*</label>
                        <input type="text" class="form-control" value="<?=$direccionCliente?>" disabled>
                        <input type="hidden" name="ClienteDestinoDropdown" value="<?=$id_destino?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="observaciones" class="form-label">Observaciones</label>
                    <textarea class="form-control" name="observaciones" id="observaciones" rows="3"></textarea>
                </div>
                <!-- NEXT BUTTON -->
                <button class="btn btn-primary siguiente text-uppercase">Siguiente</button>
            </div>
            <div class="tab-pane fade px-4" id="envio" role="tabpanel" aria-labelledby="envio-tab">
                <!-- SECOND CONTENT -->
                <div class="row mb-3">
                    <!-- Fecha del envío -->
                    <div class="col">
                        <label for="fechaEnvio" class="form-label">Fecha del envío</label>
                        <input type="date" class="form-control" value="<?=$fecha_envio;?>" disabled>
                        <input type="hidden" name="fechaEnvio" value="<?=$fecha_envio;?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="cantidadBultos" class="form-label">Cantidad de bultos*</label>
                        <input type="number" class="form-control" id="cantidadBultos" name="cantidadBultos" value="<?=$num_bultos?>">
                    </div>
                    <div class="col">
                        <label for="pesoTotal" class="form-label">Peso total*</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="pesoTotal" id="pesoTotal" value="<?php echo $peso_total; ?>">
                            <div class="input-group-append">
                                <select class="form-select" name="pesoUnidad" id="pesoUnidad">
                                    <option value="kg" <?= ($pesoUnidad == 'kg') ? 'selected' : '' ?>>KG</option>
                                    <option value="t" <?= ($pesoUnidad == 't') ? 'selected' : '' ?>>T</option>
                                    <option value="oz" <?= ($pesoUnidad == 'oz') ? 'selected' : '' ?>>OZ</option>
                                    <option value="lb" <?= ($pesoUnidad == 'lb') ? 'selected' : '' ?>>LB</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col">
                        <label for="conductorDropdown" class="form-label">Conductor</label>
                        <?php if (!empty($conductores)): ?>
                            <select class="form-control select2" disabled>
                                <?php foreach ($conductores as $conductor): ?>
                                    <option value="<?= $conductor['id']; ?>" <?= $conductor['id'] == 1 ? 'selected' : ''; ?>>
                                        <?= $conductor['nombres']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" name="conductorDropdown" value="<?=$id_conductor?>">
                        <?php else: ?>
                            <p>No conductores found.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- BACK/NEXT BUTTONS -->
                <button id="btn_anterior_1" name="btn_anterior_1"
                    class="btn btn-secondary text-uppercase">anterior</button>
                <button class="btn btn-primary siguiente text-uppercase">Siguiente</button>
            </div>
            <div class="tab-pane fade show active px-4" id="productos" role="tabpanel" aria-labelledby="productos-tab">
                <!-- THIRD CONTENT -->
                <div class="row mb-2">
                    <div class="col-md-8 mb-4">
                        <select class="form-control select2" name="productoDropdown" id="productoDropdown">
                        </select>
                    </div>
                    <div class="col-md-4">
                        <a id="agregarProducto" class="btn btn-success btn-block text-uppercase w-100"><i
                                class="fa fa-plus-circle" aria-hidden="true"></i> AÑADIR
                        </a>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col">
                        <table id="productTable" class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Table rows will be added here -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- BACK/SUBMIT BUTTONS -->
                <button id="btn_anterior_2" name="btn_anterior_2"
                    class="btn btn-secondary text-uppercase">anterior</button>
                <button type="submit" class="btn btn-primary text-uppercase">Procesar</button>
            </div>
        </div>
    </form>
</div>