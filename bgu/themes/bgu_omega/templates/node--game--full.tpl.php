<div class="top-wrapper clearfix">
  <div class="score">
    <?php print $metacritic_score; ?>
    <div class="score-number"><?php print $score; ?></div>
  </div>

  <div class="votes">
    <div class="users-score">
      <div class="title">
        <?php print $users_score; ?>
      </div>
      <div class="number">
        <div><?php print $users_score_number; ?></div>
      </div>
    </div>

    <div class="your-score">
      <div class="title">
        <?php print $your_score; ?>
        <div class="slider"><?php print render($content['field_rating']); ?></div>
      </div>
      <div class="number"><?php print t('- -'); ?></div>
    </div>
  </div>

  <div class="ribbon first"></div>
  <div class="ribbon"></div>
</div>

<div class="bottom-wrapper clearfix">
  <div class="game-image">
    <?php print $game_image; ?>
  </div>
  <div class="details">
    <div class="game-title"><?php print $title; ?></div>
    <div class="game-data">
      <?php print $game_data; ?>
    </div>
  </div>
</div>
<?php if (!empty($buy_game_url)): ?>
  <a href="<?php print $buy_game_url; ?>">
    <div class="buy-game-wrapper">
      <div class="buy-game"><span class="cart" /></span><span><?php print t('Buy this Game'); ?></span></div>
    </div>
  </a>
<?php endif; ?>
