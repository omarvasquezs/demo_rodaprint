<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;

// initController objects
use \CodeIgniter\HTTP\RequestInterface;
use \CodeIgniter\HTTP\ResponseInterface;
use \Psr\Log\LoggerInterface;

// GROCERY CRUD
include (APPPATH . 'Libraries/GroceryCrudEnterprise/autoload.php');
use Config\Database as ConfigDatabase;
use Config\GroceryCrud as ConfigGroceryCrud;
use GroceryCrud\Core\GroceryCrud;
// Reference the Dompdf namespace
use Dompdf\Dompdf;
// Reference the Options namespace
use Dompdf\Options;
// Reference the Font Metrics namespace
use Dompdf\FontMetrics;


/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['url', 'form'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;
    protected $gc;
    protected $dompdf;
    protected $options;
    protected $menuItems;
    protected $clientes;
    protected $conductores;
    protected $destinos;
    protected $guias;
    protected $productos;
    protected $remitente;
    protected $guias_productos;
    protected $uri;
    protected $departamentos;
    protected $provincias;
    protected $distritos;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        date_default_timezone_set('America/Lima');
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

        $this->gc = $this->_getGroceryCrudEnterprise();
        $this->dompdf = new Dompdf(['isRemoteEnabled' => true]);
        $this->options = new Options();
        $this->menuItems = $this->generateMenuItems();
        $this->clientes = new \App\Models\Clientes();
        $this->conductores = new \App\Models\Conductores();
        $this->destinos = new \App\Models\Destinos();
        $this->guias = new \App\Models\Guias();
        $this->productos = new \App\Models\Productos();
        $this->remitente = new \App\Models\Remitente();
        $this->departamentos = new \App\Models\Departamentos();
        $this->provincias = new \App\Models\Provincias();
        $this->distritos = new \App\Models\Distritos();
        $this->uri = service('uri');
        $this->guias_productos = new \App\Models\GuiasProductos();
    }
    protected function _mainOutput($output = null)
    {
        $menuHTML = $this->generateMenuHTML($this->menuItems);
        $data = (array) $output;
        $data['menuHTML'] = $menuHTML;

        if (isset($output->isJSONResponse) && $output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }

        // Header
        $header = view('header', $data);

        // Body (Output)
        $body = view('output', $data);

        // Footer
        $footer = view('footer', $data);

        // Combine header, body, and footer
        $fullOutput = $header . $body . $footer;

        return $fullOutput;
    }
    protected function _getDbData()
    {
        $db = (new ConfigDatabase())->default;
        return [
            'adapter' => [
                'driver' => 'Pdo_Mysql',
                'host' => $db['hostname'],
                'database' => $db['database'],
                'username' => $db['username'],
                'password' => $db['password'],
                'charset' => 'utf8'
            ]
        ];
    }
    protected function _getGroceryCrudEnterprise($bootstrap = true, $jquery = true)
    {
        $db = $this->_getDbData();
        $config = (new ConfigGroceryCrud())->getDefaultConfig();

        $groceryCrud = new GroceryCrud($config, $db);
        return $groceryCrud;
    }
    protected function generateMenuItems()
    {
        return [
            [
                'title' => 'REGISTRAR',
                'id' => 'registrarDropdown',
                'items' => [
                    ['title' => 'GUIA', 'url' => base_url('add_guia')],
                ],
            ],
            [
                'title' => 'CONSULTAR',
                'id' => 'consultarDropdown',
                'items' => [
                    ['title' => 'GUIAS', 'url' => base_url('guias')],
                    ['title' => 'CLIENTES', 'url' => base_url('clientes')],
                    ['title' => 'CONDUCTORES', 'url' => base_url('conductores')],
                    ['title' => 'PRODUCTOS', 'url' => base_url('productos')],
                ],
            ],
            ['title' => 'CONFIGURACION DE REMITENTE', 'url' => base_url('configuracion'), 'id' => ''],
        ];
    }
    protected function generateMenuHTML($menuItems)
    {
        $menuHTML = '';
        foreach ($menuItems as $item) {
            if (isset($item['items'])) {
                $menuHTML .= '<li class="nav-item dropdown hover-dropdown">';
                $menuHTML .= '<a class="nav-link dropdown-toggle" href="#" id="' . $item['id'] . '" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $item['title'] . '</a>';
                $menuHTML .= '<ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="' . $item['id'] . '">';
                foreach ($item['items'] as $subItem) {
                    $menuHTML .= '<li><a class="dropdown-item" href="' . $subItem['url'] . '">' . $subItem['title'] . '</a></li>';
                }
                $menuHTML .= '</ul>';
                $menuHTML .= '</li>';
            } else {
                $menuHTML .= '<li class="nav-item"><a class="nav-link" href="' . $item['url'] . '" role="button">' . $item['title'] . '</a></li>';
            }
        }
        return $menuHTML;
    }
    public function gc_unset()
    {
        $this->gc->unsetTools();
    }
}
