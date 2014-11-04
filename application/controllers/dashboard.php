<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DashBoard extends CI_Controller {

	public function index()
	{
        $this->load->helper("url");
		$this->load->view('admin/header');
		$this->load->view('admin/navbar');
		$this->load->view('admin/index');
		$this->load->view('admin/footer');
	}

    public function payments() { //付款记录
        $this->load->helper("url");
		$this->load->view('admin/header');
		$this->load->view('admin/navbar');
		$this->load->view('admin/payments');
		$this->load->view('admin/footer');
    
    }

}

