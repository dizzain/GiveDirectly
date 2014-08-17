<?php if (!empty($items)) { ?>
    <section class="simple-section with-header">
        <header>
            <h1><?php echo $title; ?></h1>
        </header>
        <div class="content-part">
            <ul class="people-list">
                <?php $total = count($items); for ($i=0;$i<= ($total > 8 ? 7 : $total-1);$i++) { ?>
                    <li>
                        <a href="<?php echo Navigator::get_bobject_link($items[$i]['type'],$items[$i]['url']); ?>">
												<span class="logo-link">
													<img src="<?php echo $items[$i]['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($items[$i]['avatar_url'], 'avatar_74', 'company') : Utils::get_null_image('avatar_74','company'); ?>" alt=""/>
												</span>
                            <?php echo $items[$i]['name']; ?>
                            <?php echo isset($items[$i]['is_exited']) && $items[$i]['is_exited'] == 1 ? '<span class="grey-position">(exited)</span>' : ''; ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <?php if ($total > 8) { ?>

                <div class="tags-link">
                    <?php for ($i=8;$i<=($total > 24 ? 23 : $total-1);$i++) { ?>
                        <a href="<?php echo Navigator::get_bobject_link($items[$i]['type'],$items[$i]['url']); ?>"><?php echo $items[$i]['name']; ?><?php echo isset($items[$i]['is_exited']) && $items[$i]['is_exited'] == 1 ? ' (exited)' : ''; ?><?php echo $i < ($total > 24 ? 23 : $total-1) ? ', ' : ''; ?></a>
                    <?php } ?>
                </div>

            <?php } ?>


        </div>
        <?php /*if ($total > 24) { */?>
            <footer>
                <p><a class="origin-button view-all-btn" href="<?php echo $investments_link; ?>" class="more-link">view all</a></p>
            </footer>
        <?php /*} */?>
    </section>

<?php } ?>