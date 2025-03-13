<x-app-layout>
    <div class="container py-4">
        <h2 class="mb-4">User List</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Products</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->products->count() > 0)
                                    <ol class="list-unstyled">
                                        @foreach($user->getAllProducts() as $key => $product)
                                            <li>{{ $key+1 }}. {{ $product->title }}</li>
                                        @endforeach
                                    </ol>
                                @else
                                    No products
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
