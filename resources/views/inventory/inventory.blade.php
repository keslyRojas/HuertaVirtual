<table class="table table-bordered">
    <thead>
        <tr>
            <th>Item</th>
            <th>Categoría</th>
            <th>Cantidad</th>
        </tr>
    </thead>

    <tbody>
        @forelse($inventory as $inv)
            <tr>
                <td>{{ $inv->item->name }}</td>
                <td>{{ $inv->item->category->name }}</td>
                <td>{{ $inv->quantity }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">No tienes items en tu inventario.</td>
            </tr>
        @endforelse
    </tbody>
</table>
