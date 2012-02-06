<?php

use Behat\Behat\Formatter\ConsoleFormatter;
use Behat\Behat\Formatter\FormatManager;

use Symfony\Component\EventDispatcher\EventDispatcher;

use Behat\Behat\Event\ScenarioEvent,
    Behat\Behat\Event\OutlineEvent,
    Behat\Behat\Event\StepEvent,
    Behat\Behat\Event\SuiteEvent;

/**
 * Campfire notifier
 */
class CampfireNotifier extends ConsoleFormatter
{
  /**
   * {@inheritdoc}
   */
  public static function getDescription()
  {
    return "Warns you in Ubuntu when a scenario is failing";
  }

  /**
   * {@inheritdoc}
   */
  protected function getDefaultParameters()
  {
    return array(
      "campfire_url" => null,
      "campfire_token" => null,
      "campfire_room" => null,
      "campfire_first_fail_only" => true
    );
  }

  /**
   * @see     Symfony\Component\EventDispatcher\EventSubscriberInterface::getSubscribedEvents()
   */
  public static function getSubscribedEvents()
  {
      $events = array('afterStep', 'afterSuite');

      return array_combine($events, $events);
  }

  /**
   * Listens to "step.after" event.
   *
   * @param   Behat\Behat\Event\StepEvent $event
   *
   * @uses    printStep()
   */
  public function afterStep(StepEvent $event)
  {
    if($event->getResult() == 4)
    {
      $this->send('Behat is failing... :thumbsdown:');
      $message = "\nScenario : ".$event->getStep()->getParent()->getTitle();
      $message .= "\n".$event->getStep()->getText();
      $message .= "\n> ".$event->getException()->getMessage();

      $this->send($message);
    }
  }

  /**
   * Listens to "suite.after" event.
   *
   * @param   Behat\Behat\Event\SuiteEvent    $event
   *
   * @uses    printSuiteFooter()
   */
  public function afterSuite(SuiteEvent $event)
  {
    if($event->isCompleted())
    {
      $statuses = $event->getLogger()->getScenariosStatuses();
      if($statuses['failed'] > 0)
      {
        $this->send("Behat suite finished :thumbsdown::shit:");
        $message  = '';
        $message .= "\n".$statuses['failed']. ' scenario failed';
        $message .= "\n".$statuses['passed']. ' scenario ok';
      }
      else
      {
        $this->send("Behat suite finished :thumbsup::sparkles:");
        $message = "\n".$statuses['passed']. ' scenario ok';
      }
    }
  }

  /**
   * @param $message
   */
  public function send($message)
  {
    $campfireUrl   = $this->parameters->get('campfire_url');
    $campfireToken = $this->parameters->get('campfire_token');
    $campfireRoom  = $this->parameters->get('campfire_room');

    if($campfireUrl == null)
    {
      throw new Exception("You must set a campfire URL in behat.yml");
    }

    if($campfireToken == null)
    {
      throw new Exception("You must set a campfire room in behat.yml");
    }

    if($campfireRoom == null)
    {
      throw new Exception("You must set a campfire token in behat.yml");
    }

    $cmd = sprintf("curl -u %s:X -H 'Content-Type: application/json' -d %s %s/room/%s/speak.xml", $campfireToken, escapeshellarg(json_encode(array('message' => array('body' => $message)))), trim($campfireUrl, '/'), $campfireRoom);
    print $cmd;
    exec($cmd);
  }
}