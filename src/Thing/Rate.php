<?php namespace Thing; 

class Rate
{
    /**
     * @var DateRange
     */
    private $dateRange;
    /**
     * @var Price
     */
    private $price;
    private $unitInDays;

    public function __construct(DateRange $dateRange = null, Price $price, $unitInDays)
    {
        $this->dateRange = $dateRange;
        $this->price = $price;
        $this->unitInDays = $unitInDays;
    }

    /**
     * @param DateRange $range
     * @return bool
     */
    public function appliesToDateRange(DateRange $range)
    {
        if ( ! $this->dateRange) {
            return true;
        }
        return $this->dateRange->overlapsWithRange($range);
    }

    public function getUnitDays()
    {
        return $this->dateRange->getDayCount();
    }

    /**
     * @return mixed
     */
    public function getUnitPrice()
    {
        return Price::fromString($this->price->getValue() / $this->unitInDays, $this->price->getCurrency());
    }

    public function getPrice()
    {
        return $this->price;
    }
}
