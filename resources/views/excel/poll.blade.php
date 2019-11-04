<html>
<head>
	<title>Export Poll</title>
</head>
<body>
	<style type="text/css">
	body{
		font-family: sans-serif;
	}
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		border: 1px solid #3c3c3c;
		padding: 3px 8px;

	}
	a{
		background: blue;
		color: #fff;
		padding: 8px 10px;
		text-decoration: none;
		border-radius: 2px;
	}
	</style>

	@php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Poll List.xls");
	@endphp
	<table border="1">
		<tr>
			<th>No.</th>
			<th>Date</th>
			<th>Service ID</th>
			<th>Poll</th>
			<th>Result</th>
		</tr>
		@foreach($polls as $key => $value)
		<tr>
			<td>{{ $key+1 }}</td>
			<td>{{ $value->poll_date }} </td>
			<td>{{ $value->service_id }} </td>
			<td>{{ $value->value }} </td>
			<td>{{ $value->result }} </td>
		</tr>
		@endforeach
	</table>
</body>
</html>