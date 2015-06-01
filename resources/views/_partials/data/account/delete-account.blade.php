<p>Proceed with caution</p>

<a href="#" data-toggle="modal"
   data-target={{ session('password.confirmed-'. $auth_user->id) == true ? "#deleteAccount" : "#passwordConfirm" }}>
    <button class="btn btn-danger"><i class="fa fa-remove"></i>&nbsp;Delete my Account</button>
</a>
@if(session('password.confirmed-'. $auth_user->id) === true)
    @include('_partials.modals.account.deleteAccount', ['elementID' => 'deleteAccount', 'username' => beautify($user->first_name), 'useAjax' => true])
@else
    @include('_partials.modals.account.confirm_password', ['elementID' => 'passwordConfirm', 'username' => beautify($user->first_name), 'useAjax' => true])
@endif