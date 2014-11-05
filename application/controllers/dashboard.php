<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DashBoard extends CI_Controller {

	public function index()
	{
        $this->load->helper("url");
        $data['navbar'] = "1";

		$this->load->view('admin/header');
		$this->load->view('admin/navbar',$data);
		$this->load->view('admin/index');
		$this->load->view('admin/footer');
	}

    public function statitic() {
        $this->load->helper("url"); 
        $data['navbar'] = "2";
		$this->load->view('admin/header');
		$this->load->view('admin/navbar',$data);
		$this->load->view('admin/statitic');
		$this->load->view('admin/footer');
    }

    public function adpos() {
        $this->load->helper("url"); 
        $data['navbar'] = "3";
		$this->load->view('admin/header');
		$this->load->view('admin/navbar',$data);
		$this->load->view('admin/adpos');
		$this->load->view('admin/footer');
    
    }

    public function revenue() {
        $this->load->helper("url");
        $data['navbar'] = "4";
		$this->load->view('admin/header');
		$this->load->view('admin/navbar',$data);
		$this->load->view('admin/revenue');
		$this->load->view('admin/footer');
         
    }

    public function payments() { //付款记录
        $this->load->helper("url");
        $data['navbar'] = "5";
		$this->load->view('admin/header');
		$this->load->view('admin/navbar',$data);
		$this->load->view('admin/payments');
		$this->load->view('admin/footer');
    
    }

    public function subagents() {
        $this->load->helper("url");
        $data['navbar'] = "6";
		$this->load->view('admin/header');
		$this->load->view('admin/navbar',$data);
		$this->load->view('admin/subagents');
		$this->load->view('admin/footer');
    }

    public function agents() {
        $this->load->helper("url");
        $data['navbar'] = "7";
		$this->load->view('admin/header');
		$this->load->view('admin/navbar',$data);
		$this->load->view('admin/agents');
		$this->load->view('admin/footer');
    }

    public function settings() {
        $this->load->helper("url");
        $data['navbar'] = "8";
		$this->load->view('admin/header');
		$this->load->view('admin/navbar',$data);
		$this->load->view('admin/settings');
		$this->load->view('admin/footer');
    }
}

