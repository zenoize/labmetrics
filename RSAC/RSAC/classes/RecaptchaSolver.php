<?php
	class RecaptchaSolver {
		private $apikey;
		private $pageurl;
		private $googlekey;
		function __construct($config){
			$this->url = $config['pageurl'];
			$this->googlekey = $config['googlekey'];
			$this->apikey = $config['apikey'];
			$this->pageurl = $config['pageurl'];
		}
		
		public function solveCaptcha(){
			$id = $this->sendCaptchaData();
			$solution = false;
			while($solution==false){
				$solution = $this->getSolution($id);
				sleep(1);
			}
			return $solution;
		}
			
		private function sendCaptchaData(){
			//extract data from the post
			//set POST variables
			$url = 'http://2captcha.com/in.php';
			$fields = array(
				'googlekey' => $this->googlekey,
				'key' => $this->apikey,
				'method' => "userrecaptcha",
				'pageurl' => urlencode($this->pageurl)
			);
			$fields_string = "";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			$fields_string = rtrim($fields_string, '&');
			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true); 
			//execute post
			$result = curl_exec($ch);

			//close connection
			curl_close($ch);
			
			$result = substr($result,3);
			return $result;
		}	
		
		private function getSolution($id){
			//extract data from the post
			//set POST variables
			$url = 'http://2captcha.com/res.php';
			$fields = array(
				'key' => $this->apikey,
				'id' => $id,
				'action' => "get"
			);
			$fields_string = "?";
			//url-ify the data for the POST
			foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			$fields_string = rtrim($fields_string, '&');
			$url .=$fields_string;
			$result = file_get_contents($url);
			if(strpos($result,"|")!=false)
				$result =substr($result,3);
			elseif(strpos($result,"ERROR")==false)
				$result = false;
			return $result;
			
		}
	}
?>