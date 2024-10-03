@extends('layouts.app5')

@section('title', 'packaging In')
@section('page_title', 'New packaging In Transaction')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right btn btn-default">
        <a href={{ route('packaging-in.index') }}>
            <li class="breadcrumb-item btn btn-outline-success btn-sm ">Packaging In Transactions</li>
        </a>
    </ol>
@endsection

@section('main_content')

    <div class="col-sm-12">
        <form method="post" action="{{ route('packaging-in.store') }}">
            @csrf
            <div class="card card-outline card-success pl-5 pr-5">
                <div class="card-body">

                    <div class="form-group">
                        <label for="date">Transaction Date *</label>
                        <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                            <div class="input-group-prepend" data-target="#reservationdate1" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <input id="date" name="date" type="text" class="form-control datetimepicker-input"
                                data-target="#reservationdate1" value="{{ old('date') }}" placeholder="YYYY-MM-DD"
                                required>
                        </div>
                        @error('date')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="packaging_id">Packaging *</label>
                        <select class="form-control select2" id="packaging_id" name="packaging_id" required>
                            <option value="">--Select Packaging</option>
                            @foreach ($packagings as $packaging)
                                <option value="{{ $packaging->id }}">
                                    {{ $packaging->code }} - {{ $packaging->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('packaging_id')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="vehicle_id">Vehicle *</label>
                        <select class="form-control select2" id="vehicle_id" name="vehicle_id" required>
                            <option value="">--Select Vehicle</option>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">
                                    {{ $vehicle->number_plate }}
                                </option>
                            @endforeach
                        </select>
                        @error('vehicle_id')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="delivery_note_no">Delivery Note Number *</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="delivery_note_no" name="delivery_note_no"
                                value="{{ old('delivery_note_no') }}" required>
                            @error('delivery_note_no')
                                <div class="text-sm text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="internal_delivery_no">Internal Delivery Number *</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="internal_delivery_no" name="internal_delivery_no"
                                value="{{ old('internal_delivery_no') }}" required>
                            @error('internal_delivery_no')
                                <div class="text-sm text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="no_of_packs">Number of Packs *</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="no_of_packs" name="no_of_packs"
                                value="{{ old('no_of_packs') }}" required>
                            @error('no_of_packs')
                                <div class="text-sm text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div id="quantityInputs"></div>

                    <!-- Hidden field for total quantity -->
                    <input type="hidden" id="total_quantity" name="total_quantity">

                    <script>
                        document.getElementById('no_of_packs').addEventListener('input', function() {
                            var noOfPacks = parseInt(this.value);
                            var quantityInputs = document.getElementById('quantityInputs');
                            quantityInputs.innerHTML = '';

                            if (noOfPacks > 0) {
                                var table = document.createElement('table');
                                table.classList.add('table', 'table-bordered');

                                // Create header row
                                var headerRow = document.createElement('tr');
                                var headerCell = document.createElement('th');
                                headerCell.textContent = 'Pack';
                                headerRow.appendChild(headerCell);
                                for (var i = 0; i < noOfPacks; i++) {
                                    var headerCell = document.createElement('th');
                                    headerCell.textContent = 'Pack ' + (i + 1);
                                    headerRow.appendChild(headerCell);
                                }
                                var totalHeaderCell = document.createElement('th');
                                totalHeaderCell.textContent = 'Total';
                                headerRow.appendChild(totalHeaderCell);
                                table.appendChild(headerRow);

                                // Create value row
                                var valueRow = document.createElement('tr');
                                var packNumberCell = document.createElement('td');
                                packNumberCell.textContent = 'Quantity';
                                valueRow.appendChild(packNumberCell);
                                for (var i = 0; i < noOfPacks; i++) {
                                    var inputCell = document.createElement('td');
                                    var input = document.createElement('input');
                                    input.type = 'number'; // Ensure input type is number
                                    input.classList.add('form-control', 'quantity');
                                    input.required = true;
                                    input.name = 'quantity[]'; // Use array notation for input names
                                    input.placeholder = 'Enter quantity';
                                    input.step = '0.01'; // Allow float values
                                    input.addEventListener('input', calculateTotal);
                                    inputCell.appendChild(input);
                                    valueRow.appendChild(inputCell);
                                }
                                var totalCell = document.createElement('td');
                                var totalInput = document.createElement('input');
                                totalInput.type = 'text';
                                totalInput.classList.add('form-control', 'total');
                                totalInput.readOnly = true;
                                totalCell.appendChild(totalInput);
                                valueRow.appendChild(totalCell);
                                table.appendChild(valueRow);

                                quantityInputs.appendChild(table);
                            }
                        });

                        function calculateTotal() {
                            var quantities = document.querySelectorAll('.quantity');
                            var total = 0;
                            quantities.forEach(function(input) {
                                var value = parseFloat(input.value);
                                if (!isNaN(value)) {
                                    total += value;
                                }
                            });
                            document.querySelector('.total').value = total.toFixed(2); // Display total as float
                            document.getElementById('total_quantity').value = total.toFixed(2); // Store total as float
                        }
                    </script>

                    <input type="text" class="form-control" id="user_id" name="user_id" value="{{ $user->id }}"
                        hidden>
                    <input type="text" class="form-control" id="type" name="type" value="In" hidden>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="card-tools text-right">
                        <button name="submit" type="submit" class="btn btn-success">Save Transaction</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
