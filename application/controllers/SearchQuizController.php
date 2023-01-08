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
        parent::__construct();
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
        $queryType = $this->uri->segment(3,false);
        $query = $this->uri->segment(4,false);
        $this->load->view('browseQuiz',array('queryType' => $queryType,'query' => $query));
    }

}
