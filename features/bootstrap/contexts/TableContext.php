<?php

namespace Behat\Behatch\Behat\Context;

use \Behat\Behat\Context\BehatContext,
    \Behat\Gherkin\Node\TableNode;

/**
 * This context is intended for Browser interractions
 */
class TableContext extends BehatContext
{
  /**
   * Shortcut for retrieving Mink context
   *
   * @return \Behat\Mink\Behat\Context\MinkContext
   */
  public function getMinkContext()
  {
    return $this->getMainContext()->getSubContext('mink');
  }

  /**
   * Checks that the specified table's columns match the given schema
   *
   * @Then /^the columns schema of the "([^"]*)" table should match:$/
   */
  public function theColumnsSchemaShouldMatch($element, TableNode $table)
  {
    $columnsSelector = sprintf('%s thead tr th', $element);
    $columns = $this->getMinkContext()->getSession()->getPage()->findAll('css', $columnsSelector);

    $this->iShouldSeeColumnsInTheTable(count($table->getHash()), $element);

    foreach($table->getHash() as $key => $column) {
      assertEquals($column['columns'], $columns[$key]->getText());
    }
  }

  /**
   * Checks that the specified table contains the given number of columns
   *
   * @Then /^(?:|I )should see (\d+) columns? in the "([^"]*)" table$/
   */
  public function iShouldSeeColumnsInTheTable($occurences, $element)
  {
    $columnsSelector = sprintf('%s thead tr th', $element);
    $columns = $this->getMinkContext()->getSession()->getPage()->findAll('css', $columnsSelector);

    assertEquals($occurences, count($columns));
  }

  /**
   * Checks that the specified table contains the specified number of rows in its body
   *
   * @Then /^(?:|I )should see (\d+) rows in the (\d+)(?:st|nd|rd|th) "([^"]*)" table$/
   */
  public function iShouldSeeRowsInTheNthTable($occurences, $index, $element)
  {
    $tables = $this->getMinkContext()->getSession()->getPage()->findAll('css', $element);
    if (!isset($tables[$index - 1]))
    {
      throw new \Exception(sprintf('The %d table "%s" was not found in the page', $index, $element));
    }

    $rows = $tables[$index - 1]->findAll('css', 'tbody tr');
    assertEquals($occurences, count($rows));
  }

  /**
   * Checks that the specified table contains the specified number of rows in its body
   *
   * @Then /^(?:|I )should see (\d+) rows? in the "([^"]*)" table$/
   */
  public function iShouldSeeRowsInTheTable($occurences, $element)
  {
    $this->iShouldSeeRowsInTheNthTable($occurences, 1, $element);
  }

  /**
   * Checks that the data of the specified row matches the given schema
   *
   * @Then /^the data in the (\d+)(?:st|nd|rd|th) row of the "([^"]*)" table should match:$/
   */
  public function theDataOfTheRowShouldMatch($index, $element, TableNode $table)
  {
    $rowsSelector = sprintf('%s tbody tr', $element);
    $rows = $this->getMinkContext()->getSession()->getPage()->findAll('css', $rowsSelector);

    if(!isset($rows[$index - 1]))
    {
      throw new \Exception(sprintf('The row %d was not found in the "%s" table', $index, $element));
    }

    $cells = (array)$rows[$index - 1]->findAll('css', 'td');
    $cells = array_merge((array)$rows[$index - 1]->findAll('css', 'th'), $cells);

    $hash = current($table->getHash());
    $keys = array_keys($hash);
    assertEquals(count($hash), count($cells));

    for ($i = 0; $i < count($cells); $i++)
    {
      assertEquals($hash[$keys[$i]], $cells[$i]->getText());
    }
  }

  /**
   * Checks that the specified cell (column/row) of the table's body contains the specified text
   *
   * @Then /^the (\d+)(?:st|nd|rd|th) column of the (\d+)(?:st|nd|rd|th) row in the "([^"]*)" table should contain "([^"]*)"$/
   */
  public function theStColumnOfTheStRowInTheTableShouldContain($colIndex, $rowIndex, $element, $text)
  {
    $rowSelector = sprintf('%s tbody tr', $element);
    $rows = $this->getMinkContext()->getSession()->getPage()->findAll('css', $rowSelector);

    if (!isset($rows[$rowIndex - 1]))
    {
      throw new \Exception(sprintf("The row %d was not found in the %s table", $rowIndex, $element));
    }

    $row = $rows[$rowIndex - 1];
    $colSelector = sprintf('td', $element);
    $cols = $row->findAll('css', $colSelector);

    if (!isset($cols[$colIndex - 1]))
    {
      throw new \Exception(sprintf("The column %d was not found in the row %d of the %s table", $colIndex, $rowIndex, $element));
    }

    $actual   = $cols[$colIndex - 1]->getText();
    $e = null;

    assertContains($text, $actual);
  }
}
