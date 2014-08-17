<?php if ($followers && !empty($followers) && $can_see_followers) { ?>

    <section class="simple-section with-header">
        <header>
            <h1>Who's tracking <?php echo $company_name; ?></h1>
        </header>
        <div class="content-part">
            <ul class="people-list">
                <?php $total = count($followers); for ($i=0;$i<= ($total > 4 ? 3 : $total-1);$i++) { ?>
                    <li>
                        <a href="<?php echo Navigator::get_bobject_link($followers[$i]['type'],$followers[$i]['profile_url']); ?>">
							<span class="logo-link">
								<img src="<?php echo $followers[$i]['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($followers[$i]['avatar_url'], 'avatar_74', 'user') : Utils::get_null_image('avatar_74','user'); ?>" alt=""/>
							</span>
                            <?php echo $followers[$i]['name']; ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <?php if ($total > 4) { ?>

                <div class="tags-link">
                    <?php for ($i=4;$i<=($total > 24 ? 23 : $total-1);$i++) { ?>
                        <a href="<?php echo Navigator::get_bobject_link($followers[$i]['type'],$followers[$i]['profile_url']); ?>"><?php echo $followers[$i]['name']; ?><?php echo $i+1 < $total ? ', ' : ''; ?></a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <?php if ($total > 24) { ?>
            <footer>
                <p><a href="<?php echo $followers_link; ?>" class="origin-button view-all-btn more-link">view all</a></p>
            </footer>
        <?php } ?>
    </section>

<?php } ?>