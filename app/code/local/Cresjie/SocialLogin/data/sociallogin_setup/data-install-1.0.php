<?php

$this->setConfigData('sociallogin/facebook/redirect_uri',Mage::getUrl('cresjie/sociallogin',array('service' => 'facebook') ) );
$this->setConfigData('sociallogin/google/redirect_uri', Mage::getUrl('cresjie/sociallogin',array('service' => 'google') ) );

Mage::app()->getCacheInstance()->invalidateType('config');


