<?php

class Unicached_ShippingRate_StandardController extends Mage_Core_Controller_Front_Action {
	
	public function indexAction() {
		try {
			$request     = Mage::app()->getRequest();
			$uri         = $request->getServer('REQUEST_URI');
			$path        = str_replace($request->getOriginalPathInfo(), '', $uri);
			$pathEncoded = preg_replace(
				Mage::getStoreConfig('shipping/unicachedrate/uri_pattern'),
				Mage::getStoreConfig('shipping/unicachedrate/uri_replacement'),
				urldecode($path));
			$responseText= Mage::helper('unicache')->readCache($pathEncoded);
			if ($responseText == false) {
				$client = new Zend_Http_Client(Mage::getStoreConfig('shipping/unicachedrate/url').$path);
				$responseText = $client->request();
				$isEmpty  = ($responseText == '');
				if (!$isEmpty && Mage::helper('unicache')->hasCache($pathEncoded)) {
					Mage::helper('unicache')->deleteCache($pathEncoded);
				}
				Mage::helper('unicache')->writeCache(
					$pathEncoded,
					$responseText,
					Mage::getStoreConfig('shipping/unicachedrate/cache_timeout'));
			}
		} catch(Exception $e) {
			Mage::throwException($e->getMessage());
		}
		
		$response = Zend_Http_Response::fromString($responseText);
		$this->getResponse()->clearAllHeaders();
		foreach ($response->getHeaders() as $name => $value) {
			$this->getResponse()->setHeader($name, $value);
		}
		$this->getResponse()->setBody($response->getBody());
	}

}