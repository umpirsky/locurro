<?php

namespace spec\Locurro\Converter;

use Locurro\Converter\Locale;
use Money\Money;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CountrySpec extends ObjectBehavior
{
    function let(Locale $converter)
    {
        $this->beConstructedWith($converter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Locurro\Converter\Country');
    }

    function it_implements_currency_converter_interface()
    {
        $this->shouldImplement('Locurro\Converter\ConverterInterface');
    }

    function it_converts_money_using_locale_converter(Locale $converter, Money $money, Money $converted)
    {
        $converter->convert($money, 'sr_Cyrl_RS')->shouldBeCalled()->willReturn($converted);

        $this->convert($money, 'RS')->shouldBeEqualTo($converted);
    }

    function it_throws_exception_if_country_is_invalid(Money $money)
    {
        $this->shouldThrow('Locurro\Exception\InvalidCountryException')->duringConvert($money, 'umpirsky');
    }
}
