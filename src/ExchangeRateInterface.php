<?php

namespace Icetee\MNB;

interface ExchangeRateInterface
{
    public function getCurrentExchangeRate($currency = 'EUR') : RateEntity;
    public function getCurrentExchangeRates() : RateEntityCollection;
    public function getCurrencies();
    public function getCurrencyUnits($currencyNames = null);
    public function getDateInterval();
    public function getExchangeRates($startDate = null, $endDate = null, $currencyNames = null);
    public function getInfo() : Object;
}
