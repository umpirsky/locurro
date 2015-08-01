<?php

namespace Locurro\Converter;

use Locurro\Exception\InvalidLocaleException;
use Money\Currency as MoneyCurrency;
use Money\Money;

class Locale implements ConverterInterface
{
    private $converter;

    public function __construct(Currency $converter)
    {
        $this->converter = $converter;
    }

    public function convert(Money $money, $target)
    {
        $currencyCode = $this->getCurrencyCode($target);

        return $this->converter->convert(
            $money,
            new MoneyCurrency($currencyCode)
        );
    }

    private function getCurrencyCode($locale)
    {
        $currencyCode = (new \NumberFormatter(
            $locale,
            \NumberFormatter::CURRENCY
        ))->getTextAttribute(\NumberFormatter::CURRENCY_CODE);

        if (empty($currencyCode)) {
            throw new InvalidLocaleException(sprintf(
                'Cannot find currency for "%s" locale.',
                $locale
            ));
        }

        return $currencyCode;
    }
}
