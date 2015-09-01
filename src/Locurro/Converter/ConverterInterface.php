<?php

namespace Locurro\Converter;

use Money\Money;

interface ConverterInterface
{
    public function convert(Money $money, $target);
}
