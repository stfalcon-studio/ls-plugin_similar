
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

  Scenario: Chech similar for draft topic
  # check for similar for draft topic 4
    Given I am on "/login"
    Then I want to login as "admin"

    Given I am on "/topic/add"
    Then I select "Gadgets" from "blog_id"
    When I fill in "topic_title" with "My custome draft topic"
    When I fill in "topic_text" with "draft topic text draft topic text draft topic text draft topic text"
    When I fill in "topic_tags" with "sony"
    When I press "submit_topic_save"

    Given I am on "/blog/3.html"
    Then I should not see in element by css "sidebar" values:
      | value |
      | My custome draft topic |