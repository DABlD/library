<?php

class Users extends CI_Model {

	function checkAccount($email, $password)
	{
		$this->db->where('email', $email);
		$this->db->where('password', md5($password));
		$this->db->where('deleted_at', null);
		$this->db->select('*');
		return $this->db->get('users')->row();
	}

	function addAccount($data)
	{
		$data['password'] = md5($data['password']);
		return $this->db->insert('users', $data);
	}
}