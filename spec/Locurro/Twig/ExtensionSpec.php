<?php

namespace spec\Locurro\Twig;

use Locurro\Converter\ConverterInterface;
use Money\Money;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExtensionSpec extends ObjectBehavior
{
    function let(ConverterInterface $converter)
    {
        $this->beConstructedWith($converter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Locurro\Twig\Extension');
    }

    function it_is_a_twig_extension()
    {
        $this->shouldHaveType('Twig_Extension');
    }

    function it_converts_using_locurro_converter(ConverterInterface $converter, Money $money)
    {
        $converter->convert($money, 'sr')->shouldBeCalled()->willReturn($money);

        $this->convert($money, 'sr')->shouldHaveType('Money\Money');
    }
}
