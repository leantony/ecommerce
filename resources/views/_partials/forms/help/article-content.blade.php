<div class="col-md-{{ isset($size) ? $size : 8 }} m-t-40 m-b-20">
    @if($displayTitle)
        <h2>{{ $article->topic }}</h2>
        <hr/>
    @endif
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">
                {{ $article->id }}:
                <a href="{{ route('help.article.view', ['article' => $article->id]) }}">
                    {{ $article->topic }}
                </a>
            </h3>
        </div>
        <div class="panel-body">
            {!! $article->content !!}
        </div>
        <div class="panel-footer">
            <p>
                Created by the help & support team, on <span class="bold">{{ $article->created_at }}</span>
            </p>
        </div>
    </div>
    <hr/>

</div>