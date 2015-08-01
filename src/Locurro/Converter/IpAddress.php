<?php

namespace Locurro\Converter;

use Geocoder\Exception\CollectionIsEmpty;
use Geocoder\Geocoder;
use Locurro\Exception\GeolocationException;
use Money\Money;

class IpAddress implements ConverterInterface
{
    private $converter;
    private $geocoder;

    public function __construct(Country $converter, Geocoder $geocoder)
    {
        $this->converter = $converter;
        $this->geocoder = $geocoder;
    }

    public function convert(Money $money, $target)
    {
        try {
            $country = $this->geocoder->geocode($target)->first()->getCountry();
        } catch (CollectionIsEmpty $e) {
            throw new GeolocationException(sprintf(
                'Cannot geolocate "%s".',
                $target
            ), $e);
        }

        return $this->converter->convert($money, $country->getCode());
    }
}
