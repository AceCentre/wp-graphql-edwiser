=== Connect Moodle to WPGraphql via Edwiser ===
Contributors: gavinhenderson
Tags: GraphQL, API, Gatsby, Headless, Decoupled, React, Nextjs, Vue, Apollo, REST, JSON,  HTTP, Remote, Query Language, Woocommerce, Edwiser, LMS, Moodle, AceCente, WisdmLabs, WordPress, Moodle, Courses, Users, Synchronization, Sell Courses, Learning Management System, LMS, LMS Integration, Moodle WordPress, WordPress Moodle, WP Moodle,
Stable tag: 1
License: GPL-3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

== Description ==

Add Moodle Course (via Edwiser Bridge) support and functionality to your WPGraphQL server

== Prerequisites ==

In order to use this plugin you will need to have other plugins installed.

You will need to be using:

- [Edwiser Bridge](https://en-gb.wordpress.org/plugins/edwiser-bridge/)
- [WPGraphql Woocommerce](https://github.com/wp-graphql/wp-graphql-woocommerce)
- [Woocommerce](https://en-gb.wordpress.org/plugins/woocommerce/)
- [WPGraphql](https://en-gb.wordpress.org/plugins/wp-graphql/)

== How it works ==

This simple plugin works by registering a new GraphQL post type called 'MoodleCourses'. It then attaches to the WooCommerce Product schema type.

As a result you can query courses on their own but you can also query them in relation to the products they are attached to.

== Examples ==

=== Query all courses attached to your products ===

`
{
  products(first: 1000) {
    nodes {
      id
      name
      moodleCourses(first: 1000) {
        nodes {
          id
          databaseId
          title
          slug
        }
      }
    }
  }
}
`

=== Query all courses ===

`
{
  moodleCourses(first: 1000) {
    nodes {
      id
      databaseId
      title
      slug
    }
  }
}
`

=== Query a specific course ===

`
{
  moodleCourse(id: 28140, idType: DATABASE_ID) {
    id
    databaseId
    title
    slug
  }
}
`
