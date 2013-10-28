<div class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <div class="title">
    <span class="author"><?php print $author; ?></span> - <span class="submitted"><?php print $content['created']; ?></span>
  </div>

  <div class="content"<?php print $content_attributes; ?>>
    <?php print render($content['comment_body']); ?>

    <?php if ($signature): ?>
    <div class="user-signature clearfix">
      <?php print $signature; ?>
    </div>
    <?php endif; ?>
  </div>
  <?php print $comment->vud_comment_widget; ?>
  <?php print render($content['links']); ?>
</div>
