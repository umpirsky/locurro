<?php

namespace spec\Locurro\Converter;

use Money\Currency;
use Money\Money;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Swap\Model\Rate;
use Swap\SwapInterface;

class CurrencySpec extends ObjectBehavior
{
    function let(SwapInterface $swap)
    {
        $this->beConstructedWith($swap);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Locurro\Converter\Currency');
    }

    function it_implements_currency_converter_interface()
    {
        $this->shouldImplement('Locurro\Converter\ConverterInterface');
    }

    function it_converts_money(SwapInterface $swap, Money $money, Currency $currency)
    {
        $money->getAmount()->willReturn(5);
        $money->getCurrency()->willReturn($currency);
        $money->multiply(5)->willReturn($money);

        $currency->__toString()->willReturn('EUR');

        $swap->quote(Argument::any())->shouldBeCalled()->willReturn(new Rate(5));

        $this->convert($money, $currency)->shouldHaveType('Money\Money');
    }

    function it_converts_money_based_on_given_currency(SwapInterface $swap, Money $money, Currency $currency)
    {
        $money->getAmount()->willReturn(5);
        $money->getCurrency()->willReturn($currency);
        $money->multiply(5)->willReturn($money);

        $currency->__toString()->willReturn('EUR');

        $swap->quote(Argument::any())->shouldBeCalled()->willReturn(new Rate(5));

        $this->convert($money, $currency)->getCurrency()->shouldBe($currency);
    }

    function it_converts_money_using_swap(SwapInterface $swap, Money $money, Money $converted, Currency $from, Currency $to)
    {
        $money->getAmount()->willReturn(100);
        $money->getCurrency()->willReturn($from);
        $money->multiply(120.3971)->willReturn($converted);

        $converted->getAmount()->willReturn(12039);
        $converted->getCurrency()->willReturn($to);

        $from->__toString()->willReturn('EUR');
        $to->__toString()->willReturn('RSD');

        $rate = new Rate(120.3971);

        $swap->quote('EUR/RSD')->shouldBeCalled()->willReturn($rate);

        $this->convert($money, $to)->getAmount()->shouldBe(12039);
    }
}
