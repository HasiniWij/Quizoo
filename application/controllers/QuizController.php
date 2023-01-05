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
class QuizController extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('quiz');
        $this->load->model('user');
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }
   
    // public function index_get()
    // {
    //     $this->load->view('testview');
    //     // login
    // }

    public function editQuiz_get()
    {
        $this->load->view('editQuiz.php');
    }

    public function editQuestion_get()
    {
        $id =  $this->uri->segment(3,false);
        $this->load->view('editQuestionAnswer',$id);
    }
    
    public function addQuiz_get()
    {
        $title = $this->input->get('title');
        console.log($title);
        $this->load->view('editQuestionAnswer.php');
    }
    public function quiz_get()
    {
        $id =  $this->uri->segment(3,false);
        $quizzesDetails = $this->quiz->getQuiz($id);
        $questionAnswers = $this->quiz->getQuestionAnswers($id);
        $quizzes = $quizzesDetails + array('questionAnswers' => $questionAnswers);
        print json_encode($quizzes);
    }

    public function quizzes_get(){
        $queryType =  $this->uri->segment(3,false);
        $query = $this->uri->segment(4,false);
      
        if($queryType==='category'){
            $quizzes = $this->quiz->getQuizzesFromCategory($query);
        }
        else if($queryType==='tag'){
            $query = strtolower($query);
            $quizzes = $this->quiz->getQuizzesFromTag($query);
            $quizzesFromCategory = $this->quiz->getQuizzesFromCategory($query);
            if($quizzesFromCategory){
                $quizzes = array_merge($quizzesFromCategory, $quizzes);
            }
        }
        print json_encode($quizzes);
    }

    public function viewQuiz_get()
    {
        $quizId =  $this->uri->segment(3,false);
        $this->load->view('viewQuiz.php',array('quizId' => $quizId));
    }

    public function quiz_post()
    {
        
        $data = file_get_contents('php://input');
        $arr = json_decode($data, true);
        $quizId = $this->quiz->saveQuiz($arr['title'],$arr['category']);
       
        foreach($arr['tags'] as $tag){
            $this->quiz->saveTags($quizId,$tag);
        }

        foreach($arr['questionAnswers'] as $question){
            $this->quiz->saveQuestion($quizId,$question);
        }


        
        print json_encode($arr['questionAnswers']);
        // $title = $this->input->post('category');
        // $category = $this->input->post();
        // $x = $this->request->body();
        // print json_decode( $category) ;
        // print($title);
        // print($x);
        
        // print 'x';
        // $input = $this->input->post();
        // $this->quiz->saveQuiz($input);
    }
    public function createQuiz_post()
    {
        $input = $this->input->post('title');
        print title;
        // $this->quiz->saveQuiz($input);
    }

    public function categories_get()
    {
        $categories = $this->quiz->getCategories();
        print json_encode($categories);
        // $this->quiz->saveQuiz($input);
    }

    public function finishQuiz_get()
    {
        $score =  $this->uri->segment(3,false);
        $this->load->view('finishQuiz',array('score' => $score));
        // $categories = $this->quiz->getCategories();
        // print json_encode($categories);
        // $this->quiz->saveQuiz($input);
    }
 
    

}
