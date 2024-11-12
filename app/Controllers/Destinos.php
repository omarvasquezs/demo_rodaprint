<?php

namespace App\Controllers;

class Destinos extends BaseController
{
    public function index()
    {
        $this->gc->setTable('destinos')
            ->setSubject('DIRECCION', 'DIRECCIONES')
            ->setRelation('id_cliente', 'clientes', 'razon_social')
            ->setRelation('department_id', 'ubigeo_peru_departments', 'name')
            ->setRelation('province_id', 'ubigeo_peru_provinces', 'name')
            ->setRelation('district_id', 'ubigeo_peru_districts', 'name')
            ->setDependentRelation('province_id', 'department_id', 'department_id')
            ->setDependentRelation('district_id', 'province_id', 'province_id')
            ->fieldType('id_cliente', 'hidden')
            ->unsetColumns(['id_cliente'])
            ->displayAs('id_cliente', 'CLIENTE')
            ->displayAs('direccion_destino', 'DIRECCION')
            ->displayAs('department_id', 'DEPARTAMENTO')
            ->displayAs('province_id', 'PROVINCIA')
            ->displayAs('district_id', 'DISTRITO');
        $this->gc_unset();

        if (!empty($_POST['master_id'])) {
            if (is_numeric($_POST['master_id'])) {
                $this->gc->where(['id_cliente' => $_POST['master_id']]);
            } else {
                throw new \InvalidArgumentException("Invalid argument for the field 'master_id'");
            }
        }
        
        $this->gc->callbackBeforeInsert(function ($stateParameters) {
        
            if (!empty($_POST['master_id'])) {
                if (is_numeric($_POST['master_id'])) {
                    $stateParameters->data['id_cliente'] = $_POST['master_id'];
                } else {
                    throw new \InvalidArgumentException("Invalid argument for the field 'master_id'");
                }
            }
        
            return $stateParameters;
        });
        // Rendering the CRUD
        $output = $this->gc->render();
        // HTML title
        $output->title = 'destinos';
        // Showing results in the output
        return $this->_mainOutput($output);
    }
}
