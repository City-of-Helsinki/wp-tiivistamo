<?php
    global $app;
?>
</div><!-- end of .page-content -->

<footer class="b-footer">
    <div class="b-footer__container">
        <div class="b-footer__navcontainer">
            <a href="#" class="c-back-to-top js-back-to-top" title="<?php _e('Back to top', 'swiss');?>"></a>

            <div class="b-footer__logo">
                <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>">
                    <img alt="<?php _e('Tiivistämö', 'swiss');?>" src="<?php the_field('opt_logo_footer', 'option') ?>" alt="<?php bloginfo('name'); ?>">
                </a>
            </div>
            <nav class="b-footer__navigation" aria-label="<?php _e('Footer navigation', 'swiss');?>">
                <?php wp_nav_menu(array(
                    'theme_location' => 'footer-navigation',
                        'menu_class' => 'c-page-navigation-footer',
                        'container' => '',
                        'fallback_cb' => false,
                        'depth' => 1
                    )); ?>
            </nav>
        </div>

        <div class="b-footer__lower">
            <div class="b-footer__logos">
                <div class="b-footer__logos-item b-footer__logos-item--helsinki">
                    <img class="b-footer__logos-item__logo--helsinki" alt="<?php _e('Tiivistämö', 'swiss');?>" src="
                        <?php
                            global $sitepress;
                            $logo = $sitepress->get_current_language() == 'sv' ? 'tiivistamo_logo_FHD.png' : 'tiivistamo_logo_FHD.png';
                            echo get_template_directory_uri() . '/assets/img/' . $logo;
                        ?>"
                        alt="<?php bloginfo('name'); ?>">
                </div>

            </div>

            <div class="b-footer__copyright">
                <div class="b-footer__copyright__item b-footer__copyright__item--copyright">
                    <p>&copy; <?php _e('Copyright', 'swiss');?> <?php echo date('Y');?>&nbsp;•&nbsp;<?php bloginfo('name'); ?>&nbsp;•&nbsp;<?php _e('All rights reserved', 'swiss');?>.</p>
                    <?php if( have_rows('footer_links', 'option') ): ?>
                        <?php while( have_rows('footer_links', 'option') ): the_row(); ?>
                            &nbsp;•&nbsp;<a href="<?php the_sub_field('link_url'); ?>"><?php the_sub_field('link_text'); ?></a>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <p>&nbsp;•&nbsp;<?php _e('Website crafted by', 'swiss');?> <a href="https://www.evermade.fi" target="_blank" rel="noopener noreferrer">Evermade</a>.</p>
                </div>
                <div class="b-footer__copyright__item b-footer__copyright__item--social">
                    <?php echo \Evermade\Swiss\template('_social-media.php', $app->get('opt_social_media')); ?>
                    <?php echo \Evermade\Swiss\sprint('<a class="c-btn c-btn--arrow" href="%s">%s</a>', array(
                        get_field('opt_feedback_link', 'option'),
                            __('Give feedback', 'swiss')
                        ));?>
                </div>
            </div>
        </div>

    </div>
</footer><!-- end of footer -->

<?php include(get_template_directory().'/templates/modals.php'); ?>

<?php include(get_template_directory().'/templates/foot.php'); ?>
