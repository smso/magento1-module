<?php
/**
 * @category   Smso
 * @package    Ovesenterprise_Smso
 * @copyright  Copyright (c) 2020 Smso (https://www.smso.ro/)
 * @author     Lilian Codreanu <lilian.codreanu@ovesenterprise.com>
 */

class Ovesenterprise_Smso_Model_Config
{

    const SERVICE_API_URI = 'https://app.smso.ro/api/v1/';

    const XML_PATH_SMSO_GENERAL_ENABLE = 'smso/general/enable';

    const XML_PATH_SMSO_GENERAL_SECRET_KEY = 'smso/general/secret_key';

    const XML_PATH_SMSO_GENERAL_SENDER = 'smso/general/sender';

    const XML_PATH_SMSO_NEW_ORDER_ENABLE = 'smso/new_order/enable';
    const XML_PATH_SMSO_NEW_ORDER_MESSAGE = 'smso/new_order/message';

    const XML_PATH_SMSO_SHIPPED_ENABLE = 'smso/shipped_order/enable';
    const XML_PATH_SMSO_SHIPPED_MESSAGE = 'smso/shipped_order/message';

    const XML_PATH_SMSO_PAID_ENABLE = 'smso/paid_order/enable';
    const XML_PATH_SMSO_PAID_MESSAGE = 'smso/paid_order/message';

    const XML_PATH_SMSO_COMPLETE_ENABLE = 'smso/complete_order/enable';
    const XML_PATH_SMSO_COMPLETE_MESSAGE = 'smso/complete_order/message';

    const XML_PATH_SMSO_CANCEL_ENABLE = 'smso/cancel_order/enable';
    const XML_PATH_SMSO_CANCEL_MESSAGE = 'smso/cancel_order/message';

    const XML_PATH_SMSO_REFUND_ENABLE = 'smso/refund_order/enable';
    const XML_PATH_SMSO_REFUND_MESSAGE = 'smso/refund_order/message';

    /**
     * Get store config
     *
     * @param string $path
     *
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    protected function getStoreConfig($path)
    {
        return Mage::getStoreConfig($path, Mage::app()->getStore());
    }

    /**
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function isEnable()
    {
        return $this->getStoreConfig(self::XML_PATH_SMSO_GENERAL_ENABLE);
    }

    /**
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getSecretKey()
    {
        return  Mage::helper('core')->decrypt(
            $this->getStoreConfig(self::XML_PATH_SMSO_GENERAL_SECRET_KEY)
        );
    }

    /**
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getSender()
    {
        return $this->getStoreConfig(self::XML_PATH_SMSO_GENERAL_SENDER);
    }

    /**
     * @return string
     */
    public function getSenderApiUri()
    {
        return self::SERVICE_API_URI . 'senders';
    }

    /**
     * @return string
     */
    public function getSendMessageApiUri()
    {
        return self::SERVICE_API_URI . 'send';
    }

    /**
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function isNewOrderMessageEnable()
    {
        return $this->getStoreConfig(self::XML_PATH_SMSO_NEW_ORDER_ENABLE);

    }

    /**
     * @param Mage_Sales_Model_Order $order
     *
     * @return string|string[]
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getNewOrderMessage(Mage_Sales_Model_Order $order)
    {
        $message = str_replace(
            '{{order_number}}',
            $order->getIncrementId(),
            $this->getStoreConfig(self::XML_PATH_SMSO_NEW_ORDER_MESSAGE)
        );

        if (empty($message)) {
            $message = 'Order was placed!';
        }

        return $message;
    }


    /**
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function isShippedMessageEnable()
    {
        return $this->getStoreConfig(self::XML_PATH_SMSO_SHIPPED_ENABLE);

    }
    /**
     * @param Mage_Sales_Model_Order $order
     *
     * @return string|string[]
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getShippedMessage(Mage_Sales_Model_Order $order)
    {
        $message = str_replace(
            '{{order_number}}',
            $order->getIncrementId(),
            $this->getStoreConfig(self::XML_PATH_SMSO_SHIPPED_MESSAGE)
        );

        if (empty($message)) {
            $message = 'Order was shipped!';
        }

        return $message;
    }

    /**
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function isPaidMessageEnable()
    {
        return $this->getStoreConfig(self::XML_PATH_SMSO_PAID_ENABLE);

    }
    /**
     * @param Mage_Sales_Model_Order $order
     *
     * @return string|string[]
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getPaidMessage(Mage_Sales_Model_Order $order)
    {
        $message = str_replace(
            '{{order_number}}',
            $order->getIncrementId(),
            $this->getStoreConfig(self::XML_PATH_SMSO_PAID_MESSAGE)
        );

        if (empty($message)) {
            $message = 'Order was paid!';
        }

        return $message;
    }

    /**
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function isCompleteOrderMessageEnable()
    {
        return $this->getStoreConfig(self::XML_PATH_SMSO_COMPLETE_ENABLE);
    }
    /**
     * @param Mage_Sales_Model_Order $order
     *
     * @return string|string[]
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getCompleteOrderMessage(Mage_Sales_Model_Order $order)
    {
        $message = str_replace(
            '{{order_number}}',
            $order->getIncrementId(),
            $this->getStoreConfig(self::XML_PATH_SMSO_COMPLETE_MESSAGE)
        );

        if (empty($message)) {
            $message = 'Order was completed!';
        }

        return $message;
    }

    /**
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function isCancelOrderMessageEnable()
    {
        return $this->getStoreConfig(self::XML_PATH_SMSO_CANCEL_ENABLE);

    }
    /**
     * @param Mage_Sales_Model_Order $order
     *
     * @return string|string[]
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getCancelOrderMessage(Mage_Sales_Model_Order $order)
    {
        $message = str_replace(
            '{{order_number}}',
            $order->getIncrementId(),
            $this->getStoreConfig(self::XML_PATH_SMSO_CANCEL_MESSAGE)
        );

        if (empty($message)) {
            $message = 'Order was canceled!';
        }

        return $message;
    }

    /**
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function isRefundOrderMessageEnable()
    {
        return $this->getStoreConfig(self::XML_PATH_SMSO_REFUND_ENABLE);

    }
    /**
     * @param Mage_Sales_Model_Order $order
     *
     * @return string|string[]
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getRefundOrderMessage(Mage_Sales_Model_Order $order)
    {
        $message = str_replace(
            '{{order_number}}',
            $order->getIncrementId(),
            $this->getStoreConfig(self::XML_PATH_SMSO_REFUND_MESSAGE)
        );

        if (empty($message)) {
            $message = 'Order was refunded!';
        }

        return $message;
    }
}