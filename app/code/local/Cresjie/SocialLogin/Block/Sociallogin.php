<?php

class Cresjie_SocialLogin_Block_SocialLogin extends Mage_Core_Block_Template{
	

	public function getImageSrc(){
		
		$size = $this->getData('size');
		$size = $size ? $size : 'medium';

		$color = $this->getData('color');
			$color = $color ? "-$color" : '';
		return  Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN). 'frontend/base/default/images/sociallogin/'.$this->getData('service') . "/btn-{$size}{$color}.png";
	}

	public function getSocialLoginUrl(){
		return Mage::getUrl('cresjie/sociallogin',array('service' => $this->getData('service') ) );
	}
}