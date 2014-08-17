<?php if (!empty($items)) { ?>
    <section class="simple-section with-header">
        <header>
            <h1><?php echo $name; ?> in the news</h1>
        </header>
        <div class="content-part">
            <ul class="news-list">
                <?php foreach ($items as $item) { ?>
                <li>
                    <img src="<?php echo $item['image_url']; ?>" alt="" class="left" />
                    <div class="news-text">
                        <?php echo $item['html']; ?>
                        <span class="date<?php echo isset($item['is_new']) && $item['is_new'] ? ' new' : ''; ?>"><?php echo $item['date_formatted']; ?></span>
                        <?php echo $item['source']; ?>
                    </div>
                </li>
                <?php } ?>
            </ul>
        </div>
        <footer>
            <a class="origin-button view-all-btn" href="<?php echo $news_link; ?>">view all news</a>
        </footer>
    </section>
<?php } ?>