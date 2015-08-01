<?php

namespace spec\Locurro\Converter;

use Locurro\Converter\Currency as CurrencyConverter;
use Money\Currency;
use Money\Money;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LocaleSpec extends ObjectBehavior
{
    function let(CurrencyConverter $currencyConverter)
    {
        $this->beConstructedWith($currencyConverter);
    }

    function it_implements_currency_converter_interface()
    {
        $this->shouldImplement('Locurro\Converter\ConverterInterface');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Locurro\Converter\Locale');
    }

    function it_converts_money_using_currency_converter(CurrencyConverter $currencyConverter, Money $money, Money $converted)
    {
        $currencyConverter->convert($money, Argument::any())->shouldBeCalled()->willReturn($converted);

        $this->convert($money, 'sr_Cyrl_RS')->shouldBeEqualTo($converted);
    }

    function it_throws_exception_if_locale_is_invalid(CurrencyConverter $currencyConverter, Money $money)
    {
        $this->shouldThrow('Locurro\Exception\InvalidLocaleException')->duringConvert($money, 'umpirsky');
    }
}
