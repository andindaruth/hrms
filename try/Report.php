<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Vehicle Data</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin-left: 20%;
        }

        h3 {
            margin-left: 20%;
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
</head>
<body>

<?php

$vehicleName = strtoupper(substr($transaction->vehicle->category->name, 0, 1)).'/'.$transaction->vehicle->model.'/'.$transaction->vehicle->number_plate;
// Define months and vehicle headers
$months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
$vehicles = array('UBA227W/JD5075E', 'UAW178Y/JD6100B', 'UAV851F/JD5503', 'UAV746F/JD6125D', 'UAZ149Y/JD6125D', 'UAT358R/JD5503', 'NEW290MF', 'OLD290MF', 'UBB904D', 'UBM 902T', 'UBM 901T', 'UBP 634J/UBP207Q', 'COMBINE', 'UBH 547TMACCOR', 'ISUZU', 'CANTER', 'TATA', 'SCANIA', 'CRANE Hired truck', 'UAE 200M', 'UAW 490K', 'BULL/BACKHOE', 'OTHERS/Mixture', 'Excavator', 'TANGI FARM', 'GENERATOR');

// Initialize data array with 0 for each combination of month and vehicle
$data = array();
foreach ($vehicles as $vehicle) {
    foreach ($months as $month) {
        $data[$vehicle][$month] = 0;
    }
    // Add total per vehicle
    $data[$vehicle]['Total'] = 0;
}

// Fill in some dummy data for demonstration purposes
foreach ($months as $month) {
    foreach ($vehicles as $vehicle) {
        // Dummy data, replace with actual data retrieval logic
        $data[$vehicle][$month] = rand(0, 100);
        $data[$vehicle]['Total'] += $data[$vehicle][$month];
    }
}

// Calculate total per month
foreach ($months as $month) {
    $total = 0;
    foreach ($vehicles as $vehicle) {
        $total += $data[$vehicle][$month];
    }
    $data['Total'][$month] = $total;
}

// Calculate grand total per vehicle
foreach ($vehicles as $vehicle) {
    $data[$vehicle]['Total'] = array_sum(array_slice($data[$vehicle], 0, -1)); // Exclude "Total" key
}

// Calculate grand total per month
$total = 0;
foreach ($months as $month) {
    $total += $data['Total'][$month];
}
$data['Total']['Total'] = $total;

?>

<!-- table to display detailed fuel consumption data -->

<h3>
<select class="year-select">
        <?php
        // Get current year
        $currentYear = date('Y');
        for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
            echo "<option value='$i'>$i</option>";
        }
        ?>
    </select>
</h3>
    
<table class="detail">
    <tr>
        <th colspan ="16"><h3>Summary Report of fuel Consumption for each Vehicle per Month and per Season for year :2024 </h3></th>
    </tr>
    <tr>
        <th></th>
        <th colspan="12">Months</th>
        <th colspan="3">Total per Vehicle </th>
    </tr>
    <tr>
        <th></th>
        <?php foreach ($months as $index => $month): ?>
            <th class="rotate <?php if ($index === 5) echo 'bold-june-july'; ?>"><?php echo $month; ?></th>
        <?php endforeach; ?>
        <th class="bold-column">Season A (Jan-Jun)</th>
        <th class="bold-season">Season B (Jul-Dec)</th>
        <th class="last-column overall-column">Overall (Jan-Dec)</th>
    </tr>

    <?php foreach ($vehicles as $index => $vehicle): ?>
        <tr>
            <td><?php echo $vehicle; ?></td>
            <?php foreach ($months as $index => $month): ?>
                <td class="<?php if ($index === 6) echo 'bold-june-july-column'; ?>"><?php echo $data[$vehicle][$month]; ?></td>
            <?php endforeach; ?>
            <td class="bold-column"><?php echo array_sum(array_slice($data[$vehicle], 0, 6)); ?></td>
            <td class="bold-jul-dec"><?php echo array_sum(array_slice($data[$vehicle], 6, 6)); ?></td>
            <td class="last-column"><?php echo $data[$vehicle]['Total']; ?></td>
        </tr>
        <?php if ($vehicle == 'UBH 547TMACCOR' || $vehicle == 'Excavator' || $vehicle == 'GENERATOR'): ?>
            <tr class="subtotal highlight-subtotal">
                <td><b>Subtotal</b></td>
                <?php foreach ($months as $month): ?>
                    <td class="highlight-subtotal"><?php
                        $subtotal = 0;
                        for ($i = 0; $i <= $index; $i++) {
                            $subtotal += $data[$vehicles[$i]][$month];
                        }
                        echo $subtotal;
                        ?></td>
                <?php endforeach; ?>
                <td class="highlight-subtotal"><?php
                    $subtotalSeasonA = 0;
                    for ($i = 0; $i <= $index; $i++) {
                        $subtotalSeasonA += array_sum(array_slice($data[$vehicles[$i]], 0, 6)); // Sum of Jan-Jun for each vehicle
                    }
                    echo $subtotalSeasonA;
                    ?></td>
                <td class="highlight-subtotal"><?php
                    $subtotalSeasonB = 0;
                    for ($i = 0; $i <= $index; $i++) {
                        $subtotalSeasonB += array_sum(array_slice($data[$vehicles[$i]], 6, 6)); // Sum of Jul-Dec for each vehicle
                    }
                    echo $subtotalSeasonB;
                    ?></td>
                <td class="highlight-subtotal"><?php
                    $subtotalOverall = $subtotalSeasonA + $subtotalSeasonB; // Overall sum for the subtotals
                    echo $subtotalOverall;
                    ?></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>

    <!-- Total per month row -->
    <tr class="bold-row last-row">
        <td>Total per month and per season</td>
        <?php foreach ($months as $month): ?>
            <td><?php echo $data['Total'][$month]; ?></td>
        <?php endforeach; ?>
        <td class="highlight-orange bold-column"><?php echo array_sum(array_slice($data['Total'], 0, 6)); ?></td>
        <td class="highlight-orange bold-jul-dec"><?php echo array_sum(array_slice($data['Total'], 6, 6)); ?></td>
        <td class="highlight-orange last-column"><?php echo $data['Total']['Total']; ?></td>
    </tr>
</table>

</body>
</html>


<div class="col-sm-12">
        <div class="card card-success card-outline">


            <div class="card-body table-responsive">
                <table>
                    <tr>
                        <th colspan ="16"><h3>Summary Report of fuel Consumption for each Vehicle per Month and per Season for year : {{ $year }} </h3></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="12">Months</th>
                        <th colspan="3">Total per Vehicle </th>
                    </tr>
                <tr>
                    <th>Vehicle</th>
                                <th class="rotate ">Jan</th>
                                <th class="rotate ">Feb</th>
                                <th class="rotate ">Mar</th>
                                <th class="rotate ">Apr</th>
                                <th class="rotate ">May</th>
                                <th class="rotate bold-june-july">Jun</th>
                                <th class="rotate ">Jul</th>
                                <th class="rotate ">Aug</th>
                                <th class="rotate ">Sep</th>
                                <th class="rotate ">Oct</th>
                                <th class="rotate ">Nov</th>
                                <th class="rotate ">Dec</th>
                            <th class="bold-column">Season A (Jan-Jun)</th>
                    <th class="bold-season">Season B (Jul-Dec)</th>
                    <th class="last-column overall-column">Overall (Jan-Dec)</th>
                </tr>
                @foreach($summaryData as $categoryName => $categoryData)
               
                <tr>
                    <!-- Table headers -->
                </tr>
                @foreach($categoryData['vehicles'] as $vehicleName => $months)
                    <tr>
                        <td>{{ $vehicleName }}</td>
                        @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                            <td>{{ $months[$month] ?? 0 }}</td>
                        @endforeach
                        <!-- Total per vehicle -->
                    </tr>
                @endforeach
                <!-- Subtotal per category -->
            @endforeach
            <!-- Total per month row -->
        </table>
            </div>

        </div>
        <div class="pb-3">

        </div>
    </div>


    <!-- more -->
    <table>
                    <tr>
                        <th colspan ="16">
                            <h3>Summary Report of fuel Consumption for each Vehicle per Month and per Season for year :
                                {{ $year }} </h3>
                        </th>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="12">Months</th>
                        <th colspan="3">Total per Vehicle </th>
                    </tr>
                    <tr>
                        <th>Vehicle</th>
                        <th class="rotate ">Jan</th>
                        <th class="rotate ">Feb</th>
                        <th class="rotate ">Mar</th>
                        <th class="rotate ">Apr</th>
                        <th class="rotate ">May</th>
                        <th class="rotate bold-june-july">Jun</th>
                        <th class="rotate ">Jul</th>
                        <th class="rotate ">Aug</th>
                        <th class="rotate ">Sep</th>
                        <th class="rotate ">Oct</th>
                        <th class="rotate ">Nov</th>
                        <th class="rotate ">Dec</th>
                        <th class="bold-column">Season A (Jan-Jun)</th>
                        <th class="bold-season">Season B (Jul-Dec)</th>
                        <th class="last-column overall-column">Overall (Jan-Dec)</th>
                    </tr>
                    @foreach ($summaryData as $categoryName => $categoryData)
                        <tr>
                           
                        </tr>
                        @foreach ($categoryData['vehicles'] as $vehicleName => $months)
                            <tr>
                                <td>{{ $vehicleName }}</td>
                                @php
                                    $seasonA = array_slice($months, 0, 6);
                                    $seasonB = array_slice($months, 6, 6);
                                    $totalSeasonA = array_sum($seasonA);
                                    $totalSeasonB = array_sum($seasonB);
                                    $overallTotal = array_sum($months);
                                @endphp
                                @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                                    <td>{{ $months[$month] ?? 0 }}</td>
                                @endforeach
                                <td>{{ $totalSeasonA }}</td>
                                <td>{{ $totalSeasonB }}</td>
                                <td>{{ $overallTotal }}</td>

                            </tr>
                        
                        @endforeach
                        <!-- add Subtotal per category and season -->
                        
                        
                    @endforeach
                    <!-- add Total per month row -->
                </table>