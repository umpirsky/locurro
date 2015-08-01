<?php

namespace Locurro\Converter;

use Locurro\Exception\InvalidCountryException;
use Money\Money;

class Country implements ConverterInterface
{
    private $converter;

    public function __construct(Locale $converter)
    {
        $this->converter = $converter;
    }

    public function convert(Money $money, $target)
    {
        $locale = \Zend_Locale::getLocaleToTerritory($target);

        if (null === $locale) {
            throw new InvalidCountryException(sprintf(
                'Cannot find locale for "%s" country.',
                $target
            ));
        }

        return $this->converter->convert($money, $locale);
    }
}
