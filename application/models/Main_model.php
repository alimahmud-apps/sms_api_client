<?php

/**
* 
*/
class Main_model extends CI_Model
{
	
	function insert_ci($data,$table){
		$insert = $this->db->insert($table,$data);

		if($insert){
			return true;
		}else{
			return false;
		}
	}

	function getSekolah($id_sekolah_client){
		$sql="select *  from m_sekolah where id_sekolah_client='$id_sekolah_client'";
		$query = $this->db->query($sql)->result_array();

		return $query;
	}

	
}


?>