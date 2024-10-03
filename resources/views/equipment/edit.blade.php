@extends('layouts.app6')

@section('title', 'Edit Equipment | NASECO')
@section('page_title', 'Edit Equipment')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right btn btn-default">
        <a href="{{ route('equipment.actions') }}" class="btn float-right bg-success"> <i class="fas fa-tasks"></i> Actions
        </a>
    </ol>
@endsection

@section('main_content')

    <div class="col-sm-12">
        <form method="post" action="{{ route('equipment.update', ['equipment' => $equipment]) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card card-outline card-success">
                <div class="card-body pl-5 pr-5">


                    <div class="form-group">
                        <label for="name">Name *</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $equipment->name }}" placeholder="Enter name" required>
                        @error('name')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Description </label>
                        <input type="text" class="form-control" id="description" name="description"
                            value="{{ $equipment->description }}" placeholder="Enter description">
                        @error('description')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category1">Category 1*</label>
                        <select class="form-control select2" id="category1" name="category1" required>
                            <option value="">--Select category 1</option>                            
                            <option value="item"  @if ($equipment->category1 == "item") selected @endif>Item</option>
                            <option value="tool" @if ($equipment->category1 == "tool") selected @endif>Tool</option>      
                            <option value="spare_part" @if ($equipment->category1 == "spare_part") selected @endif>Spare_part</option>                        
                        </select>
                        @error('category1')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>   
                    <div class="form-group">
                        <label for="category2">Category 2 </label>
                        <select class="form-control select2" id="category2" name="category2" required>
                            <option value="">--Select category 2</option>                            
                            <option value="farm"  @if ($equipment->category2 == "farm") selected @endif>Farm</option>
                            <option value="workshop" @if ($equipment->category2 == "workshop") selected @endif>Workshop</option>                             
                        </select>
                        @error('category2')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category3">Category 3 </label>
                        <select class="form-control select2" id="category1" name="category3" required>
                            <option value="">--Select category 3</option>                            
                            <option value="returnable"  @if ($equipment->category3 == "returnable") selected @endif>Returnable</option>
                            <option value="non_returnable" @if ($equipment->category3 == "non_returnable") selected @endif>Non_returnable</option>                            
                        </select>
                        @error('category3')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="quantity_in_stock">Quantity in Stock *</label>
                        <input type="text" class="form-control" id="quantity_in_stock" name="quantity_in_stock"
                            value="{{ $equipment->quantity_in_stock }}" required>
                        @error('quantity_in_stock')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="re_order_value">Re-order value *</label>
                            <input type="text" class="form-control" id="re_order_value" name="re_order_value"
                                value="{{ $equipment->re_order_value }}" required>
                            @error('re_order_value')
                                <div class="text-sm text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                        <label for="image">Image *</label>
                        <input type="file" name="image" id="imageInput" accept="image/*" class="form-control">

                        <div class="image-preview" id="imagePreview">
                            @if($equipment->image) <!-- Check if there's an existing image -->
                                <img src="{{ asset('storage/' . $equipment->image) }}" alt="Equipment Image" class="img-fluid" style="width: 175px; height: 200px;">
                            @else
                                <p>No image selected</p>
                            @endif
                        </div>
                        @error('image')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <script>
                        document.getElementById('imageInput').addEventListener('change', function(event) {
                            const file = event.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const imagePreview = document.getElementById('imagePreview');
                                    imagePreview.innerHTML =
                                        `<img src="${e.target.result}" alt="Selected Image" class="img-fluid" style="width: 175px; height: 200px;">`;
                                }
                                reader.readAsDataURL(file);
                            } else {
                                document.getElementById('imagePreview').innerHTML = '<p>No image selected</p>';
                            }
                        });
                    </script>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="card-tools text-right">
                                <button name="submit" type="submit" class="btn btn-success">update</button>
                            </div>
                        </div>
                    </div>
        </form>
    </div>

@endsection
