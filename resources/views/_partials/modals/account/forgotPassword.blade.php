<div class="modal" id="{{ $elementID }}" tabindex="-1" role="dialog" aria-labelledby="{{ $elementID . 'Label'}}"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="infoModalLabel">Password reset</h4>
            </div>
            <div class="modal-body">
                @include('_partials.forms.authentication.reset_pass', ['useAjax' => true])
            </div>
        </div>
    </div>
</div>