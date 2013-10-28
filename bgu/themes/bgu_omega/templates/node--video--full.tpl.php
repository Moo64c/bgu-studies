<div<?php print $attributes; ?>>

  <div<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      print render($content);
    ?>
  </div>

  <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>

  <div class="details">
    <span><?php print $category; ?></span> | <span><?php print $submitted; ?></span> | <span class="comments-symbol"></span> <span><?php print $comment_count; ?></span>
  </div>

  <div class="service-links clearfix">
    <?php print $service_links; ?>
  </div>

  <div class="description">
    <?php print $game_description; ?>
    <?php print $read_more; ?>
  </div>

</div>
