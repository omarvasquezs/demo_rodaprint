<?php

namespace App\Controllers;

class Productos extends BaseController
{
    public function index()
    {
        $this->gc->setTable('productos')
        ->displayAs('descripcion', 'DESCRIPCION')
        ->setSubject('PRODUCTO', 'PRODUCTOS');
        $this->gc_unset();
        // Rendering the CRUD
        $output = $this->gc->render();
        // Title
        $output->title = 'productos';
        return $this->_mainOutput($output);
    }
}
