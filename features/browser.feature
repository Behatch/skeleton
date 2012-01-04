Feature: Browser Feature

  # If this scenari fails
  # It's probably because your web environment is not properly setup
  # You will find the necessery help in README.md
  @browser
  Scenario: Testing simple web access
    Given I am on "index.html"
    Then I should see "Foobar"