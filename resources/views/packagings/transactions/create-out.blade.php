@extends('layouts.app5')

@section('title', 'packaging Out')
@section('page_title', 'New packaging Out Transaction')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right btn btn-default">
        <a href={{ route('packaging-out.index') }}>
            <li class="breadcrumb-item btn btn-outline-success btn-sm ">Packaging Out Transactions</li>
        </a>
    </ol>
@endsection

@section('main_content')

    <div class="col-sm-12">
        <form method="post" action="{{ route('packaging-out.store') }}">
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
                        <label for="person_id">Taken By *</label>
                        <select class="form-control select2" id="person_id" name="person_id" required>
                            <option value="">--Select Person</option>
                            @foreach ($operators as $operator)
                                <option value="{{ $operator->id }}">
                                    {{ $operator->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('person_id')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="destination">Destination *</label>
                        <select class="form-control select2" id="destination" name="destination" required>
                            <option value="">--Select Destination</option>
                            <option value="Factory"> Factory</option>
                            <option value="Parent Seed">Parent Seed</option>
                        </select>
                        @error('destination')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="receipt_no">Receipt Number *</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="receipt_no" name="receipt_no"
                                value="{{ old('receipt_no') }}" required>
                            @error('receipt_no')
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
                    <input type="text" class="form-control" id="type" name="type" value="Out" hidden>
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
