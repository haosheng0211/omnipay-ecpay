<?php

namespace Omnipay\ECPay\Message;

use Exception;

class CompletePurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        try {
            $ecPay = $this->createECPay();
            $ecPay->CheckOutFeedback();

            return $this->getCode() === '1';
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Response Message.
     *
     * @return null|string A response message from the payment gateway
     */
    public function getMessage()
    {
        return $this->data['RtnMsg'];
    }

    /**
     * Response code.
     *
     * @return null|string A response code from the payment gateway
     */
    public function getCode()
    {
        return $this->data['RtnCode'];
    }

    /**
     * Gateway Reference.
     *
     * @return null|string A reference provided by the gateway to represent this transaction
     */
    public function getTransactionReference()
    {
        return $this->data['TradeNo'];
    }

    /**
     * Get the transaction ID as generated by the merchant website.
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->data['MerchantTradeNo'];
    }

    /**
     * Get the response data.
     *
     * @return array
     */
    public function getData()
    {
        $data = array_merge([], $this->data);
        unset($data['HashKey'], $data['HashIV'], $data['EncryptType']);

        return $data;
    }
}
