<?php
/**
 * @category   Smso
 * @package    Ovesenterprise_Smso
 * @copyright  Copyright (c) 2020 Smso (https://www.smso.ro/)
 * @author     Lilian Codreanu <lilian.codreanu@ovesenterprise.com>
 */

class Ovesenterprise_Smso_Model_Service_Smso
{

    /**
     * @var Ovesenterprise_Smso_Model_Config
     */
    protected $_config;

    public function __construct()
    {
        $this->_config = Mage::getModel('smso/config');
    }

    /**
     * @return false|Ovesenterprise_Smso_Model_Config
     */
    public function getConfig()
    {
        if (!$this->_config) {
            $this->_config = Mage::getModel('smso/config');
        }
        return $this->_config;
    }

    /**
     * @return array|mixed
     */
    public function getSenderList()
    {
        try {
            $client = $this->_getClient();
            /** @var  Zend_Http_Response $response */
            $response = $client->setUri($this->getConfig()->getSenderApiUri())
                ->setMethod(Zend_Http_Client::GET)
                ->request();

            if ($response->getStatus() === 200) {
                return json_decode($response->getBody());
            }
        }catch (\Exception $e) {
            Mage::logException($e);
            return [];
        }
    }


    /**
     * @param $to
     * @param $message
     *
     * @return bool
     */
    public function sendMessage($to, $message)
    {
        try {
            $client = $this->_getClient();
            $response = $client->setUri($this->getConfig()->getSendMessageApiUri())
                ->setMethod(Zend_Http_Client::POST)
                ->setParameterPost(
                    [
                        'to'     => $to,
                        'body'   => $message,
                        'sender' => $this->getConfig()->getSender(),
                    ]
                )
                ->request();
            return $response;
//            if ($response->getStatus() === 200) {
//                return true;
//            }
        }catch (\Exception $e) {
            Mage::logException($e);
            return false;
        }

        return false;
    }


    /**
     * @return Zend_Http_Client
     * @throws Zend_Http_Client_Exception
     * @throws Mage_Core_Model_Store_Exception
     */
    protected function _getClient()
    {
        $client = new Zend_Http_Client();
        $client->setConfig($this->_getClientConfig());
        $client->setHeaders(
            [
                'X-Authorization' => $this->getConfig()->getSecretKey()
            ]
        );

        return $client;
    }

    /**
     * @return array
     */
    protected function _getClientConfig()
    {
        return [
            'adapter'     => $this->_getClientAdapterClass(),
            'curloptions' => [
                CURLOPT_FOLLOWLOCATION        => true,
                CURLOPT_DNS_USE_GLOBAL_CACHE => false,
                CURLOPT_DNS_CACHE_TIMEOUT    => 2
            ],
            'timeout'     => 30
        ];
    }

    /**
     * @return string
     */
    protected function _getClientAdapterClass()
    {
        return Zend_Http_Client_Adapter_Curl::class;
    }

}