<form action="/sales-product" method="POST">

    <!-- Кнопка открытия модального окна-->
    <button type="button" class="btn btn-primary w-75" data-toggle="modal" data-target="#orders-product">Фильтры</button>

<!--    --><?php //var_dump($checkCriterias); die(); ?>

    <!-- Модальное окно -->
    <div class="modal fade" id="orders-product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Фильтры</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- фильтрация по дате -->
                    <div class="text-center py-3">
                        <div class="d-flex justify-content-around">
                            <div class="mt-1">
                                <p class="text-center"><b>Установить период:</b></p>
                            </div>
                            <div>
                                <input id="calendar" type="text" value="<?= $date ?> " class="form-control"
                                       id="date" name="date" required>
                            </div>
                        </div>
                    </div>

                    <!-- фильтрация по магазинах -->
                    <div class="text-center py-3 border-top">
                        <div class="d-flex justify-content-around">
                            <div class="mt-1">
                                <p class="text-center"><b>Магазины:</b></p>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary dropdown-toggle"
                                        data-toggle="dropdown">Магазины
                                </button>
                                <ul class="dropdown-menu checkbox-menu allow-focus">
                                    <? foreach ($shops as $shop) : ?>
                                        <li class="ml-2">
                                            <label>
                                                <input name="id_shop[]" value="<?= $shop->id ?>" type="checkbox"
                                                    <?php if (in_array($shop->id, $checkShops)) : ?>
                                                        checked
                                                    <?php endif; ?>
                                                > <?= $shop->shop_name ?>
                                            </label>
                                        </li>
                                    <? endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- фильтрация по категориях -->
                    <div class="text-center py-3 border-top">
                        <div class="d-flex justify-content-around">
                            <div class="mt-1">
                                <p class="text-center"><b>Категории:</b></p>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary dropdown-toggle"
                                        data-toggle="dropdown">Категории:
                                </button>
                                <ul class="dropdown-menu checkbox-menu allow-focus">
                                    <? foreach ($categories as $category) : ?>
                                        <li class="ml-2">
                                            <label>
                                                <input name="categories[]" value="<?= $category->id ?>"
                                                       type="checkbox"
                                                    <?php if (in_array($category->id, $checkCategory)) : ?>
                                                        checked
                                                    <?php endif; ?>
                                                > <?= $category->category ?>
                                            </label>
                                        </li>
                                    <? endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- фильтрация по бренду -->
                    <div class="text-center py-3 border-top">
                        <div class="d-flex justify-content-around">
                            <div class="mt-1">
                                <p class="text-center"><b>Бренды:</b></p>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary dropdown-toggle"
                                        data-toggle="dropdown">Бренды
                                </button>
                                <ul class="dropdown-menu checkbox-menu allow-focus">
                                    <? foreach ($brands as $brand) : ?>
                                        <li class="ml-2">
                                            <label>
                                                <input name="brands[]" value="<?= $brand->id ?>" type="checkbox"
                                                    <?php if (in_array($brand->id, $checkBrands)) : ?>
                                                        checked
                                                    <?php endif; ?>
                                                > <?= $brand->brand ?>
                                            </label>
                                        </li>
                                    <? endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <!-- фильтрация по стране-производителю -->
                    <div class="text-center py-3 border-top">
                        <div class="d-flex justify-content-around">
                            <div class="mt-1">
                                <p class="text-center"><b>Страны-производители:</b></p>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary dropdown-toggle"
                                        data-toggle="dropdown">Страны-производители
                                </button>
                                <ul class="dropdown-menu checkbox-menu allow-focus">
                                    <? foreach ($countries as $country) : ?>
                                        <li class="ml-2">
                                            <label>
                                                <input name="countries[]" value="<?= $country->id ?>"
                                                       type="checkbox"
                                                    <?php if (in_array($country->id, $checkCountries)) : ?>
                                                        checked
                                                    <?php endif; ?>
                                                > <?= $country->country ?>
                                            </label>
                                        </li>
                                    <? endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- фильтрация по критериях -->
                    <div class="text-center py-3 border-top">
                        <p class="text-center"><b>Выбрание критерии:</b></p>

                        <div class="checkbox text-left">
                            <label><input type="checkbox" value="category" name="criterias[]"
                                    <?php if (in_array('category', $checkCriterias)) : ?>
                                        checked
                                    <?php endif; ?>
                                > Категория</label>
                        </div>

                        <div class="checkbox text-left">
                            <label><input type="checkbox" value="brand" name="criterias[]"
                                    <?php if (in_array('brand', $checkCriterias)) : ?>
                                        checked
                                    <?php endif; ?>
                                > Бренд</label>
                        </div>

                        <div class="checkbox text-left">
                            <label><input type="checkbox" value="country" name="criterias[]"
                                    <?php if (in_array('country', $checkCriterias)) : ?>
                                        checked
                                    <?php endif; ?>
                                > Страна-производитель</label>
                        </div>

                        <div class="checkbox text-left">
                            <label><input type="checkbox" value="sum" name="criterias[]"
                                    <?php if (in_array('sum', $checkCriterias)) : ?>
                                        checked
                                    <?php endif; ?>
                                > Оборот</label>
                        </div>

                        <div class="checkbox text-left">
                            <label><input type="checkbox" value="profit" name="criterias[]"
                                    <?php if (in_array('profit', $checkCriterias)) : ?>
                                        checked
                                    <?php endif; ?>
                                > Прибыль</label>
                        </div>

                        <div class="checkbox text-left">
                            <label><input type="checkbox" value="cost_price" name="criterias[]"
                                    <?php if (in_array('cost_price', $checkCriterias)) : ?>
                                        checked
                                    <?php endif; ?>
                                > Себестоимость</label>
                        </div>

                        <div class="checkbox text-left">
                            <label><input type="checkbox" value="count_product" name="criterias[]"
                                    <?php if (in_array('count_product', $checkCriterias)) : ?>
                                        checked
                                    <?php endif; ?>
                                > Кол-во прод товаров</label>
                        </div>

                        <div class="checkbox text-left">
                            <label><input type="checkbox" value="discount" name="criterias[]"
                                    <?php if (in_array('discount', $checkCriterias)) : ?>
                                        checked
                                    <?php endif; ?>
                                > Сделанная скидка</label>
                        </div>
                    </div>

                    <div class="text-center my-3">
                        <button class="btn btn-success">Применить</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>

<!-- Скачать отчет -->
<div class="text-center py-3">

    <!-- Скачать отчет в excel (передаем в форму выбранные критерии для формирования отчета из БД) -->
    <form action="/download-sales-product-excel" method="POST" target="_blank">
        <? foreach ($categories as $category) : ?>
            <?php if (in_array($category->id, $checkCategory)) : ?>
                <input type="hidden" name="categories[]" value="<?= $category->id ?>">
            <?php endif; ?>
        <? endforeach; ?>

        <?php foreach($brands as $brand) : ?>
            <?php if (in_array($brand->id, $checkBrands)) : ?>
                <input type="hidden" name="brands[]" value="<?= $brand->id ?>">
            <?php endif; ?>
        <? endforeach; ?>

        <?php foreach($countries as $country) : ?>
            <?php if (in_array($country->id, $checkCountries)) : ?>
                <input type="hidden" name="countries[]" value="<?= $country->id ?>">
            <?php endif; ?>
        <? endforeach; ?>

        <?php foreach($checkCriterias as $key => $value) : ?>
            <input type="hidden" name="criterias[]" value="<?= $value ?>">
        <? endforeach; ?>

        <?php foreach ($checkShops as $key => $value) : ?>
            <input type="hidden" name="id_shop[]" value="<?= $value ?>">
        <? endforeach; ?>

        <input type="hidden" name="date" value="<?= $date ?>">
        <input type="submit" class="btn btn-link text-dark" value="Скачать в Excel">
    </form>
</div>