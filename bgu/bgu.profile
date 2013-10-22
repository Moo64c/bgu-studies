<?php
/**
 * @file
 * BGU profile.
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

  $tasks['bgu_setup_menus'] = array(
    'display_name' => st('Create menu items'),
    'display' => FALSE,
  );

  $tasks['bgu_setup_blocks'] = array(
    'display_name' => st('Setup Blocks'),
    'display' => FALSE,
  );

  $tasks['bgu_settings'] = array(
    'display_name' => st('Set various settings'),
    'display' => FALSE,
  );

  $tasks['bgu_setup_languages'] = array(
    'display_name' => st('Setup languages'),
    'display' => FALSE,
  );

  return $tasks;
}

/**
 * Profile task; Setup blocks.
 */
function bgu_setup_blocks() {
  $default_theme = variable_get('theme_default', 'bgu_omega');

  $blocks[] = array(
    'module' => 'search',
    'delta' => 'form',
    'theme' => $default_theme,
    'status' => TRUE,
    'weight' => 0,
    'region' => 'navigation',
    'visibility' => 0,
    'pages' => '',
    'title' => '<none>',
    'cache' => DRUPAL_NO_CACHE,
  );

  $blocks[] = array(
    'module' => 'panels_mini',
    'delta' => 'footer',
    'theme' => $default_theme,
    'status' => TRUE,
    'weight' => 0,
    'region' => 'footer',
    'visibility' => 0,
    'pages' => '',
    'title' => '<none>',
    'cache' => DRUPAL_NO_CACHE,
  );

  drupal_static_reset();
  _block_rehash($default_theme);
  foreach ($blocks as $record) {
    db_merge('block')
      ->fields($record)
      ->condition('module', $record['module'])
      ->condition('delta', $record['delta'])
      ->condition('theme', $record['theme'])
      ->execute();
  }
}

/**
 * Profile task; create menu links.
 */
function bgu_setup_menus() {

  // Main menu.
  $item = array(
    'link_title' => 'Home',
    'link_path' => '<front>',
    'menu_name' => 'main-menu',
    'weight' => -100,
  );
  menu_link_save($item);
}

/**
 * Profile task; Set various settings.
 */
function bgu_settings() {
  $variables = array(

    // Search settings.
    'search_active_modules' => array('apachesolr_search' => 'apachesolr_search'),
    'search_default_module' => 'apachesolr_search',
  );

  foreach ($variables as $variable => $value) {
    variable_set($variable, $value);
  }
}

/**
 * Task callback; Setup languages.
 */
function bgu_setup_languages() {
  locale_add_language('id');

  $language_negotiation = array(
    'locale-url' => array(
      'callbacks' => array(
        'language' => 'locale_language_from_url',
        'switcher' => 'locale_language_switcher_url',
        'url_rewrite' => 'locale_language_url_rewrite_url',
      ),
      'file' => 'includes/locale.inc',
    ),
    'language-default' => array(
      'callbacks' => array(
        'language' => 'language_from_default',
      ),
    ),
  );
  variable_set('language_negotiation_language', $language_negotiation);
}
