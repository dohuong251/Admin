<div class="form-group">
    <label for="{{Str::slug($name)}}">{{$label}}:</label>
    <select class="form-control @error($name) is-invalid @enderror" id="{{Str::slug($name)}}" name="{{$name}}">
        @foreach($options as $option)
            <option value="{{$option->$fieldValue}}" @if(old($name,$defaultValue??null)==$option->$fieldValue) selected @endif>{{$option->$fieldName}}</option>
        @endforeach
    </select>
    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
