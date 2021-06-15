@moodle @local_jirapush @curl
  Feature:
    Given I am on a Moodle site
    And the following "users" exist:
        | username | email             |
        | user1    | user1@example.com |
    And the following "local plugin" exist:
        | name     |
        | jirapush |
        | reportgen|
    And the follow field appear for "jirapush"
        | enabled  | service url | REST API key | Object Schema key | Object Type Name |

  Scenario: Test that the specific information will be sent to JIRA Cloud
    Given I log in as "user1"
    And I click on "reportgen" and generate the information required
    When I click on "jirapush" and add the settings fields
    And I click on "jirapush" task manager and run the API manually
    Then I can see an input with the value of the information generated by "reportgen" on JIRA Cloud

  Scenario: Test that when the JIRA Push plugin is not enabled the API fails to respond
    Given I log in as "user1"
    And I click on "reportgen" and generate the information required
    And I click on the "jirapush" settings
    When I set "enabled" to not enabled
    And I click on "jirapush" task manager and run the API manual
    Then I should see "Please enable the JIRA Push plugin"

  Scenario: Test that when the JIRA Push plugin service url is not inputted the API fails to respond
    Given I log in as "user1"
    And I click on "reportgen" and generate the information required
    And I click on the "jirapush" settings
    When I leave the "service url" field empty
    And I click on "jirapush" task manager and run the API manually
    Then I should see "Please enter Service url"

  Scenario: Test that when the JIRA Push plugin REST API key is not inputted the API fails to respond
    Given I log in as "user1"
    And I click on "reportgen" and generate the information required
    And I click on the "jirapush" settings
    When I leave the "REST API key" field empty
    And I click on "jirapush" task manager and run the API manually
    Then I should see "Please enter REST API key"

  Scenario: Test that when the JIRA Push plugin Object Schema key is not inputted the API fails to respond
    Given I log in as "user1"
    And I click on "reportgen" and generate the information required
    And I click on the "jirapush" settings
    When I leave the "Object Schema key" field empty
    And I click on "jirapush" task manager and run the API manually
    Then I should see "Please enter Object Schema key"

  Scenario: Test that when the JIRA Push plugin Object Type Name is not inputted the API fails to respond
    Given I log in as "user1"
    And I click on "reportgen" and generate the information required
    And I click on the "jirapush" settings
    When I leave the "Object Type Name" field empty
    And I click on "jirapush" task manager and run the API manually
    Then I should see "Please enter Object Type Name"

  Scenario: Test what happens when the Report Generator plugin has not been used before using the JIRA Push plugin
    Given I log in as "user1"
    And I don't click on "reportgen" to generate the information required
    When I click on "jirapush" and add the settings fields
    And I click on "jirapush" task manager and run the API manually
    Then I should see "Please generate the information through the Report Generator plugin"
