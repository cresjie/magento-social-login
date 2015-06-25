<?php

class Cresjie_SocialLogin_Helper_Oauth2 extends Mage_Core_Helper_Abstract{
	
	protected $service_name, 
	 		$login_url ,
			$access_token_url,
			$endpoint ,
			
			$service_data,

			//optional
			$scope = [],
			$scope_separator = " ",
			$access_token_method = "post",
			$access_token_extra_curl = [],
			$endpoint_extra_curl = [],
			$endpoint_method = "get";


	public function setState($value){
		Mage::getSingleton('core/session')->setSocialLoginSession($value);
		return $this;
	}

	public function getState(){
		return Mage::getSingleton('core/session')->getSocialLoginSession();
	}
	public function loginUrl(){

		$state = Mage::helper('core')->getRandomString(10);
		$this->setState( $state );

		$param = http_build_query([
			'client_id' => Mage::getStoreConfig('sociallogin/'.$this->service_name.'/client_id',Mage::app()->getStore()), //Mage::getStoreConfig('sociallogin/google/client_id',Mage::app()->getStore())
			'response_type' => 'code',
			'scope' => implode($this->scope, $this->scope_separator),
			'redirect_uri' =>  Mage::getStoreConfig('sociallogin/'.$this->service_name.'/redirect_uri',Mage::app()->getStore()),
			'state' => $state
		]);
		
		
		return $this->login_url . '?' . $param;
	}

	public function authenticate( $code ){

		$params = [
			'client_id' => Mage::getStoreConfig('sociallogin/'.$this->service_name.'/client_id',Mage::app()->getStore()),
			'client_secret' => Mage::getStoreConfig('sociallogin/'.$this->service_name.'/client_secret',Mage::app()->getStore()),
			'redirect_uri' =>  Mage::getStoreConfig('sociallogin/'.$this->service_name.'/redirect_uri',Mage::app()->getStore()),
			'code' => $code,
			'grant_type' => 'authorization_code'
		];


		//exchange code for access_token
		$result = Mage::helper('sociallogin')->sendRequest( $this->access_token_url, $params, $this->access_token_method);

		//exchange access_token for user data
		$result = Mage::helper('sociallogin')->sendRequest( $this->endpoint,[
				'access_token' => $result['access_token'],
				'alt' => 'json' // for json response
		],	$this->endpoint_method);

		$this->service_data = $result;

		return $this;

	}

	public function getData(){
		return $this->service_data;
	}

	public function getEmail(){
		return $this->service_data['email'];
	}

	public function getFirstName(){
		return $this->service_data['first_name'];
	}

	public function getLastName(){
		return $this->service_data['last_name'];
	}
}