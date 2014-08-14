<?php

namespace spec\Rental;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rental\Currency;
use Rental\RentalPeriod;
use Rental\Price;

class RateSpec extends ObjectBehavior
{
    function let()
    {
        $dateRange = RentalPeriod::fromDateTime(new \DateTime('2014-07-01'), new \DateTime('2014-07-07'));
        $price = Price::fromString(70, Currency::fromString('EUR'));
        $this->beConstructedWith($dateRange, $price, 1);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Rental\Rate');
    }

    function it_tests_whether_or_not_it_applies_to_a_date_range()
    {
        $endsInsideOfRange = RentalPeriod::fromDateTime(new \DateTime('2014-06-01'), new \DateTime('2014-07-02'));
        $this->overlapsWithPeriod($endsInsideOfRange)->shouldBe(true);

        $startsInsideOfRange = RentalPeriod::fromDateTime(new \DateTime('2014-07-02'), new \DateTime('2014-08-02'));
        $this->overlapsWithPeriod($startsInsideOfRange)->shouldBe(true);

        $encapsulatesRange = RentalPeriod::fromDateTime(new \DateTime('2014-06-02'), new \DateTime('2014-08-02'));
        $this->overlapsWithPeriod($encapsulatesRange)->shouldBe(true);

        $endsBeforeRange = RentalPeriod::fromDateTime(new \DateTime('2014-06-02'), new \DateTime('2014-06-30'));
        $this->overlapsWithPeriod($endsBeforeRange)->shouldBe(false);

        $startsAfterRange = RentalPeriod::fromDateTime(new \DateTime('2014-07-08'), new \DateTime('2014-08-02'));
        $this->overlapsWithPeriod($startsAfterRange)->shouldBe(false);
    }

    function it_applies_to_all_ranges_when_a_range_is_not_defined()
    {
        $price = Price::fromString(70, Currency::fromString('EUR'));
        $this->beConstructedWith(null, $price, 1);

        $startsAfterRange = RentalPeriod::fromDateTime(new \DateTime('2014-07-08'), new \DateTime('2014-08-02'));
        $this->overlapsWithPeriod($startsAfterRange)->shouldBe(true);
    }

    function it_returns_the_price()
    {
        $this->getPrice()->shouldHaveType('Rental\Price');
        $this->getPrice()->getValue()->shouldBe(70);
    }

    function it_returns_unit_price()
    {
        $this->getUnitPrice()->getValue()->shouldBe(70);
    }

    function it_returns_unit_days()
    {
        $this->getUnitDays()->shouldBe(1);
    }
}
