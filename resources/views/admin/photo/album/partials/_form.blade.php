@csrf
<div class="col-md-4">
    <div class="form-group">
        <label for="parent_id">Parent</label>
        <select name="parent_id" class="form-control">
            <option>--- Make Selection ---</option>
            @foreach($albumOptions as $albumOption)
                <option value="{{ $albumOption->id }}">{{ $albumOption->name }}</option>
            @endforeach
        </select>
        @if ($errors->has('parent_id'))
            <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('parent_id') }}</strong>
                </span>
        @endif
    </div>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" value="{{ inputOld('name', $album->name ?? null) }}"/>
        @if ($errors->has('name'))
            <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
        @endif
        @if ($errors->has('label'))
            <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('label') }}</strong>
                </span>
        @endif
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea type="text" class="form-control" name="description">{{ inputOld('description', $album->description ?? null) }}</textarea>
        @if ($errors->has('description'))
            <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
        @endif
    </div>
    <div class="form-group">
        <label for="file">Cover</label>
        <input type="file" class="form-control" name="file"/>
        @if ($errors->has('file'))
            <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('file') }}</strong>
                </span>
        @endif
    </div>
</div>
<div class="col-md-4">
    <div class="form-group row">
        <input type="submit" value="Save" class="btn btn-info"/>
    </div>
</div>