<div class="container">
    <div class="catalog center">
       <div class="catalog--title">
           <span class="material-icons">local_offer</span>
           Спеціальна пропозиція
       </div>
        <div id="timer" class="catalog--timer"></div>
    </div>

    <div class="catalog--description center">
        Для отримання знижки 20% необхідно додати в кошик три чи більше одиниць акційних товарів.
        Акція діє тільки при оформленні замовлення на сайті або в мобільному застосунку.
    </div>
    <div class="catalog--action center">
        <a href="/sale" class="btn btn-link">
            Перейти до покупок
        </a>
    </div>

    <div class="filter">
        <div class="filter--sort">
            <label for="sortSelect">Сортування:</label>
            <select id="sortSelect" name="order">
                <option value="title-asc">За назвою А-Я</option>
                <option value="title-desc">За назвою Я-А</option>
                <option value="price-asc">Від дешевих до дорогих</option>
                <option value="price-desc">Від дорогих дошевих</option>

            </select>
        </div>
    </div>

    <div class="products"></div>

    <div class="pagination"></div>
</div>

<script>
    window.onload = () => startCountdown("timer");
</script>
<script src="./scripts/catalog.js"></script>