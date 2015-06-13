<h3>{{ $user->present()->first_name . '\'s' }} Account</h3>
<hr/>
<div class="alert alert-info">
    <p>Personal info</p>
</div>
<p>This section displays your personal information. You can add more information about yourself using
    the button provided below</p>

<table class="table table-bordered">
    <tbody>
    <tr>
        <th class="bold">Your Name:</th>
        <td>
            {{ $user->present()->fullName }}
        </td>
    </tr>
    <tr>
        <th class="bold">County:</th>
        <td>
            {{ !empty($user->county) ? beautify($user->county->name) : "None" }}
        </td>
    </tr>
    <tr>
        <th class="bold">Home town:</th>
        <td>
            {{ !empty($user->town) ? beautify($user->town) : "None" }}
        </td>
    </tr>
    @if(!empty($user->avatar))
        <tr>
            <th class="bold">
                Avatar:
            </th>
            <td>
                <img src="{{ asset($user->avatar) }}" class="img-circle img-responsive img-thumbnail"
                     style="height: 128px; width: 128px;">
            </td>
        </tr>
    @endif
    @if(!empty($user->gender))
        <tr>
            <th class="bold">
                Gender:
            </th>
            <td>
                {{ $user->gender }}
            </td>
        </tr>
    @endif
    @if(!empty($user->dob))
        <tr>
            <th class="bold">
                Date of birth:
            </th>
            <td>
                {{ $user->dob }} <span class="text text-info">({{ $user->present()->age . " Years" }})</span>
            </td>
        </tr>
    @endif
    </tbody>
</table>

<div class="row account-data-buttons">
    <div class="pull-right">
        <button class="btn btn-success" data-toggle="modal" data-target="#addAccountInfo"><i
                    class="fa fa-plus-square"></i>&nbsp;Add extra details
        </button>
    </div>
    <div class="pull-left">
        <button class="btn btn-info" data-toggle="modal" data-target="#editPersonal"><i
                    class="fa fa-edit"></i>&nbsp;Edit
        </button>
    </div>
</div>
@include('_partials.modals.account.addAccountInfo', ['elementID' => 'addAccountInfo', 'route' => 'account.info.addMore'])
@include('_partials.modals.account.editUserProfile', ['elementID' => 'editPersonal', 'route' => 'account.info.personal.edit'])