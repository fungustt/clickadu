<?php
use \Aggregator\DataAggregatorInterface;
use \Catalog\TmpDirManagerInterface;
use Log\LoggerAwareTrait;

class App
{
    use LoggerAwareTrait;

    /**
     * @var DataAggregatorInterface
     */
    private $dataAggregator;

    /**
     * @var TmpDirManagerInterface
     */
    private $tmpDirManager;

    public function __construct(
        DataAggregatorInterface $dataAggregator,
        TmpDirManagerInterface $tmpDirManager
    ) {
        $this->dataAggregator = $dataAggregator;
        $this->tmpDirManager = $tmpDirManager;
    }

    public function run()
    {
        $this->logger->log('File aggregation started');

        $this->tmpDirManager->clearTmpDir(); // Pre clean

        $this->dataAggregator->aggregate();

        $this->tmpDirManager->clearTmpDir(); // Post clean

        $this->logger->log('File aggregation complete. You can get aggregated data from result.csv');
    }
}