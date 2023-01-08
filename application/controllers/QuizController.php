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
        parent::__construct();
        $this->load->model('quiz');
        $this->load->model('user');
    }
   
    public function editQuiz_get()
    {
        $this->load->view('editQuiz.php');
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
        $dataArray = json_decode($data, true);
        $quizId = $this->quiz->saveQuiz($dataArray['title'],$dataArray['category']);
       
        foreach($dataArray['tags'] as $tag){
            $this->quiz->saveTags($quizId,$tag);
        }

        foreach($dataArray['questionAnswers'] as $question){
            $this->quiz->saveQuestion($quizId,$question);
        }
   
        print json_encode(array('status' => 200,'msg' => 'ok'));
    }

    public function categories_get()
    {
        $categories = $this->quiz->getCategories();
        print json_encode($categories);
    }

    public function viewFinishQuiz_get()
    {
        $score =  $this->uri->segment(3,false);
        $this->load->view('finishQuiz',array('score' => $score));
    }

    public function voteQuiz_post()
    {
        $data = file_get_contents('php://input');
        $dataArray = json_decode($data, true);
        $vote =  $dataArray['vote'];
        $quizId =  $dataArray['quizId'];
        $this->quiz->updateNumberOfQuizLikes($vote,$quizId);
        if($vote=='like'){
            print 'in';
            $this->quiz->likeQuiz($quizId);
        }
        else{
            print 'out';
            $this->quiz->unlikeQuiz($quizId); 
        }
        print json_encode(array('status' => 200,'msg' => 'Success'));
    }

    public function userLikedQuizzes_get(){
        $userLikedQuizzes = $this->quiz->getUserLikedQuizzes();
        print json_encode($userLikedQuizzes);
    }

}
