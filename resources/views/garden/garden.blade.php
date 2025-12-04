<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huerta</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/huerta.css') }}">
</head>

<body>

<div id="seedModal" class="seed-modal hidden">
    <div class="seed-box">
        <h2>Selecciona una semilla</h2>

        <div class="seed-grid">
            @foreach($plants as $plant)
                <div class="seed-item" onclick="selectSeed({{ $plant->id }})">
                    <img src="{{ asset('img/seeds/' . strtolower($plant->name) . '.png') }}" class="seed-img">
                    <p>{{ $plant->name }}</p>
                </div>
            @endforeach
        </div>

        <button onclick="closeSeedModal()" class="close-btn">Cerrar</button>
    </div>
</div>


<div class="top-bar">

    <div class="coins-box">
    <div class="coins-stack">
        <img src="{{ asset('img/coin.png') }}" class="coin">
        <img src="" class="coin coin2">
    </div>
        <span class="coin-amount">{{ $coins }}</span>
    </div>



    <div class="right-side">
        <div class="top-icons">
            <button class="icon-btn"><img src="{{ asset('img/bell.png') }}" class="icon-img"></button>
            <button class="icon-btn"><img src="{{ asset('img/store.png') }}" class="icon-img"></button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inventoryModal">Inventario</button>

        </div>

        <div class="user-card">
            <img src="{{ asset('img/user.png') }}" class="user-icon">
            <div class="user-info">
                <p><strong>Usuario:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Semillas disponibles:</strong> {{ $seeds }}</p>
                <p><strong>Productos cosechados:</strong> {{ $harvestedCount }}</p>
            </div>
        </div>
    </div>

</div>


@if(session('success'))
<div class="alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert-error">{{ session('error') }}</div>
@endif


<div class="main-box">
    @foreach($plots as $plot)
        <div class="inner-box plot" data-id="{{ $plot->id }}">

            @php
                $crop = \App\Models\PlantedCrop::where('garden_plots_id', $plot->id)
                        ->whereNull('harvested_at')
                        ->first();
            @endphp

            @if($crop)
                <img src="{{ asset('img/crops/' . strtolower($crop->plant->name) . '_stage' . $crop->growth_stage . '.png') }}"
                     class="crop-img">
            @else
                <img src="{{ asset('img/crops/empty.png') }}" class="crop-img">
            @endif

        </div>
    @endforeach
</div>


<div class="action-buttons">

    <!-- SEMBRAR -->
    <button class="img-btn" onclick="submitAction('seed')">
        <img src="{{ asset('img/plant-btn.png') }}">
    </button>

    <!-- REGAR -->
    <button class="img-btn" onclick="submitAction('water')">
        <img src="{{ asset('img/water-btn.png') }}" alt="Regar">
    </button>

    <!-- FERTILIZAR -->
    <button class="img-btn" onclick="submitAction('fertilize')">
        <img src="{{ asset('img/fertilizer-btn.png') }}" alt="Abonar">
    </button>

    <!-- COSECHAR -->
    <button class="img-btn" onclick="submitAction('harvest')">
        <img src="{{ asset('img/harvest-btn.png') }}" alt="Cosechar">
    </button>

</div>


<form id="formPlant" method="POST" action="{{ route('garden.plant') }}" class="hidden-form">
    @csrf
    <input type="hidden" name="garden_plot_id" id="plotPlant">
    <input type="hidden" name="plant_id" id="plantId">
</form>

<form id="formWater" method="POST" action="{{ route('garden.water') }}" class="hidden-form">
    @csrf
    <input type="hidden" name="garden_plot_id" id="plotWater">
</form>

<form id="formFertilize" method="POST" action="{{ route('garden.fertilize') }}" class="hidden-form">
    @csrf
    <input type="hidden" name="garden_plot_id" id="plotFertilize">
</form>

<form id="formHarvest" method="POST" action="{{ route('garden.harvest') }}" class="hidden-form">
    @csrf
    <input type="hidden" name="garden_plot_id" id="plotHarvest">
</form>



<script>
    let selectedPlot = null;

    document.querySelectorAll('.plot').forEach(plot => {
        plot.addEventListener('click', () => {
            selectedPlot = plot.getAttribute('data-id');

            document.querySelectorAll('.plot').forEach(p => p.style.outline = "none");
            plot.style.outline = "4px solid yellow";
        });
    });

    function submitAction(action) {
        if (!selectedPlot) {
            alert("Selecciona una parcela primero.");
            return;
        }

        if (action === "seed") {
            document.getElementById('seedModal').classList.remove('hidden');
            return;
        }

        if (action === "water") {
            document.getElementById("plotWater").value = selectedPlot;
            document.getElementById("formWater").submit();
        }

        if (action === "fertilize") {
            document.getElementById("plotFertilize").value = selectedPlot;
            document.getElementById("formFertilize").submit();
        }

        if (action === "harvest") {
            document.getElementById("plotHarvest").value = selectedPlot;
            document.getElementById("formHarvest").submit();
        }
    }

    function selectSeed(seedId) {
        document.getElementById("plotPlant").value = selectedPlot;
        document.getElementById("plantId").value = seedId;
        document.getElementById("formPlant").submit();
    }

    function closeSeedModal() {
        document.getElementById('seedModal').classList.add('hidden');
    }
</script>


<!-- Modal de Inventario -->
 <div class="modal-zone" id="inventory-modal-zone">

 
<style>
@import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
</style>

<div class="modal fade" id="inventoryModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Inventario del Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="inventoryContent">
        Cargando inventario...
      </div>
    </div>
  </div>
</div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$('#inventoryModal').on('show.bs.modal', function () {

    $.ajax({
        url: "{{ route('inventory.index') }}",
        type: 'GET',
        success: function(data) {
            $('#inventoryContent').html(data);
        },
        error: function() {
            $('#inventoryContent').html('<p>Error al cargar el inventario.</p>');
        }
    });

});
</script>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
