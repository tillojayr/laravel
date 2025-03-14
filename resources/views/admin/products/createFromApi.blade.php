<x-app-layout>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Products Management</h2>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Body</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            @if(isset($product->image))
                                <img src="{{ $product->image }}" alt="{{ $product->title }}" class="img-thumbnail" style="max-width: 100px">
                            @elseif(isset($product->images[0]))
                                <img src="{{ $product->images[0] }}" alt="{{ $product->title }}" class="img-thumbnail" style="max-width: 100px">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->description }}</td>
                        <td>
                            <form action="{{ route('admin.products.api.store', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">+ Add</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
