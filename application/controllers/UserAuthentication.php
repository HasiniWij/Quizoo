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
class UserAuthentication extends RestController {

    function __construct()
    {
        parent::__construct();
        $this->load->model('user');
        $this->load->library('session');
    }

    public function signupView_get()
    {
        $this->load->view('signup');
    }

    public function signinView_get()
    {
        $this->load->view('signin');
    }

    public function user_get()
    {
        $user = $this->user->getUserDetails();
        $quizzes = $this->user->getUserQuizzes();
        $userDetails = $user + array('quizzes' => $quizzes);
        print json_encode($userDetails);
    }

    public function user_put()
    {
        $data = file_get_contents('php://input');
        $user = json_decode($data, true);
        if(array_key_exists("newPassword",$user)){
            if($this->user->authenticateUser($user['email'],$user['password'])){
                $this->user->updatePassword($user['id'],$user['newPassword']);
                print json_encode(array('status' => 200,'msg' => 'Success'));
            }
            else{
                print json_encode(array('status' => 401,'msg' => 'unauthorized'));
            }
        }
        else{
            if($this->user->updateUsername($user)){
                print json_encode(array('status' => 200,'msg' => 'Success'));
            }
            else{
                print json_encode(array('status' => 500,'msg' => 'error'));
            }
        }
    }

    public function user_post()
    {
        $email = $this->input->post('email');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $id = $this->user->createUser($email,$username,$password);
        if($id){
            $this->session->is_logged_in = true;
            $this->session->id = $id;
            print json_encode(array('status' => 200,'msg' => 'ok'));
        }
        else{
            print json_encode(array('status' => 500,'msg' => 'error'));
        }
        
    }

    public function authenticate_post()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $id = $this->user->authenticateUser($email,$password);
        if ($id) {
            $this->session->is_logged_in = true;
            $this->session->id = $id;
            print true;
        }
        else {
            print false;
        }
    }

    public function logout_get()
    {
        $this->session->is_logged_in = false;
        redirect('/UserAuthentication/signinView');
    }

}
