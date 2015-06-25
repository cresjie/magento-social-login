<?php
//Cresjie_SocialLogin_Helper_OAuth2
class Cresjie_SocialLogin_Helper_Google extends Cresjie_SocialLogin_Helper_Oauth2{
	
	
	protected $service_name = "google",
			$login_url = "https://accounts.google.com/o/oauth2/auth",
			$access_token_url = "https://www.googleapis.com/oauth2/v3/token", //"https://accounts.google.com/o/oauth2/token",
			$endpoint = "https://www.googleapis.com/oauth2/v3/userinfo",//"https://www.googleapis.com/oauth2/v2/userinfo",
			$scope = ['openid','email'];
		

	public function getFirstName(){
		return $this->service_data['given_name'];
	}

	public function getLastName(){
		return $this->service_data['family_name'];
	}
	
	
	
}