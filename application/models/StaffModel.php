<?php

use Carbon\Carbon;

class StaffModel extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('datatables');
	}

	function getAll($table, $withActions = 0)
	{
		if($table == 'users')
		{
			$this->db->where('type !=', 'Librarian');
		}
		
		$results = $this->db->where('deleted_at', null)->get($table)->result();

		foreach($results as $row)
		{
			if($withActions)
			{
				$row->actions = '<a onclick="editRow(' . $row->id . ')" class="btn btn-xs btn-primary"><i class="fa fa-pencil fa-2x" data-toggle="tooltip" title="Edit"></i></a>';
			}
			else
			{
				$row->actions = '';
			}
		}

		return $results;
	}

	function getForSelect($table, $column, $value)
	{
		if($table != 'authors')
		{
			return $this->db->select('id, name as text')->where('deleted_at', null)->like($column, $value)->get($table)->result();
		}
		else
		{
			$full_name = "CONCAT(fname, ' ', lname)";
			return $this->db->select('id, ' . $full_name . ' as text')->where('deleted_at', null)->like($full_name, $value)->get($table)->result();
		}
	}

	function getRow($table, $id)
	{
		return $this->db->where('id', $id)->get($table)->row();
	}

	function deleteRow($table, $id)
	{
		return $this->db->where('id', $id)->set('deleted_at', Carbon::now())->update($table);
	}

	function updateRow($table, $data)
	{
		$data['updated_at'] = Carbon::now();
		return $this->db->where('id', $data['id'])->update($table, $data);
	}

	function addRow($table, $data)
	{
		return $this->db->insert($table, $data);
	}
}