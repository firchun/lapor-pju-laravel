<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ public_path() }}/img/logo.png" />
    <style>
        @page {
            margin: 5px;
            /* size: 165pt 100vh; */
        }

        body {
            margin: 5px 5px 0px 5px;
        }

        * {
            font-family: Verdana, Arial, sans-serif;
        }

        h5,
        p {
            margin: 2px 0;
        }



        .container {
            width: 170px;
        }

        table {
            font-size: 8px;
        }

        thead,
        tbody {
            border-bottom: .0px solid #000;
            margin-bottom: 10px;
        }

        td {
            padding-bottom: 5px;
            padding-right: 5px;
        }

        thead,


        header {
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            font-size: 10px;
        }

        table {
            font-family: sans-serif;
            color: #232323;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 0px solid #999;
            padding: 4px 10px;
        }
    </style>
</head>

<body>



    <table class="table table-bordered table-hover" id="table-order">

        <thead>
            <tr>
                <th colspan='2' style="text-align:center;">
                    <img src="{{ public_path() }}/img/logo.png" alt="" width="100"
                        style="text-align:center;" />
                    <img src="{{ public_path() }}/img/logo-dishub.png" alt="" width="55"
                        style="text-align:center; margin-left:10px;" />
                </th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>
                    <h1 style="font-size: 70px; text-align:center; color:#291471;">{{ $data->code }}</h1>
                </td>
            </tr>
            <tr>

                <td style="text-align: center;">
                    <div style="display: inline-block; width: 100%;"> <!-- Adjust width as needed -->
                        <img src="data:image/png;base64, {!! $qr !!}"
                            style="width: 100%; height: auto; display: block; margin: 0 auto;">
                    </div>
                </td>
            </tr>
            <tr>
                <td style="text-align: center; color:red;">
                    <h1>HARAP JANGAN MERUSAK, BAIK MEROBEK, MENYIRAM ATAU HAL APAPUN UNTUK MERUSAK LABEL INI</h1>
                </td>
            </tr>

        </tbody>
    </table>

</body>

</html>
