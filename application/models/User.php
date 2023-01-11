<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
    }

    function createUser($email,$username,$password)
    {
        $hashed_password = password_hash($password,PASSWORD_DEFAULT);
        if ($this->db->insert('users',array('email' => $email,'password'=>$hashed_password,'username' => $username)))
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
        $result = $this->db->get_where('users',array('email' => $email));
        if ($result->num_rows() != 1) {
            return false;
        }
        else {
            $row = $result->row();
            if (password_verify($enteredPassword,$row->password)) {
                return $result->row()->id;
            }
            else {
                return false;
            }
        }
    }

    function getUserDetails()
    {
        $result = $this->db->get_where('users',array('id' => $this->session->id));
        if ($result->num_rows() != 1) {
            return false;
        }
        else {
            $user = $result->row_array();
            return $user;
        }
    }

    function getUserQuizzes()
    {    	
        $result = $this->db->get_where('quiz',array('authorId' =>$this->session->id));
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

    function isUserLoggedIn()
    {
        if(isset($this->session->is_logged_in) && $this->session->is_logged_in == true)       
        {
            return true; 
        }
        return false ;  
    }
  
    function updateUsername($user)
     {
        $this->db->set('username', $user['username']);
        $this->db->where("id",$user['id']);
        $result = $this->db->update('users'); 

        if($result)       
        {
            return true; 
        }
        return false ;  
        
     }

     function updatePassword($id,$password)
     {
        $hashed_password = password_hash($password,PASSWORD_DEFAULT);
        $this->db->set('password', $hashed_password);
        $this->db->where("id",$id);
        $result = $this->db->update('users'); 
        if($result)       
        {
            return true; 
        }
        return false ;  
        
     }

     function updateScore($score)
     {
        $this->db->where('id',$this->session->id);
        $this->db->set('score', 'score+'.$score, FALSE);
        $result = $this->db->update('users');
        if($result)       
        {
            return true; 
        }
        return false ;   
     }

     function getUserRank()
     {
        $id = $this->session->id;
        $this->db->select('username,email, score');
        $this->db->order_by('score', 'DESC');
        $result = $this->db->get('users'); 

        // $id =  $res->row()->id;
            if ($result->num_rows() == 0) {
                return [];
            }
            else{
                $users = array();
                foreach ($result->result_array() as $row){
                    $users[] = $row;
                    // $row->username;

                }
            }
        
                return $users[0];
        }
     
     function getMaxScoreUsers()
     {
        $this->db->select('username, score');
        $this->db->order_by('score', 'DESC');
        $this->db->limit(2);
        $result = $this->db->get('users'); 

        if ($result->num_rows() == 0) {
            return [];
        }
        else{
            $users = array();
            foreach ($result->result_array() as $row){
                $users[] = $row;
            }
            return $users;
        }   
    } 
}