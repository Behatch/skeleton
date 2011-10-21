<?php

use Behat\Behat\Formatter\JUnitFormatter;

use Symfony\Component\EventDispatcher\EventDispatcher;

use Behat\Behat\Event\EventInterface,
    Behat\Behat\Event\FeatureEvent,
    Behat\Behat\Event\ScenarioEvent,
    Behat\Behat\Event\OutlineExampleEvent,
    Behat\Behat\Event\StepEvent;

use Behat\Gherkin\Node\FeatureNode,
    Behat\Gherkin\Node\ScenarioNode,
    Behat\Gherkin\Node\StepNode,
    Behat\Behat\Exception\FormatterException;

/**
 * Formatter for Hudson, JUnit format with scenario printing
 *
 * @author      Konstantin Kudryashov <ever.zet@gmail.com>
 */
class HudsonFormatter extends JUnitFormatter
{
  /**
   * {@inheritdoc}
   */
  public static function getDescription()
  {
      return "Generates a report similar to Ant+JUnit.";
  }

  /**
   * Prints testcase.
   *
   * @param   Behat\Gherkin\Node\ScenarioNode     $feature
   * @param   float                               $time
   * @param   Behat\Behat\Event\EventInterface    $event
   */
  protected function printTestCase(ScenarioNode $scenario, $time, EventInterface $event)
  {
    $className  = $scenario->getFeature()->getTitle();
    $name       = $scenario->getTitle();
    $caseStats  = sprintf('classname="%s" name="%s" time="%f"', htmlspecialchars($className), htmlspecialchars($name), htmlspecialchars($time));

    $customMessage  = sprintf("Feature: %s\n", $scenario->getFeature()->getTitle());
    $customMessage .= sprintf("  Scenario: %s\n", $scenario->getTitle());
    foreach($scenario->getSteps() as $step)
    {
      $customMessage .= "    ".$step->getText()."\n";
    }

    $xml  = "    <testcase $caseStats>\n";

    foreach ($this->exceptions as $exception) {
      $xml .= sprintf(
        '        <failure message="%s" type="%s">',
        htmlspecialchars($exception->getMessage()),
        $this->getResultColorCode($event->getResult())
      );
      $exception = str_replace(array('<![CDATA[', ']]>'), '', (string) $exception);
      $xml .= "<![CDATA[\n".$customMessage."\n$exception\n]]></failure>\n";
    }
    $this->exceptions = array();

    $xml .= "    </testcase>";

    $this->testcases[] = $xml;
  }
}
