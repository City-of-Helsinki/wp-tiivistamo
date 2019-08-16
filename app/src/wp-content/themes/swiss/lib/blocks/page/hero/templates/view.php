<section class="b-hero">

    <div class="b-hero__background" style="background-image:url(<?php echo  $block->getImageUrl('hero-extra-large', 'background_image'); ?>);"></div>

    <div class="b-hero__content">
        <div class="b-hero__container">
            <div class="b-hero__intro">
                <?php echo \Evermade\Swiss\sprint('<div class="h-wysiwyg-html" data-scheme-target>%s</div>', $block->get('text')); ?>
            </div>
            <div class="b-hero__meta">
                <div class="b-hero__video-link">
                    <div class="c-video-link">
                        <?php echo \Evermade\Swiss\sprint('<h4 class="c-video-link__title">%s</h4>', $block->get('video_title'));?>
                        <?php echo \Evermade\Swiss\sprint('<div class="c-video-link__image" style="background-image:url(%s);"></div>', $block->getImageUrl('medium-large', 'video_thumbnail'));?>
                        <?php echo \Evermade\Swiss\sprint('<a target="_blank" class="c-video-link__link c-cta-link" href="%s" title="%s">%s</a>', array(
                            $block->get('video_link_url'),
                            $block->get('video_link_text'),
                            $block->get('video_link_text')
                        ));?>
                    </div>
                </div>
                <?php if($block->get('countdown')): ?>
                    <div class="b-hero__countdown">
                        <?php echo \Evermade\Swiss\template('_countdown.php', \Evermade\Swiss\dateCounter(get_field('countdown', 'option')));?>
                    </div>
                <?php endif; ?>
                <?php if($block->get('opening_hours')): ?>
                    <div class="b-hero__opening-hours">
                        <?php echo $block->get('opening_hours'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</section><!-- end of b-hero -->
