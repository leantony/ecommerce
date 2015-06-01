<div class="col-md-12">
    @if(Session::has('flash_notification.message') || $errors->has())
        <div id="login-alert"
             class="alert alert-{{ eq(Session::get('flash_notification.level') ,null) ? 'danger' : Session::get('flash_notification.level') }} col-sm-12">
            <ul>
                {{ Session::get('flash_notification.message') }}
                @foreach ($errors->all() as $message)
                    <li>
                        {{ $message }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(isset($ajax_output))
        <div class="msgDisplay"></div>
    @endif
</div>