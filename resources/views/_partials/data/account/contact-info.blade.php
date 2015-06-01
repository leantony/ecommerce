<div class="alert alert-info">
    <p>Contact Information</p>
</div>
<p>Use this section to edit your contact information. Your mobile number will be used to contact you,
    only when you order a product</p>


<table class="table table-bordered">
    <tr>
        <th class="bold">Email address:</th>
        <td>{{ $user->email }}</td>
    </tr>
    <tr>
        <th class="bold">Mobile number:</th>
        <td>{{ beautify($user->phone) }}</td>
    </tr>
</table>

<button class="btn btn-info" data-toggle="modal" data-target="#editContactInfo"><i
            class="fa fa-edit"></i>&nbsp;Edit
</button>
@include('_partials.modals.account.editContactInfo', ['elementID' => 'editContactInfo', 'route' => 'account.info.contact.edit'])