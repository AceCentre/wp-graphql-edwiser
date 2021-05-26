<?php

/**
 * Plugin Name: WPGraphql Edwiser
 * Description:       Adds Moodle Courses to your GraphQL schema via Edwiser Bridge
 * Author:            Ace Centre, Gavin Henderson
 * Author URI:        https://github.com/AceCentre
 * Version:           1
 * GitHub Plugin URI: https://github.com/acecentre/wp-graphql-edwiser
 * License: GPL-3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

add_action('init', 'wpgraphql_edwiser_init');
add_action('graphql_register_types', 'wpgraphql_graphql_register_types');

function wpgraphql_graphql_register_types()
{
    register_graphql_connection([
        'fromType' => 'Product',
        'toType' => 'MoodleCourse',
        'fromFieldName' => 'moodleCourses',
        'connectionArgs' => \WPGraphQL\Connection\PostObjects::get_connection_args(),
        'resolve' => function (\WPGraphQL\Model\Post $source, $args, $context, $info) {
            $resolver   = new \WPGraphQL\Data\Connection\PostObjectConnectionResolver($source, $args, $context, $info, 'eb_course');

            $product_attr = get_post_meta($source->ID, 'product_options', true);
            $courses = $product_attr['moodle_post_course_id'];

            // For some reason some courses are an empty string,
            // if thats the case lets set it to an empty array for consistency
            if ($courses == "") {
                $courses = array();
            }

            // Map the string IDs to ints
            $courseInts = array_map('intval', $courses);

            // If there is an empty array it just returns everything which we dont want
            // so we trick it by giving it an array with an id that nothing matches
            if (count($courseInts) == 0) {
                $courseInts = array(-1);
            }

            $resolver->set_query_arg('post__in', $courseInts);

            $connection = $resolver->get_connection();
            return $connection;
        },
    ]);
}

function wpgraphql_edwiser_init()
{
    register_post_type('eb_course', [
        'show_ui' => true,
        'labels'  => [
            'menu_name' => 'MoodleCourses',
        ],
        'show_in_graphql' => true,
        'hierarchical' => true,
        'graphql_single_name' => 'moodleCourse',
        'graphql_plural_name' => 'moodleCourses',
    ]);
};
