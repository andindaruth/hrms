@extends('layouts.app3')

@section('title', 'Edit Chemical | NASECO')
@section('page_title', 'Edit Chemical')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right btn btn-default">
        <a href={{ route('chemicals.index') }}>
            <li class="breadcrumb-item btn btn-outline-success btn-sm ">Chemical</li>
        </a>
    </ol>
@endsection

@section('main_content')

    <div class="col-sm-12">
        <form method="post" action="{{ route('chemicals.update', ['chemical' => $chemical]) }}">
            @csrf
            @method('PUT')
            <div class="card card-outline card-success">
                <div class="card-body pl-5 pr-5">  
                    
                    
                    <div class="form-group">
                        <label for="name">Name *</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $chemical->name }}"
                            placeholder="Enter name" required>
                        @error('name')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>      
                    <div class="form-group">
                        <label for="code">Code </label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ $chemical->code }}"
                            placeholder="Enter code" >
                        @error('code')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div> 
                    <div class="form-group">
                        <label for="category">Category *</label>
                        <select class="form-control select2" id="category" name="category" required>
                            <option value="">--Select category</option>                            
                            <option value="Seed treatment"  @if ($chemical->category == "Seed treatment") selected @endif>Seed treatment (CF)</option>
                            <option value="Farm" @if ($chemical->category == "Farm") selected @endif>Farm (CC)</option>                          
                        </select>
                        @error('category')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>   
                    <div class="form-group">
                        <label for="purpose">Purpose *</label>
                        <select class="form-control select2" id="purpose" name="purpose" required>
                            <option selected>{{ $chemical->purpose }}</option>                            
                            <option>Total herbicide </option> 
                            <option>Selective herbicide </option> 
                            <option>Pre emergence herb </option> 
                            <option>pre herbi maize grass  </option> 
                            <option>herbicide </option> 
                            <option>Post herbi maize grass </option> 
                            <option>post ememergence </option>
                            <option>contact insectcide </option> 
                            <option>Pesticide </option> 
                            <option>insecticide </option> 
                            <option>Fungicide </option>
                            <option> Dye </option>
                            <option>Parent Seed </option>
                            <option>Fungicide </option>
                            <option>Systemic insectcide </option>                         
                        </select>
                        @error('purpose')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>  
                    <div class="form-group">
                        <label for="unit_of_measure">Unit of measurement *</label>
                        <select class="form-control select2" id="unit_of_measure" name="unit_of_measure" required>
                            <option value="">--Select unit of measure</option>                            
                            <option value="lt" @if ($chemical->unit_of_measure == "lt") selected @endif>Litres</option>
                            <option @if ($chemical->unit_of_measure == "Kg") selected @endif>Kg</option>                          
                        </select>
                        @error('unit_of_measure')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>     
                    <div class="form-group">
                        <label for="quantity_per_pack">Quantity per pack *</label>
                        <input type="number" class="form-control" id="quantity_per_pack" name="quantity_per_pack" value="{{ $chemical->quantity_per_pack }}"
                             required>
                        @error('quantity_per_pack')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div> 
                    <div class="form-group">
                        <label for="rate">Rate *</label>
                        <input type="text" class="form-control" id="rate" name="rate" value="{{ $chemical->rate }}"
                             required>
                        @error('rate')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div> 
                    <div class="form-group">
                        <label for="unit_price">Unit Price *</label>
                        <input type="number" class="form-control" id="unit_price" name="unit_price" value="{{ $chemical->unit_price }}"
                             required>
                        @error('unit_price')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>          
                                               
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="card-tools text-right">
                        <button name="submit" type="submit" class="btn btn-success">update Chemical</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
