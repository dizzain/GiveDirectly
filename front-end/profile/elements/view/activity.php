<?php if (!empty($activities)) { ?>

    <section class="simple-section with-header">
        <header>
            <h1><?php echo $name; ?> updates</h1>
        </header>
        <div class="content-part">
            <ul class="updates-list">
                <?php for ($i=0;$i<=count($activities)-1;$i++) { ?>
                <li>
                    <p><?php echo Utils::replace_links($activities[$i]['html']); ?></p>
                    <span class="time"><?php echo $activities[$i]['date_formatted']; ?></span>
                </li>
                <?php if ($i==2) { ?>
            </ul><ul  class="updates-list hide-text"  data-text="more-info">
                <?php } ?>
                <?php } ?>
            </ul>
        </div>
        <footer>
            <a href="#"  data-link="more-info" data-original-text="view all updates">view all updates &raquo;</a>
        </footer>
    </section>

<?php } ?>