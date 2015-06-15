<div class="alert alert-info">
    <p>Account Security</p>
</div>
<p>This section displays various related security options about your account</p>


<table class="table table-bordered">
    <tbody>
    <tr>
        <th class="bold">Account creation date:</th>
        <td>
            {{ $user->present()->accountAge }} ({{ $user->created_at }})
        </td>
    </tr>
    <tr>
        <th class="bold">Last account login:</th>
        <td>
            {{ $user->present()->lastLogin }} ({{ $user->last_login }})
        </td>
    </tr>
    <tr>
        <th class="bold">Last Access date:</th>
        <td>
            {{ \Carbon\Carbon::now()->diffForHumans() }}, on IP address {{ Request::getClientIp() }}
        </td>
    </tr>
    </tbody>
</table>
<hr/>
<h3>Your password</h3>
<p>Your password is private. Always provide a strong password, and avoid reusing the same password across sites</p>
<a href="#" data-toggle="modal" data-target="#editPassword">Edit password</a>

@include('_partials.modals.account.editPassword', ['elementID' => 'editPassword', 'route' => route('account.password.edit'), 'logoutOption' => true])