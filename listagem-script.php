<script>
window.addEventListener('load', function() {    
    const c  = (el)=> document.querySelector(el);
    const cs = (el)=> document.querySelectorAll(el);


    c('.container #inputMoeda').addEventListener('keyup', (e)=>{
        let valueInput = e.target.value;
        let valueReal  = c('.container').getAttribute('data-moeda');
        let inputResult = c('.container #inputReal');
        
        if(valueInput) {
            inputResult.value = (parseFloat(valueReal) * parseFloat(valueInput)).toFixed(2);
        }
    });

    c('.container #inputReal').addEventListener('keyup', (e)=>{
        let valueInput = e.target.value;
        let valueReal  = c('.container').getAttribute('data-moeda');
        let inputResult = c('.container #inputMoeda');
        
        if(valueInput) {
            inputResult.value = (parseFloat(valueInput) / parseFloat(valueReal)).toFixed(2);
        }
        
    });

    // grafico inicial
    let contexto = document.getElementById('myChart').getContext('2d');
    let myChart  = new Chart(contexto, {
        type:'line',
        data: {
            labels: [<?=implode(',', $label);?>],
            datasets: [{
                label:'Dolar',
                backgroundColor:'#000000',
                borderColor:'#000000',
                data:[
                   <?=implode(',', $data);?>
                ],
                fill:false
            }]
        }
    });

    const selectElement = c('.listas-moedas');
    selectElement.addEventListener('change', async (event)=>{
        let moeda = event.target.value;

        let data = new FormData();
        data.append('moeda', moeda);

        let req = await fetch('ajax_moeda.php', {
            method: 'POST',
            body  : data
        });
        let json = await req.json();

        if(json.error == '') {
            exchangeContentList(json);
        }
    });
    
    // atualizar as informações
    function exchangeContentList(json) {

        let titleMoeda = c('.container p:first-child');
        let titleData  = c('.container .data');
        let titleReal  = c('.container h2');
        let inputReal  = c('.container #inputReal');
        let inputMoeda = c('.container #inputMoeda');
        let dataMoeda =  c('.container');
        json.price = parseFloat(json.price).toFixed(2);
        dataMoeda.setAttribute('data-moeda', json.price);
        titleMoeda.innerHTML = `1 ${json.name} igual a`;
        titleReal.innerHTML = `${json.price} Real brasileiro`;
        titleData.innerHTML = `${json.date}. ${json.hour}`;
        inputReal.value     = parseFloat(json.price).toFixed(2);
        inputMoeda.value    = 1,00;

        let dates = [];
        let prices = [];

        json.lastDays.forEach((item)=>{
            dates.push(item.date);
            prices.push(parseFloat(item.price).toFixed(2));
        });

        // atualizar as informações do grafico 
        c('.graphic-moeda').innerHTML = '';

        let html = '<h2>Últimos dias</h2>';
        html += '<canvas id="myChart"></canvas>';
        c('.graphic-moeda').innerHTML += html;

        let contexto = document.getElementById('myChart').getContext('2d');
        let myChart  = new Chart(contexto, {
            type:'line',
            data: {
                labels: dates,
                datasets: [{
                    label:json.name,
                    backgroundColor:'#000000',
                    borderColor:'#000000',
                    data:prices,
                    fill:false
                }]
            }
        });
    }

    

});
</script>