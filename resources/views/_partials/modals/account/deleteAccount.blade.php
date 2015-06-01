<div class="modal" id="{{ $elementID }}" tabindex="-1" role="dialog" aria-labelledby="{{ $elementID. 'delete'}}"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                            class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title text-center">Delete Account prompt</h4>
            </div>
            <div class="modal-body">
                <h5>Hey {{ $username }}. Here's what will happen once you press the 'Yes' button</h5>
                <ol>
                    <li>Your user account will be deleted, and you wont be able to login again</li>
                    <li>All the orders you've made will be subsequently deleted</li>
                </ol>

                <div class="alert alert-warning"><span class="fa fa-warning fa-2x"></span>
                    &nbsp;&nbsp; Are you sure you want to continue?
                </div>
            </div>
            <div class="modal-footer">
                <div class="pull-left">
                    {!! Form::open(['url' => route('account.delete.temporary') , 'method' => 'DELETE', $useAjax ? "data-remote" : ""]) !!}

                    <button class="btn btn-danger">
                        <i class="fa fa-trash-o"></i>&nbsp;Yes
                    </button>
                    &nbsp;<span class="alt-ajax-image"><img src="{{ alt_ajax_image() }}"> </span>
                    {!! Form::close() !!}
                </div>
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                        <i class="fa fa-close"></i>&nbsp;No
                    </button>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>