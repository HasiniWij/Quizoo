<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Books extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function create($title,$author,$genre)
    {
        if ($this->db->insert('books',array('title' => $title,'author'=>$author,'genre' => $genre)))
        {
            return True;
        }
        else {
            return False;
        }
    }

    function getBook($title)
    {
        $res = $this->db->get_where('books',array('title' => $title));
        if ($res->num_rows() != 1) {
            return false;
        }
        else {
            $row = $res->row();
            return $row; 
        }
    }

 
}