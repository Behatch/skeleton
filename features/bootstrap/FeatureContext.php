<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\ResponseTextException;
use PHPUnit_Framework_ExpectationFailedException as AssertException;

require_once __DIR__.'/../../mink.phar';

ini_set('include_path', ini_get('include_path') . ':' . __DIR__.'/../../lib/vendor/PHPUnit-3.5.3');
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
  /**
   * Context initialization
   *
   * @param array $parameters context parameters (set them up through behat.yml)
   */
  public function __construct(array $parameters)
  {
    $this->useContext('browser', new \BrowserContext($parameters));
  }

  /**
   * Array for storing custom parameters during steps
   *
   * @var array
   */
  private $parameters = array();

  /**
   * @param string $name
   * @return string
   */
  public function getParameter($name)
  {
    return $this->parameters[$name];
  }

  /**
   * @param string $name
   * @return boolean
   */
  public function hasParameter($name)
  {
    return isset($this->parameters[$name]);
  }

  /**
   * @param string $name
   * @param string $value
   * @return void
   */
  public function setParameter($name, $value)
  {
    $this->parameters[$name] = $value;
  }
}
