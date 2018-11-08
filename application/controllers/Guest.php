<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guest extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('UserModel');
	}

	public function index()
	{
		$this->_defaultView('books');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('Login','refresh');
	}

	public function getAll($table)
	{
		echo json_encode(array(
			'data' => $this->UserModel->getAll($table, $this->input->get('withActions')),
		));
	}

	public function getAllBooks()
	{
		$books = $this->UserModel->getAll('books', $this->input->get('withActions'));
		$authors = $this->UserModel->getAll('authors');
		$categories = $this->UserModel->getAll('categories');
		$publishers = $this->UserModel->getAll('publishers');

		foreach($books as $book){
			// GET AUTHOR NAME
			foreach($authors as $author){
				if($author->id == $book->author_id){
					$book->author_id = json_encode(array($author->fname . ' ' . $author->lname));
				}
			}

			// GET CATEGORIES
			$bookCategories = json_decode($book->categories);
			$temp = array();
			foreach($bookCategories as $bookCategory){
				foreach($categories as $category){
					if($bookCategory == $category->id){
						array_push($temp, $category->name);
					}
				}
			}

			$book->categories = json_encode($temp);

			// GET PUBLISHERS
			$bookPublishers = json_decode($book->publisher_id);
			$temp = array();
			foreach($bookPublishers as $bookPublisher){
				foreach($publishers as $publisher){
					if($bookPublisher == $publisher->id){
						array_push($temp, $publisher->name);
					}
				}
			}

			$book->publisher_id = json_encode($temp);
		}

		// $this->viewData($books);
		echo json_encode(array(
			'data' => $books
		));
	}

	public function getRow($table)
	{
		echo json_encode($this->UserModel->getRow($table, $this->input->get('id')));
	}

	//DEFAULTS
	public function _defaultView($view, $data = null)
	{
		$data['type'] = "Guest";
		$this->_view('guest/includes/header');
		$this->_view('guest/includes/sidebar');
		$this->_view('guest/' . $view, $data);
		$this->_view('guest/includes/footer');
	}

	public function _input($post, $name)
	{
		return $post[$name];
	}

	public function _view($view, $data = null)
	{
		$this->load->view($view, $data);
	}

	public function _session($name, $string)
	{	
		$this->session->set_userdata($name, $string);
	}

	public function _flash($name, $string)
	{
		$this->session->set_flashdata($name, $string);
	}

	public function viewData($data)
	{
		echo '<pre>';
		print_r($data);
		die;
	}

}

/* End of file Guest.php */
/* Location: ./application/controllers/Guest.php */