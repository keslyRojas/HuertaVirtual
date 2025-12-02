<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huerta</title>

    <link rel="stylesheet" href="{{ asset('css/huerta.css') }}">
</head>
<body>


   <div class="top-bar">

 
    <div class="coins-box">
        <img src="/img/coin.png" class="coin">
        <img src="" class="coin coin2">
    </div>


    <div class="right-side">

        <div class="top-icons">
            <button class="icon-btn">
                <img src="/img/bell.png" class="icon-img">
            </button>

            <button class="icon-btn">
                <img src="/img/store.png" class="icon-img">
            </button>
        </div>

        <div class="user-card">
            <img src="/img/user.png" class="user-icon">
            <div class="user-info">
                <p><strong>Usuario:</strong> Invitado</p>
                <p><strong>Semillas disponibles:</strong> 0</p>
                <p><strong>Productos cosechados:</strong> 0</p>
            </div>
        </div>

    </div>

</div>

    <div class="main-box">
        <div class="inner-box"></div>
        <div class="inner-box"></div>
    </div>


    <div class="action-buttons">

        <button class="img-btn">
            <img src="/img/water-btn.png" alt="Water">
        </button>

        <button class="img-btn">
            <img src="/img/plant-btn.png" alt="Plant">
        </button>

        <button class="img-btn">
            <img src="/img/harvest-btn.png" alt="Harvest">
        </button>

        <button class="img-btn">
            <img src="/img/fertilizer-btn.png" alt="Fertilize">
        </button>

    </div>

</body>
</html>
