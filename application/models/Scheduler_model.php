<?php
class Scheduler_model extends CI_Model {

	public function __construct(){
	
	}
	
	public function getDataFromDHIS($username, $password, $url){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
		$result = curl_exec ($ch);
			
		if(!curl_errno($ch)){
			$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		}
			
		curl_close ($ch);
		$data = json_decode($result, true);
		return $data;
	}
	
	public function sendDataToDHIS($json){
		$url = $this->config->item('dhis_url') . 'events';
		$username = $this->config->item('dhis_username');
		$password = $this->config->item('dhis_password');
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($json))                                                                       
		);
		curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
		
		$result = curl_exec ($ch);
			
		if(!curl_errno($ch)){
			$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		}
			
		curl_close ($ch);
		$data = json_decode($result, true);
		return $data;
	}
	
	public function updateDataToDHIS($trackedEntityInstance, $json){
		$url = $this->config->item('dhis_url') . 'trackedEntityInstances/'.$trackedEntityInstance;
		//die($json);
		$username = $this->config->item('dhis_username');
		$password = $this->config->item('dhis_password');
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($json))                                                                       
		);
		curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
		
		$result = curl_exec ($ch);
			
		if(!curl_errno($ch)){
			$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		}
			
		curl_close ($ch);
		$data = json_decode($result, true);
		return $data;
	}
	
	public function getLastLog($select = null, $from, $joins = null, $where = null, $orderby = null){
		if($select == null){
			$select = '*';
		}
		$this->db->select($select);
		$this->db->from($from);
		if($joins != null){
			foreach($joins as $join){
				$this->db->join($join[0],$join[1],$join[2]);
			}
		}
		if($where != null){
			$this->db->where($where);	
		}
		if($orderby != null){
			$this->db->order_by($orderby[0],$orderby[1]);	
		}
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function add($tablename,$data){
		if($this->db->insert($tablename, $data)){
			return true;
		}else{
			return false;
		}
	}
}