<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Carbon\Carbon;

function updateUserFees($id){
	$CI =& get_instance();
	$borrows = $CI->db->where('user_id', $id)->where('returned_on', null)->get('borrows')->result();
	doUpdate($borrows);
}

function updateAllFees(){
	$CI =& get_instance();
	$borrows = $CI->db->where('returned_on', null)->get('borrows')->result();
	doUpdate($borrows);
}

function doUpdate($borrows){
	$CI =& get_instance();
	$fee = $CI->db->select('value')->where('name', 'excessFee')->get('settings')->row()->value;

	foreach($borrows as $borrow){
		$diff = Carbon::parse($borrow->required_return_date)->diffInDays(Carbon::now(), false);
		$fee = $diff > 0 ? $diff * $fee : 0.0;
		$CI->db->where('id', $borrow->id)->update('borrows', array(
			'fee' => $fee
		));
	}
}

function addTrail($action){
	$CI =& get_instance();
	$CI->db->insert('audit_trail', array(
		'action' => $action
	));
}

?>