<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FormValidation extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("formvalidation_model");
    }

    


}
