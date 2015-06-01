<div class="alert alert-info">
    Shipping Information
</div>
<p>This section displays location specific details about yourself. This information is used to be used
    to ship products to your destination. You can add more destinations using the links provided</p>


<table class="table table-bordered">
    <tbody>
    <tr>
        <th class="bold">County:</th>
        <td>{{ !empty($user->county) ? beautify($user->county->name) : "None" }}</td>
    </tr>
    <tr>
        <th class="bold">Town:</th>
        <td>{{ beautify($user->town) }}</td>
    </tr>
    <tr>
        <th class="bold">Home address:</th>
        <td>{{ beautify($user->home_address) }}</td>
    </tr>
    </tbody>
</table>

<div class="row account-data-buttons">
    <div class="pull-right">
        <button class="btn btn-success" data-toggle="modal" data-target="#AddNewShipping"><i
                    class="fa fa-plus-square"></i>&nbsp;Add Shipping destination
        </button>
    </div>
    <div class="pull-left">
        <button class="btn btn-info" data-toggle="modal" data-target="#editShippingInfo"><i
                    class="fa fa-edit"></i>&nbsp;Edit
        </button>
    </div>
</div>
@include('_partials.modals.account.editShippingInfo', ['elementID' => 'editShippingInfo', 'route' => 'account.info.shipping.edit'])