<?php

namespace Ups\Entity;

use LogicException;

class ItemizedPaymentInformation
{

    const TYPE_Shipper_Paid = 'Shipper';
    const TYPE_CONSIGNEE_Paid = 'Consingee';
    const TYPE_ThirdParty_Paid = 'ThirdParty';

    /**
     * @var Prepaid
     */
    private $sprepaid;
    private $tprepaid;

    /**
     * @var BillThirdParty
     */
    private $sbillThirdParty;
    private $tbillThirdParty;
    /**
     * @var FreightCollect
     */
    private $sfreightCollect;
    private $tfreightCollect;

    /**
     * @var bool
     */

    public function __construct($stype = self::TYPE_Shipper_Paid, $sattributes = null,$ttype = self::TYPE_Shipper_Paid,$tattributes = null)
    {
        switch ($stype) {
            case self::TYPE_Shipper_Paid:
                $this->sprepaid = new Prepaid($sattributes);
                break;
            case self::TYPE_ThirdParty_Paid:
                $this->sbillThirdParty = new BillThirdParty($sattributes);
                break;
            case self::TYPE_CONSIGNEE_Paid:
                $this->sfreightCollect = new FreightCollect($sattributes);
                break;
            default:
                throw new LogicException(sprintf('Unknown PaymentInformation type requested: "%s"', $type));
        }

        switch ($ttype) {
            case self::TYPE_Shipper_Paid:
                $this->tprepaid = new Prepaid($tattributes);
                break;
            case self::TYPE_ThirdParty_Paid:
                $this->tbillThirdParty = new BillThirdParty($tattributes);
                break;
            case self::TYPE_CONSIGNEE_Paid:
                $this->tfreightCollect = new FreightCollect($tattributes);
                break;
            default:
                throw new LogicException(sprintf('Unknown PaymentInformation type requested: "%s"', $type));
        }
    }

    /**
     * @return Prepaid
     */
    public function getSprepaid()
    {
        return $this->sprepaid;
    }

    /**
     * @param Prepaid $prepaid
     * @return PaymentInformation
     */
    public function setSprepaid(Prepaid $prepaid = null)
    {
        $this->sprepaid = $prepaid;

        return $this;
    }

    public function getTprepaid()
    {
        return $this->tprepaid;
    }

    /**
     * @param Prepaid $prepaid
     * @return PaymentInformation
     */
    public function setTprepaid(Prepaid $prepaid = null)
    {
        $this->tprepaid = $prepaid;

        return $this;
    }

    /**
     * @return BillThirdParty
     */
    public function getSbillThirdParty()
    {
        return $this->sbillThirdParty;
    }

    /**
     * @param BillThirdParty $billThirdParty
     * @return PaymentInformation
     */
    public function setSbillThirdParty(BillThirdParty $billThirdParty = null)
    {
        $this->sbillThirdParty = $billThirdParty;

        return $this;
    }

    public function getTbillThirdParty()
    {
        return $this->tbillThirdParty;
    }

    /**
     * @param BillThirdParty $billThirdParty
     * @return PaymentInformation
     */
    public function setTbillThirdParty(BillThirdParty $billThirdParty = null)
    {
        $this->tbillThirdParty = $billThirdParty;

        return $this;
    }

    /**
     * @return FreightCollect
     */
    public function getTfreightCollect()
    {
        return $this->tfreightCollect;
    }

    /**
     * @param FreightCollect $freightCollect
     * @return PaymentInformation
     */
    public function setTfreightCollect(FreightCollect $freightCollect = null)
    {
        $this->tfreightCollect = $freightCollect;

        return $this;
    }

    public function getSfreightCollect()
    {
        return $this->sfreightCollect;
    }

    /**
     * @param FreightCollect $freightCollect
     * @return PaymentInformation
     */
    public function setSfreightCollect(FreightCollect $freightCollect = null)
    {
        $this->sfreightCollect = $freightCollect;

        return $this;
    }

    /**
     * @return bool
     */

}