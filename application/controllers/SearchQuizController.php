<?php
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
        $this->load->model('user');
    }

    public function index_get()
    {
        if($this->user->isUserLoggedIn()){
            $this->load->view('home');
        }
        else{
            redirect('/UserAuthentication/signinView');
        }
    }

    public function browseView_get()
    {
        if($this->user->isUserLoggedIn()){
            $this->load->view('browse');
        }
        else{
            redirect('/UserAuthentication/signinView');
        }
        
    }
    
    public function browseQuizzesView_get()
    {
        $queryType = $this->uri->segment(3,false);
        $query = $this->uri->segment(4,false);
        if($this->user->isUserLoggedIn()){
            $this->load->view('browseQuiz',array('queryType' => $queryType,'query' => $query));
        }
        else{
            redirect('/UserAuthentication/signinView');
        }
    }

}
