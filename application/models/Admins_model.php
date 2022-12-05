<?php

class Admins_model extends CI_Model {
    public $fullname;
    public $password;
    public $email;
    public $status;

    protected $table = 'admins';

    public function insert(){
        $data = array(
                'fullname' => $this->fullname,
                'password' => $this->password,
                'email' => $this->email,
                'status' => $this->status
        );
    
        $this->db->insert($this->table, $data);

        return $this->db->insert_id;
    }

    public function select_all(){
        $this->db->where('status',1);
        $query = $this->db->get($this->table);

        return $query->result();
    }

}