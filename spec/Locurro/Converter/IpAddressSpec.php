<?php

namespace spec\Locurro\Converter;

use Geocoder\Geocoder;
use Geocoder\Model\Address;
use Geocoder\Model\AddressCollection;
use Geocoder\Model\Country;
use Locurro\Converter\Country as CountryConverter;
use Money\Money;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IpAddressSpec extends ObjectBehavior
{
    function let(CountryConverter $converter, Geocoder $geocoder)
    {
        $this->beConstructedWith($converter, $geocoder);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Locurro\Converter\IpAddress');
    }

    function it_implements_currency_converter_interface()
    {
        $this->shouldImplement('Locurro\Converter\ConverterInterface');
    }

    function it_converts_money_using_country_converter(CountryConverter $converter, Geocoder $geocoder, Money $money, Money $converted)
    {
        $country = new Country('Serbia', 'RS');
        $address = new Address(null, null, null, null, null, null, null, null, $country);
        $addresses = new AddressCollection([$address]);

        $geocoder->geocode('109.92.115.78')->shouldBeCalled()->willReturn($addresses);
        $converter->convert($money, 'RS')->shouldBeCalled()->willReturn($converted);

        $this->convert($money, '109.92.115.78')->shouldBeEqualTo($converted);
    }

    function it_throws_exception_if_country_is_not_geolocated(Geocoder $geocoder, Money $money)
    {
        $geocoder->geocode(Argument::any())->shouldBeCalled()->willReturn(new AddressCollection());

        $this->shouldThrow('Locurro\Exception\GeolocationException')->duringConvert($money, 'umpirsky');
    }
}
