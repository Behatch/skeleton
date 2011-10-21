Feature: Dummy Feature
  Scenario: Is the github page still up ?
    Given I am on "http://github.com/gabrielpillet/BehatCH"
    Then I should see "Behat Custom Helper"

  Scenario: I'm gonna check myself a bit
    Given I am on "http://github.com/gabrielpillet/BehatCH"
    When I follow "features"
    And I follow "dummy.feature"
    Then I should see "WE HAVE TO GO DEEPER"
