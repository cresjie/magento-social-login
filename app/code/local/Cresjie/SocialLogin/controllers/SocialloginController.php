<?php

class Cresjie_SocialLogin_SocialLoginController extends Mage_Core_Controller_Front_Action{
	
	public function indexAction(){
		$serviceName = $this->getRequest()->getParam('service');
	 	
	 	
	 	
	 	$this->_redirectUrl( Mage::helper('sociallogin/'. $serviceName)->loginUrl() );

	 	//echo Mage::getUrl('cresjie/sociallogin/',['service' => 'facebook']);
	}

		
	public function callbackAction(){
		
		$serviceName = $this->getRequest()->getParam('service');
		
		if( $service ){

			if( $_GET['code'] ){

				//compares session state token to state token parameter
				if( Mage::helper('sociallogin/oauth2')->getState() != $_GET['state'] ){

					//@var sample: Cresjie_SocialLogin_Helper_Google
					$response = Mage::helper('sociallogin/'.$serviceName)->authenticate( $_GET['code'] ); 

					$customer = Mage::getModel('customer/customer')
								->setWebsiteId( Mage::app()->getWebsite()->getId() )
								->loadByEmail( $response->getEmail() );

					//checks if the customer already exists in the database
					if( $customer->getId() ){

						$this->loginCustomer( $customer );

					}else{

						$customer = Mage::getModel('customer/customer');
						$customer->setWebsiteId( Mage::app()->getWebsite()->getId() )
								->setStore( Mage::app()->getStore() )
								->setFirstName( $response->getFirstName() )
								->setLastName( $response->getLastName() )
								->setEmail( $response->getEmail() );
						try{
							$customer->save();

							//automatically confirms customer account
							$customer->setConfirmation(null);
							$customer->setStatus(1);
							$customer->save();

						}
						catch (Exception $e){
							 Zend_Debug::dump($e->getMessage());
						}

						//login the customer after saving
						$this->loginCustomer( $customer );
					}


					
				}

				throw new Exception('state token mismatch');

			}elseif( $_GET['error'] )
				throw new Exception( $_GET['error_message']);
				

			
		}
			throw new Exception('Service parameter is required');

	}
	

	
	public function loginCustomer( $customer ){

		Mage::getSingleton('customer/session')->setCustomerAsLoggedIn( $customer );

		//redirects customer to dashboard after logging in
		$url = Mage::app()->getWebsite(Mage::app()->getWebsite()->getId())->getDefaultStore()->getBaseUrl() . 'customer/account/index';
		$this->_redirectUrl($url);

	}

	


	
	
	
}