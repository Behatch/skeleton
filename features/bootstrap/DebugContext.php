<?php
use Behat\Behat\Context\BehatContext;

/**
 * Features context.
 */
class DebugContext extends BehatContext
{
  /**
   * Pauses the scenario until the user presses a key. Usefull when debugging a scenario.
   *
   * @Then /^(?:|I )put a breakpoint$/
   */
  public function iPutABreakpoint()
  {
    fwrite(STDOUT, "\033[s    \033[93m[Breakpoint] Press \033[1;93m[RETURN]\033[0;93m to continue...\033[0m");
    while (fgets(STDIN, 1024) == '') {}
    fwrite(STDOUT, "\033[u");
    
    return;
  }
}
