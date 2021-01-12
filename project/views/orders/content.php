<div class="container-fluid">
    <div class="row">

        <div class="col-md-2 border-right main-color">
            <div class="text-center mt-4 border-bottom">
                <?php include('filter-orders.php') ?>
            </div>
            <div class="text-center border-bottom">
                <?php include('project/views/left-sidebar.php') ?>
            </div>
        </div>

        <div class="col-md-10 table-responsive">
            <table class="table table-striped table-sm table-bordered" id="table-orders">
                <thead class="main-color">
                <tr>
                    <th style="min-width: 200px;" scope="col"></th>
                    <?php foreach ($sales as $key => $value) : ?>
                        <th style="min-width: 90px;" scope="col"><?= $value->date ?></th>
                    <?php endforeach; ?>
                </tr>
                </thead>
                <tbody>
                <?php if (\Project\Models\Report\ReportSales::checkPropertyExists($sales, 'count_orders')) : ?>
                    <tr>
                        <th scope="row">Кол-во чеков</th>
                        <?php foreach ($sales as $key => $value) : ?>
                            <td><?= $value->count_orders ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>

                <?php if (\Project\Models\Report\ReportSales::checkPropertyExists($sales, 'sum')) : ?>
                    <tr>
                        <th scope="row">Оборот</th>
                        <?php foreach ($sales as $key => $value) : ?>
                            <td><?= number_format($value->sum, 2, ',', '.') ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>

                <?php if (\Project\Models\Report\ReportSales::checkPropertyExists($sales, 'profit')) : ?>
                    <tr>
                        <th scope="row">Прибыль</th>
                        <?php foreach ($sales as $key => $value) : ?>
                            <td><?= number_format($value->profit, 2, ',', '.') ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>

                <?php if (\Project\Models\Report\ReportSales::checkPropertyExists($sales, 'cost_price')) : ?>
                    <tr>
                        <th scope="row">Себестоимость</th>
                        <?php foreach ($sales as $key => $value) : ?>
                            <td><?= number_format($value->cost_price, 2, ',', '.') ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>

                <?php if (\Project\Models\Report\ReportSales::checkPropertyExists($sales, 'count_product')) : ?>
                    <tr>
                        <th scope="row">Кол-во прод товаров</th>
                        <?php foreach ($sales as $key => $value) : ?>
                            <td><?= $value->count_product ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>

                <?php if (\Project\Models\Report\ReportSales::checkPropertyExists($sales, 'avg')) : ?>
                    <tr>
                        <th scope="row">Средний чек</th>
                        <?php foreach ($sales as $key => $value) : ?>
                            <td><?= number_format($value->avg, 2, ',', '.') ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>

                <?php if (\Project\Models\Report\ReportSales::checkPropertyExists($sales, 'discount')) : ?>
                    <tr>
                        <th scope="row">Сделанная скидка</th>
                        <?php foreach ($sales as $key => $value) : ?>
                            <td><?= number_format($value->discount, 2, ',', '.') ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
