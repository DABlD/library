<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Carbon\Carbon;
$CI =& get_instance();

function updateFees($id){
	$borrows = $CI->db->where('user_id', $id)->get('borrows')->result();
	$fee = $CI->db->select('value')->where('name', 'excessFee')->get('settings')->row()->value;

	foreach($borrows as $borrow){
		$diff = Carbon::now()->diff(Carbon::parse($borrow->required_return_date));
		if($diff > 0){
			$CI->db->where('id', $borrow->id)->update('borrows', array(
				'fee' = $diff * $fee;
			));
		}
	}
}

?>