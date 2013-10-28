<?php
/**
 * @file
 * bgu profile.
 */

/**
 * Implements hook_form_FORM_ID_alter().
 *
 * Allows the profile to alter the site configuration form.
 */
function bgu_form_install_configure_form_alter(&$form, $form_state) {
  // Pre-populate the site name with the server name.
  $form['site_information']['site_name']['#default_value'] = $_SERVER['SERVER_NAME'];
}

/**
 * Implements hook_install_tasks().
 */
function bgu_install_tasks() {
  $tasks = array();

  $tasks['bgu_setup_blocks'] = array(
    'display_name' => st('Setup Blocks'),
    'display' => FALSE,
  );

  return $tasks;
}

/**
 * Task callback; Setup blocks.
 */
function bgu_setup_blocks() {
  $default_theme = variable_get('theme_default', 'bgu_omega');

  $blocks[] = array(
    'module' => 'panels_mini',
    'delta' => 'categories',
    'theme' => $default_theme,
    'status' => 1,
    'weight' => 0,
    'region' => 'header_first',
    'visibility' => 0,
    'title' => '<none>',
    'cache' => DRUPAL_NO_CACHE,
  );

  $blocks[] = array(
    'module' => 'panels_mini',
    'delta' => 'consoles',
    'theme' => $default_theme,
    'status' => 1,
    'weight' => 0,
    'region' => 'header_last',
    'visibility' => 0,
    'title' => '<none>',
    'cache' => DRUPAL_NO_CACHE,
  );

  $blocks[] = array(
    'module' => 'panels_mini',
    'delta' => 'footer_categories',
    'theme' => $default_theme,
    'status' => 1,
    'weight' => 0,
    'region' => 'footer_first',
    'visibility' => 0,
    'title' => '',
    'cache' => DRUPAL_NO_CACHE,
  );

  $blocks[] = array(
    'module' => 'mailchimp_lists',
    // @TODO: Change to real list.
    'delta' => $mail_list = variable_get('mailchimp_newletter_list', 'newsletter'),
    'theme' => $default_theme,
    'status' => 1,
    'weight' => 3,
    'region' => 'footer_first',
    'visibility' => 0,
    'title' => '',
    'cache' => DRUPAL_NO_CACHE,
  );

  $blocks[] = array(
    'module' => 'panels_mini',
    'delta' => 'bottom',
    'theme' => $default_theme,
    'status' => 1,
    'weight' => 0,
    'region' => 'footer_last',
    'visibility' => 0,
    'title' => '<none>',
    'cache' => DRUPAL_NO_CACHE,
  );

  drupal_static_reset();
  _block_rehash($default_theme);
  foreach ($blocks as $record) {
    $module = array_shift($record);
    $delta = array_shift($record);
    $theme = array_shift($record);
    db_update('block')
      ->fields($record)
      ->condition('module', $module)
      ->condition('delta', $delta)
      ->condition('theme', $theme)
      ->execute();
  }
}
