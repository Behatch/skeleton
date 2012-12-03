Feature: Browser Feature

  @debug
  Scenario: Testing a break point
    Given I am on "index.html"
    Then I put a breakpoint
    Then I should see "Congratulations, you've correctly set up your apache environment."
    Then I put a breakpoint

  @debug @javascript
  Scenario: Taking a screenshot
    Given I am on "index.html"
    And I save a screenshot in "index.png"
