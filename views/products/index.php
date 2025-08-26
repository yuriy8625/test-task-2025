<div class="container">
    <div class="sale center">
       <div class="sale--title">
           <span class="material-icons">local_offer</span>
           Спеціальна пропозиція
       </div>
        <div id="timer" class="sale--timer"></div>
    </div>

    <div class="sale--description center">
        Для отримання знижки 20% необхідно додати в кошик три чи більше одиниць акційних товарів.
        Акція діє тільки при оформленні замовлення на сайті або в мобільному застосунку.
    </div>
    <div class="sale--action center">
        <a href="/sale" class="btn btn-link">
            Перейти до покупок
        </a>
    </div>


</div>

<script>
    window.onload = () => startCountdown("timer");
</script>