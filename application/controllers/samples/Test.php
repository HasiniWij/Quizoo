<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/RestController.php';
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
class Test extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('books');
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function index_get()
    {
        $this->load->view('editQuestionAnswer.php');
    }

    public function view_get()
    {
        $this->load->view('editQuiz.php');
    }

//    public function index_delete()
//     {
//         print "hello";
//     } 

//     public function book_get()
//     {

        
//           // 2nd argument - what to return if segment is missing
//           $name = urldecode($this->uri->segment(3));

//           if ($name == false) {
//             print "hello";
//           }
//           else {
//               $name = $name;
//               $book = $this->books->getBook($name);
              
//               print json_encode($book);
//           }
         
        
     
//     }

//     public function book_post()
//     {
//         $input = $this->input->post();
//         $this->books->create($input);
//     }
    

}
