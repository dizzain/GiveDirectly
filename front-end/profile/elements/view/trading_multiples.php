<?php if ($trading_multiples && !empty($trading_multiples)) { ?>

    <section class="simple-section with-header">
        <header>
            <h1>Trading multiples</h1>
        </header>
        <div class="content-part part-with-table">
            <table class="trading-table origin-table">
                <thead>
                    <tr>
                        <th>
                            &nbsp;
                        </th>
                        <th colspan="2">Market Value</th>
                        <th colspan="2">EV/Revenue</th>
                        <th colspan="2">EV/EBITDA</th>
                    </tr>
                    <tr>
                        <th>
                            <span class="td-126">Company Name</span>
                        </th>
                        <th><span class="td-68">Equity</span></th>
                        <th><span class="td-68">Firm Value</span></th>
                        <th><span class="td-46">2014</span></th>
                        <th><span class="td-46">2015</span></th>
                        <th><span class="td-46">2014</span></th>
                        <th><span class="td-46">2015</span></th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php foreach ($trading_multiples as $trading_multiple) { ?>
                        <tr>
                            <td> <span class="td-126"><?php echo $trading_multiple['company_name']; ?></span></td>
                            <td><?php echo $trading_multiple['market_equity']; ?></td>
                            <td><?php echo $trading_multiple['market_firm']; ?></td>
                            <td><?php echo $trading_multiple['revenue_2014']; ?></td>
                            <td><?php echo $trading_multiple['revenue_2015']; ?></td>
                            <td><?php echo $trading_multiple['ebitda_2014']; ?></td>
                            <td><?php echo $trading_multiple['ebitda_2015']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <footer>
            <a href="#" class="do-request-excel" data-multiple-type="trading" data-referer-type="profile_page" data-item-id="<?php echo $company_bobject_id; ?>">request excel model</a>
        </footer>
    </section>


<?php } ?>