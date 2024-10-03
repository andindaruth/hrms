@extends('layouts.app')

@section('title', 'Fuel Consumption Report for the Year ' . $year . ' ')
@section('page_title', 'Fuel Consumption Report for the Year ' . $year . ' ')
<style>
    table {
        border-collapse: collapse;
       
    }


    .active {
        background-color: blue;
        color: white;
    }

    table, th, td {
        border: 1px solid black;
    }

    th, td {
        padding: 5px;
        text-align: left;
    }

    th.rotate {
        max-width: 50px;
    }

    .bold-row td,
    .bold-column {
        font-weight: bold;
    }

    .bold-june-july {
        border-right: 2px solid black;
    }

    .bold-june-july-column {
        border-left: 2px solid black;
    }

    .highlight-yellowgreen {
        background-color: yellowgreen;
    }

    .bold-line td {
        border-bottom: 2px solid black;
    }

    /* Highlight the last row */
    .last-row td {
        background-color: yellowgreen;
    }
    .last-column {
        background-color: yellowgreen;
        font-weight: bold;
    }
    .subtotal td,
    .bold-season {
        font-weight: bold;
    }
    .bold-jul-dec {
        font-weight: bold;
    }
    .overall-column {
        font-weight: bold;
    }
    .highlight-subtotal {
        background-color: yellow;
    }
    .highlight-orange {
        background-color: orange;
    }
    .year-select {
        margin-left: 90%;
    }
</style>


@section('bread_crumb')
    <ol class="breadcrumb float-sm-right">

    </ol>
@endsection

@section('main_content')


    <!-- filter -->
    <div class="col-sm-12">

        <div class="card-body pb-0">
            <form action="{{ route('fuel-out.report-sum') }}" method="get">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="inline"> Select Reportig Year:</div>
                            <select class="form-control select2" id="year" name="year" required>
                                @foreach ($yearsArray as $y)
                                    <option value="{{ $y }}" @if ($y == $year) selected @endif>
                                        {{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            :
                            <input type="submit" class="btn bg-success form-control" value="Filter">
                        </div>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>

            </form>

            <!-- /.card-body -->
        </div><!-- /.card -->
    </div> <!-- filter -->

    <div class="col-sm-12">
        <div class="card card-success card-outline">

            <div class="card-body table-responsive">
                <table id="example3" class="table table-sm ">

                    <thead>
                        <tr>
                            <th></th>
                            <th colspan="12">Months</th>
                            <th colspan="3">Total per Vehicle </th>
                        </tr>
                        <tr>
                            <th>Vehicle</th>
                            @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                                <th class="rotate">{{ $month }}</th>
                            @endforeach
                            <th class="bold-column">Season A (Jan-Jun)</th>
                            <th class="bold-season">Season B (Jul-Dec)</th>
                            <th class="last-column overall-column">Overall (Jan-Dec)</th>
                        </tr>
                    </thead>
                    @foreach ($summaryData as $categoryName => $categoryData)
                        @php
                            $subtotalSeasonA = 0;
                            $subtotalSeasonB = 0;
                            $subtotalOverall = 0;
                            $subtotalMonths = array_fill(0, 12, 0);
                        @endphp

                        @foreach ($categoryData['vehicles'] as $vehicleName => $months)
                            <tr>
                                <td>{{ $vehicleName }}</td>
                                @php
                                    $totalSeasonA = 0;
                                    $totalSeasonB = 0;
                                    $overallTotal = 0;
                                    $counter = 0;

                                @endphp
                                @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                                    @php
                                        $totalSeasonA += $months[$month] ?? 0;
                                        $subtotalMonths[$counter] += $months[$month] ?? 0;
                                        $counter += 1;
                                        if (in_array($month, ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'])) {
                                            $subtotalSeasonA += $months[$month] ?? 0;
                                        } else {
                                            $subtotalSeasonB += $months[$month] ?? 0;
                                        }
                                        $subtotalOverall += $months[$month] ?? 0;
                                    @endphp
                                    <td>{{ $months[$month] ?? 0 }}</td>
                                @endforeach
                                <td class="bold-column">{{ $totalSeasonA }}</td>
                                <td class="bold-jul-dec">{{ $totalSeasonB }}</td>
                                <td class="last-column">{{ $totalSeasonA + $totalSeasonB }}</td>
                            </tr>
                        @endforeach

                        <!-- Subtotal per category and season -->
                        <tr class="subtotal highlight-subtotal">
                            <td><b>Subtotal ({{ $categoryName }})</b></td>
                            {{-- <td colspan="12"></td> --}}
                            @foreach ($subtotalMonths as $subtotalMonth)
                                <td>{{ $subtotalMonth }}</td>
                            @endforeach
                            <td>{{ $subtotalSeasonA }}</td>
                            <td>{{ $subtotalSeasonB }}</td>
                            <td>{{ $subtotalOverall }}</td>
                        </tr>
                    @endforeach
                    <!-- Total per month row -->
                    <tr class="bold-row last-row">
                        <td>Total per month and per season</td>
                        @php
                            $totalMonths = array_fill_keys(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], 0);
                            $totalSeasonA = 0;
                            $totalSeasonB = 0;
                            $overallTotal = 0;
                        @endphp
                        @foreach ($summaryData as $categoryData)
                            @foreach ($categoryData['vehicles'] as $months)
                                @foreach ($months as $month => $value)
                                    @php
                                        $totalMonths[$month] += $value;
                                        if (in_array($month, ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'])) {
                                            $totalSeasonA += $value;
                                        } else {
                                            $totalSeasonB += $value;
                                        }
                                        $overallTotal += $value;
                                    @endphp
                                @endforeach
                            @endforeach
                        @endforeach
                        @foreach ($totalMonths as $total)
                            <td>{{ $total }}</td>
                        @endforeach
                        <td class="highlight-orange bold-column">{{ $totalSeasonA }}</td>
                        <td class="highlight-orange bold-jul-dec">{{ $totalSeasonB }}</td>
                        <td class="highlight-orange last-column">{{ $overallTotal }}</td>
                    </tr>
                </table>

            </div>

        </div>

    </div>


@endsection
