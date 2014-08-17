<?php if (isset($media) && !empty($media)) { ?>

    <section class="simple-section with-header">
        <header class="without-border">
            <h1>Media materials</h1>
        </header>

        <div class="slider-part">
            <div class="flexslider slider" data-slider="slider">
                <ul class="slides">
                    <?php foreach ($media as $media_item) { ?>
                        <li>
                            <?php if (!empty($media_item['description'])) { ?>
                                <span class="media-caption"><?php echo $media_item['description']; ?></span>
                            <?php } ?>
                            <?php echo $media_item['code']; ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <ul class="jcarousel-skin-tango" data-slider="carousel">
                <?php foreach ($media as $key=>$media_item) { ?>
                    <li<?php echo $key == 0 ? ' class="active"' : ''; ?>><img src="<?php echo $media_item['icon']; ?>" alt="" width="68" height="68" /></li>
                <?php } ?>
            </ul>
        </div>
    </section>

<?php } ?>