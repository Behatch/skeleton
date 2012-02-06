Feature: Browser Feature

  # If this scenari fails
  # It's probably because your web environment is not properly setup
  # You will find the necessery help in README.md
  @browser @javascript
  Scenario: Testing simple web access
    Given I am on "index.html"
    Then I should see "Congratulations, you've correctly set up your apache environment."

  # Testing basic authentication
  @browser
  Scenario: Basic authentication
    Given I am on "testing-auth.php"
    Then the response status code should be 401
    And I should see "NONE SHALL PASS"

    When I set basic authentication with "something" and "wrong"
    And I go to "testing-auth.php"
    Then the response status code should be 401
    And I should see "NONE SHALL PASS"

    When I set basic authentication with "gabriel" and "30091984"
    And I go to "testing-auth.php"
    Then the response status code should be 200
    And I should see "Successfuly logged in"

    When I go to "testing-auth.php?logout"
    Then I should see "Logged out"

    When I go to "testing-auth.php"
    Then the response status code should be 401
    And I should see "NONE SHALL PASS"
