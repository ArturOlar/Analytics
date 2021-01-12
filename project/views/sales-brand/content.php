<div class="container-fluid">
    <div class="row">

        <div class="col-md-2 border-right main-color">
            <div class="text-center mt-4 pb-4 border-bottom">
                <?php include('filter-orders.php') ?>
            </div>
            <div class="text-center pb-4 border-bottom">
                <?php include('project/views/left-sidebar.php') ?>
            </div>
        </div>

        <div class="col-md-10 table-responsive">
            <table class="table table-striped table-sm table-bordered display" id="table-orders-product">
                <thead class="main-color">
                <tr>
                    <th style="max-height: 100px;" scope="col">бренд</th>

                    <?php if (\Project\Models\Report\ReportSales::checkPropertyExists($sales, 'count_orders')) : ?>
                        <th style="min-height: 100px;" scope="col">кол-во заказов</th>
                    <?php endif; ?>

                    <?php if (\Project\Models\Report\ReportSales::checkPropertyExists($sales, 'sum')) : ?>
                        <th style="min-height: 100px;" scope="col">сума</th>
                    <?php endif; ?>

                    <?php if (\Project\Models\Report\ReportSales::checkPropertyExists($sales, 'count_product')) : ?>
                        <th style="min-height: 100px;" scope="col">кол-во товаров</th>
                    <?php endif; ?>

                    <?php if (\Project\Models\Report\ReportSales::checkPropertyExists($sales, 'profit')) : ?>
                        <th style="min-height: 100px;" scope="col">прибыль</th>
                    <?php endif; ?>

                    <?php if (\Project\Models\Report\ReportSales::checkPropertyExists($sales, 'cost_price')) : ?>
                        <th style="min-height: 100px;" scope="col">себестоимость</th>
                    <?php endif; ?>

                    <?php if (\Project\Models\Report\ReportSales::checkPropertyExists($sales, 'avg')) : ?>
                        <th style="min-height: 100px;" scope="col">средняя цена продажи</th>
                    <?php endif; ?>

                    <?php if (\Project\Models\Report\ReportSales::checkPropertyExists($sales, 'discount')) : ?>
                        <th style="min-height: 100px;" scope="col">скидка</th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($sales as $key => $value) : ?>
                    <tr>
                        <th><?= $value->brand ?></th>

                        <?php if (isset($value->count_orders)) : ?>
                            <td><?= $value->count_orders ?></td>
                        <?php endif; ?>

                        <?php if (isset($value->sum)) : ?>
                            <td><?= number_format($value->sum, 2, ',', '.') ?></td>
                        <?php endif; ?>

                        <?php if (isset($value->count_product)) : ?>
                            <td><?= $value->count_product ?></td>
                        <?php endif; ?>

                        <?php if (isset($value->profit)) : ?>
                            <td><?= number_format($value->profit, 2, ',', '.') ?></td>
                        <?php endif; ?>

                        <?php if (isset($value->cost_price)) : ?>
                            <td><?= number_format($value->cost_price, 2, ',', '.') ?></td>
                        <?php endif; ?>

                        <?php if (isset($value->avg)) : ?>
                            <td><?= number_format($value->avg, 2, ',', '.') ?></td>
                        <?php endif; ?>

                        <?php if (isset($value->discount)) : ?>
                            <td><?= number_format($value->discount, 2, ',', '.') ?></td>
                        <?php endif; ?>

                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
