<table class="table table-bordered">
    <tr>
        <th class="bold">User Name:</th>
        <td>{{ beautify($data->first_name . " ". $data->last_name) }}</td>
    </tr>
    <tr>
        <th class="bold">County:</th>
        <td>{{ beautify($data->county->name) }}</td>
    </tr>
    <tr>
        <th class="bold">Hometown:</th>
        <td>{{ beautify($data->town) }}</td>
    </tr>
    <tr>
        <th class="bold">Home Address:</th>
        <td>{{ beautify($data->home_address) }}</td>
    </tr>
</table>