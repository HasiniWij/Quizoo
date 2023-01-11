<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Quiz extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
    }

    function saveQuiz($title,$category)
    {
        $result = $this->db->insert('quiz',array('title' => $title,'category'=>$category,'authorId' => $this->session->id));
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
        $result = $this->db->get_where('quiz',array('category' => $category));
        if ($result->num_rows() == 0) {
            return false;
        }
        else {
            $quizzes = array();
            foreach ($result->result_array() as $row){
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
        $result = $this->db->get_where('quiz',array('quizId' => $quizId));
        if ($result->num_rows() != 1) {
            return false;
        }
        else {
            $quiz = $result->row_array();
            return $quiz;
        }
    }

    function getTags($quizId){
        $result = $this->db->get_where('tag',array('quizId' => $quizId));
        $tags = array();
        if ($result->num_rows() != 0) {
            foreach ($result->result_array() as $row){
                $tags[] = $row;
            }
        }
        return $tags;
    }

    function getQuestionAnswers($quizId){
        $result = $this->db->get_where('questionAnswer',array('quizId' => $quizId));
        if ($result->num_rows() == 0) {
            return false;
        }
        else {
            $questions = array();
            foreach ($result->result_array() as $row){
                $questions[] = $row;
            }
            return $questions;
        }
     }

    function likeQuiz($quizId){
        $result = $this->db->insert('userQuiz',array('quizId' => $quizId,'userId' => $this->session->id));
        if ($result)
        {
            return true;
        }
        else {
            return false;
        }
     }

     function unlikeQuiz($quizId){
        $this->db->where(array('quizId' => $quizId,'userId' => $this->session->id));
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
        $result = $this->db->get_where('userQuiz',array('userId' => $this->session->id));
        if ($result->num_rows() !== 0) {
            foreach ($result->result_array() as $row){
                $quizzes[] = $row;
            }
        }
        return $quizzes;
     }
     function updateQuiz($quizId,$title, $category){
         $this->db->where('quizId', $quizId);
         $result= $this->db->update('quiz', array('title' => $title,'category' =>$category)); 
         if ($result)
         {
             return true;
         }
         else {
             return false;
         }
     }
     
     function deleteTag($tagIds){
        $this->db->where_in('tagId', $tagIds);
        $result = $this->db->delete('tag');
        if ($result)
        {
            return true;
        }
        else {
            return false;
        }
     }

     function deleteQuestionAnswers($quizId){
        $result = $this->db->delete('questionAnswer', array('quizId' => $quizId));  
        if ($result)
        {
            return true;
        }
        else {
            return false;
        }

     }
}