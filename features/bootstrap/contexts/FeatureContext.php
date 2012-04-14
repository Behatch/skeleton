<?php

use Behat\Behat\Context\BehatContext;
use Behat\Behatch\Behat\Context\BehatchContext;

class FeatureContext extends BehatContext
{
  public function __construct(array $parameters)
  {
    $this->useContext('behatch', new BehatchContext($parameters));
  }
}

