<?php

/**
 * ACF Field Groups for Roadmap Theme
 * 
 * @package Roadmap
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register ACF Fields for Changelog CPT
 */
function roadmap_register_changelog_fields()
{
    // Check if ACF function exists
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_changelog',
        'title' => 'Changelog Details',
        'fields' => array(
            // Version Number
            array(
                'key' => 'field_version_number',
                'label' => 'Version Number',
                'name' => 'version_number',
                'type' => 'text',
                'instructions' => 'Enter the version number (e.g., v1.0.13)',
                'required' => 1,
                'default_value' => 'v1.0.0',
                'placeholder' => 'v1.0.13',
            ),

            // Release Date
            array(
                'key' => 'field_release_date',
                'label' => 'Release Date',
                'name' => 'release_date',
                'type' => 'date_picker',
                'instructions' => 'Select the release date',
                'required' => 1,
                'display_format' => 'F j, Y',
                'return_format' => 'Y-m-d',
            ),

            // Web Enhancements (Repeater)
            array(
                'key' => 'field_web_enhancements',
                'label' => 'Web Enhancements',
                'name' => 'web_enhancements',
                'type' => 'repeater',
                'instructions' => 'Add web enhancement features',
                'layout' => 'table',
                'button_label' => 'Add Enhancement',
                'sub_fields' => array(
                    array(
                        'key' => 'field_web_feature_title',
                        'label' => 'Feature Title',
                        'name' => 'feature_title',
                        'type' => 'text',
                        'required' => 1,
                        'placeholder' => 'Pinned Messages',
                    ),
                    array(
                        'key' => 'field_web_feature_description',
                        'label' => 'Description',
                        'name' => 'feature_description',
                        'type' => 'textarea',
                        'required' => 1,
                        'rows' => 2,
                        'placeholder' => 'High-priority info can now be starred.',
                    ),
                ),
            ),

            // Mobile Features (Repeater)
            array(
                'key' => 'field_mobile_features',
                'label' => 'Mobile Features',
                'name' => 'mobile_features',
                'type' => 'repeater',
                'instructions' => 'Add mobile feature updates',
                'layout' => 'table',
                'button_label' => 'Add Feature',
                'sub_fields' => array(
                    array(
                        'key' => 'field_mobile_feature_title',
                        'label' => 'Feature Title',
                        'name' => 'feature_title',
                        'type' => 'text',
                        'required' => 1,
                        'placeholder' => 'Manual Unread',
                    ),
                    array(
                        'key' => 'field_mobile_feature_description',
                        'label' => 'Description',
                        'name' => 'feature_description',
                        'type' => 'textarea',
                        'required' => 1,
                        'rows' => 2,
                        'placeholder' => 'Long-press to mark for follow-up.',
                    ),
                ),
            ),

            // Active Bugs (Repeater)
            array(
                'key' => 'field_active_bugs',
                'label' => 'Active Development & Bugs',
                'name' => 'active_bugs',
                'type' => 'repeater',
                'instructions' => 'Add active development items and bugs being worked on',
                'layout' => 'table',
                'button_label' => 'Add Bug/Task',
                'sub_fields' => array(
                    array(
                        'key' => 'field_bug_title',
                        'label' => 'Title',
                        'name' => 'bug_title',
                        'type' => 'text',
                        'required' => 1,
                        'placeholder' => 'Socket/Pusher Connection',
                    ),
                    array(
                        'key' => 'field_bug_description',
                        'label' => 'Description',
                        'name' => 'bug_description',
                        'type' => 'textarea',
                        'required' => 1,
                        'rows' => 2,
                        'placeholder' => 'Fixing "zombie connections" during device wake/sleep transitions (Yury\'s Lead).',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'changelog',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ));
}
add_action('acf/init', 'roadmap_register_changelog_fields');

/**
 * Register ACF Fields for Roadmap Items CPT
 */
function roadmap_register_roadmap_fields()
{
    // Check if ACF function exists
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_roadmap_item',
        'title' => 'Roadmap Item Details',
        'fields' => array(
            // Item Title (using post title, so just description field)
            array(
                'key' => 'field_roadmap_description',
                'label' => 'Description',
                'name' => 'roadmap_description',
                'type' => 'textarea',
                'instructions' => 'Brief description of this roadmap item',
                'required' => 1,
                'rows' => 3,
                'placeholder' => 'Nancy\'s request for custom Small/Medium/Large toggles for laptops.',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'roadmap_item',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ));
}
add_action('acf/init', 'roadmap_register_roadmap_fields');

/**
 * Register ACF Fields for Submissions CPT
 */
function roadmap_register_submission_fields()
{
    // Check if ACF function exists
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_submission',
        'title' => 'Submission Details',
        'fields' => array(
            // Submission Type
            array(
                'key' => 'field_submission_type',
                'label' => 'Type',
                'name' => 'submission_type',
                'type' => 'select',
                'instructions' => 'Type of submission',
                'required' => 1,
                'choices' => array(
                    'bug' => 'Bug Report',
                    'feature' => 'Feature Request',
                ),
                'default_value' => 'bug',
            ),

            // Description
            array(
                'key' => 'field_submission_description',
                'label' => 'Description',
                'name' => 'submission_description',
                'type' => 'textarea',
                'instructions' => 'Detailed description',
                'required' => 1,
                'rows' => 5,
            ),

            // Submitter Name
            array(
                'key' => 'field_submitter_name',
                'label' => 'Submitter Name',
                'name' => 'submitter_name',
                'type' => 'text',
                'instructions' => 'Name of the person who submitted this',
                'required' => 1,
            ),

            // Submitter Email
            array(
                'key' => 'field_submitter_email',
                'label' => 'Submitter Email',
                'name' => 'submitter_email',
                'type' => 'email',
                'instructions' => 'Email address of the submitter',
                'required' => 1,
            ),

            // Submission Date
            array(
                'key' => 'field_submission_date',
                'label' => 'Submission Date',
                'name' => 'submission_date',
                'type' => 'date_time_picker',
                'instructions' => 'When this was submitted',
                'required' => 1,
                'display_format' => 'F j, Y g:i a',
                'return_format' => 'Y-m-d H:i:s',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'submission',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ));
}
add_action('acf/init', 'roadmap_register_submission_fields');
