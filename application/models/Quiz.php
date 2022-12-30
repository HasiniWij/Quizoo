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
        $x = $this->db->insert('quiz',array('title' => $title,'category'=>$category,'authorId' => $res->row()->id));
        if ($x)
        {
            $insertId = $this->db->insert_id();
            return $insertId;
        }
        else {
            return false;
        }
    }

    function authenticateUser($email,$enteredPassword)
    {
        $res = $this->db->get_where('users',array('email' => $email));
        if ($res->num_rows() != 1) {
            return false;
        }
        else {
            $row = $res->row();
            if (password_verify($enteredPassword,$row->password)) {
                return true;
            }
            else {
                return false;
            }
        }
    }

    function getUserDetails()
    {
        
        $res = $this->db->get_where('users',array('email' => $this->session->email));
        if ($res->num_rows() != 1) {
            return false;
        }
        else {
            $user = $res->row_array();
            return $user;
        }
    }

    function isUserLoggedIn()
    {
        if(isset($this->session->is_logged_in) && $this->session->is_logged_in == true)       
        {
            return true; 
        }
        return false ;  
    }
     function updateUser($user)
     {
        $this->db->replace('users', $user);
     }

     function getCategories(){
        $this->db->select('category');
        $this->db->distinct();
        $result = $this->db->get('quiz');
        return $result->result_array();

     }
    // function updateName($userId,$username)
    // function updatePassword($userId,$username)
    // function updateScore($userId,$username)
    // function update($userId,$username)
    // function getHighestScoreUsers($userId,$username)

    // function updateName($userId,$username)
    // {
    //     $res = $this->db->get_where('users',array('email' => $email, 'password' => $password));
    //     if ($res->num_rows() != 1) {
    //         return false;
    //     }
    //     else {
    //         $row = $res->row();
    //         return $row['userId']; 
    //     }
    // }

  

 
}