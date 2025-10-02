<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Maintenance Page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container mt-4">

    <div class="top-nav mb-3">
        <a href="{{ route('dashboard') }}" class="home-btn">Back to Dashboard</a>
    </div>

    <h2>Item Maintenance Page</h2>

    @if(session('success'))
        <div class="message added">{{ session('success') }}</div>
    @endif

    @if(session('update'))
        <div class="message updated">{{ session('update') }}</div>
    @endif

    @if(session('delete'))
        <div class="message deleted">{{ session('delete') }}</div>
    @endif

    <!-- Add Item Button -->
    <div class="text-end mb-3">
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addItemModal">
            + Add Item
        </button>
    </div>

    <table class="table table-bordered text-center table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Item</th>
                <th>Price</th>
                <th>Date Added</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#editItemModal{{ $item->id }}">
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>₱ {{ number_format($item->price) }}</td>
                <td>{{ \Carbon\Carbon::parse($item->date_added)->format('Y-m-d') }}</td>
                <td>
                    <button class="btn btn-sm delete-circle" data-bs-toggle="modal" data-bs-target="#deleteItemModal{{$item->id}}"
                        onclick="event.stopProgpagation()">&times;
                </td>
            </tr>

            <!-- Update Modal -->
            <div class="modal fade" id="editItemModal{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('items.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Update Item</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="name{{ $item->id }}" class="form-label">Item</label>
                                    <input type="text" name="name" id="name{{ $item->id }}" class="form-control" value="{{ $item->name }}" required>
                                </div>
                                <div class="mb-2">
                                    <label for="price{{ $item->id }}" class="form-label">Price</label>
                                    <input type="number" name="price" id="price{{ $item->id }}" class="form-control" value="{{ $item->price }}" step="1000" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Date Added</label>
                                    <input type="text" class="form-control bg-light" value="{{ \Carbon\Carbon::parse($item->date_added)->format('Y-m-d') }}" readonly>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-warning text-white">Save</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Modal -->
            <div class="modal fade" id="deleteItemModal{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('items.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete <strong>{{ $item->name }}</strong>?
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        @endforeach
        </tbody>
    </table>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('items.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="name" class="form-label">Item</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" name="price" class="form-control" value="1000" step="1000" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const messages = document.querySelectorAll('.message');
    messages.forEach(msg => {
        msg.classList.add('show');
        setTimeout(() => {
            msg.classList.remove('show');
        }, 3000);
    });
</script>
</body>
</html>