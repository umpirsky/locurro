<?php

namespace Locurro\Twig;

use Locurro\Converter\ConverterInterface;
use Money\Money;

class Extension extends \Twig_Extension
{
    private $converter;

    public function __construct(ConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('locurro_convert', [$this, 'convert']),
        ];
    }

    public function convert(Money $money, $target)
    {
        return $this->converter->convert($money, $target);
    }

    public function getName()
    {
        return 'locurro';
    }
}
