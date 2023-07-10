<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Kargo
Description: Manage Kargo
Version: 0.1.1
Author: Ahmet Can ÇAKIR
Requires at least: 2.3.*
*/

define('KARGO_MODULE_NAME', 'kargo');


hooks()->add_action('admin_init', 'kargo_module_init_menu_items');
hooks()->add_action('admin_init', 'kargo_permissions');
hooks()->add_filter('module_kargo_action_links', 'module_kargo_action_links');

/**
 * Register activation module hook
 */
register_activation_hook(KARGO_MODULE_NAME, 'kargo_module_activation_hook');

/**
 * Add additional settings for this module in the module list area
 * @param  array $actions current actions
 * @return array
 */
function module_kargo_action_links($actions)
{
    if (has_permission('kargo', '', 'kargo_update')) {
        $actions[] = '<a href="' . admin_url('kargo/kargo_update') . '">' . _l('kargo_update') . '</a>';
    }

    return $actions;
}


function kargo_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

/**
 * Register language files, must be registered if the module is using languages
 */
register_language_files(KARGO_MODULE_NAME, [KARGO_MODULE_NAME]);

/**
 * Init kargo module menu items in setup in admin_init hook
 * @return null
 */
function kargo_module_init_menu_items()
{
    $CI = &get_instance();

    // if (has_permission('kargo', '', 'view')) {
    //     $CI->app_menu->add_sidebar_menu_item('kargo', [
    //         'collapse' => true,
    //         'name'     => _l('kargo'),
    //         'href'     => admin_url('kargo'),
    //         'icon'     => 'fa fa-desktop',
    //         'position' => 78,
    //     ]);
    //     // if (has_permission('kargo', '', 'foxtv_logs')) {
    //     //     $CI->app_menu->add_sidebar_children_item('kargo', [
    //     //             'slug'     => 'foxtv-logs',
    //     //             'name'     => _l('foxtv_logs'),
    //     //             'href'     => admin_url('kargo/foxtv_logs'),
    //     //             'position' => 20,
    //     //     ]);
    //     // }
    // }

    if (has_permission('kargo', '', 'view')) {
        $CI->app_menu->add_sidebar_menu_item('kargo', [
            'slug'     => 'kargo',
            'name'     => _l('kargo'),
            'href'     => admin_url('kargo/kargo_all'),
            'icon'     => 'fa fa-user-check',

            'position' => 82,
        ]);
    }

    // if (has_permission('kargo', '', 'foxtv_programs')) {
    //     $CI->app_menu->add_sidebar_children_item('system_care', [
    //             'slug'     => 'foxtv-programs',
    //             'name'     => _l('foxtv_programs'),
    //             'href'     => admin_url('kargo/foxtv_programs'),
    //             'position' => 40,
    //     ]);
    // }
    // if (has_permission('kargo', '', 'foxtv_episodes')) {
    //     $CI->app_menu->add_sidebar_children_item('system_care', [
    //             'slug'     => 'foxtv-episodes',
    //             'name'     => _l('foxtv_episodes'),
    //             'href'     => admin_url('kargo/foxtv_episodes'),
    //             'position' => 45,
    //     ]);
    // }
    // if (has_permission('kargo', '', 'foxtv_movies')) {
    //     $CI->app_menu->add_sidebar_children_item('system_care', [
    //             'slug'     => 'foxtv-movies',
    //             'name'     => _l('foxtv_movies'),
    //             'href'     => admin_url('kargo/foxtv_movies'),
    //             'position' => 50,
    //     ]);
    // }

}

function kargo_permissions()
{
    $capabilities = [];

    $capabilities['capabilities'] = [
        'view'   => _l('permission_view') . '(' . _l('permission_global') . ')',
        'kargo_list' => _l('kargo_list'),
        'kargo_hepsi_gor' => _l('kargo_list') .' ('._l('kargo_hepsi_gor').')',
        'kargo_programs_batch' => _l('kargo_programs') . '(' . _l('new_item_batch_process') . ')',
        'kargo_programs_general_control' => _l('kargo_programs') . '(' . _l('general_control') . ')',
        'kargo_programs_deleteAll' => _l('kargo_programs') . '(' . _l('record_delete_multiple') . ')',
        'kargo_programs_deactivate' => _l('kargo_programs') . '(' . _l('deactivate') . ')',

        'kargo_programs_record_update_id_number_multiple' => _l('kargo_programs') . '(' . _l('record_update_id_number_multiple') . ')',
        'kargo_programs_series_after_download_request' => _l('kargo_programs') . '(' . _l('series_after_download_request') . ')',
        'kargo_programs_remove_serie_from_main' => _l('kargo_programs') . '(' . _l('remove_serie_from_main') . ')',
        'kargo_programs_remove_serie_from_main_episodes' => _l('kargo_programs') . '(' . _l('remove_serie_from_main_episodes') . ')',
        'kargo_programs_update_remote_date' => _l('kargo_programs') . '(' . _l('update_remote_date') . ')',
        'kargo_programs_check_id_number' => _l('kargo_programs') . '(' . _l('check_id_number') . ')',
        'kargo_programs_make_selected_uncomplete' => _l('kargo_programs') . '(' . _l('make_selected_uncomplete') . ')',
        'kargo_programs_make_selected_complete' => _l('kargo_programs') . '(' . _l('make_selected_complete') . ')',
        'kargo_programs_change_categories' => _l('kargo_programs') . '(' . _l('change_categories') . ')',
        'kargo_programs_only_id_number' => _l('kargo_programs') . '(' . _l('only_id_number') . ')',
        'kargo_programs_details' => _l('kargo_programs') . '(' . _l('record_details') . ')',
        'kargo_programs_copy' => _l('kargo_programs') . '(' . _l('record_copy') . ')',
        'kargo_programs_ms_ready' => _l('kargo_programs') . '(' . _l('ms_ready') . ')',
        'kargo_programs_check_episodes_status' => _l('kargo_programs') . '(' . _l('check_episodes_status') . ')',
        'kargo_programs_go_to_site' => _l('kargo_programs') . '(' . _l('go_to_site') . ')',
        'kargo_programs_delete' => _l('kargo_programs') . '(' . _l('record_delete') . ')',
        'kargo_programs_update_remote_date' => _l('kargo_programs') . '(' . _l('update_remote_date') . ')',
        'kargo_programs_deactivate' => _l('kargo_programs') . '(' . _l('deactivate') . ')',
        'kargo_programs_is_active' => _l('kargo_programs') . '(' . _l('is_active') . ')',
        'kargo_programs_ms_ready' => _l('kargo_programs') . '(' . _l('ms_ready') . ')',
        'kargo_programs_is_archive' => _l('kargo_programs') . '(' . _l('is_archive') . ')',
        'kargo_programs_has_error' => _l('kargo_programs') . '(' . _l('has_error') . ')',
        'kargo_programs_ana_sistem_go' => _l('kargo_programs') . '(' . _l('ana_sistem_go') . ')',
        'kargo_programs_url_export'    => _l('kargo_programs').'('._l('url_export').')',

        'kargo_episodes' => _l('kargo_episodes'),
        'kargo_episodes_batch' => _l('kargo_episodes') . '(' . _l('new_item_batch_process') . ')',
        'kargo_episodes_order_with_title' => _l('kargo_episodes') . '(' . _l('order_with_title') . ')',
        'kargo_episodes_order_with_first' => _l('kargo_episodes') . '(' . _l('order_with_first') . ')',
        'kargo_episodes_series_after_download_request' => _l('kargo_episodes') . '(' . _l('series_after_download_request') . ')',
        'kargo_episodes_reset_all_errors' => _l('kargo_episodes') . '(' . _l('reset_all_errors') . ')',
        'kargo_episodes_save' => _l('kargo_episodes') . '(' . _l('save') . ')',
        'kargo_episodes_is_complated' => _l('kargo_episodes') . '(' . _l('is_complated') . ')',
        'kargo_episodes_has_error' => _l('kargo_episodes') . '(' . _l('has_error') . ')',
        'kargo_episodes_video_preview' => _l('kargo_episodes') . '(' . _l('video_preview') . ')',
        'kargo_episodes_details' => _l('kargo_episodes') . '(' . _l('record_details') . ')',
        'kargo_episodes_copy' => _l('kargo_episodes') . '(' . _l('record_copy') . ')',
        'kargo_episodes_after_download_request' => _l('kargo_episodes') . '(' . _l('after_download_request') . ')',
        'kargo_episodes_delete' => _l('kargo_episodes') . '(' . _l('record_delete') . ')',
        'kargo_episodes_deleteAll' => _l('kargo_episodes') . '(' . _l('record_delete_multiple') . ')',

        'kargo_movies' => _l('kargo_movies'),
        'kargo_movies_batch' => _l('kargo_movies') . '(' . _l('new_item_batch_process') . ')',
        'kargo_movies_check_id_number' => _l('kargo_movies') . '(' . _l('check_id_number') . ')',
        'kargo_movies_record_update_id_number_multiple' => _l('kargo_movies') . '(' . _l('record_update_id_number_multiple') . ')',
        'kargo_movies_remove_serie_from_main' => _l('kargo_movies') . '(' . _l('remove_serie_from_main') . ')',
        'kargo_movies_update_remote_date' => _l('kargo_movies') . '(' . _l('update_remote_date') . ')',
        'kargo_movies_fill_categories' => _l('kargo_movies') . '(' . _l('fill_categories') . ')',
        'kargo_movies_change_categories' => _l('kargo_movies') . '(' . _l('change_categories') . ')',
        'kargo_movies_details' => _l('kargo_movies') . '(' . _l('record_details') . ')',
        'kargo_movies_copy' => _l('kargo_movies') . '(' . _l('record_copy') . ')',
        'kargo_movies_delete' => _l('kargo_movies') . '(' . _l('record_delete') . ')',
        'kargo_movies_deleteAll' => _l('kargo_movies') . '(' . _l('record_delete_multiple') . ')',
        'kargo_movies_has_error' => _l('kargo_movies') . '(' . _l('has_error') . ')',
        'kargo_movies_is_archive' => _l('kargo_movies') . '(' . _l('is_archive') . ')',
        'kargo_movies_is_complated' => _l('kargo_movies') . '(' . _l('is_complated') . ')',
        'kargo_movies_is_active' => _l('kargo_movies') . '(' . _l('is_active') . ')',
        'kargo_movies_url_export'    => _l('kargo_movies').'('._l('url_export').')',

        'kargo_module_settings' => _l('kargo_module_settings'),
        'kargo_module_settings_details' =>  _l('kargo_module_settings') . '(' . _l('record_details') . ')',
        'kargo_update' => _l('kargo_update'),
    ];

    register_staff_capabilities('kargo', $capabilities, _l('kargo'));
}

if (!function_exists('str_starts_with')) {
    function str_starts_with(string $haystack, string $needle)
    {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }
}
