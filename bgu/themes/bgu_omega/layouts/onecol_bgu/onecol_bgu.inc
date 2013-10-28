<?php

/**
 * implementation of hook_panels_layouts()
 */
// Plugin definition
$plugin = array(
  'title' => t('Single column hirotv'),
  'category' => t('HiroTV'),
  'icon' => 'onecol.png',
  'theme' => 'panels_onecol_hirotv',
  'css' => 'onecol.css',
  'regions' => array(
    'top' => t('Top column'),
    'middle' => t('Middle column'),
  ),
);
