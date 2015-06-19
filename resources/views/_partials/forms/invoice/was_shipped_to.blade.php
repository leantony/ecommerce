<div class="col-xs-5 col-xs-offset-2">
    <p class="text-left">The products were shipped to:</p>
    <table class="table table-bordered">
        <tr>
            <th class="bold">UserName:</th>
            <td>{{ $is_logged_in ? $user->present()->fullName : beautify($user->first_name . " " . $user->last_name) }}</td>
        </tr>
        <tr>
            <th class="bold">Email Address</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th class="bold">
                County
            </th>
            <td>
                {{ $user->county->name }}
            </td>
        </tr>
        <tr>
            <th class="bold">Town</th>
            <td>
                {{ $user->town }}
            </td>
        </tr>
        <tr>
            <th class="bold">Home Address</th>
            <td>
                {{ $user->home_address }}
            </td>
        </tr>
    </table>
</div>