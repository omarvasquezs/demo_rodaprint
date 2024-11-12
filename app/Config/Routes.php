<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// ADD GUIA
$routes->get('add_guia','Guias::add_guia');
$routes->get('add_guia/(:any)','Guias::add_guia/$1');
$routes->post('add_guia','Guias::add_guia');
$routes->post('add_guia/(:any)','Guias::add_guia');
$routes->get('fetchClientes','Guias::fetchClientes');
$routes->get('fetchDestinos/(:any)','Guias::fetchDestinos');
$routes->get('fetchConductores','Guias::fetchConductores');
$routes->get('fetchProductos','Guias::fetchProductos');
$routes->post('submit_guia','Guias::submit_guia');

// RE-USAR GUIA
$routes->get('reusar_guia','Guias::reusar_guia');
$routes->get('reusar_guia/(:any)','Guias::reusar_guia/$1');
$routes->post('reusar_guia','Guias::reusar_guia');
$routes->post('reusar_guia/(:any)','Guias::reusar_guia');

// GUIA
$routes->get('guias','Guias::index');
$routes->get('guias/(:any)','Guias::index/$1');
$routes->post('guias','Guias::index');
$routes->post('guias/(:any)','Guis::index');

// PDF
$routes->get('consultar_guia/(:any)', 'Guias::generatePdfA4/$1');

// PRODUCTOS
$routes->get('productos','Productos::index');
$routes->get('productos/(:any)','Productos::index/$1');
$routes->post('productos','Productos::index');
$routes->post('productos/(:any)','Productos::index');

// CLIENTES
$routes->get('clientes','Clientes::index');
$routes->get('clientes/(:any)','Clientes::index/$1');
$routes->post('clientes','Clientes::index');
$routes->post('clientes/(:any)','Clientes::index');

// CONDUCTORES
$routes->get('conductores','Conductores::index');
$routes->get('conductores/(:any)','Conductores::index/$1');
$routes->post('conductores','Conductores::index');
$routes->post('conductores/(:any)','Conductores::index');

// DESTINOS
$routes->get('destinos','Destinos::index');
$routes->get('destinos/(:any)','Destinos::index/$1');
$routes->post('destinos','Destinos::index');
$routes->post('destinos/(:any)','Destinos::index');

// CONFIGURACION
$routes->get('configuracion','Configuracion::index');
$routes->get('configuracion/(:any)','Configuracion::index/$1');
$routes->post('configuracion','Configuracion::index');
$routes->post('configuracion/(:any)','Configuracion::index');