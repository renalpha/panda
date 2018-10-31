@csrf
<div class="col-md-4">
    <div class="form-group row">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" value="{{ $group->name ?? null }}"/>
        @if ($errors->has('name'))
            <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
        @endif
    </div>
</div>
<div class="col-md-4">
    <div class="form-group row">
        <input type="submit" value="Save" class="btn btn-info"/>
    </div>
</div>