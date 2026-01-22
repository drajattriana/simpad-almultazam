<?php

namespace App\Controllers;

use App\Models\ClassModel;
use App\Models\EmployeeModel;
use App\Models\IpadModel;
use App\Models\MenuModel;
use App\Models\MenuSubModel;
use App\Models\NavigationModel;
use App\Models\RoleModel;
use App\Models\ScanModel;
use App\Models\StudentModel;
use App\Models\UsersModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 * @property array $viewData Data yang akan dikirimkan ke semua view.
 * @property UsersModel $usersModel
 * @property MenuModel $menuModel
 * @property MenuSubModel $menusubModel
 * @property RoleModel $roleModel
 * For security be sure to declare any new methods as protected or private.
 */

abstract class BaseController extends Controller
{

    
    protected $usersModel;
    protected $menuModel;
    protected $menusubModel;
    protected $roleModel;
    protected $navigationModel;
    protected $studentModel;
    protected $ipadModel;
    protected $scanModel;
    protected $employeeModel;
    protected $classModel;

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

    protected array $authData = [];
    protected $helpers = ['session'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        
        $this->usersModel = new UsersModel();
        $this->menuModel = new MenuModel();
        $this->menusubModel = new MenuSubModel();
        $this->roleModel = new RoleModel();
        $this->navigationModel = new NavigationModel();
        $this->studentModel = new StudentModel();
        $this->ipadModel = new IpadModel();
        $this->scanModel = new ScanModel();
        $this->employeeModel = new EmployeeModel();
        $this->classModel = new ClassModel();

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = service('session');

        if (session()->get('id_role')) {
            $flatAuthMenu = $this->menuModel->getSubMenusByRoleId(session()->get('id_role'));
            $groupedAuthMenu = [];
            foreach ($flatAuthMenu as $item) {
                // Use the value from the 'menu' column as the array key.
                $masterMenuName = $item['menu'];
                
                // Add the entire item data as a child of that main menu.
                $groupedAuthMenu[$masterMenuName][] = $item;
            }

            // Store common data in the class property
            $this->authData['auth'] = $groupedAuthMenu;
        }
    }
}
