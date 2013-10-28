<?php
/**
 * @file
 * bgu_base.features.wysiwyg.inc
 */

/**
 * Implements hook_wysiwyg_default_profiles().
 */
function bgu_base_wysiwyg_default_profiles() {
  $profiles = array();

  // Exported profile: math
  $profiles['math'] = array(
    'format' => 'math',
    'editor' => 'tinymce',
    'settings' => array(
      'default' => 1,
      'user_choose' => 0,
      'show_toggle' => 1,
      'theme' => 'advanced',
      'language' => 'en',
      'buttons' => array(
        'default' => array(
          'justifyleft' => 1,
          'justifycenter' => 1,
          'justifyright' => 1,
          'code' => 1,
        ),
        'directionality' => array(
          'ltr' => 1,
          'rtl' => 1,
        ),
        'asciimath' => array(
          'asciimath' => 1,
          'asciimathcharmap' => 1,
        ),
        'asciisvg' => array(
          'asciisvg' => 1,
        ),
      ),
      'toolbar_loc' => 'top',
      'toolbar_align' => 'left',
      'path_loc' => 'bottom',
      'resizing' => 1,
      'verify_html' => 1,
      'preformatted' => 0,
      'convert_fonts_to_spans' => 1,
      'remove_linebreaks' => 1,
      'apply_source_formatting' => 0,
      'paste_auto_cleanup_on_paste' => 0,
      'block_formats' => 'p,address,pre,h2,h3,h4,h5,h6,div',
      'css_setting' => 'theme',
      'css_path' => '',
      'css_classes' => '',
    ),
    'rdf_mapping' => array(),
  );

  return $profiles;
}
