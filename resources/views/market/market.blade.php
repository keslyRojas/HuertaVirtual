<table class="table table-bordered">
    <tr>
        <th>Item</th>
        <th>Precio</th>
        <th>Comprar</th>
        <th>Vender</th>
    </tr>

    @foreach($items as $item)
    <tr>
        <td>{{ $item->name }}</td>
        <td>{{ $item->price }} $</td>

        <td>
            @if(in_array($item->category->name, ['Improved & Special Seeds', 'Fertilizer']))
            <button class="btn btn-success buy-btn" data-id="{{ $item->id }}">Comprar</button>
            @else
            <button class="btn btn-success" disabled>Comprar</button>
            @endif
        </td>

        <td>
            @if($item->category->name === 'Products')
            <button class="btn btn-danger sell-btn" data-id="{{ $item->id }}">Vender</button>
            @else
            <button class="btn btn-danger" disabled>Vender</button>
            @endif
        </td>
    </tr>
    @endforeach
</table>

<script>
$(document).ready(function() {
    function updateCoins(newBalance) {
        $('.coin-amount').text(newBalance);
    }

    $('.buy-btn').click(function () {
        let itemId = $(this).data('id');
        $.post("{{ route('market.buy') }}", {_token:"{{ csrf_token() }}", item_id:itemId}, function(res) {
            $('#marketModal').modal('hide');
            alert(res.message);
            updateCoins(res.newBalance);
        }).fail(function(xhr){
            alert(xhr.responseJSON?.error || "Error al comprar.");
        });
    });

    $('.sell-btn').click(function () {
        let itemId = $(this).data('id');
        $.post("{{ route('market.sell') }}", {_token:"{{ csrf_token() }}", item_id:itemId}, function(res) {
            $('#marketModal').modal('hide');
            alert(res.message);
            updateCoins(res.newBalance);
        }).fail(function(xhr){
            alert(xhr.responseJSON?.error || "Error al vender.");
        });
    });
});
</script>
