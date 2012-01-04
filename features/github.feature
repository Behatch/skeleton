# This Feature is intended to be the proof of concept of BehatCH
# It looks directly at the github website so it will fail if you don't have any Internet connection

Feature: Github Feature

  @github
  Scenario: Is the github page still up ?
    Given I am on "http://github.com/gabrielpillet/BehatCH"
    Then I should see "Behat Custom Helper"

  @github
  Scenario: I'm gonna check myself a bit
    Given I am on "http://github.com/gabrielpillet/BehatCH"
    When I follow "features"
    And I follow "github.feature"
    Then I should see "WE NEED TO GO DEEPER !!"
