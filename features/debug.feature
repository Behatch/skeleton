Feature: Browser Feature

  @debug
  Scenario: Testing simple web access
    Given I am on "index.html"

    Then I put a breakpoint
    Then I should see "Congratulations, you've correctly set up your apache environment."
    Then I put a breakpoint

  @debug
  Scenario: Basic authentication
    Given I am on "testing-auth.php"
    Then the response status code should be 401
    And I should see "NONE SHALL PASS"

    Then I put a breakpoint

    When I set basic authentication with "something" and "wrong"
    And I go to "testing-auth.php"
    Then the response status code should be 401
    And I should see "NONE SHALL PASS"

    Then I put a breakpoint

    When I set basic authentication with "gabriel" and "30091984"
    And I go to "testing-auth.php"
    Then the response status code should be 200
    And I should see "Successfuly logged in"

    Then I put a breakpoint

    When I go to "testing-auth.php?logout"
    Then I should see "Logged out"

    Then I put a breakpoint

    When I go to "testing-auth.php"
    Then the response status code should be 401
    And I should see "NONE SHALL PASS"
