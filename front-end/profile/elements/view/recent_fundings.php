<?php if ($items && count($items) > 0) { ?>
    <section class="simple-section with-header">
        <header>
            <h1><?php echo $name; ?></h1>
        </header>
        <div class="content-part part-with-table">
            <div class="swipe table-block">
                <table class="origin-table">
                    <thead>
                    <tr>
                        <th><span class="left-align">name</span></th>
                        <th>date</th>
                        <th>investors</th>
                        <th><span class="right-align">amount</span></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; foreach ($items as $funding) { ?>
                        <tr<?php echo $i>10 ? ' style="display:none;" class="hidden-row"' : ''; ?>>
                            <td><a href="<?php echo Navigator::get_bobject_link($funding['type'],$funding['url']); ?>"><?php echo $funding['name']; ?></a></td>
                            <td><span class="center-align"><?php echo $funding['date_formatted']; ?></span></td>
                            <td>
                                <span class="center-align">
                                    <?php if (isset($funding['investors']) && !empty($funding['investors'])) { ?>
                                        <?php foreach ($funding['investors'] as $key=>$investor) { ?>
                                            <a href="<?php echo $investor['profile_link']; ?>"><?php echo $investor['name']; ?></a><?php echo $key < count($funding['investors'])-1 ? ', ' : ''; ?>
                                        <?php } ?>
                                    <?php } ?>
                                </span>
                            </td>
                            <td><span class="right-align"><?php echo $funding['amount_formatted'] != 0 ? $funding['currency_formatted'] . ' ' . $funding['amount_formatted'] . 'M' : ''; ?></span></td>
                        </tr>
                        <?php $i++; } ?>
                    </tbody>
                </table>
            </div>
            <div class="show-all">
                <?php if (count($items) > 10) { ?>
                    <a href="#" class="do-show-more-companies">+ expand</a>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>