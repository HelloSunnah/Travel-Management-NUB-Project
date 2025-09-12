@extends('master')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Manage Food Menus</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
        <div class="container mt-4">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"> Manage Food Menus</h4>
                  <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#foodModal"
            onclick="openFoodModal()">+ Add Food Menu</button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                              <tr>
                        <th>Name</th>
                        <th>Destination</th>
                        <th>Menu Items</th>
                        <th>Price (TK)</th>
                        <th>Actions</th>
                    </tr>
                        </thead>
                        <tbody>
                                 @foreach($foods as $food)
                    <tr>
                        <td>{{ $food->name }}</td>
                        <td>{{ $food->destination->name ?? 'N/A' }}</td>
                        <td>{{ $food->menu_items }}</td>
                        <td>{{ $food->price }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary mb-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#foodModal"
                                    onclick="openFoodModal({{ $food }})">Edit</button>

                            <form action="{{ route('foods.destroy', $food) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
















</div>

{{-- Bootstrap Modal --}}
<div class="modal fade" id="foodModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="foodForm" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="foodModalTitle">Add Food Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="formMethod" name="_method" value="POST">

          <div class="mb-3">
              <label for="name" class="form-label">Food Name</label>
              <input type="text" id="name" name="name" class="form-control" required>
          </div>

          <div class="mb-3">
              <label for="destination_id" class="form-label">Destination</label>
              <select id="destination_id" name="destination_id" class="form-control" required>
                  <option value="">Select Destination</option>
                  @foreach($destinations as $destination)
                      <option value="{{ $destination->id }}">{{ $destination->name }}</option>
                  @endforeach
              </select>
          </div>

          <div class="mb-3">
              <label for="menu_items" class="form-label">Menu Items</label>
              <textarea id="menu_items" name="menu_items" class="form-control" rows="3" required></textarea>
          </div>

          <div class="mb-3">
              <label for="price" class="form-label">Price (TK)</label>
              <input type="number" step="0.01" id="price" name="price" class="form-control" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success" id="submitBtn">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- JavaScript --}}
<script>
    function openFoodModal(food = null) {
        let form = document.getElementById('foodForm');
        let methodInput = document.getElementById('formMethod');
        let modalTitle = document.getElementById('foodModalTitle');
        let submitBtn = document.getElementById('submitBtn');

        if (food) {
            // Edit mode
            form.action = `/foods/${food.id}`;
            methodInput.value = "PUT";
            modalTitle.textContent = "Edit Food Menu";
            submitBtn.textContent = "Update";

            // Fill form fields
            document.getElementById('name').value = food.name;
            document.getElementById('destination_id').value = food.destination_id;
            document.getElementById('menu_items').value = food.menu_items;
            document.getElementById('price').value = food.price;
        } else {
            // Add mode
            form.action = "{{ route('foods.store') }}";
            methodInput.value = "POST";
            modalTitle.textContent = "Add Food Menu";
            submitBtn.textContent = "Save";

            // Clear form
            form.reset();
        }
    }
</script>
@endsection
