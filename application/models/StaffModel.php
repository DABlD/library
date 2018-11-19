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

				if($table == "books"){
					$row->actions .= '&nbsp;' . '<a onclick="duplicateRow(' . $row->id . ')" class="btn btn-xs btn-warning"><i class="fa fa-files-o fa-2x" data-toggle="tooltip" title="Add Copy"></i></a>';
				}
			}
			else
			{
				$row->actions = '';
			}
		}

		return $results;
	}

	function getAllWithJoin($table1, $table2, $data)
	{
		$results = $this->db->where($table1 . '.deleted_at', null)->join($table1, $table2 . '.id = ' . $table1 . '.' . $data['ref'], $data['type'])->get($table2)->result();

		foreach($results as $row)
		{
			if($data['withActions'])
			{
				$row->actions = '<a onclick="deleteRow(' . $row->id . ')" class="btn btn-xs btn-danger"><i class="fa fa-trash-o fa-2x" data-toggle="tooltip" title="Delete"></i></a>' . '&nbsp;' . '<a onclick="editRow(' . $row->id . ')" class="btn btn-xs btn-primary"><i class="fa fa-pencil fa-2x" data-toggle="tooltip" title="Edit"></i></a>';
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

	function getWhere($table, $data)
	{
		return $this->db->where($data['column'], $data['value'])->get($table)->result();
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