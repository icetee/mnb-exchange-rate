<?php

namespace Icetee\MNB;

class ExchangeRate extends ExchangeRateAbstract implements ExchangeRateInterface
{
    public function __construct()
    {
        //
    }

    public function getCurrentExchangeRate($currency = 'EUR') : RateEntity
    {
        return $this->getCurrentExchangeRates()->findEntityByCurrency($currency);
    }

    public function getCurrentExchangeRates() : RateEntityCollection
    {
        $doc = $this->getDocument('GetCurrentExchangeRates');

        $node = $doc->getElementsByTagName('Day')->item(0);

        $date = $node->getAttribute('date');

        $rate_entity_collection = new RateEntityCollection();
        foreach ($node->childNodes as $childNode) {
            $rate_entity = (new RateEntity())
              ->setValue($childNode->nodeValue)
              ->setUnit($childNode->getAttribute('unit'))
              ->setDate($date)
              ->setCurrency($childNode->getAttribute('curr'));

            $rate_entity_collection->addEntity($rate_entity);
        }

        return $rate_entity_collection;
    }

    public function getCurrencies()
    {
        $doc = $this->getDocument('GetCurrencies');
        $node = $doc->getElementsByTagName('Currencies')->item(0);

        $currencies = [];
        foreach ($node->childNodes as $childNode) {
            $currencies[] = $childNode->nodeValue;
        }

        return $currencies;
    }

    public function getCurrencyUnits($currencyNames = null)
    {
        $doc = $this->getDocument('GetCurrencyUnits', [
          'parameters' => [
            'currencyNames' => $currencyNames
          ]
        ]);

        $node = $doc->getElementsByTagName('Units')->item(0);

        $units = [];
        foreach ($node->childNodes as $childNode) {
            $units[$childNode->getAttribute('curr')] = (int)$childNode->nodeValue;
        }

        return $units;
    }

    public function getDateInterval()
    {
        $doc = $this->getDocument('GetDateInterval');
        $node = $doc->getElementsByTagName('DateInterval')->item(0);

        return (object)[
            'startdate' => $node->getAttribute('startdate'),
            'enddate' => $node->getAttribute('enddate'),
        ];
    }

    public function getExchangeRates($startDate = null, $endDate = null, $currencyNames = null)
    {
        $doc = $this->getDocument('GetExchangeRates', [
          'parameters' => [
             'startDate' => $startDate,
             'endDate' => $endDate,
             'currencyNames' => $currencyNames
          ]
        ]);

        $node = $doc->getElementsByTagName('Day');

        if (is_null($startDate) && is_null($endDate) && is_null($currencyNames)) {
            $days = [];
            for ($i = 0; $i < $node->length; $i++) {
                $days[] = $node->item($i)->getAttribute('date');
            }

            return $days;
        }

        $rate_entity_collection = new RateEntityCollection();
        for ($i = 0; $i < $node->length; $i++) {
            $day_node = $node->item($i);

            for ($r = 0; $r < $node->length; $r++) {
                $rate_node = $day_node->childNodes->item($r);

                if ($rate_node instanceof \DOMElement) {
                    $rate_entity = (new RateEntity())
                      ->setValue($rate_node->nodeValue)
                      ->setUnit($rate_node->getAttribute('unit'))
                      ->setDate($day_node->getAttribute('date'))
                      ->setCurrency($rate_node->getAttribute('curr'));

                    $rate_entity_collection->addEntity($rate_entity);
                }
            }
        }

        return $rate_entity_collection;
    }

    public function getInfo()
    {
        $doc = $this->getDocument('GetInfo');

        $node = $doc->getElementsByTagName('MNBExchangeRatesQueryValues')->item(0);
        $currencies_node = $doc->getElementsByTagName('Currencies')->item(0);

        $currencies = [];
        foreach ($currencies_node->childNodes as $childNode) {
            $currencies[] = $childNode->nodeValue;
        }

        return (object)[
            'firstdate' => $node->getElementsByTagName('FirstDate')->item(0)->nodeValue,
            'lastdate' => $node->getElementsByTagName('LastDate')->item(0)->nodeValue,
            'currencies' => $currencies,
        ];
    }

    private function getDocument($name, array $parameter = [])
    {
        $client = new \SoapClient(self::MNB_SOAP_URL);
        $response = $client->__soapCall($name, $parameter);

        $doc = new \DOMDocument;
        $doc->loadXML($response->{$name . 'Result'});

        return $doc;
    }
}
