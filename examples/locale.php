<?php

require __DIR__.'/../vendor/autoload.php';

$converter = new Locurro\Converter\Locale(
    new Locurro\Converter\Currency(
        new Swap\Swap(
            new Swap\Provider\YahooFinanceProvider(
                new Ivory\HttpAdapter\FileGetContentsHttpAdapter()
            )
        )
    )
);

$money = $converter->convert(
    new Money\Money(100, new Money\Currency('EUR')),
    'sr-Cyrl-RS'
);

var_dump($money);
