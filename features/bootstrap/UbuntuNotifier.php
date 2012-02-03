<?php

use Behat\Behat\Formatter\ConsoleFormatter;
use Behat\Behat\Formatter\FormatManager;

use Symfony\Component\EventDispatcher\EventDispatcher;

use Behat\Behat\Event\ScenarioEvent,
    Behat\Behat\Event\OutlineEvent,
    Behat\Behat\Event\StepEvent,
    Behat\Behat\Event\SuiteEvent;

/**
 * Ubuntu scenarios formatter.
 */
class UbuntuNotifier extends ConsoleFormatter
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
      "error_icon" => "/usr/share/icons/gnome/48x48/status/error.png",
      "sad_icon" => "/usr/share/icons/gnome/48x48/emotes/face-sad.png",
      "smile_icon" => "/usr/share/icons/gnome/48x48/emotes/face-laugh.png"
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
      $message = 'Scenario : '.$event->getStep()->getParent()->getTitle()."\\";
      $message .= "\n".$event->getStep()->getText()."\\";
      $message .= "\n> ".$event->getException()->getMessage();

      exec(sprintf("notify-send -i %s -t 1000 'Behat step failure' '%s'", $this->parameters->get('error_icon'), str_replace("'", "`", $message)));
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
        $message  = "FAILURE";
        $message .= "\n".$statuses['failed']. ' scenario failed';
        $message .= "\n".$statuses['passed']. ' scenario ok';
        exec(sprintf("notify-send -i %s -t 1000 'Behat suite ended' '%s'", $this->parameters->get('sad_icon'), $message));
      }
      else
      {
        $message  = "SUCCESS";
        $message .= "\n".$statuses['passed']. ' scenario ok';
        exec(sprintf("notify-send -i %s -t 1000 'Behat suite ended' '%s'", $this->parameters->get('smile_icon'), $message));
      }
    }
  }
}