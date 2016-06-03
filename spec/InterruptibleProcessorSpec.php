<?php

namespace spec\League\Pipeline;

use League\Pipeline\InterruptibleProcessor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InterruptibleProcessorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(InterruptibleProcessor::class);
    }

    function let()
    {
        $this->beConstructedWith(function ($payload) {
            return $payload < 10;
        });
    }

    function it_should_interrupt()
    {
        $this->process([
            function ($payload) { return $payload + 2; },
            function ($payload) { return $payload * 10; },
            function ($payload) { return $payload * 10; },
        ], 5)->shouldBe(70);

        $this->process([
            function ($payload) { return $payload + 2; },
        ], 5)->shouldBe(7);
    }
}
