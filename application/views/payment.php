<section class="widget form-widget" id="coffee_block">
    <h3>Купить мне кофе</h3>
    <form class="form-callback" id="coffee_forms" method="POST" action="<?php echo base_url(); ?>payment/success2" accept-charset="utf-8">
        <div class="form-group">
            <input class="input-field" type="text" name="coffee_email" id="coffee_email" placeholder="Введите ваш email">
        </div>
        <div class="form-group child">
            <input class="input-field" type="text" name="coffee_sum" id="coffee_sum" placeholder="25 грн.">
        </div>
        <button class="btn-detail open_popup_coffee">УГОСТИТЬ</button>
    </form>
</section>