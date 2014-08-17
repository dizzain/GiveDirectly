<?php if (!empty($items)) { ?>

    <section class="simple-section with-header">
        <header>
            <h1><?php echo $name; ?> companies</h1>
        </header>
        <div class="content-part">
            <ul class="people-list">
                <?php $total = count($items); for ($i=0;$i<= ($total > 4 ? 3 : $total-1);$i++) { ?>
                    <li>
                        <a href="<?php echo Navigator::get_bobject_link($items[$i]['type'],$items[$i]['url']); ?>">
												<span class="logo-link">
													<img src="<?php echo $items[$i]['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($items[$i]['avatar_url'], 'avatar_74', 'company') : Utils::get_null_image('avatar_74','company'); ?>" alt=""/>
												</span>
                            <?php echo $items[$i]['name']; ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <?php if ($total > 4) { ?>

                <div class="tags-link">
                    <?php for ($i=4;$i<=($total > 24 ? 23 : $total-1);$i++) { ?>
                        <a href="<?php echo Navigator::get_bobject_link($items[$i]['type'],$items[$i]['url']); ?>"><?php echo $items[$i]['name']; ?><?php echo $i+1 < $total ? ', ' : ''; ?></a>
                    <?php } ?>
                </div>
                <?php if ($total > 24) { ?>
                    <?php for ($i=24;$i<=($total-1);$i++) { ?>
                        <div class="hide-text tags-link" data-text="more-info">
                            <a href="<?php echo Navigator::get_bobject_link($items[$i]['type'],$items[$i]['url']); ?>"><?php echo $items[$i]['name']; ?><?php echo $i+1 < $total ? ', ' : ''; ?></a>
                        </div>
                    <?php } ?>
                <?php } ?>

            <?php } ?>
            <?php if ($total > 24) { ?>
                <p><a href="#" class="more-link" data-link="more-link" data-original-text="<?php echo $total-24; ?> more…"><?php echo $total-24; ?> more…</a></p>
            <?php } ?>


        </div>
    </section>

<?php } ?>