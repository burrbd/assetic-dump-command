<?php

namespace Burrbd\Helper;

use Symfony\Component\Console\Helper\Helper;
use Twig_Environment;

class TwigHelper extends Helper
{

    protected $environment;

    public function __construct(Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function getName()
    {
        return 'twig';
    }
}
