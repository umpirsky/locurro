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

    public function convert(Money $money, $target)
    {
        if (!$target instanceof MoneyCurrency) {
            throw new InvalidArgumentException(sprintf(
                'Second argument must be Currency, %s given.',
                gettype($target)
            ));
        }

        $rate = $this->swap->quote(
            new CurrencyPair($money->getCurrency(), $target)
        );

        return new Money(
            $money->multiply(
                (float) $rate->getValue()
            )->getAmount(),
            $target
        );
    }
}
