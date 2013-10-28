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

  // Video teaser.
  if ($variables['type'] == 'video' && $variables['view_mode'] == 'teaser') {
    $variables['display_submitted'] = FALSE;
    $variables['hide_title'] = TRUE;
    $variables['hide_links'] = TRUE;
    $variables['hide_comments'] = TRUE;
  }
  // Game in search results.
  if ($variables['type'] == 'game' && in_array($variables['view_mode'], array('extra_search_results_data', 'teaser'))) {
    $variables['display_submitted'] = FALSE;
    $variables['hide_title'] = TRUE;
    $variables['hide_links'] = TRUE;
    $variables['hide_comments'] = TRUE;
  }
}

/**
 * Node preprocess.
 *
 * @see bgu_omega_preprocess_node()
 */
function bgu_omega_preprocess_node_video_large_teaser(&$variables) {
  $term = taxonomy_term_load($variables['field_category'][LANGUAGE_NONE][0]['target_id']);
  $variables['category'] = $term->name;

  // Fetch content from the video's game node.
  $node = node_load($variables['field_game'][LANGUAGE_NONE][0]['target_id']);
  $wrapper =entity_metadata_wrapper('node', $variables['nid']);
  $variables['title'] = $wrapper->field_subtitle->value();
  $variables['front_page'] = drupal_is_front_page();

  bgu_omega_video_description_by_game($variables, $node);
}

/**
 * Node preprocess.
 *
 * @see bgu_omega_preprocess_node()
 */
function bgu_omega_preprocess_node_video_full(&$variables) {
  $term = taxonomy_term_load($variables['field_category'][LANGUAGE_NONE][0]['target_id']);
  $variables['category'] = $term->name;
  $node = node_load($variables['field_game'][0]['target_id']);

  bgu_omega_video_description_by_game($variables, $node);
}

/**
 * Helper function for return variables for the node tpl files.
 *
 * @param $variables
 *   The preprocess variables, passed by reference.
 * @param $node
 *   The Game node object.
 */
function bgu_omega_video_description_by_game(&$variables, $node) {
  $wrapper = entity_metadata_wrapper('node', $node);

  $variables['comment_count'] = l(format_plural($node->comment_count, '1 comment', '@count comments'), 'node/' . $variables['nid']);

  $variables['game_description'] = '';
  if ($value = $wrapper->field_description->value()) {
    $variables['game_description'] = $wrapper->field_description->value->value();
  }

  $variables['read_more'] = l(t('Read more...'), 'node/' . $variables['nid']);
  $date = date(variable_get('date_format_short'), $variables['created']);
  $variables['submitted'] = t('Uploaded on @date', array('@date' => $date));

  $node->service_links = service_links_render($node, TRUE);
  $variables['service_links'] = theme('service_links_node_format', array('links' => $node->service_links));
}

/**
 * Node preprocess.
 *
 * @see bgu_omega_preprocess_node()
 */
function bgu_omega_preprocess_node_game_full(&$variables) {
  $variables['metacritic_score'] = l(t('Metacritic'), 'http://www.metacritic.com/', array('attributes' => array('target' => '_blank'))) . t(' Score');
  $variables['ranked'] = t('Ranked');
  $variables['users_score'] = t('Users Score');
  $variables['your_score'] = t('Your score');

  // Count the votes on the game.
  $votes = votingapi_select_votes(array('entity_id' => $variables['nid']));
  $votes_count = count($votes);

  // Calculate average score.
  $total_score = 0;
  foreach ($votes as $vote) {
    $total_score += $vote['value'];
  }

  $variables['users_score_number'] = $votes_count ? round($total_score / $votes_count) : t('- -');

  $variables['buy_this_game'] = t('But this Game');
  $variables['score'] = !empty($variables['field_grade'][0]['value']) ? $variables['field_grade'][0]['value'] : '';
  $variables['game_image'] = drupal_render($variables['content']['field_box_image']);

  $variables['game_data'] = '';

  $items = array();
  $field_names = array(
    t('Console') => 'field_consoles',
    t('Genre') => 'field_genre',
    t('R.Date') => 'field_launch_date',
    t('Pub. by') => 'field_publisher',
    t('Dev. by') => 'field_developer',
  );

  foreach ($field_names as $field_title => $field_name) {
    if (empty($variables['content'][$field_name][0]['#markup'])) {
      continue;
    }
    $items[] = '<span class="title">' . $field_title . ': </span>' . $variables['content'][$field_name][0]['#markup'];
  }

  if ($items) {
    $variables['game_data'] = theme('item_list', array('items' => $items));
  }
  if (isset($variables['field_buy_game'][0])) {
    $variables['buy_game_url'] = $variables['field_buy_game'][0]['value'];
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

/**
 * Comment preprocess.
 */
function bgu_omega_preprocess_comment(&$variables) {
  $comment = $variables['comment'];

  $variables['content']['created'] = t('@time ago', array('@time' => format_interval(time() - $comment->created)));
  $variables['author'] = $comment->name;
}
