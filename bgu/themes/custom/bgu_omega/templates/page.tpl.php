<div id="top-frame"></div>

<div class="container">
  <header id="header-first" role="banner">
    <?php print render($page['header_first']); ?>
  </header>

  <header id="header-last" role="banner">
    <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo"></a>

    <?php print render($page['header_last']); ?>
  </header>

  <?php if(isset($page['breadcrumbs'])): ?>
    <div id="breadcrumbs"><?php print $page['breadcrumbs']; ?></div>
  <?php endif; ?>

  <div id="main" class="clearfix <?php if(isset($page['breadcrumbs'])): ?>breadcrumbs<?php endif; ?>">
    <div id="main-content" role="main">

      <a id="main-content-anchor"></a>

      <?php print $messages; ?>
      <?php print render($tabs); ?>
      <?php print render($page['help']); ?>
      <?php if ($action_links): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>

      <?php print render($page['content']); ?>

      <?php print render($page['content_last']); ?>
    </div>

    <?php if (render($page['sidebar_second'])): ?>
      <aside class="sidebars">
        <?php print render($page['sidebar_second']); ?>
      </aside>
    <?php endif; ?>
  </div>

  <?php print render($page['content_bottom']); ?>
</div>

<div id="footer-first">
  <div class="container">
    <?php print render($page['footer_first']); ?>
  </div>
</div>

<div id="footer-last">
  <div class="container">
    <?php print render($page['footer_last']); ?>
  </div>
</div>

<div id="bottom-frame"></div>