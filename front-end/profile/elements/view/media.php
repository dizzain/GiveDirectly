<?php if (isset($media) && !empty($media)) { ?>
    <section class="simple-section with-header">
        <header>
            <h1>Media materials</h1>
        </header>
        <div class="content-part tabs-container">
            <div id="tabs">
                <div id="tabs_container">
                    <?php foreach ($media as $media_item) { ?>
                        <div id="tabs-<?php echo $media_item['id']; ?>" style="display: none;">
                            <?php if (!empty($media_item['description'])) { ?>
                                <p><?php echo $media_item['description']; ?></p>
                            <?php } ?>
                            <?php echo $media_item['code']; ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="bottom-part-tab" data-scroll="true">
                    <ul class="slides-list">
                        <?php foreach ($media as $media_item) { ?>
                            <li>
                                <a href="#tabs-<?php echo $media_item['id']; ?>" class="tabs-li<?php echo $media_item['type'] == 'files' ? ' lets-open-media' : ''; ?>"<?php echo $media_item['type'] == 'files' ? ' data-media-url="'.$media_item['url'].'"' : ''; ?> data-media-id="<?php echo $media_item['id']; ?>" title="">
                                    <img src="<?php echo $media_item['icon']; ?>" alt="" width="69" height="69" />
                                    <span><?php echo $media_item['description']; ?></span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

    </section>

<?php } ?>