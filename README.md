# MNB - Exchange Rate

### Load with composer

The simplest solution is to call the package when using a composer. This cli command, install the package.

    $ composer require icetee/mnb-exchange-rate

### Usage

**Create instance:**

    $exchange_rate = new \Icetee\MNB\ExchangeRate();

**Get current exchange entity by currency:**

    $rate_entity = $exchange_rate->getCurrentExchangeRate('USD');

The properties of `RateEntity`:

    object(Icetee\MNB\RateEntity)#40 (4) {
      ["date":protected]=>
      string(10) "2018-10-24"
      ["unit":protected]=>
      string(1) "1"
      ["value":protected]=>

      string(9) "282,91000"
      ["currency":protected]=>
      string(3) "USD"
    }

**Get all current exchange entities:**

    $rate_entity_collection = $exchange_rate->getExchangeRates();

The properties of `RateEntityCollection`:

    object(Icetee\MNB\RateEntityCollection)#4 (1) {
      ["collection":"Icetee\MNB\RateEntityCollection":private]=>
      array(34) {
        [0]=>
        object(Icetee\MNB\RateEntity)#9 (4) {
          ["date":protected]=>

          string(10) "2018-10-24"
          ["unit":protected]=>
          string(1) "1"
          ["value":protected]=>
          string(9) "200,36000"
          ["currency":protected]=>
          string(3) "AUD"
        }

        ...
      }
    }

**Get filtered exchange entities:**

    $rate_entity_collection = $exchange_rate->getExchangeRates('1992-11-11', '1992-11-13', 'USD,AUD');

**Get filtered units:**

    $units = $exchange_rate->getCurrencyUnits('USD,AUD');

### ExchangeRate functions

| Function name           | Parameter                                       | Default | Return                       |
| ----------------------- | ----------------------------------------------- | ------- | ---------------------------- |
| getCurrentExchangeRate  | $currency                                       | EUR     | RateEntity / Null            |
| getCurrentExchangeRates | -                                               | -       | RateEntityCollection         |
| getCurrencies           | -                                               | -       | Array                        |
| getDateInterval         | -                                               | -       | Object                       |
| getExchangeRates        | (optional) $startDate, $endDate, $currencyNames | -       | Array / RateEntityCollection |
| getCurrencyUnits        | (optional) $currencyNames                       | -       | Associative Array            |
| getInfo                 | -                                               | -       | Object                       |

### RateEntity methods

| Function name | Parameter | Return     |
| ------------- | --------- | ---------- |
| getDate       | -         | string     |
| setDate       | $date     | RateEntity |
| getUnit       | -         | int        |
| setUnit       | $unit     | RateEntity |
| getCurrency   | -         | string     |
| setCurrency   | $currency | RateEntity |
| getValue      | -         | float      |
| setValue      | $value    | RateEntity |

### RateEntityCollection methods

| Function name        | Parameter          | Return            |
| -------------------- | ------------------ | ----------------- |
| addEntity            | RateEntity $entity | -                 |
| removeEntity         | RateEntity $entity | -                 |
| findEntity           | RateEntity $entity | RateEntity        |
| findEntityByCurrency | $currency          | RateEntity / Null |
| getCollection        | -                  | Array             |

### Reference

<http://www.mnb.hu/arfolyamok>  
<https://www.mnb.hu/letoltes/aktualis-es-a-regebbi-arfolyamok-webszolgaltatasanak-dokumentacioja-1.pdf>
