<?php if ($items && count($items) > 0) { ?>
    <section class="simple-section with-header">
        <header>
            <h1><?php echo $name; ?></h1>
        </header>
        <?php
            $total = 0;
            $total_currency = null;
            $show_total = true;
        ?>
        <div class="content-part part-with-table">
            <div class="swipe table-block">
                <table class="origin-table">
                    <thead>
                        <tr>
                            <th><span class="td-74">date</span></th>
                            <th><span class="td-52">round</span></th>
                            <th><span class="td-244 left-align">investors</span></th>
                            <th><span class="td-78">amount</span></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item) {
                        $total += $item['amount_formatted'];
                        if ($total_currency === null) {
                            $total_currency = $item['currency_formatted'];
                        }
                        if ($item['amount'] == 0) {
                            $show_total = false;
                        }
                    ?>
                        <tr>
                            <td><?php echo $item['date_formatted']; ?></td>
                            <td><span class="center-align"><?php echo wordwrap($item['round'], 5, "<br />", true); ?></span></td>
                            <td>

                                    <?php if (isset($item['investors']) && !empty($item['investors'])) { ?>
                                        <?php foreach ($item['investors'] as $key=>$investor) { ?>
                                            <a href="<?php echo $investor['profile_link']; ?>"><?php echo $investor['name'].($key < count($item['investors'])-1 || ($key == count($item['investors'])-1 && isset($item['hidden_angels']) && !empty($item['hidden_angels'])) ? ', ' : ''); ?></a>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (isset($item['hidden_angels']) && !empty($item['hidden_angels'])) { ?>
                                        <?php echo $item['hidden_angels']; ?>
                                    <?php } ?>

                            </td>
                            <td>
                                <?php if ($item['amount_formatted'] > 0) { ?>
                                    <span class="val"><?php echo $item['currency_formatted']; ?></span> <span class="sum"><?php echo $item['amount_formatted']; ?>M</span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                    <?php if ($total > 0 && $show_total) { ?>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <span class="right-align">total funding: <span class="sum"><?php echo $total_currency; ?><?php echo $total; ?>M</span></span>
                                </td>
                            </tr>
                        </tfoot>
                    <?php } ?>
                </table>
            </div>
        </div>
    </section>
<?php } ?>