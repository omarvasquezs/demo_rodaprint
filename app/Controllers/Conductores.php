<?php

namespace App\Controllers;

class Conductores extends BaseController
{
    public function index()
    {
        $this->gc->setTable('conductores')
        ->setSubject('CONDUCTOR', 'CONDUCTORES')
        ->displayAs('nombres', 'NOMBRES')
        ->displayAs('dni', 'DNI')
        ->displayAs('licencia', 'LICENCIA')
        ->displayAs('num_placa', 'NÚMERO DE PLACA')
        ->uniqueFields(['dni','licencia']);
        $this->gc_unset();
        // Rendering the CRUD
        $output = $this->gc->render();
        // Title
        $output->title = 'conductores';
        return $this->_mainOutput($output);
    }
}
