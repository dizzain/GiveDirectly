<?php $can_invest = Utils::can_invest($company_bobject_id); ?>
<?php $has_pending = Utils::has_pending_investment($company_bobject_id); ?>
<?php if ($has_pending) $investors = array_merge($investors,$has_pending); ?>
<?php if (!empty($investors) || $can_invest || $has_pending) { ?>
    <section class="simple-section with-header">
        <header>
            <h1>Investors</h1>
        </header>
        <div class="content-part">
            <?php $total = count($investors); /*$total_pending = count($has_pending);*/ ?>
            <ul class="people-list">
                <?php for ($i=0;$i<=($total > 8 ? 7 : $total-1);$i++) { ?>
                    <li>
                        <a href="<?php echo Navigator::get_bobject_link($investors[$i]['type'],$investors[$i]['url']); ?>">
                            <span class="logo-link<?php echo isset($investors[$i]['status']) && $investors[$i]['status'] == 0 ? ' pending' : ''; ?>">
                                 <img src="<?php echo $investors[$i]['avatar_link']; ?>" alt=""/>
                            </span>
                            <?php echo $investors[$i]['name']; ?>
                            <?php echo $investors[$i]['is_exited'] == 1 ? '<span class="grey-position">(exited)</span>' : ''; ?>
                        </a>
                    </li>
                <?php } ?>
                <?php // TODO пилить вывод пендинг ?>
                <?php if ($total/*+$total_pending*/ < 8 && $can_invest) { ?>
                    <li>
                        <a href='#' class="add-link-big add-me-as-investor" data-company-name="<?php echo $company_name; ?>" data-company-bobject-id="<?php echo $company_bobject_id; ?>">
                            <i class="icon icons-plus-w"></i>
                            <span>add</span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <?php if ($total > 8 || ($total == 8 && $can_invest)) { ?>
                <ul class="people-list hide-text"  data-text="more-info">
                    <?php for ($i=8;$i<=$total-1;$i++) { ?>
                        <li>
                            <a href="<?php echo Navigator::get_bobject_link($investors[$i]['type'],$investors[$i]['url']); ?>">
                            <span class="logo-link">
                                 <img src="<?php echo $investors[$i]['avatar_link']; ?>" alt=""/>
                            </span>
                                <?php echo $investors[$i]['name']; ?>
                                <?php echo $investors[$i]['is_exited'] == 1 ? '<span class="grey-position">(exited)</span>' : ''; ?>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($total >= 8 && $can_invest) { ?>
                        <li>
                            <a href='#' class="add-link-big add-me-as-investor" data-company-name="<?php echo $company_name; ?>" data-company-bobject-id="<?php echo $company_bobject_id; ?>">
                                <i class="icon icons-plus-w"></i>
                                <span>add</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
        <footer>
            <a href="#"  data-link="more-info" data-original-text="view all team members">view all investors &raquo;</a>
        </footer>
    </section>
<?php } ?>