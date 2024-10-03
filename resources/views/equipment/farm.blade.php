@extends('layouts.app6')

@section('title', 'Farm ')
@section('page_title', 'Farm')

@section('main_content')

    <div class="col-sm-12">
        <div class="card card-success card-outline">
            <div class="card-header">
                <!-- <h4 class="card-title text-success">Equipment</h4> -->
            </div>
            <div class="card-body table-responsive">
                <table id="example3" class="table table-hover table-head-fixed table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Re-order value</th>
                            <th>Quantity in stock</th>
                            <th>Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @unless ($equipment->isEmpty())
                            @foreach ($equipment as $equipment)
                                @if ($equipment->category2 === 'farm') <!-- Filtering by category1 -->
                                    <tr class="text-nowrap">
                                        <td>
                                            <img src="{{ Storage::url($equipment->image) }}" alt="{{ $equipment->name }}" class="img-fluid" style="max-width: 60px; height: 75px;">
                                        </td>
                                        <td>
                                            <a href="{{ route('equipment.edit', $equipment->id) }}">{{ $equipment->name }}</a>
                                        </td>
                                        <td>{{ $equipment->description }}</td>
                                        <td>{{ $equipment->re_order_value }}</td>
                                        <td>{{ $equipment->quantity_in_stock }}</td>
                                        <td>
                                            @if($equipment->quantity_in_stock > $equipment->re_order_value + 10)
                                            <span style="background-color: #90EE90; color: black;">Stock OK</span>
                                           @elseif($equipment->quantity_in_stock >= $equipment->re_order_value && $equipment->quantity_in_stock <= $equipment->re_order_value + 10)
                                            <span style="background-color: yellow; color: black;">Need to Re-stock soon</span>
                                           @else
                                             <span style="background-color: red; color: black;">Crtical: Re-Stock now</span>
                                        @endif
                                         </td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <tr class="border-gray-300">
                                <td colspan="10">
                                    <p class="text-center">No equipment Found</p>
                                </td>
                            </tr>
                        @endunless
                    </tbody>
                </table>
            </div> <!-- /.card-body -->
        </div>
    </div>

@endsection
