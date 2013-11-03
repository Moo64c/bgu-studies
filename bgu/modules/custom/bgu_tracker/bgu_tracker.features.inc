<?php
/**
 * @file
 * bgu_tracker.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function bgu_tracker_ctools_plugin_api() {
  list($module, $api) = func_get_args();
  if ($module == "strongarm" && $api == "strongarm") {
    return array("version" => "1");
  }
}

/**
 * Implements hook_node_info().
 */
function bgu_tracker_node_info() {
  $items = array(
    'tracker' => array(
      'name' => t('Tracker'),
      'base' => 'node_content',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  return $items;
}
