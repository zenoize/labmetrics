<?php
	class ProxyRotator{
		private $proxies = array();
		function __construct(){
			$this->base = dirname(__DIR__)."/";
			if(!file_exists($this->base."bin/hideme_proxy_export.csv"))
				$this->downloadProxies();
			$this->getProxies();
		}
		private function downloadProxies(){
			$proxies = file_get_contents("http://incloak.com/api/proxylist.txt?&maxtime=1000&type=s&out=csv&lang=en&code=318884291872382");
			$proxies = explode(PHP_EOL,$proxies);
			array_shift($proxies);
			$proxylist = implode(PHP_EOL,$proxies);
			file_put_contents($this->base."bin/hideme_proxy_export.csv",$proxylist);
		}
		
		private function getProxies(){
			$proxies = file_get_contents($this->base."bin/hideme_proxy_export.csv");
			$lines = explode(PHP_EOL,$proxies);
			if(count($lines)<3){
				$this->downloadProxies();
				return $this->getProxies();
			}
			foreach($lines as $line){
				$bits = explode(";",$line);
				$tmp['ip'] = $bits[1];
				$tmp['port'] = $bits[2];
				$tmp['delay'] = $bits[4];
				array_push($this->proxies, $tmp);
			}
			
			//array_shift($this->proxies);
			usort($this->proxies,function($a,$b){
				return ((int)$a['delay']<=(int)$b['delay'])?1:0;
			});
		}
		
		public function getProxy(){
			$proxy = array_pop($this->proxies);
			
			$this->updateProxies();
			return $proxy;
		}
		
		private function updateProxies(){
			$file_string = "";
			foreach($this->proxies as $proxy){
				$line = ";".$proxy['ip'].";".$proxy['port'].";;".$proxy['delay'].PHP_EOL;
				$file_string .= $line;
			}
			file_put_contents("hideme_proxy_export.csv",rtrim($file_string,PHP_EOL));
		}
		
		private function setUsedProxies($used_proxy_file){
			$file_data = file_get_contents($used_proxy_file);
			$lines = explode(PHP_EOL,$file_data);
			$this->used_proxies = array();
			foreach($lines as $line){
				$data =  explode(",",$line);
				$tmp['ip'] = $data[0];
				$tmp['port'] = $data[1];
				$tmp['used'] = $data[2];
				$proxy = $tmp['ip'].":".$tmp['port'];
				$this->used_proxies[$proxy] = $tmp;
			}
		}		
	}
?>