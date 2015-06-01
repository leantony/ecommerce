<div class="alert alert-info">
    <p>Account Security</p>
</div>
<p>This section displays various related security options about your account</p>

<div class="well">
    <button class="btn btn-info" data-toggle="modal" data-target="#editPassword"><i
                class="fa fa-edit"></i>&nbsp;Edit password
    </button>
</div>
@include('_partials.modals.account.editPassword', ['elementID' => 'editPassword', 'route' => 'account.password.edit', 'logoutOption' => true])