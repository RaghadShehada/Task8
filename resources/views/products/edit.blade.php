<!doctype html>
<html>
<head><title>Edit Product</title></head>
<body>
    <h2>Edit Product</h2>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        Name: <input type="text" name="name" value="{{ old('name', $product->name) }}"><br><br>
        Price: <input type="text" name="price" value="{{ old('price', $product->price) }}"><br><br>

        <button type="submit">Update</button>
    </form>

    <br>
    <a href="{{ route('products.index') }}">Back to list</a>
</body>
</html>
