<div class="form-group">
    {!! Form::label('topic', "Article topic:", []) !!}
    {!! Form::text('topic', isset($article) ? $article->topic : old('topic'), ['class' => 'form-control', 'placeholder' => 'Enter an article topic']) !!}
    @if($errors->has('topic'))
        <span class="wow flash error-msg">{{ $errors->first('topic') }}</span>
    @endif
</div>
<div class="form-group">
    <label for="editor_small">Article content</label>
        <textarea name="content" id="editor_small" class="custom-editor" cols="15"
                  rows="7">{{ isset($article) ? $article->content : old('content') }}</textarea>
    @if($errors->has('content'))
        <span class="wow flash error-msg">{{ $errors->first('content') }}</span>
    @endif
</div>
<br/>