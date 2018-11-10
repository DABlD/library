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
		$data['account_id'] = $this->generateID($data['type']);
		$data['password'] = md5($data['password']);
		return $this->db->insert('users', $data);
	}

	function generateID($type){
		$id = $this->db->like('type', $type != "Staff" ? $type : '')->from('users')->count_all_results() + 1;
		if($type != "Staff"){
			$id = "305414-" . str_pad($id, $type == "Teacher" ? 3 : 6, "0", STR_PAD_LEFT);
		}
		return $id;
	}
}