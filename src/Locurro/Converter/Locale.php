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
        try {
            $currencyCode = (new \Zend_Currency(null, $locale))->getShortName();
            if (null === $currencyCode) {
                throw new InvalidLocaleException(sprintf(
                    'Cannot find currency for "%s" locale.',
                    $locale
                ));
            }
        } catch (\Exception $e) {
            throw new InvalidLocaleException(sprintf(
                'Cannot find currency for "%s" locale.',
                $locale
            ), $e->getCode(), $e);
        }

        return $currencyCode;
    }
}
