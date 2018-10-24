<?php

class ExchangeRateTest extends PHPUnit\Framework\TestCase
{
    private $underTest;

    public function setUp()
    {
        $this->underTest = new Icetee\MNB\ExchangeRate();

        $this->rate_entity = (new Icetee\MNB\RateEntity())
          ->setDate('2018-10-24')
          ->setUnit('1')
          ->setValue('323,00000')
          ->setCurrency('EUR');
    }

    /**
     * @test
     */
    public function it_should_return_rate_entity()
    {
        $actualCurrency = $this->underTest->getCurrentExchangeRate();

        $this->assertInstanceOf(Icetee\MNB\RateEntity::class, $actualCurrency);
    }

    /**
     * @test
     */
    public function it_should_return_rate_entity_collection()
    {
        $actualCurrency = $this->underTest->getCurrentExchangeRates();

        $this->assertInstanceOf(Icetee\MNB\RateEntityCollection::class, $actualCurrency);
    }

    /**
     * @test
     */
    public function it_should_return_numbers()
    {
        $this->assertInternalType('float', $this->rate_entity->getValue());
        $this->assertInternalType('int', $this->rate_entity->getUnit());
    }
}
