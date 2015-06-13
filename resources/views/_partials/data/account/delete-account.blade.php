<div class="alert alert-danger">
    <p>Please proceed with caution</p>
</div>

<a href="#" data-toggle="modal"
   data-target={{ session('password.confirmed-'. $auth_user->id) == true ? "#deleteAccount" : "#passwordConfirm" }}>
    Delete my Account
</a>
@if(session('password.confirmed-'. $auth_user->id) === true)
    @include('_partials.modals.account.deleteAccount', ['elementID' => 'deleteAccount', 'username' => beautify($user->first_name), 'useAjax' => true])
@else
    @include('_partials.modals.account.confirm_password', ['elementID' => 'passwordConfirm', 'username' => beautify($user->first_name), 'useAjax' => true])
@endif