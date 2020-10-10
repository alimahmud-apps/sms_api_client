<?php

require APPPATH . '/libraries/REST_Controller.php';

class push extends REST_Controller {

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
			if($flag == "datasms"){
				$sender	 			= $this->post('sender');
				$text 				= $this->post('text');
				$id_sekolah 		= $this->post('id_sekolah');
				$message_ar 		= $this->post('message_ar');
				
				$cekSekolah = $this->Main_model->getSekolah($id_sekolah);
				if(count($cekSekolah)>0){
					$data_insert = array(
							'sender' 			=> $sender,
							'text_message' 		=> $text,
							'id_sekolah_client' => $id_sekolah,
							'message_ar' 		=> $message_ar,

						);
					$insert = $this->Main_model->insert_ci($data_insert,"data_sms");
					if($insert==true){
						$this->response(array('data' => array("response" => "accept" , $sender,$id_sekolah)));
					}else{
						$this->response(array('error' => 502 , 'message' => $sender."|".$id_sekolah." not insertDB"));	
					}
				}else{
					$this->response(array('error' => 502 , 'message' => $id_sekolah." not found"));	
				}

				
			}else{
				$this->response(array('error' => 502 , 'message' =>'Failed Access'));	
			}
		}else{
			$this->response(array('error' => 502 , 'message' =>'Not Json'));
		}
    }


	

}