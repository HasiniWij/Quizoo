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
class ScoreController extends RestController {

    function __construct()
    {
        parent::__construct();
        $this->load->model('user');
        $this->load->library('session');
    }

    public function leaderBoardView_get()
    {
        if($this->user->isUserLoggedIn()){
            $this->load->view('leaderboad');
        }
        else{
            redirect('/UserAuthentication/signinView');
        } 
    }
    public function maxScoreUsers_get()
    {
        $users = $this->user->getMaxScoreUsers();
        print json_encode($users);
    }
    public function userRank_get()
    {
        $user = $this->user->getUserRank();
        print json_encode($user);
    }
    
    public function score_post()
    {
        $score =  $this->uri->segment(3,false);
        $result = $this->user->updateScore($score);
        if($result){
            print json_encode(array('status' => 200,'msg' => 'Success'));
        }
        else{
            print json_encode(array('status' => 500,'msg' => 'error'));
        }
    }  

    public function profile_get()
    {
        if($this->user->isUserLoggedIn()){
            $this->load->view('profile');
        }
        else{
            redirect('/UserAuthentication/signinView');
        }
    }

}
