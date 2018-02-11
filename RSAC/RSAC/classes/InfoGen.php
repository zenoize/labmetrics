<?php
	class InfoGen{
		private $names = array(); 
		function __construct($name_file){
			$name_data = file_get_contents(dirname(__DIR__)."/".$name_file);
			$name_lines = explode(PHP_EOL,$name_data);
			$male_names = array();
			$female_names = array();
			foreach($name_lines as $line){
				$line_split = explode(',',$line);
				if(!empty($line_split[0]))
					array_push($male_names,$line_split[0]);
				if(!empty($line_split[1]))
					array_push($female_names,$line_split[1]);
			}
			$this->names["male"]=$male_names;
			$this->names["female"]=$female_names;
		}
		
		public function generateName($length = 12,$special_chars = array("_"),$numbers = true,$sex = false){
			$tmp_name = "";
			while(strlen($tmp_name)<=$length){
				$tmp_name .= $this->getAName($sex);
				$special = $special_chars[rand(0,count($special_chars)-1)];
				$tmp_name .=(rand(0,1)==0)?$special:rand(0,99);
			}
			$tmp_name .= rand(0,500);
			$this->name = $tmp_name;
			$tmp_name = $this->trimName($tmp_name,$length);
			return $tmp_name;
		}
		
		public function getAge(){
			return rand(25,45);
		}
		
		private function getAName($sex = false){
			if($sex == false)
				$sex = (rand(0,2)==0)?"male":"female";
			$rand_number = rand(0,count($this->names[$sex])-1);
			return $this->names[$sex][$rand_number];
		}
		
		private function trimName($string,$length){
			return substr($string,0,$length);
		}
		
		public function generateEmail(){
			return str_replace("_",".",$this->name ."@gmail.com");
		}
		
		public function generatePassword($min = 5,$max=12){
			$chars = explode(",","a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,1,2,3,4,5,6,7,8,9");
			$charlen = rand($min,$max);
			$password = "";
			while(strlen($password)<$charlen){
				$password .=$chars[rand(0,count($chars)-1)];
			}
			return $password;
			
		}
	}
?>
