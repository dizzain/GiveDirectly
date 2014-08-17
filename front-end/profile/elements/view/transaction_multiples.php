<?php if ($transaction_multiples && !empty($transaction_multiples)) { ?>

    <section class="simple-section with-header">
        <header>
            <h1>Transaction multiples</h1>
        </header>
        <div class="content-part part-with-table">
            <table class="trading-table origin-table">
                <thead>
                <tr>
                    <th>
                        <span class="td-30 left-align">Date</span>
                    </th>
                    <th><span class="td-100 left-align">Acquiror</span></th>
                    <th><span class="td-100 left-align">Target</span></th>
                    <th><span class="td-52">Total EV<br/>(M)</span></th>
                    <th><span class="td-52">EV/LTM<br/>Sales</span></th>
                    <th><span class="td-52">EV/LTM<br/>EBITDA</span></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($transaction_multiples as $transaction_multiple) { ?>
                <tr>
                    <?php
                        if (strlen($transaction_multiple['acquiror']) > 15) {
                            $acquiror = substr($transaction_multiple['acquiror'], 0, 15) . '<br />' . substr($transaction_multiple['acquiror'], 15);
                        }
                        else {
                            $acquiror = $transaction_multiple['acquiror'];
                        }
                        if (strlen($transaction_multiple['target']) > 15) {
                            $target = substr($transaction_multiple['target'], 0, 15) . '<br />' . substr($transaction_multiple['target'], 15);
                        }
                        else {
                            $target = $transaction_multiple['target'];
                        }                        
                    ?>
                    <td><?php echo  preg_replace("([^A-z])", "", $transaction_multiple['date']) . ' ' . preg_replace("([^0-9])", "", $transaction_multiple['date']); ?></td>
                    <td><?php echo $acquiror; ?></td>
                    <td><?php echo $target; ?></td>
                    <td><span class="center-align"><?php echo $transaction_multiple['total_ev']; ?></span></td>
                    <td><span class="center-align"><?php echo $transaction_multiple['ev_ltm_sales']; ?></span></td>
                    <td><span class="center-align"><?php echo $transaction_multiple['ev_ltm_ebidta']; ?></span></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <footer>
            <a href="#" class="do-request-excel" data-multiple-type="transaction" data-referer-type="profile_page" data-item-id="<?php echo $company_bobject_id; ?>">request excel model</a>
        </footer>
    </section>

<?php } ?>

