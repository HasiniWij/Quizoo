<?php
// https://w1761085.users.ecs.westminster.ac.uk/ciapp/index.php
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
use chriskacerguis\RestServer\RestController;
/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class SearchQuizController extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // $this->load->model('user');
        // $this->load->library('session');
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function index_get()
    {
        $this->load->view('home');
    }

    public function browse_get()
    {
        $this->load->view('browse');
    }
    
    public function quizzesOfCategory_get()
    {
        // console.log()
        $queryType = $this->uri->segment(3,false);
        $query = $this->uri->segment(4,false);
        // print( $this->uri->segment(3,false))    ;
        // print($category);
        $this->load->view('browseQuiz',array('queryType' => $queryType,'query' => $query));
    }

}
