<?php global $app; ?>
<header class="b-site-header js-site-header">
    <div class="b-site-header__container">
        <a class="b-site-header__logo" style="background-image: url('<?php the_field('opt_logo', 'options') ?>')" href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a>

        <div class="b-site-header__slogan">
            <?php echo \Evermade\Swiss\template('_slogan.php'); ?>
        </div>

        <?php if ( !empty(get_field('opt_opening_times_link', 'option') ) ): ?>
              <div class="b-site-header__opening-times-wrapper" id="opening-times"></div>
        <?php endif; ?>

        <div class="b-site-header__extras">
            <?php echo \Evermade\Swiss\wpmlLanguageSwitcher(); ?>
            <?php echo \Evermade\Swiss\template('_social-media.php', $app->get('opt_social_media')); ?>
        </div>
    </div>
</header>
