<?php

require APPPATH . '/libraries/REST_Controller.php';

class Cek_aktivasi extends REST_Controller {

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
			if($flag == "aktivasi"){
				$id_sekolah 		= $this->post('id_sekolah');
				$imei 				= $this->post('imei');
		
				
				$cekSekolah = $this->Main_model->cekAktivasi($id_sekolah,$imei);
				if(count($cekSekolah)>0){
					$res = array('status' => 1, 'data' => $cekSekolah);
				}else{
					$res = array('status' => 0, 'message' => 'Data not found');
					
				}
				$this->response($res);
			}else{
				$this->response(array('error' => 502 , 'message' =>'Failed Access'));	
			}
		}else{
			$this->response(array('error' => 502 , 'message' =>'Not Json'));
		}
    }


	

}