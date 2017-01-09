<?php

namespace Ups;

use DOMDocument;
use Exception;
use Psr\Log\LoggerInterface;
use SimpleXMLElement;
use stdClass;
use Ups\Entity\AddressNew;

/**
 * Address Validation API Wrapper.
 */
class AddressValidationNew extends Ups
{
    const ENDPOINT = '/AV';

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ResponseInterface
     *
     * @todo make private
     */
    public $response;
    /**
     * @var AddressNew
     */
    private $addressNew;

    /**
     * Request Options.
     */

    /**
     * @param string|null $accessKey UPS License Access Key
     * @param string|null $userId UPS User ID
     * @param string|null $password UPS User Password
     * @param bool $useIntegration Determine if we should use production or CIE URLs.
     * @param RequestInterface|null $request
     * @param LoggerInterface|null $logger PSR3 compatible logger (optional)
     */
    public function __construct(
        $accessKey = null,
        $userId = null,
        $password = null,
        $useIntegration = false,
        RequestInterface $request = null,
        LoggerInterface $logger = null
    )
    {
        if (null !== $request) {
            $this->setRequest($request);
        }
        parent::__construct($accessKey, $userId, $password, $useIntegration, $logger);
    }


    /* Get address suggestions from UPS.
    *
    * @param $address
    * @param int $requestOption
    * @param int $maxSuggestion
    *
    * @throws Exception
    *
    * @return stdClass|AddressValidationResponse
    */
    public function validate($addressNew)
    {
        $this->addressNew = $addressNew;
        $access = $this->createAccess();
        $request = $this->createRequest();

        $this->response = $this->getRequest()->request($access, $request, $this->compileEndpointUrl(self::ENDPOINT));
        $response = $this->response->getResponse();

        if (null === $response) {
            throw new Exception('Failure (0): Unknown error', 0);
        }

        if ($response instanceof SimpleXMLElement && $response->Response->ResponseStatusCode == 0) {
            throw new Exception(
                "Failure ({$response->Response->Error->ErrorSeverity}): {$response->Response->Error->ErrorDescription}",
                (int)$response->Response->Error->ErrorCode
            );
        }

        return json_decode(json_encode($response), TRUE);
    }

    /**
     * Create the AV request.
     *
     * @return string
     */
    private function createRequest()
    {
        $xml = new DOMDocument();
        $xml->formatOutput = true;

        $avRequest = $xml->appendChild($xml->createElement('AddressValidationRequest'));
        $avRequest->setAttribute('xml:lang', 'en-US');

        $request = $avRequest->appendChild($xml->createElement('Request'));

        $node = $xml->importNode($this->createTransactionNode(), true);
        $request->appendChild($node);

        $request->appendChild($xml->createElement('RequestAction', 'AV'));

        if (null !== $this->addressNew) {
            $addressNode = $avRequest->appendChild($xml->createElement('Address'));
            if ($this->addressNew->getCity()) {
                $addressNode->appendChild($xml->createElement('City', $this->addressNew->getCity()));
            }
            if ($this->addressNew->getCountryCode()) {
                $addressNode->appendChild($xml->createElement('CountryCode', $this->addressNew->getCountryCode()));
            }
            if ($this->addressNew->getStateProvinceCode()) {
                $addressNode->appendChild($xml->createElement('StateProvinceCode', $this->addressNew->getStateProvinceCode()));
            }

            if ($this->addressNew->getPostalCode()) {
                $addressNode->appendChild($xml->createElement('PostalCode', $this->addressNew->getPostalCode()));
            }

        }

        return $xml->saveXML();
    }

    /**
     * Format the response.
     *
     * @param SimpleXMLElement $response
     *
     * @return stdClass
     */
    private function formatResponse(SimpleXMLElement $response)
    {
        return $this->convertXmlObject($response->AddressKeyFormat);
    }

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        if (null === $this->request) {
            $this->request = new Request();
        }

        return $this->request;
    }

    /**
     * @param RequestInterface $request
     *
     * @return $this
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return $this
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;

        return $this;
    }
}
