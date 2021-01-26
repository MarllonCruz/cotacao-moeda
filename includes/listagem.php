<!-- Seleção da moeda  -->
<div class="select-moedas">
    <select class="listas-moedas">
        <?php foreach($allMoedas as $item): ?>
            <option <?=($item->code == 'USD-BRL')?'selected':'';?> value="<?=$item->code;?>">
                <?=$item->name;?>
            </option>
        <?php endforeach; ?>    
        
    </select>
</div>

<!-- Conteúdo da moeda -->
<div class="containes container" data-moeda="<?=number_format($moedaInicial->price, 2);?>">
    <p>1 <?=$moedaInicial->name;?> igual a</p>
    <h2><?=number_format($moedaInicial->price, 2);?> Real brasileiro</h2>
    <p class='data'><?=$moedaInicial->date;?>. <?=$moedaInicial->hour;?><p>
    <form>
        <input  id="inputMoeda" value="1" />
        <input  id="inputReal" value="<?=number_format($moedaInicial->price, 2);?>" />
    </form>
</div>

<!-- Grafico da moeda  -->
<div class="graphic-moeda">
    <h2>Últimos dias</h2>
    <canvas id="myChart"></canvas>
</div>

