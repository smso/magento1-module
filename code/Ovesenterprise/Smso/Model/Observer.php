<?php
/**
 * @category   Smso
 * @package    Ovesenterprise_Smso
 * @copyright  Copyright (c) 2020 Smso (https://www.smso.ro/)
 */

class Ovesenterprise_Smso_Model_Observer
{

    /** @var  Ovesenterprise_Smso_Model_Config */
    protected $_config;

    /**
     * Ovesenterprise_Smso_Model_Observer constructor.
     */
    public function __construct()
    {
        $this->_config = Mage::getModel('smso/config');
    }

    /**
     * @param Varien_Event_Observer $observer
     *
     * @return bool
     * @throws Mage_Core_Model_Store_Exception
     */
    public function notifyPlaceOrderAfter(Varien_Event_Observer $observer)
    {
        /** @var string $originMessage */
        $originMessage = trim($this->_config->getNewOrderMessage());
        try {
            // Skip if not enable.
            if (!$this->_config->isNewOrderMessageEnable() || empty($originMessage)){
                return false;
            }

            /** @var Mage_Sales_Model_Order $order */
            $order = $observer->getOrder();

            /** @var  Zend_Http_Response $response */
            $response = Mage::getModel('smso/service_smso')
                ->sendMessage(
                    $this->_getTelephoneByOrder($order),
                    $this->_processMessage($order, $originMessage)
                );

            if ($response->getStatus() !== 200) {
                Mage::throwException('SMS does not sent!');
            }
        }catch (\Exception $e){
            Mage::logException($e);
        }
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function notifyPayOrderAfter(Varien_Event_Observer $observer)
    {
        try {
            /** @var string $originMessage */
            $originMessage = trim($this->_config->getPaidMessage());

            // Skip if not enable.
            if (!$this->_config->isPaidMessageEnable()|| empty($originMessage)){
                return ;
            }

            $order = $observer->getInvoice()->getOrder();

            /** @var  Zend_Http_Response $response */
            $response = Mage::getModel('smso/service_smso')
                ->sendMessage(
                    $this->_getTelephoneByOrder($order),
                    $this->_processMessage($order, $originMessage)
                );

            if ($response->getStatus() !== 200) {
                Mage::throwException('SMS does not sent!');
            }
        }catch (\Exception $e) {
            Mage::logException($e);
        }
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function notifyShippedOrderBefore(Varien_Event_Observer $observer)
    {
        $shipment = $observer->getEvent()->getShipment();
        if (!$shipment->getId()) {
            // Mark this shipment as new
            $shipment->setIsNew(true);
        }
    }

    /**
     * @param Varien_Event_Observer $observer
     *
     * @throws Mage_Core_Model_Store_Exception
     */
    public function notifyShippedOrderAfter(Varien_Event_Observer $observer)
    {
        $shipment = $observer->getShipment();
        $order = $shipment->getOrder();

        /** @var string $originMessage */
        $originMessage = trim($this->_config->getShippedMessage());

        if ($shipment->getIsNew() === true) {
            try {
                // Skip if not enable.
                if (!$this->_config->isShippedMessageEnable()  || empty($originMessage)){
                    return ;
                }

                /** @var  Zend_Http_Response $response */
                $response = Mage::getModel('smso/service_smso')
                    ->sendMessage(
                        $this->_getTelephoneByOrder($order),
                        $this->_processMessage($order, $originMessage)
                    );

                if ($response->getStatus() !== 200) {
                    Mage::throwException('SMS does not sent!');
                }
            }catch (\Exception $e) {
                Mage::logException($e);
            }
        }
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function notifyCommitOrderAfter(Varien_Event_Observer $observer)
    {
        /** @var Mage_Sales_Model_Order $order */
        $order = $observer->getOrder();

        // Check if the order is canceled
        if($order->getState() === Mage_Sales_Model_Order::STATE_CANCELED ){
            try {
                /** @var string $originMessage */
                $originMessage = trim($this->_config->getCancelOrderMessage());

                // Skip if not enable.
                if (!$this->_config->isCancelOrderMessageEnable() || empty($originMessage)){
                    return ;
                }

                /** @var  Zend_Http_Response $response */
                $response = Mage::getModel('smso/service_smso')
                    ->sendMessage(
                        $this->_getTelephoneByOrder($order),
                        $this->_processMessage($order, $originMessage)
                    );

                if ($response->getStatus() !== 200) {
                    Mage::throwException('SMS does not sent!');
                }
            }catch (\Exception $e) {
                Mage::logException($e);
            }
        }

        // Check if order is Complete
        if($order->getState() === Mage_Sales_Model_Order::STATE_COMPLETE){
            try {
                /** @var string $originMessage */
                $originMessage = trim($this->_config->getCompleteOrderMessage());

                // Skip if not enable.
                if (!$this->_config->isCompleteOrderMessageEnable() || empty($originMessage)){
                    return ;
                }

                /** @var  Zend_Http_Response $response */
                $response = Mage::getModel('smso/service_smso')
                    ->sendMessage(
                        $this->_getTelephoneByOrder($order),
                        $this->_processMessage($order, $originMessage)
                    );

                if ($response->getStatus() !== 200) {
                    Mage::throwException('SMS does not sent!');
                }
            }catch (\Exception $e) {
                Mage::logException($e);
            }
        }
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function notifyRefundOrderAfter(Varien_Event_Observer $observer)
    {
        $order = $observer->getCreditmemo()->getOrder();
        $telephone = $order->getBillingAddress()->getTelephone();

        try {
            /** @var string $originMessage */
            $originMessage = trim($this->_config->getRefundOrderMessage());

            // Skip if not enable.
            if (!$this->_config->isRefundOrderMessageEnable() || empty($originMessage)){
                return ;
            }

            /** @var  Zend_Http_Response $response */
            $response = Mage::getModel('smso/service_smso')
                ->sendMessage(
                    $this->_getTelephoneByOrder($order),
                    $this->_processMessage($order, $originMessage)
                );

            if ($response->getStatus() !== 200) {
                Mage::throwException('SMS does not sent!');
            }
        }catch (\Exception $e) {
            Mage::logException($e);
        }
    }

    /**
     * @param Mage_Sales_Model_Order $order
     * @param                        $message
     *
     * @return string|string[]
     * @throws Mage_Core_Model_Store_Exception
     */
    private function _processMessage(Mage_Sales_Model_Order $order, $message)
    {
        return str_replace(
            array(
                '%name%',
                '%order_number%',
                '%total%'
            ),
            array(
                $order->getBillingAddress()->getName(),
                $order->getIncrementId(),
                $order->getGrandTotal()
            ),
            $message
        );
    }

    /**
     * @param Mage_Sales_Model_Order $order
     *
     * @return string
     */
    private function _getTelephoneByOrder(Mage_Sales_Model_Order $order)
    {
        return $order->getBillingAddress()->getTelephone();
    }
}