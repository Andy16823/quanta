<div class="grid">
    <?php foreach($cards as $card): ?>
        <?php $quanta->render_component("card", $card); ?>
    <?php endforeach; ?>
</div>