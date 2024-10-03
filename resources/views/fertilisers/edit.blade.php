@extends('layouts.app')

@section('title', 'Edit Fertiliser | NASECO')
@section('page_title', 'Edit Fertiliser')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right btn btn-default">
        <a href={{ route('fertilisers.index') }}>
            <li class="breadcrumb-item btn btn-outline-success btn-sm ">Fertiliser</li>
        </a>
    </ol>
@endsection

@section('main_content')

    <div class="col-sm-12">
        <form method="post" action="{{ route('fertilisers.update', ['fertiliser' => $fertiliser]) }}">
            @csrf
            @method('PUT')
            <div class="card card-outline card-success">
                <div class="card-body pl-5 pr-5">  
                    
                    
                    <div class="form-group">
                        <label for="name">Name *</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $fertiliser->name }}"
                            placeholder="Enter name" required>
                        @error('name')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>      
                    <div class="form-group">
                        <label for="code">Code </label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ $fertiliser->code }}"
                            placeholder="Enter code" >
                        @error('code')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div> 
                    <div class="form-group">
                        <label for="quantity_per_pack">Quantity per pack *</label>
                        <input type="number" class="form-control" id="quantity_per_pack" name="quantity_per_pack" value="{{ $fertiliser->quantity_per_pack }}"
                             required>
                        @error('quantity_per_pack')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div> 
                    <div class="form-group">
                        <label for="rate">Rate *</label>
                        <input type="text" class="form-control" id="rate" name="rate" value="{{ $fertiliser->rate }}"
                             required>
                        @error('rate')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div> 
                    <div class="form-group">
                        <label for="unit_price">Unit Price *</label>
                        <input type="number" class="form-control" id="unit_price" name="unit_price" value="{{ $fertiliser->unit_price }}"
                             required>
                        @error('unit_price')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>          
                                               
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="card-tools text-right">
                        <button name="submit" type="submit" class="btn btn-success">update Fertiliser</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
