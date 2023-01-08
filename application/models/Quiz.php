<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// https://www.figma.com/file/LpoyRh9WIOJVAUoiQCxk9e/Server-side?node-id=0%3A1&t=zpeBGX8tGwSGDgll-0
class Quiz extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
    }

    function saveQuiz($title,$category)
    {
        $email = $this->session->email;
        $res = $this->db->get_where('users',array('email' => $email));
        if ($res->num_rows() != 1) {
            return false;
        }
        $result = $this->db->insert('quiz',array('title' => $title,'category'=>$category,'authorId' => $res->row()->id));
        if ($result)
        {
            $insertId = $this->db->insert_id();
            return $insertId;
        }
        else {
            return false;
        }
    }

     function getCategories(){
        $this->db->select('category');
        $this->db->distinct();
        $result = $this->db->get('quiz');
        return $result->result_array();
     }

     function saveTags($quizId,$tag){
        $result = $this->db->insert('tag',array('quizId' => $quizId,'tag'=>$tag));
        if ($result)
        {
            return true;
        }
        else {
            return false;
        }
     }

     function saveQuestion($quizId,$question){
        $result = $this->db->insert('questionAnswer',array(
            'quizId' => $quizId,
            'question' =>$question['question'],
            'answerA'=>$question['answerA'],
            'answerB'=>$question['answerB'],
            'answerC'=>$question['answerC'],
            'answerD'=>$question['answerD'],
            'correctAnswer'=>$question['correctAnswer'],
    
        ));
        if ($result)
        {
            return true;
        }
        else {
            return false;
        }
     }

     function getQuizzesFromCategory($category){
        $res = $this->db->get_where('quiz',array('category' => $category));
        if ($res->num_rows() == 0) {
            return false;
        }
        else {
            $quizzes = array();
            foreach ($res->result_array() as $row){
                $quizzes[] = $row;
            }
            return $quizzes;
        }
     }

    function getQuizzesFromTag($tag){
        $res = $this->db->get_where('tag',array('tag' => $tag));
        if ($res->num_rows() == 0) {
            return array();
        }
        else {
            $quizIds = array();
            $quizzes = array();
            foreach ($res->result_array() as $row){
                $quizIds[] = $row['quizId'];
            }

            $this->db->where_in('quizId', $quizIds);
            $result = $this->db->get('quiz'); 

            if ($result->num_rows() == 0) {
                return [];
            }
            else{
                foreach ($result->result_array() as $row){
                    $quizzes[] = $row;
                }
            }
            return  $quizzes;
        }
    }

    function getQuiz($quizId){
        $res = $this->db->get_where('quiz',array('quizId' => $quizId));
        if ($res->num_rows() != 1) {
            return false;
        }
        else {
            $quiz = $res->row_array();
            return $quiz;
        }
    }

    function getQuestionAnswers($quizId){
        $res = $this->db->get_where('questionAnswer',array('quizId' => $quizId));
        if ($res->num_rows() == 0) {
            return false;
        }
        else {
            $questions = array();
            foreach ($res->result_array() as $row){
                $questions[] = $row;
            }
            return $questions;
        }
     }

    function likeQuiz($quizId){
        $email = $this->session->email;
        $res = $this->db->get_where('users',array('email' => $email));
        if ($res->num_rows() != 1) {
            return false;
        }
        $result = $this->db->insert('userQuiz',array('quizId' => $quizId,'userId' => $res->row()->id));
        if ($result)
        {
            return true;
        }
        else {
            return false;
        }
     }

     function unlikeQuiz($quizId){
        $email = $this->session->email;
        $res = $this->db->get_where('users',array('email' => $email));
        if ($res->num_rows() != 1) {
            return false;
        }
        $this->db->where(array('quizId' => $quizId,'userId' => $res->row()->id));
        $result = $this->db->delete('userQuiz');
        if ($result)
        {
            return true;
        }
        else {
            return false;
        }
     }

     function updateNumberOfQuizLikes($vote,$quizId){

        $this->db->where('quizId', $quizId);
        if($vote=='like'){
            $this->db->set('numberOfLikes', 'numberOfLikes+1', FALSE);
        }
        else{
            $this->db->set('numberOfLikes', 'numberOfLikes-1', FALSE);
        }

        $result=$this->db->update('quiz');

        if ($result)
        {
            return true;
        }
        else {
            return false;
        }
    }

    function getUserLikedQuizzes(){
        
        $quizzes = array();
        $email = $this->session->email;
        $res = $this->db->get_where('users',array('email' => $email));
        if ($res->num_rows() != 1) {
            return false;
        }

        $result = $this->db->get_where('userQuiz',array('userId' => $res->row()->id));
        if ($result->num_rows() !== 0) {
            foreach ($result->result_array() as $row){
                $quizzes[] = $row;

            }
        }

        return $quizzes;
     }


    


  

 
}