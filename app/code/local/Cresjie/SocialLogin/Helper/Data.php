<?php

class Cresjie_SocialLogin_Helper_Data extends Mage_Core_Helper_Abstract{
	

	public  function sendRequest( $host,array $fields, $method = 'get', $extra_curl = []){
		$curl = curl_init();
		switch ( strtolower($method) ) {
			case 'get':
				
				$curl_params = [
					CURLOPT_URL => $host . '?' . http_build_query($fields),
					CURLOPT_RETURNTRANSFER => 1
				] + $extra_curl;
				curl_setopt_array($curl, $curl_params);
				break;
			
			case 'post':
				$curl_params = [
					CURLOPT_POST =>true,
					CURLOPT_URL => $host,
					CURLOPT_HTTPAUTH => CURLAUTH_ANY,
					CURLOPT_SSL_VERIFYPEER => false,
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_HEADER => false,
					CURLOPT_POSTFIELDS => http_build_query($fields)
				] + $extra_curl;
				curl_setopt_array($curl, $curl_params);
				break;
		}
		$result = curl_exec($curl);
		if( !$result){
			
			throw new \Exception( curl_errno($curl) ); 
		}
		$json = json_decode($result,true);
		if($json)
			$output = $json;
		else
			parse_str($result,$output); // if the result is not a valid json, it might be a string to be parsed
		if( isset($output['error']) ){
			//throw new \Exception( $output['error_message']);
			var_dump($output);exit();
		}
		return $output;
	} // /sendRequest
}