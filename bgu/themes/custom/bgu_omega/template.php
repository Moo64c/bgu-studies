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
  else {
    $item = menu_get_item();
    if (in_array($item['path'], array('console', 'review'))) {
      // Load the term, to show its name properly.
      $vocabulary = $item['map'][0] == 'console' ? 'consoles' : 'categories';
      if ($terms = taxonomy_get_term_by_name($item['map'][1], $vocabulary)) {
        $term = reset($terms);
        $items = array(t('@term Videos', array('@term' => $term->name)));
      }
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

  if ($variables['type'] == 'webform') {
    $variables['display_submitted'] = FALSE;
    $variables['hide_links'] = TRUE;
  }
}
