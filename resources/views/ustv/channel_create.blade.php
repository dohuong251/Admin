@extends('layouts.main')
@section('title', 'Add Channel')
@section('css')

@endsection
@section('js')

@endsection
@section('content')
    <nav>
        <ol class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item justify-content-center">
                Ustv
            </li>
            <li class="breadcrumb-item justify-content-center">
                <a href="{{route('admin.ustv.channels')}}">Channels</a>
            </li>
            <li class="breadcrumb-item justify-content-center">
                Add Channel
            </li>
        </ol>
    </nav>

    <div>
        <form class="col-12 col-lg-8 m-a" action="{{route('admin.ustv.channels.store')}}" method="post">
            @csrf
            <div class="form-group row">
                <label class="col-sm-2" for="channel-name">Name:</label>
                <div class="col-sm-10">
                    <input class="form-control" name="symbol" placeholder="Enter channel name..." value="{{old('symbol')}}" id="channel-name" required/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2" for="channel-description">Description:</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="description" placeholder="Enter description..." id="channel-description">{{old('description')}}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2" for="channel-priority">Priority:</label>
                <div class="col-sm-10">
                    <select class="custom-select" name="id_type_tv" id="channel-priority">
                        <option value="9" @if(old('icon_name')==9) selected @endif>US</option>
                        <option value="20" @if(old('icon_name')==20) selected @endif>UK</option>
                        <option value="12" @if(old('icon_name')==12) selected @endif>International</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2" for="channel-icon">Icon Url:</label>
                <div class="col-sm-10">
                    <input class="form-control" name="icon_name" value="{{old('icon_name')}}" placeholder="Enter icon url..." id="channel-icon"/>
                </div>
            </div>
            <div class="ta-c mb-2">
                <button type="submit" class="btn btn-success">Tạo Kênh</button>
            </div>
        </form>
    </div>
@endsection
