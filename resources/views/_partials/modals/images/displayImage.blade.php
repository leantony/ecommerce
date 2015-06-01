<div class="modal" id="{{ $elementID }}" tabindex="-1" role="dialog" aria-labelledby="{{ $elementID . "Label" }}"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="infoModalLabel">{{ isset($property) ? $property : "image" }}</h4>
            </div>
            <div class="modal-body">
                <img class="img-responsive img-thumbnail center-block"
                     src="{{ display_img($model, isset($property) ? $property : "image") }} "/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close
                </button>
            </div>
        </div>
    </div>
</div>