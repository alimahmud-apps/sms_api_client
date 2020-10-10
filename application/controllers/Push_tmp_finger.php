<?php

require APPPATH . '/libraries/REST_Controller.php';

class push_tmp_finger extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('main_model');
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
		// $nik	 	= $this->post('nik');
		// $checktime 	= $this->post('checktime');
		// $zona 		= $this->post('zona');
		// $status 	= $this->post('status');
		// $warehouse 	= $this->post('warehouse');

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
				// $data_insert = array(
				// 		'nik' =>  $nik,
				// 		'checktime' => $checktime,
				// 		'status' => $status,
				// 		'warehouse' => $warehouse,
				// 		'zona' => $zona
				// 	);
				// $insert = $this->main_model->insert_ci($data_insert,"checkinoutfinger");
				// if($insert==true){
				// 	$this->response(array('data' => array("response" => "accept" , $nik,$checktime,$zona,$status,$warehouse)));
				// }else{
				// 	$this->response(array('error' => 502 , 'message' => $nik." not insertDB"));	
				// }
				
				$co = count($this->post());
				$data="";
				$nik ="";
				for($i=0 ; $i < $co ; $i++){
					$data = $this->post($i);
					$nik .= $data[0]." ";
					// $data = " $i";

				}
				$this->response(array('data' => array("response" => "accept" ,  $nik )));
				//$data1 = $this->post('6');
				
			}else{
				$this->response(array('error' => 502 , 'message' =>'Failed Access'));	
			}
		}else{
			$this->response(array('error' => 502 , 'message' =>'Not Json'));
		}
    }


	

}