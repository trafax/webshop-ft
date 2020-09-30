<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <style>
        body, html {
            font-family: Arial, Helvetica, sans-serif;
        }
        h2 {
            margin: 0 0 10px 0;
        }
        td {
            width: auto !important;
        }
		.page-break {
			page-break-after: always;
		}
    </style>
</head>
<body>
	<div><img width="250" style="width: 250px;" src="{{ url('/img/floratuin.png') }}"></div>
	<div style="border-top: #CCC solid 1px; margin-top: 20px; width: 700px;"></div>
				<div style="height: 20px;"></div>
	@yield('content')
                <div style="border-top: #CCC solid 1px; margin-top: 60px; width: 700px;"></div>

                <table width="700" style="width: 700px !important;">
                    <tr>
                        <td style="text-align: center; padding: 10px 0;">
                            Floratuin B.V. - Rijksweg 85, 1787 PK Julianadorp - info@floratuin.com - +316-10694149
                        </td>
                    </tr>
                </table>
</body>
</html>
