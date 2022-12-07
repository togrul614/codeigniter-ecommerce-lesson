<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admins extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('Admins_model');

    }
	
	public function index()
	{
        $data['title'] = 'Admins List';

        $admins = new Admins_model();

        $data['lists'] = $admins->select_all();
        
		$this->load->admin('admins/index',$data);
	}

    public function create(){
        $admins = new Admins_model();

        $admins->fullname = 'admin';

        $data['title'] = 'Admins List';

        $this->load->admin('admins/create',$data);

    }
}
