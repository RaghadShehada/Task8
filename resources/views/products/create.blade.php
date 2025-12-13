<!doctype html>
<html>
<head><title>Add Product</title></head>
<body>
    <h2>Add New Product</h2>

    @if ($errors->any())
        <div style="color:red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        Name: <input type="text" name="name" value="{{ old('name') }}"><br><br>
        Price: <input type="text" name="price" value="{{ old('price') }}"><br><br>

        <button type="submit">Save</button>
    </form>

    <br>
    <a href="{{ route('products.index') }}">Back to list</a>
</body>
</html>
