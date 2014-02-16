<?php

namespace Burrbd\Helper;

use Symfony\Component\Console\Helper\Helper;
use Assetic\Factory\AssetFactory;

class AssetFactoryHelper extends Helper
{

    protected $factory;

    public function __construct(AssetFactory $factory)
    {
        $this->factory = $factory;
    }

    public function getFactory()
    {
        return $this->factory;
    }

    public function getName()
    {
        return 'asset factory';
    }
}
