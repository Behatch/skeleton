Feature: System feature

    @system
    Scenario: Testing execution
        Given I execute "ls"

    @system
    Scenario: Testing execution from the project root
        Given I execute "bin/behat --help"
