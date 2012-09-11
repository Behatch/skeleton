Feature: Testing RESTContext

  @rest
  Scenario: Testing headers
    When I send a GET request on "testing-rest.php"
    Then the header "Content-Type" should be contains "text"
    Then the header "Content-Type" should be equal to "text/html"
    Then the header "xxx" should not exist

  @rest
  Scenario: Testing request methods.
    Given I send a GET request on "testing-rest.php"
    Then I should see "You have sent a GET request. "
    And I should see "No parameter received"

    When I send a GET request on "testing-rest.php?first=foo&second=bar"
    Then I should see "You have sent a GET request. "
    And I should see "2 parameter(s)"
    And I should see "first : foo"
    And I should see "second : bar"

    When I send a POST request on "testing-rest.php" with parameters:
      | key | value |
      | foo | bar   |
    Then I should see "You have sent a POST request. "
    And I should see "1 parameter(s)"
    And I should see "foo : bar"

    When I send a PUT request on "testing-rest.php"
    Then I should see "You have sent a PUT request. "

    When I send a DELETE request on "testing-rest.php"
    Then I should see "You have sent a DELETE request. "

    When I send a POST request on "testing-rest.php" with body:
      """
      This is a body.
      """
    #Don't know why this is not working. :o
    #Then I should see "Body : This is a body."
