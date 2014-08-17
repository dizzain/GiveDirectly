<?php if (!empty($about)) { ?>
    <section class="simple-section with-header">
        <header>
            <h1>About</h1>
        </header>
        <div class="content-part" data-toggle2="true">
            <?php echo Utils::replace_links($about); ?>
        </div>
        <footer>
            <a href="#" data-toggle2-button="more-info" data-original-text="more information">more information &raquo;</a>
        </footer>
    </section>
<?php } ?>