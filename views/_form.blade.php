<form method="POST" action="{{ route('wiki-lite.save') }}" class="wiki-lite">
    {{ csrf_field() }}

    @if ($page->uuid)
        <input type="hidden" name="uuid" value="{{ $page->uuid }}">
    @endif

    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        <label for="title">Title</label>

        @if ($errors->has('title'))
            <ul class="help-block">
                <li><strong>{{ $errors->first('title') }}</strong></li>
            </ul>
        @endif

        <div>
            <input id="title" type="text" name="title" value="{{ old('title', $page->title) }}" autofocus>           
        </div>
    </div>

    <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
        <label for="content">Content</label>

        <div>
            @if ($errors->has('content'))
                <ul class="help-block">
                    <li><strong>{{ $errors->first('content') }}</strong></li>
                </ul>
            @endif

            <div class="textarea-wrap">
                <div class="textarea-pull"></div>
                <textarea id="content" name="content">{{ old('content', $page->content) }}</textarea>
            </div>
        </div>
    </div>

    <div class="form-group">
        <input type="submit" name="save" class="button button-primary" value="Save page" />
    </div>
</form>