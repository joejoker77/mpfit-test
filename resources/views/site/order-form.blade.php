<form method="post" action="{{ route('order.create') }}" enctype="multipart/form-data">
    @csrf
    <h5>Вы оформляете заказ на товар:<br>{{$product->name}}</h5>
    <div class="mb-3">
        <label for="customerName" class="form-label">Ваше имя (Ф.И.О)</label>
        <input type="text" class="form-control" id="customerName" name="customerName" required>
    </div>
    <div class="mb-3">
        <label for="customerNote" class="form-label">Комментарий к заказу</label>
        <textarea class="form-control" id="customerNote" rows="5" name="customerNote" required></textarea>
    </div>
    <input type="hidden" name="productId" value="{{ $product->id }}">
    <input type="hidden" name="productQuantity" value="{{ $quantity }}">
    <button type="submit" class="btn btn-primary w-100">Оформить заказ</button>
</form>
