@extends('layouts.app5')

@section('title', 'Edit Packaging | NASECO')
@section('page_title', 'Edit Packaging')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right btn btn-default">
        <a href={{ route('packagings.index') }}>
            <li class="breadcrumb-item btn btn-outline-success btn-sm ">Packaging</li>
        </a>
    </ol>
@endsection

@section('main_content')

    <div class="col-sm-12">
        <form method="post" action="{{ route('packagings.update', ['packaging' => $packaging]) }}">
            @csrf
            @method('PUT')
            <div class="card card-outline card-success">
                <div class="card-body pl-5 pr-5">  
                    
                    
                    <div class="form-group">
                        <label for="name">Name *</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $packaging->name }}"
                            placeholder="Enter name" required>
                        @error('name')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>      
                    <div class="form-group">
                        <label for="code">Code </label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ $packaging->code }}"
                            placeholder="Enter code" >
                        @error('code')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div> 
                    <div class="form-group">
                        <label for="purpose">Purpose *</label>
                        <input type="text" class="form-control" id="purpose" name="purpose" value="{{ old('purpose') }}"
                            placeholder="Enter purpose" >
                        @error('purpose')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category">Category *</label>
                        <select class="form-control select2" id="category" name="category" required>
                            <option value="">--Select category</option>                            
                            <option value="Roll"  @if ($packaging->category == "Roll") selected @endif>Roll</option>
                            <option value="Bell" @if ($packaging->category == "Bell") selected @endif>Bell</option>                          
                        </select>
                        @error('category')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>   
                    <div class="form-group">
                        <label for="purpose">Purpose *</label>
                        <input type="text" class="form-control" id="purpose" name="purpose" value="{{ $packaging->purpose }}"
                            placeholder="Enter purpose" >
                        @error('purpose')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>                     
                    
                   <div class="form-group">
                        <label for="rate">Rate *</label>
                        <input type="text" class="form-control" id="rate" name="rate" value="{{ $packaging->rate }}"
                             required>
                        @error('rate')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div> 
                    <div class="form-group">
                        <label for="unit_price">Unit Cost *</label>
                        <input type="number" class="form-control" id="unit_price" name="unit_price" value="{{ $packaging->unit_price }}"
                             required>
                        @error('unit_price')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>          
                                               
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="card-tools text-right">
                        <button name="submit" type="submit" class="btn btn-success">update Packaging</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
