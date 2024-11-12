<?php

namespace App\Controllers;

class Clientes extends BaseController
{
    public function index()
    {
        $this->gc->setTable('clientes')
        ->displayAs('ruc', 'RUC')
        ->displayAs('razon_social', 'RAZON SOCIAL')
        ->setSubject('CLIENTE', 'CLIENTES')
        ->setMasterDetail(base_url().'destinos')
        ->uniqueFields(['ruc', 'razon_social']);
        $this->gc_unset();
        // Rendering the CRUD
        $output = $this->gc->render();
        // Title
        $output->title = 'clientes';
        return $this->_mainOutput($output);
    }
}
