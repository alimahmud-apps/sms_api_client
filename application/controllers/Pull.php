<?php

require APPPATH . '/libraries/REST_Controller.php';

class pull extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('Main_model');
    }

    // get 
    function index_get() {
		$this->response(array('error' => 502 , 'message' =>'NOT POST METHOD'));
    }
    // update
    function index_put() {
		$this->response(array('error' => 502 , 'message' =>'NOT POST METHOD'));
    }

    // delete
    function index_delete() {
		$this->response(array('error' => 502 , 'message' =>'NOT POST METHOD'));
    }
	
	function err_not_found(){
		$this->response(array('error' => 502 , 'message' =>'Failed Access'));	
	}

    // post data
    function index_post() {
		foreach(getallheaders() as $name => $value) 
		{
			if($name=='Accept') 
			{
				$accept = $value;
			}
			 if($name=='Content-Type') 
			{
				$content = $value;
			}
			if($name=='Flag') 
			{
				$flag = $value;
			}
		}
		if(stristr(strtolower($content), 'application/json') == true && strtolower($accept) == strtolower('application/json'))
		{
			if($flag == "essm"){
				$getEmploye = $this->Main_model->get_employee();
				$this->response($getEmploye);
				
			}elseif($flag == "essm_version"){
				$ver	 		= $this->post('version');
				$cek_versison 	= $this->Main_model->cek_versison($ver);
				$get_version 	= $this->Main_model->get_version();
				
				$this->response(array('data' => $cek_versison,'v_new' => $get_version));
				
			}elseif($flag == "essm_finger"){
				   $warehouse	= $this->post('warehouse');
				   $cek_pull 	= $this->Main_model->cek_pull($warehouse);
				   if(count($cek_pull) > 0){
				   		$row = "";
				   		foreach ($cek_pull as $item_cek_pull){
				   			$getFinger 	= $this->Main_model->getFinger($item_cek_pull["nik"]);
				   			if(count($getFinger) > 0 ){
				   				foreach ($getFinger as $item_getFinger){
				   					$nik = $item_getFinger["nik"];
				   					$finger = $item_getFinger["tmp_finger"];
				   					$row[] = array('nik' => $nik,'finger' =>$finger );
				   				}
				   			}else{
				   				$row[] = array('nik' =>$item_cek_pull["nik"],'finger' =>"null" );
				   			}
				   			$this->Main_model->update_pull($item_cek_pull["p_pull_finger_id"]);
				   		}
				   		$this->response(array('data' => $row));
				   }else{
				   		$row[] = array('nik' =>"null");
				   		$this->response(array('data' => $row));
				   }
			}

			elseif($flag == "essm_finger_update"){
				   $warehouse	= $this->post('warehouse');
				   $cek_pull 	= $this->Main_model->cek_pull_ubah($warehouse);

				   if(count($cek_pull) > 0){
				   		$row = "";
				   		foreach ($cek_pull as $item_cek_pull){
				   			$getFinger 	= $this->Main_model->getFinger($item_cek_pull["nik_old"]);
				   			if(count($getFinger) > 0 ){
				   				foreach ($getFinger as $item_getFinger){
				   					$nik = $item_getFinger["nik"];
				   					$finger = $item_getFinger["tmp_finger"];
				   					$row[] = array('nik_old' => $nik,'nik_new' => $item_cek_pull["nik_new"],'finger' =>$finger );
				   				}
				   			}else{
				   				$row[] = array('nik_old' =>$item_cek_pull["nik_old"],'finger' =>"null" );
				   			}
				   			$this->Main_model->update_pull_ubah($item_cek_pull["p_pull_finger_update_id"]);
				   		}
				   		$this->response(array('data' => $row));
				   }else{
				   		$row[] = array('nik_old' =>"null");
				   		$this->response(array('data' => $row));
				   }
			}


			else{
				$this->response(array('error' => 502 , 'message' =>'Failed Access'));	
			}
		}else{
			$this->response(array('error' => 502 , 'message' =>'Not Json'));
		}
    }


	

}