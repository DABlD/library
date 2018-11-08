<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Carbon\Carbon;

class Staff extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->has_userdata('logged_in_user'))
		{
			$this->session->set_flashdata('error', 'You must log in an account first.');
			redirect('Login','refresh');
		}

		$this->load->model('StaffModel');
	}

	public function index()
	{
		$this->_defaultView('index');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('Login','refresh');
	}

	public function users()
	{
		$this->_defaultView('users');
	}

	public function publishers()
	{
		$this->_defaultView('publishers');
	}

	public function categories()
	{
		$this->_defaultView('categories');
	}

	public function authors()
	{
		$this->_defaultView('authors');
	}

	public function books()
	{
		$this->_defaultView('books');
	}

	public function getAll($table)
	{
		echo json_encode(array(
			'data' => $this->StaffModel->getAll($table, $this->input->get('withActions')),
		));
	}

	public function getAllBooks()
	{
		$books = $this->StaffModel->getAll('books', $this->input->get('withActions'));
		$authors = $this->StaffModel->getAll('authors');
		$categories = $this->StaffModel->getAll('categories');
		$publishers = $this->StaffModel->getAll('publishers');

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

	public function getForSelect($table, $column)
	{
		echo json_encode($this->StaffModel->getForSelect($table, $column, $this->input->get('term')));
	}

	public function getRow($table)
	{
		echo json_encode($this->StaffModel->getRow($table, $this->input->get('id')));
	}
	
	public function getRow2($table)
	{
		echo json_encode(array($this->UserModel->getRow($table, $this->input->get('id')), $this->input->get('ref')));
	}

	public function deleteRow($table)
	{
		echo $this->StaffModel->deleteRow($table, $this->input->get('id'));
	}

	public function addRow($table)
	{
		echo $this->StaffModel->addRow($table, $this->input->post());
	}

	//VALIDATIONS
	public function validateUserDetails()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('fname', 'First Name', 'required|regex_match[/^[a-zA-Z .-]*$/]');
		$this->form_validation->set_rules('lname', 'Last Name', 'required|regex_match[/^[a-zA-Z .-]*$/]');
		$this->form_validation->set_rules('gender', 'Gender', 'required|alpha');
		$this->form_validation->set_rules('contact', 'Contact', 'required|numeric');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

		if($this->form_validation->run() == FALSE)
		{
			$this->_flash('error', validation_errors());
			redirect('Staff/users','refresh');
		}
		else
		{
			$this->StaffModel->updateRow('users', $this->input->post());
			$this->_flash('success', 'User has been updated.');
			redirect('Staff/users','refresh');
		}
	}

	public function validatePublisherDetails()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('location', 'Location', 'required');

		if($this->form_validation->run() == FALSE)
		{
			$this->_flash('error', validation_errors());
			redirect('Staff/publishers','refresh');
		}
		else
		{
			$this->StaffModel->updateRow('publishers', $this->input->post());
			$this->_flash('success', 'Publisher has been updated.');
			redirect('Staff/publishers','refresh');
		}
	}

	public function validateCategoryDetails()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Name', 'required');

		if($this->form_validation->run() == FALSE)
		{
			$this->_flash('error', validation_errors());
			redirect('Staff/categories','refresh');
		}
		else
		{
			$this->StaffModel->updateRow('categories', $this->input->post());
			$this->_flash('success', 'Category has been updated.');
			redirect('Staff/categories','refresh');
		}
	}

	public function validateAuthorDetails()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('fname', 'First Name', 'required|regex_match[/^[a-zA-Z .-]*$/]');
		$this->form_validation->set_rules('lname', 'Last Name', 'required|regex_match[/^[a-zA-Z .-]*$/]');

		if($this->form_validation->run() == FALSE)
		{
			$this->_flash('error', validation_errors());
			redirect('Staff/authors','refresh');
		}
		else
		{
			$this->StaffModel->updateRow('authors', $this->input->post());
			$this->_flash('success', 'Author has been updated.');
			redirect('Staff/authors','refresh');
		}
	}

	public function validateBookDetails()
	{
		//JSON ENCODE ARRAYS
		$_POST['categories'] = json_encode($this->input->post('categories'));
		$_POST['publisher_id'] = json_encode($this->input->post('publisher_id'));
		
		$this->load->library('form_validation');

		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('categories[]', 'Categories', 'required');
		$this->form_validation->set_rules('isbn', 'ISBN', 'required|regex_match[/^[0-9-]*$/]');
		$this->form_validation->set_rules('edition', 'Edition', 'required');
		$this->form_validation->set_rules('date_published', 'Date Published', 'required');
		$this->form_validation->set_rules('author_id', 'Authors', 'required');
		$this->form_validation->set_rules('publisher_id[]', 'Publishers', 'required');
		$this->form_validation->set_rules('stock', 'stock', 'required');

		if($this->form_validation->run() == FALSE)
		{
			$this->_flash('error', validation_errors());
			redirect('Staff/books','refresh');
		}
		else
		{
			$this->StaffModel->updateRow('books', $this->input->post());
			$this->_flash('success', 'Book has been updated.');
			redirect('Staff/books','refresh');
		}
	}

	//DEFAULTS
	public function _defaultView($view, $data = null)
	{
		$this->_view('staff/includes/header');
		$this->_view('staff/includes/sidebar');
		$this->_view('staff/' . $view, $data);
		$this->_view('staff/includes/footer');
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