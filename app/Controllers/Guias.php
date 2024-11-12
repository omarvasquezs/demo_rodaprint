<?php

namespace App\Controllers;

class Guias extends BaseController
{
    public function index()
    {
        $this->gc->setTable('guias')
            ->unsetAdd()
            ->unsetDelete()
            ->unsetEdit()
            ->columns(['num_guia','id_cliente'])
            ->displayAs('num_guia', 'NÚMERO DE GUIA')
            ->displayAs('id_cliente', 'CLIENTE')
            ->defaultOrdering('guias.id', 'desc')
            ->setActionButton('VER GUIA', 'far fa-eye', function ($row) {
                return base_url() . 'consultar_guia/' . $row->id;
            }, true)
            ->setActionButton('RE-USAR GUIA', 'fas fa-copy', function ($row) {
                return base_url() . 'reusar_guia/' . $row->id;
            })
            ->setRelation('id_cliente', 'clientes', 'razon_social')
            ->setSubject('GUIA', 'GUIAS');
        $this->gc_unset();
        // Rendering the CRUD
        $output = $this->gc->render();
        // Title
        $output->title = 'guias';
        return $this->_mainOutput($output);
    }
    public function add_guia()
    {
        $data = [
            'conductores' => $this->conductores->findAll()
        ];
        $output = (object) [
            'css_files' => [],
            'js_files' => [],
            'title' => 'nueva guia',
            'output' => view('add_guia', $data)
        ];
        return $this->_mainOutput($output);
    }
    public function reusar_guia()
    {
        $guiaData = $this->guias->select('num_guia,id_cliente,fecha_emision,fecha_envio,peso_total,num_bultos,id_destino,pesoUnidad,id_conductor,observaciones,direccion_remitente,ubigeo_remitente,razon_social_remitente,ruc_remitente,email_remitente,tel_fijo_remitente,tel_cel_remitente,logo_remitente,urbanizacion_remitente')->where('id', $this->uri->getSegment(2))->first();
        $clientes = $this->clientes->select('razon_social')->where('id', $guiaData['id_cliente'])->first();
        $destinos = $this->destinos->select('direccion_destino')->where('id', $guiaData['id_destino'])->first();
        $data = [
            'conductores' => $this->conductores->findAll(),
            'peso_total' => $guiaData['peso_total'] ?? null,
            'fecha_emision' => $guiaData['fecha_emision'] ?? null,
            'fecha_envio' => $guiaData['fecha_envio'] ?? null,
            'num_bultos' => $guiaData['num_bultos'] ?? null,
            'id_destino' => $guiaData['id_destino'] ?? null,
            'id_cliente' => $guiaData['id_cliente'] ?? null,
            'id_conductor' => $guiaData['id_conductor'] ?? null,
            'razonSocialCliente' => $clientes['razon_social'] ?? null,
            'direccionCliente' => $destinos['direccion_destino'] ?? null,
            'pesoUnidad' => $guiaData['pesoUnidad'] ?? null
        ];
        $output = (object) [
            'css_files' => [],
            'js_files' => [],
            'title' => 're-uso de guia ' . $guiaData['num_guia'] ?? null,
            'output' => view('reusar_guia', $data)
        ];
        return $this->_mainOutput($output);
    }
    public function fetchClientes()
    {
        // Get the search term from the request
        $searchTerm = $this->request->getVar('q');

        // If a search term is provided, filter results
        if ($searchTerm !== null) {
            $clientes = $this->clientes
                ->like('razon_social', $searchTerm) // Adjust 'razon_social' based on your database column
                ->findAll();
        } else {
            // If no search term, retrieve all enabled clientes
            $clientes = $this->clientes->findAll();
        }

        return $this->response->setJSON($clientes);
    }
    public function fetchDestinos()
    {
        $servicios = $this->destinos
            ->where('id_cliente', $this->uri->getSegment(2))
            ->findAll();

        return $this->response->setJSON($servicios);
    }
    public function fetchProductos()
    {
        // Get the search term from the request
        $searchTerm = $this->request->getVar('q');

        // If a search term is provided, filter results
        if ($searchTerm !== null) {
            $productos = $this->productos
                ->like('descripcion', $searchTerm) // Adjust 'descripcion' based on your database column
                ->findAll();
        } else {
            // If no search term, retrieve all
            $productos = $this->productos->findAll();
        }

        return $this->response->setJSON($productos);
    }
    public function submit_guia()
    {
        // Retrieve all necessary fields in one query
        $remitenteData = $this->remitente->select('direccion, district_id, razon_social, ruc, email, tel_fijo, tel_cel, logo, urbanizacion')->first();
        $data_guia = (object) [
            'id_cliente' => $this->request->getPost('clienteDropdown'),
            'fecha_emision' => $this->request->getPost('fechaEmision'),
            'fecha_envio' => $this->request->getPost('fechaEnvio'),
            'peso_total' => $this->request->getPost('pesoTotal'),
            'num_bultos' => $this->request->getPost('cantidadBultos'),
            'pesoUnidad' => $this->request->getPost('pesoUnidad'),
            'id_destino' => $this->request->getPost('ClienteDestinoDropdown'),
            'id_conductor' => $this->request->getPost('conductorDropdown'),
            'observaciones' => $this->request->getPost('observaciones'),
            'direccion_remitente' => $remitenteData['direccion'] ?? null,
            'ubigeo_remitente' => $remitenteData['district_id'] ?? null,
            'razon_social_remitente' => $remitenteData['razon_social'] ?? null,
            'ruc_remitente' => $remitenteData['ruc'] ?? null,
            'email_remitente' => $remitenteData['email'] ?? null,
            'tel_fijo_remitente' => $remitenteData['tel_fijo'] ?? null,
            'tel_cel_remitente' => $remitenteData['tel_cel'] ?? null,
            'logo_remitente' => $remitenteData['logo'] ?? null,
            'urbanizacion_remitente' => $remitenteData['urbanizacion'] ?? null,
        ];

        $guia_inserted_id = $this->guias->insert($data_guia);

        // Update the num_guia field
        $num_guia = $this->request->getPost('serie') . '-' . str_pad($guia_inserted_id, 7, '0', STR_PAD_LEFT);
        $data = (object) ['num_guia' => $num_guia];
        $this->guias->update($guia_inserted_id, $data);

        $producto = $this->request->getPost('selectedProduct');
        $productoCantidad = $this->request->getPost('productoCantidad');

        $data_guia_productos = [];

        foreach ($producto as $key => $value) {
            $data_guia_productos[] = [
                'cantidad' => $productoCantidad[$key],
                'id_producto' => $producto[$key],
                'id_guia' => $guia_inserted_id
            ];
        }

        $this->guias_productos->insertBatch($data_guia_productos);

        session()->setFlashdata('success_message', 'El número de guia generado es: <b>' . $num_guia . '</b>');

        return redirect()->to('/guias');
    }
    public function generatePdfA4()
    {
        $id = $this->uri->getSegment(2);

        $guiaData = $this->guias->select('num_guia,id_cliente,fecha_emision,fecha_envio,peso_total,num_bultos,id_destino,pesoUnidad,id_conductor,observaciones,direccion_remitente,ubigeo_remitente,razon_social_remitente,ruc_remitente,email_remitente,tel_fijo_remitente,tel_cel_remitente,logo_remitente,urbanizacion_remitente')->where('id', $id)->first();

        $ubigeoRemitente = $this->remitente->select('department_id,province_id,district_id')->first();

        $departmentRemitente = $this->departamentos->select('name')->where('id', $ubigeoRemitente['department_id'])->first()['name'];

        $provinceRemitente = $this->provincias->select('name')->where('id', $ubigeoRemitente['province_id'])->first()['name'];

        $districtRemitente = $this->distritos->select('name')->where('id', $ubigeoRemitente['district_id'])->first()['name'];

        $clienteDestinos = $this->destinos->select('department_id,province_id,district_id,direccion_destino')->where('id', $guiaData['id_destino'])->first();

        $departmentDestino = $this->departamentos->select('name')->where('id', $clienteDestinos['department_id'])->first()['name'];

        $provinceDestino = $this->provincias->select('name')->where('id', $clienteDestinos['province_id'])->first()['name'];

        $districtDestino = $this->distritos->select('name')->where('id', $clienteDestinos['district_id'])->first()['name'];

        $clienteData = $this->clientes->select('ruc,razon_social')->where('id', $guiaData['id_cliente'])->first();

        $conductorData = $this->conductores->select('nombres,dni,licencia,num_placa')->where('id', $guiaData['id_conductor'])->first();

        $data = [
            'num_guia' => $guiaData['num_guia'] ?? null,
            'fecha_emision' => $guiaData['fecha_emision'] ?? null,
            'fecha_envio' => $guiaData['fecha_envio'] ?? null,
            'peso_total' => $guiaData['peso_total'] ?? null,
            'num_bultos' => $guiaData['num_bultos'] ?? null,
            'pesoUnidad' => $guiaData['pesoUnidad'] ?? null,
            'observaciones' => $guiaData['observaciones'] ?? null,
            'direccion_remitente' => $guiaData['direccion_remitente'] ?? null,
            'urbanizacion_remitente' => $guiaData['urbanizacion_remitente'] ?? null,
            'ubigeo_remitente' => $guiaData['ubigeo_remitente'] ?? null,
            'razon_social_remitente' => $guiaData['razon_social_remitente'] ?? null,
            'ruc_remitente' => $guiaData['ruc_remitente'] ?? null,
            'email_remitente' => $guiaData['email_remitente'] ?? null,
            'tel_fijo_remitente' => $guiaData['tel_fijo_remitente'] ?? null,
            'tel_cel_remitente' => $guiaData['tel_cel_remitente'] ?? null,
            'logo_remitente' => $guiaData['logo_remitente'] ?? null,
            'productos' => $this->guias_productos
            ->select('productos.descripcion as descripcion,guias_productos.cantidad as cantidad')
            ->join('productos', 'productos.id = guias_productos.id_producto')
            ->where('guias_productos.id_guia', $id)->findAll(),
            'departamento_remitente' => $departmentRemitente ?? null,
            'provincia_remitente' => $provinceRemitente,
            'distrito_remitente' => $districtRemitente,
            'departamento_destino' => $departmentDestino,
            'provincia_destino' => $provinceDestino,
            'distrito_destino' => $districtDestino,
            'ruc_cliente' => $clienteData['ruc'] ?? null,
            'razon_social_cliente' => $clienteData['razon_social'] ?? null,
            'direccion_destino' => $clienteDestinos['direccion_destino'] ?? null,
            'ubigeo_destino' => $clienteDestinos['district_id'] ?? null,
            'conductor_nombres' => $conductorData['nombres'] ?? null,
            'conductor_dni' => $conductorData['dni'] ?? null,
            'conductor_licencia' => $conductorData['licencia'] ?? null,
            'conductor_num_placa' => $conductorData['num_placa'] ?? null,
            'logo' => $guiaData['logo_remitente'] ?? null
            // Add other data you want to pass to the view...
        ];

        // Set options to enable embedded PHP
        $this->options->set('isPhpEnabled', 'true');
        $this->dompdf->loadHtml(view('template', $data), 'UTF-8');
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();
        $this->dompdf->stream($guiaData['num_guia'] ?? null . '_' . date('YmdHis') . '.pdf', ['Attachment' => false]);
        exit();
    }
}
