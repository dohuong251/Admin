<div class="form-group">
    <label for="{{Str::slug($name)}}">{{$label}}:</label>
    <input type="text" class="form-control @error($name) is-invalid @enderror" id="{{Str::slug($name)}}" name="{{$name}}" value="{{old($name, $defaultValue??null)}}" @if(isset($require)&&$require) required @endif>
    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
