<div class="form-group">
    <label for="{{Str::slug($name)}}">{{$label}}:</label>
    <textarea type="text" class="form-control @error($name) is-invalid @enderror" id="{{Str::slug($name)}}" name="{{$name}}">{{old($name, $defaultValue??null)}}</textarea>
    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
