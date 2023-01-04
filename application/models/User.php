<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// https://www.figma.com/file/LpoyRh9WIOJVAUoiQCxk9e/Server-side?node-id=0%3A1&t=zpeBGX8tGwSGDgll-0
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
            return true;
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

    function getUserQuizzes()
    {
        $x = $this->db->get_where('users',array('email' => $this->session->email));
        $user = $x->row_array();
        	
                                                  	
        $res = $this->db->get_where('quiz',array('authorId' => $user['id']));
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
        $email = $this->session->email;
        $res = $this->db->get_where('users',array('email' => $email));
        if ($res->num_rows() != 1) {
            return false;
        }
   
        $id =  $res->row()->id;

        $this->db->where('id', $id);
        $this->db->set('score', 'score+'.$score, FALSE);
        $result = $this->db->update('users');

        if($result)       
        {
            return true; 
        }
        return false ;  
        
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