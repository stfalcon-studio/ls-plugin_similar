
Feature: ls-plugin-similar-plugins
  Test base functionality of ls-similar-plugins

  Scenario: Chech similar for topic who have 1 similar
    # check for similar of topic 1
    Given I am on "blog/3.html"
    Then the response status code should be 200

    Then I should see in element by css "sidebar" values:
      | value |
      | Toshiba unveils 13.3-inch AT330 Android ICS 4.0 tablet |

    Then I should not see in element by css "sidebar" values:
      | value |
      | iPad 3 rumored to come this March with quad-core chip and 4G LTE |

  Scenario: Chech similar for topic who have not similar
    # check for similar for topic 2
    Given I am on "/blog/gadgets/2.html"
    Then the response status code should be 200
    Then I should not see in element by css "sidebar" values:
      | value |
      | Similar articles |


