@if (Session::has('flash_notification.message'))
    @if (Session::has('flash_notification.overlay'))
        @include('flash::modal', ['modalClass' => 'flash-modal', 'title' => Session::get('flash_notification.title'), 'body' => Session::get('flash_notification.message')])
    @else
        <div class="alert alert-{{ Session::get('flash_notification.level') }} flash-msg wow bounce m-t-10 m-b-10">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" data-toggle="tooltip"
                    data-placement="top" title="dismiss message">&times;</button>

            <p class="text-center">
                {{ Session::get('flash_notification.message') }}
            </p>
        </div>
    @endif
@endif
