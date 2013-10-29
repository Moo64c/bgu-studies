<?php

/**
 * @file
 * Template overrides as well as (pre-)process and alter hooks for the
 * Default Omega Starterkit theme.
 */

/**
 * Page preprocess.
 *
 * Fetch page breadcrumbs.
 */
function bgu_omega_preprocess_page(&$variables) {
  $node = menu_get_object();
  if ($node) {
    $function = "bgu_{$node->type}_get_breadcrumbs_list";
    if (function_exists($function)) {
      $items = $function($node);
    }
  }

  if (!empty($items)) {
    $variables['page']['breadcrumbs'] = bgu_page_format_breadcrumbs($items);
  }
}

/**
 * Node preprocess.
 */
function bgu_omega_preprocess_node(&$variables) {
  array_unshift($variables['theme_hook_suggestions'], 'node__' . $variables['type'] . '__' . $variables['view_mode']);
  $preprocess_function = 'bgu_omega_preprocess_node_' . $variables['type'] . '_' . $variables['view_mode'];

  if (function_exists($preprocess_function)) {
    $preprocess_function($variables);
  }
}

/**
 * Returns HTML for a button form element.
 *
 * @see theme_button()
 */
function bgu_omega_button($variables) {
  return '<div class="button-wrapper">' . theme_button($variables) . '</div>';
}
