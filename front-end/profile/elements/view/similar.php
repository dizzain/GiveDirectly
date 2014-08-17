<?php if (!empty($items)) { ?>
    <header>
        <h3><?php echo $title; ?></h3>
        <a class="origin-button view-all-btn" href="<?php echo $link; ?>" class="small-link">view all</a>
    </header>
    <ul class='card-list'>
        <?php foreach ($items as $item) { ?>
            <li>
                <a href="<?php echo $item['profile_link']; ?>">
                <div class="card-block">
                    <div class="card-top">
                        <span class="logo-link">
                            <img src="<?php echo $item['image']; ?>" alt="" />
                        </span>
                        <div class="text-part">
                            <h4>
                                <?php echo $item['name']; ?>
                            </h4>
                            <p><?php echo $item['tagline']; ?></p>
                        </div>
                    </div>
                    <div class="card-bottom">
                        <?php if (!empty($item['params'])) { ?>
                            <dl>
                            <?php foreach ($item['params'] as $key=>$param) { ?>

                                <?php if (!empty($param)) { ?>
                                    <dt><?php echo wordwrap(Utils::get_param_dictionary($key,$type), 12, "<br />"); ?>:</dt>
                                    <dd>
                                    <?php for ($i=0;$i<=(count($param)>2 ? 1 : count($param)-1);$i++) { ?>
                                        <?php echo $param[$i]['name']; ?><?php echo $i == 0 && count($param) != 1 ? ', ' : ''; ?>
                                    <?php } ?>
                                    <?php //echo count($param)>2 ? '...' : ''; ?>
                                    </dd>
                                <?php } ?>
                            <?php } ?>
                            </dl>
                        <?php } ?>
                    </div>
                </div>
                </a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
