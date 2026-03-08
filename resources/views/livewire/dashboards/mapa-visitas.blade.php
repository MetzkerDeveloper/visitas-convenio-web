<div style="padding:20px" wire:ignore>

<style>

.marker-visita{
    width:34px;
    height:34px;
    border-radius:50%;
    background:#2563eb;
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
    border:3px solid white;
    box-shadow:0 3px 8px rgba(0,0,0,0.35);
}

.cluster{
    background:#1d4ed8;
    border-radius:50%;
    color:white;
    width:40px;
    height:40px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
}

</style>

<div id="map" style="
height:550px;
border-radius:10px;
overflow:hidden;
"></div>

</div>


<script>

document.addEventListener("DOMContentLoaded", function(){

maptilersdk.config.apiKey = '{{ env('MAPS_APIKEY') }}';

let mapLoaded = false;
let visitasPendentes = null;

let markers = [];
let clusterMarkers = [];

window.map = new maptilersdk.Map({
container: 'map',
style: "https://api.maptiler.com/maps/streets/style.json?key={{ env('MAPS_APIKEY') }}",
center: [-41.50, -17.86],
zoom: 12
});

window.map.on('load', function(){

mapLoaded = true;

if(visitasPendentes){
atualizarMapa(visitasPendentes);
visitasPendentes = null;
}

});


/* =======================
ROTA REAL
======================= */

async function desenharRota(coords){

    if(coords.length < 2) return;

    const pontos = coords.slice(0,50);

    try{

    const response = await fetch(
    'https://api.openrouteservice.org/v2/directions/driving-car/geojson',
    {
    method:'POST',
    headers:{
    'Authorization':"{{ env('OPENROUTESERVICE_APIKEY') }}",
    'Content-Type':'application/json'
    },
    body: JSON.stringify({
    coordinates:pontos
    })
    });

    const data = await response.json();


    /* remove rota antiga */

    if(window.map.getSource('rota')){
    window.map.removeLayer('rota');
    window.map.removeSource('rota');
    }


    /* cria rota */

    window.map.addSource('rota',{
    type:'geojson',
    data:data
    });


    window.map.addLayer({
    id:'rota',
    type:'line',
    source:'rota',
    paint:{
    'line-color':'#2563eb',
    'line-width':6,
    'line-opacity':0.85
    }
    });

    }catch(e){

        console.error("Erro rota:", e);

    }

}

/* =======================
CLUSTER
======================= */

function criarClusters(coords){

clusterMarkers.forEach(m => m.remove());
clusterMarkers = [];

if(coords.length < 15) return;

let agrupados = {};

coords.forEach(c => {

let chave =
Math.round(c[0]*100)/100 +
"-" +
Math.round(c[1]*100)/100;

if(!agrupados[chave]) agrupados[chave] = [];

agrupados[chave].push(c);

});

Object.values(agrupados).forEach(grupo => {

if(grupo.length === 1) return;

const el = document.createElement("div");
el.className = "cluster";
el.innerHTML = grupo.length;

let marker = new maptilersdk.Marker({element:el})
.setLngLat(grupo[0])
.addTo(window.map);

clusterMarkers.push(marker);

});

}


/* =======================
ATUALIZAR MAPA
======================= */

function atualizarMapa(visitas){

if(!mapLoaded){
visitasPendentes = visitas;
return;
}

markers.forEach(m => m.remove());
markers = [];

clusterMarkers.forEach(m => m.remove());
clusterMarkers = [];

if(window.map.getSource && window.map.getSource('rota')){
window.map.removeLayer('rota');
window.map.removeSource('rota');
}

let coords = [];

visitas.forEach((v,index)=>{

const el = document.createElement("div");
el.className = "marker-visita";
el.innerHTML = index + 1;

let marker = new maptilersdk.Marker({element:el})
.setLngLat([v.longitude, v.latitude])
.setPopup(
new maptilersdk.Popup().setHTML(
"<b>Empresa:</b> "+v.empresa+
"<br><b>Data:</b> "+v.data
)
)
.addTo(window.map);

markers.push(marker);

coords.push([v.longitude, v.latitude]);

});


/* rota real */

desenharRota(coords);

/* clusters */

criarClusters(coords);


/* zoom */

if(coords.length){

const bounds = new maptilersdk.LngLatBounds();

coords.forEach(c => bounds.extend(c));

window.map.fitBounds(bounds,{padding:80});

}

}


/* =======================
LIVEWIRE EVENT
======================= */

window.addEventListener("carregarMapa",(event)=>{

let visitas = event.detail[0]
? event.detail[0].visitas
: event.detail.visitas;

atualizarMapa(visitas);

});

});

</script>