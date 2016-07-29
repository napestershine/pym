<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BlogBundle\Model\Orders as BasePaymentDetails;

/**
 * Orders
 */
class Orders extends BasePaymentDetails
{
    /**
     * @var integer
     */
    protected $id;

    private $number;

    private $description;

    private $client_email;

    private $client_id;

    private $total_amount;

    private $currency_code;

    protected $details;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return Orders
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Orders
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set client_email
     *
     * @param string $clientEmail
     * @return Orders
     */
    public function setClientEmail($clientEmail)
    {
        $this->client_email = $clientEmail;

        return $this;
    }

    /**
     * Get client_email
     *
     * @return string
     */
    public function getClientEmail()
    {
        return $this->client_email;
    }

    /**
     * Set client_id
     *
     * @param string $clientId
     * @return Orders
     */
    public function setClientId($clientId)
    {
        $this->client_id = $clientId;

        return $this;
    }

    /**
     * Get client_id
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * Set total_amount
     *
     * @param float $totalAmount
     * @return Orders
     */
    public function setTotalAmount($totalAmount)
    {

        $this->total_amount = $totalAmount;
        return $this;
    }

    /**
     * Get total_amount
     *
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->total_amount;
    }

    /**
     * Set currency_code
     *
     * @param string $currencyCode
     * @return Orders
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currency_code = $currencyCode;

        return $this;
    }

    /**
     * Get currency_code
     *
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currency_code;
    }

    /**
     * Set details
     *
     * @param string $details
     * @return Orders
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }
}