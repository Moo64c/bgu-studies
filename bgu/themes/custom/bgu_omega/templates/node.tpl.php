<div<?php print $attributes; ?>>
  <?php print $user_picture; ?>

  <?php if (empty($hide_title)): ?>
    <?php print render($title_prefix); ?>
    <?php if (!$page): ?>
      <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
    <?php endif; ?>
    <?php print render($title_suffix); ?>
  <?php endif; ?>

  <?php if ($display_submitted): ?>
    <div class="submitted">
      <?php print $submitted; ?>
    </div>
  <?php endif; ?>

  <div class="panel-box">
    <div<?php print $content_attributes; ?>>
      <?php
        // We hide the comments and links now so that we can render them later.
        hide($content['comments']);
        hide($content['links']);
        print render($content);
      ?>
    </div>
  </div>

  <?php if (empty($hide_links)): ?>
    <?php print render($content['links']); ?>
  <?php endif; ?>

  <?php if (empty($hide_comments)): ?>
    <?php print render($content['comments']); ?>
  <?php endif; ?>
</div>
