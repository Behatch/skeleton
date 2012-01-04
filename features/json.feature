Feature: Testing JSONContext

  @json
  Scenario: Am I a JSON ?
    Given I am on "json/imajson.json"
    Then the response should be in JSON
    When I am on "json/imnotajson.json"
    Then the response should not be in JSON

  @json
  Scenario: Checking JSON evaluation
    Given I am on "json/imajson.json"

    Then the JSON node "foo" should exists
    And the JSON node "foo" should contain "bar"
    And the JSON node "foo" should not contain "something else"

    And the JSON node "numbers[0]" should contain "one"
    And the JSON node "numbers[1]" should contain "two"
    And the JSON node "numbers[2]" should contain "three"
    And the JSON node "numbers[3].complexeshizzle" should be equal to "true"
    And the JSON node "numbers[3].so[0]" should be equal to "very"
    And the JSON node "numbers[3].so[1].complicated" should be equal to "indeed"

    And the JSON node "bar" should not exists