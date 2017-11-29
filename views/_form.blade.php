<form role="form" method="POST" action="{{ route('wiki-lite.save') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        <label for="title">Title</label>

        <div>
            <input id="title" type="text" name="title" value="{{ $page->title }}" autofocus>

            @if ($errors->has('title'))
                <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
        <label for="content">Content</label>

        <div>
            <div class="textarea-wrap">
                <div class="textarea-pull"></div>
                <textarea id="content" name="content">{{ $page->content }}</textarea>
            </div>

            <span class="help-block">
                @if ($errors->has('content'))
                    <strong>{{ $errors->first('content') }}</strong><br />
                @endif
            </span>
        </div>
    </div>

    <div class="form-group">
        <input type="submit" name="save" class="button button-primary" value="Save" />
    </div>
</form>