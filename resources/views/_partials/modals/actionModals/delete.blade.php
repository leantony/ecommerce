<div class="modal" id="{{ $elementID }}" tabindex="-1" role="dialog" aria-labelledby="{{ $elementID. 'delete'}}"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                            class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title text-center">Delete prompt</h4>
            </div>
            <div class="m-t-10 msgDisplay"></div>
            {!! Form::open(['url' => $route, 'method' => 'DELETE', 'class' => 'deleteAction']) !!}
            <div class="modal-body">
                <div class="alert alert-warning"><span class="fa fa-warning fa-2x"></span>
                    &nbsp;&nbsp; Are you sure you want to delete this item?
                </div>
            </div>
            <div class="modal-footer">
                <div class="pull-left">
                    <a href="#">
                        <button class="btn btn-danger" type="submit">
                            <i class="fa fa-trash-o"></i>&nbsp;Yes
                        </button>
                        <span class="alt-ajax-image"><img src="{{ alt_ajax_image() }}"> </span>
                    </a>
                </div>
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                        <i class="fa fa-close"></i>&nbsp;No
                    </button>
                </div>

            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>