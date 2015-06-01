<div class="row">
    <div class="col-md-12 col-xs-12 col-sm-12">
        <a href="{{ route('auth.loginUsingAPI', ['provider' => 'facebook']) }}">
            <button class="btn btn-info" style="margin-right: 20px" data-toggle="tooltip"
                    title="{{ $action }} using your facebook account">
                <i class="fa fa-facebook-f fa-2x p-all-5"></i>&nbsp;
            </button>
        </a>
        <a href="{{ route('auth.loginUsingAPI', ['provider' => 'google']) }}">
            <button class="btn btn-danger" data-toggle="tooltip"
                    title="{{ $action }} using your google account">
                <i class="fa fa-google-plus fa-2x p-all-5"></i>&nbsp;
            </button>
        </a>
    </div>
</div>
<div class="strike m-t-10 m-b-10">
    <span>or, use our {{ $action }} service</span>
</div>
