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


<!-- ==============================
     MODAL DE SELECCIÓN DE SEMILLA
============================== -->
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

<!-- ==============================
     TOP BAR
============================== -->
<div class="top-bar">

    <div class="coins-box">
        <img src="{{ asset('img/coin.png') }}" class="coin">
        <img src="" class="coin coin2">
    </div>

    <div class="right-side">
        <div class="top-icons">
            <button class="icon-btn"><img src="{{ asset('img/bell.png') }}" class="icon-img"></button>
            <button class="icon-btn"><img src="{{ asset('img/store.png') }}" class="icon-img"></button>
        </div>

        <div class="user-card">
            <img src="{{ asset('img/user.png') }}" class="user-icon">
            <div class="user-info">
                <p><strong>Usuario:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Semillas disponibles:</strong> 0</p>
                <p><strong>Productos cosechados:</strong> 0</p>
            </div>
        </div>
    </div>

</div>

<!-- ==============================
     ALERTAS
============================== -->
@if(session('success'))
<div class="alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert-error">{{ session('error') }}</div>
@endif

<!-- ==============================
     PARRCELAS
============================== -->
<div class="main-box">
    @foreach($plots as $plot)
        <div class="inner-box plot" data-id="{{ $plot->id }}"></div>
    @endforeach
</div>

<!-- ==============================
     BOTONES DE ACCIÓN
============================== -->
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
    <button class="img-btn" onclick="alert('Fertilizar no implementado aún');">
        <img src="{{ asset('img/fertilizer-btn.png') }}" alt="Abonar">
    </button>

    <!-- COSECHAR -->
    <button class="img-btn" onclick="submitAction('harvest')">
        <img src="{{ asset('img/harvest-btn.png') }}" alt="Cosechar">
    </button>

</div>

<!-- ==============================
     FORMULARIOS INVISIBLES
============================== -->

<!-- Sembrar -->
<form id="formPlant" method="POST" action="{{ route('garden.plant') }}" class="hidden-form">
    @csrf
    <input type="hidden" name="garden_plot_id" id="plotPlant">
    <input type="hidden" name="plant_id" id="plantId">
</form>

<!-- Regar -->
<form id="formWater" method="POST" action="{{ route('garden.water') }}" class="hidden-form">
    @csrf
    <input type="hidden" name="garden_plot_id" id="plotWater">
</form>

<!-- Cosechar -->
<form id="formHarvest" method="POST" action="{{ route('garden.harvest') }}" class="hidden-form">
    @csrf
    <input type="hidden" name="garden_plot_id" id="plotHarvest">
</form>

<!-- ==============================
     JAVASCRIPT
============================== -->
<script>
    let selectedPlot = null;

    // Seleccionar parcela
    document.querySelectorAll('.plot').forEach(plot => {
        plot.addEventListener('click', () => {
            selectedPlot = plot.getAttribute('data-id');

            document.querySelectorAll('.plot').forEach(p => p.style.outline = "none");
            plot.style.outline = "4px solid yellow";
        });
    });

    // Acciones
    function submitAction(action) {
        if (!selectedPlot) {
            alert("Selecciona una parcela primero.");
            return;
        }

        // ABRIR EL MODAL DE SEMILLAS
        if (action === "seed") {
            document.getElementById('seedModal').classList.remove('hidden');
            return;
        }

        // REGAR
        if (action === "water") {
            document.getElementById("plotWater").value = selectedPlot;
            document.getElementById("formWater").submit();
        }

        // COSECHAR
        if (action === "harvest") {
            document.getElementById("plotHarvest").value = selectedPlot;
            document.getElementById("formHarvest").submit();
        }
    }

    // Seleccionar semilla y sembrar
    function selectSeed(seedId) {
        document.getElementById("plotPlant").value = selectedPlot;
        document.getElementById("plantId").value = seedId;
        document.getElementById("formPlant").submit();
    }

    // Cerrar modal
    function closeSeedModal() {
        document.getElementById('seedModal').classList.add('hidden');
    }
</script>

</body>
</html>
