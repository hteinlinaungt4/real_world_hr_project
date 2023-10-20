<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Attendance</title>
    <style>
        @page {
                margin: 100px 25px;
        }

        /* Reset default styles */
        table {
        border-collapse: collapse;
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        text-align: center;
        }

        /* Table header styles */
        thead th {
        background-color: #333;
        color: #fff;
        font-weight: bold;
        padding: 10px;
        border: 1px solid #555;
        }

        /* Table row styles */
        tr:nth-child(even) {
        background-color: #f2f2f2;
        }

        /* Table cell styles */
        td {
        padding: 10px;
        border: 1px solid #ccc;
        }

        /* Add hover effect to rows */
        tr:hover {
        background-color: #ddd;
        }

        /* Add a border to the table */
        table.styled-table {
        border: 1px solid #333;
        }
            footer {
                position: fixed;
                bottom: -60px;
                left: 0px;
                right: 0px;
                height: 50px;
                font-size: 20px !important;
                background-color: #000;
                color: white;
                text-align: center;
                line-height: 35px;
            }
            header {
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
                height: 50px;
                font-size: 20px !important;
                color: black;
                line-height: 35px;
            }

    </style>
</head>
<body>
    <header>
        <span style="text-align: left;">Attendance Report</span>
        <span><?php echo date("Y-m-d"); ?></span>
    </header>


    <table class="styled-table" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Checkin Time</th>
                <th>Checkout Time</th>
            </tr>
        </thead>
        <tbody style="text-align: center;">
           @foreach ($records as $attendance)
           <tr>
                <td scope="row">{{optional($attendance->employee)->name}}</td>
                <td>{{ $attendance->date }}</td>
                <td>{{ Carbon\Carbon::parse($attendance->checkin_time)->format('H:i:s') }}</td>
                <td>{{ Carbon\Carbon::parse($attendance->checkout_time)->format('H:i:s') }}</td>
            </tr>
           @endforeach

        </tbody>
    </table>

</body>
</html>
