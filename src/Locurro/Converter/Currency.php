<?php

namespace Locurro\Converter;

use Locurro\Exception\InvalidArgumentException;
use Money\Currency as MoneyCurrency;
use Money\Money;
use Swap\Model\CurrencyPair;
use Swap\SwapInterface;

class Currency
{
    private $swap;

    public function __construct(SwapInterface $swap)
    {
        $this->swap = $swap;
    }

    public function convert(Money $money, $currency)
    {
        if (!$currency instanceof MoneyCurrency) {
            throw new InvalidArgumentException(sprintf(
                'Second argument must be Currency, %s given.',
                gettype($currency)
            ));
        }

        $rate = $this->swap->quote(
            new CurrencyPair($money->getCurrency(), $currency)
        );

        return $money->multiply(
            (float) $rate->getValue()
        );
    }
}
