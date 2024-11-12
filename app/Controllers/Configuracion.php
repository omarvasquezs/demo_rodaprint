<?php

namespace App\Controllers;

class Configuracion extends BaseController
{
    public function index()
    {
        $this->gc->setTable('remitente')
            ->setSubject('REMITENTE')
            ->setRead()
            ->setFieldUpload('logo', 'assets/uploads/images/', base_url() . 'assets/uploads/images/')
            ->setRelation('department_id', 'ubigeo_peru_departments', 'name')
            ->setRelation('province_id', 'ubigeo_peru_provinces', 'name')
            ->setRelation('district_id', 'ubigeo_peru_districts', 'name')
            ->setDependentRelation('province_id', 'department_id', 'department_id')
            ->setDependentRelation('district_id', 'province_id', 'province_id')
            ->unsetAdd()
            ->unsetDelete()
            ->unsetSearchColumns(['razon_social'])
            ->columns(['razon_social'])
            ->displayAs('logo', 'ARCHIVO DE LOGO')
            ->displayAs('direccion', 'DIRECCION DE LA EMPRESA')
            ->displayAs('razon_social', 'RAZON SOCIAL')
            ->displayAs('ruc', 'RUC')
            ->displayAs('email', 'E-MAIL DE LA EMPRESA')
            ->displayAs('tel_fijo', 'TELEFONO FIJO')
            ->displayAs('tel_cel', 'TELEFONO CELULAR')
            ->displayAs('department_id', 'DEPARTAMENTO')
            ->displayAs('province_id', 'PROVINCIA')
            ->displayAs('district_id', 'DISTRITO')
            ->displayAs('urbanizacion', 'URBANIZACION');
        // Unset print, filter, settings and export
        $this->gc_unset();
        // Rendering the CRUD
        $output = $this->gc->render();
        // Adding custom css class
        $output->css_class = 'gc_unset_header_footer';
        // Title
        $output->title = 'configuración';
        // Returning the output
        return $this->_mainOutput($output);
    }
}
