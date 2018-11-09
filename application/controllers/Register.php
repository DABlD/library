<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// if($this->session->has_userdata('logged_in_user'))
		// {
		// 	redirect('Librarian');
		// }
		$this->load->model('Users');
	}

	public function index()
	{
		$this->load->view('auth/register');
	}

	public function register()
	{
		echo $this->Users->addAccount($this->input->post());
	}
}