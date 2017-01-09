<?php

namespace Ups\Entity;

use DOMDocument;
use DOMElement;
use Ups\NodeInterface;

class AddressNew implements NodeInterface
{
    /** @deprecated */
    public $City;
    /** @deprecated */
    public $StateProvinceCode;
    /** @deprecated */
    public $PostalCode;
    /** @deprecated */
    public $CountryCode;


    /** @deprecated */
    private $city;

    /**
     * @var string
     */
    private $stateProvinceCode;

    /**
     * @var string
     */
    private $postalCode;

    /**
     * @var string
     */
    private $countryCode;


    /**
     * @param null|object $attributes
     */
    public function __construct($attributes = null)
    {
        if (null !== $attributes) {
            if (isset($attributes->City)) {
                $this->setCity($attributes->City);
            }
            if (isset($attributes->StateProvinceCode)) {
                $this->setStateProvinceCode($attributes->StateProvinceCode);
            }
            if (isset($attributes->PostalCode)) {
                $this->setPostalCode($attributes->PostalCode);
            }
            if (isset($attributes->CountryCode)) {
                $this->setCountryCode($attributes->CountryCode);
            }
        }
    }

    /**
     * @param null|DOMDocument $document
     *
     * @return DOMElement
     */
    public function toNode(DOMDocument $document = null)
    {
        if (null === $document) {
            $document = new DOMDocument();
        }

        $node = $document->createElement('Address');
        if ($this->getCity()) {
            $node->appendChild($document->createElement('City', $this->getCity()));
        }
        if ($this->getStateProvinceCode()) {
            $node->appendChild($document->createElement('StateProvinceCode', $this->getStateProvinceCode()));
        }
        if ($this->getPostalCode()) {
            $node->appendChild($document->createElement('PostalCode', $this->getPostalCode()));
        }
        if ($this->getCountryCode()) {
            $node->appendChild($document->createElement('CountryCode', $this->getCountryCode()));
        }

        return $node;
    }


    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     *
     * @return $this
     */
    public function setCity($city)
    {
        $this->City = $city;
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     *
     * @return $this
     */
    public function setCountryCode($countryCode)
    {
        $this->CountryCode = $countryCode;
        $this->countryCode = $countryCode;

        return $this;
    }


    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     *
     * @return $this
     */
    public function setPostalCode($postalCode)
    {
        $this->PostalCode = $postalCode;
        $this->postalCode = $postalCode;

        return $this;
    }


    /**
     * @return string
     */
    public function getStateProvinceCode()
    {
        return $this->stateProvinceCode;
    }

    /**
     * @param string $stateProvinceCode
     *
     * @return $this
     */
    public function setStateProvinceCode($stateProvinceCode)
    {
        $this->StateProvinceCode = $stateProvinceCode;
        $this->stateProvinceCode = $stateProvinceCode;

        return $this;
    }
}