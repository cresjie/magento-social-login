<?php

class Cresjie_SocialLogin_IndexController extends Mage_Core_Controller_Front_Action{
	
	public function indexAction(){
		echo 'hello-';
		echo Mage::getStoreConfig('sociallogin/facebook/client_id',Mage::app()->getStore());
	}

	public function testAction(){
		echo 'here in test'; 
	}
}