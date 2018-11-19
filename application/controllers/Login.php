<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->has_userdata('logged_in_user'))
		{
			redirect($this->session->logged_in_user->type);
		}
		$this->load->model('Users');
	}

	public function index()
	{
		$this->load->view('auth/login');
	}

	public function checkAccount()
	{
		$post = $this->input->post(array('email', 'password'));

		$result = $this->Users->checkAccount($this->_input($post, 'email'), $this->_input($post, 'password'));

		if(gettype($result) == "object")
		{
			unset($result->password);
			$result->full_name = $result->fname . ' ' . $result->lname;
			$this->session->set_userdata('logged_in_user', $result);
			addTrail($result->full_name . ' has logged in.');

			echo json_encode(array($result->type, $result->fname . ' ' . $result->lname));
		}
		else
		{
			echo 'Invalid Email or Password';
		}
	}

	public function _input($post, $name)
	{
		return $post[$name];
	}
}