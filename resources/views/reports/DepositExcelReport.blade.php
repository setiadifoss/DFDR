<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="content-type" content="charset=UTF-8">
	<title>Report <?php echo date('d M Y'); ?></title>
</head>

<body>
  <h4>Deposit Report</h4>
  <table>
		<thead>
			<tr>
        <th>Title</th>
        <th>Category</th>
        <th>Publisher</th>
        <th>Date</th>
        <th>Language</th>
        <th>Division</th>
        <th>Right Management</th>
        <th>Status</th>
        <th>Download - View</th>
			</tr>
		</thead>
		<tbody>
      @foreach ($upload_form as $datas)
			<tr>
				<td>{{$datas->title}}</td>
        <td>{{$datas->category_name}}</td>
        <td>{{$datas->publisher}}</td>
        <td>{{$datas->date}}</td>
        <td>{{$datas->language_name}}</td>
        <td>{{$datas->division_name}}</td>
        <td>{{$datas->right_management}}</td>
        <td>{{$datas->status}}</td>
        <td>{{$datas->total_download}}</td>
			</tr>
      @endforeach
		</tbody>
	</table>
</body>

</html>