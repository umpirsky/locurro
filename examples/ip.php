<?php

require __DIR__.'/../vendor/autoload.php';

$converter = new Locurro\Converter\IpAddress(
    new Locurro\Converter\Country(
        new Locurro\Converter\Locale(
            new Locurro\Converter\Currency(
                new Swap\Swap(
                    new Swap\Provider\YahooFinanceProvider(
                        new Ivory\HttpAdapter\FileGetContentsHttpAdapter()
                    )
                )
            )
        )
    ),
    new Geocoder\Provider\GeoIP2(
        new Geocoder\Adapter\GeoIP2Adapter(
            new GeoIp2\Database\Reader(__DIR__.'/../data/GeoLite2-Country.mmdb'),
            Geocoder\Adapter\GeoIP2Adapter::GEOIP2_MODEL_COUNTRY
        )
    )
);

$money = $converter->convert(
    new Money\Money(100, new Money\Currency('EUR')),
    '109.92.115.78'
);

var_dump($money);
