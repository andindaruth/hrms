@extends('layouts.app6')

@section('title', 'New Equipment | NASECO')
@section('page_title', 'New Equipment')

@section('bread_crumb')
<ol class="breadcrumb float-sm-right">
    <a href="{{ route('equipment.actions') }}" class="btn float-right bg-success"> <i class="fas fa-tasks"></i> Actions</a>
</ol>
@endsection

@section('main_content')
<div class="col-sm-12">
    <form method="post" action="{{ route('equipment.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card card-outline card-success pl-5 pr-5">
            <div class="card-body">

                <div class="form-group">
                    <label for="name">Name of Equipment*</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter name" required>
                    @error('name')
                        <div class="text-sm text-danger">{{ $message }}</div>
                    @enderror
                </div> 
                <div class="form-group">
                    <label for="category1">Category 1*</label>
                    <select class="form-control select2" id="category1" name="category1" required>
                        <option value="">--Select category</option>                            
                        <option value="item">Item</option>
                        <option value="tool">Tool</option>
                        <option value="spare_part">Spare Part</option>
                        <option value="material">Material</option>                         
                    </select>
                    @error('category1')
                        <div class="text-sm text-danger">{{ $message }}</div>
                    @enderror
                </div> 
                <div class="form-group">
                    <label for="category2">Category 2*</label>
                    <select class="form-control select2" id="category2" name="category2" required>
                        <option value="">--Select category</option> 
                        <option value="workshop">Workshop</option>                           
                        <option value="farm">Farm</option>
                                                   
                    </select>
                    @error('category2')
                        <div class="text-sm text-danger">{{ $message }}</div>
                    @enderror
                </div>   
                <div class="form-group">
                    <label for="category3">Category 3*</label>
                    <select class="form-control select2" id="category3" name="category3" required>
                        <option value="">--Select category</option>                            
                        <option value="returnable">Returnable</option>
                        <option value="non_returnable">Non-Returnable</option>                           
                    </select>
                    @error('category3')
                        <div class="text-sm text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Description/Purpose</label>
                    <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}" placeholder="Enter description/purpose">
                    @error('description')
                        <div class="text-sm text-danger">{{ $message }}</div>
                    @enderror
                </div> 
                   
                <div class="form-group">
                    <label for="quantity_in_stock">Quantity In stock*</label>
                    <input type="text" class="form-control" id="quantity_in_stock" name="quantity_in_stock" value="{{ old('quantity_in_stock') }}" required>
                    @error('quantity_in_stock')
                        <div class="text-sm text-danger">{{ $message }}</div>
                    @enderror
                </div> 
                <div class="form-group">
                    <label for="re_order_value">Re-order value *</label>
                    <input type="text" class="form-control" id="re_order_value" name="re_order_value" value="{{ old('re_order_value') }}" required>
                    @error('re_order_value')
                        <div class="text-sm text-danger">{{ $message }}</div>
                    @enderror
                </div>          
                <div class="form-group">
                        <label for="image">Image *</label>
                        <input type="file" name="image" id="imageInput" accept="image/*" class="form-control">
                                                    <div class="image-preview" id="imagePreview">
                                                        <p>No image selected</p>
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
                imagePreview.innerHTML = `<img src="${e.target.result}" alt="Selected Image" class="img-fluid" style="width: 175px; height: 200px;">`;
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
                    <button name="submit" type="submit" class="btn btn-success">Create </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
