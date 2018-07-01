<?php
namespace Aggregator;

interface DataAggregatorInterface
{
    /**
     * @param bool $break
     */
    public function aggregate(bool $break = false);
}