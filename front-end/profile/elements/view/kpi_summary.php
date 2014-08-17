<section class="simple-section with-header">
    <header>
        <h1>KPI summary</h1>
    </header>

    <div class="content-part">
        <div class="bottom-part">
            <div class="overview-part">
                <div class="name column1">
                    <span>users:</span>
                </div>
                <div class="description column2"><?php echo $kpi_summary['users_formatted'] ? $kpi_summary['users_formatted'] : 'undisclosed'; ?></div>
            </div>
            <div class="overview-part">
                <div class="name column1">
                    <span>annual user growth:</span>
                </div>
                <div class="description column2"><?php echo $kpi_summary['users_growth_formatted'] ? $kpi_summary['users_growth_formatted'] . ' %' : 'undisclosed'; ?></div>
            </div>
            <div class="overview-part">
                <div class="name column1">
                    <span>paying customers:</span>
                </div>
                <div class="description column2"><?php echo $kpi_summary['paying_customers_formatted'] ? $kpi_summary['paying_customers_formatted'] : 'undisclosed'; ?></div>
            </div>
            <div class="overview-part">
                <div class="name column1">
                    <span>volume:</span>
                </div>
                <div class="description column2"><?php echo $kpi_summary['volume_formatted'] ? $kpi_summary['volume_formatted'] : 'undisclosed'; ?></div>
            </div>
            <div class="overview-part">
                <div class="name column1">
                    <span>average price per sale:</span>
                </div>
                <div class="description column2"><?php echo $kpi_summary['avg_price_formatted'] ? $kpi_summary['avg_price_formatted'] . ' ' .$kpi_summary['currency'] : 'undisclosed'; ?></div>
            </div>
            <div class="overview-part">
                <div class="name column1">
                    <span>annual growth rate:</span>
                </div>
                <div class="description column2"><?php echo $kpi_summary['yoy_growth_formatted'] ? $kpi_summary['yoy_growth_formatted'] . ' %' : 'undisclosed'; ?></div>
            </div>
            <div class="overview-part">
                <div class="name column1">
                    <span>gross margin:</span>
                </div>
                <div class="description column2"><?php echo $kpi_summary['gross_margin_formatted'] ? $kpi_summary['gross_margin_formatted'] . ' %' : 'undisclosed'; ?></div>
            </div>
            <div class="overview-part">
                <div class="name column1">
                    <span>operating margin:</span>
                </div>
                <div class="description column2"><?php echo $kpi_summary['operating_margin_formatted'] ? $kpi_summary['operating_margin_formatted'] . ' %' : 'undisclosed'; ?></div>
            </div>
            <div class="overview-part">
                <div class="name column1">
                    <span>source:</span>
                </div>
                <div class="description column2"><?php echo $kpi_summary['source_formatted']; ?></div>
            </div>
            <div class="overview-part">
                <div class="name column1">
                    <span>last updated:</span>
                </div>
                <div class="description column2"><?php echo $kpi_summary['last_update_formatted']; ?></div>
            </div>
        </div>
    </div>
</section>