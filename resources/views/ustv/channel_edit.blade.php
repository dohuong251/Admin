@extends('layouts.main')
@section('title', 'Edit Channel')
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
            @if(!empty($channel))
                <li class="breadcrumb-item justify-content-center">
                    {{$channel->symbol}}
                </li>
            @endif
        </ol>
    </nav>

    @if(!empty($channel))
        <div>
            <form class="col-12 col-lg-8 m-auto" method="post" action="{{route('admin.ustv.channels.update',$channel->id)}}">
                @method('PUT')
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2" for="channel-name">Name:</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="symbol" placeholder="Enter channel name..." id="channel-name" value="{{old('symbol',$channel->symbol)}}" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2" for="channel-description">Description:</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="description" placeholder="Enter description..." id="channel-description">{{old('description',$channel->description)}}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2" for="channel-priority">Properties :</label>
                    <div class="col-sm-10">
                        <select class="custom-select" name="properties" id="channel-priority">
                            <option value="0" @if(old('properties',$channel->properties)==0) selected @endif>Copyright/Non-copyright channel</option>
                            <option value="1" @if(old('properties',$channel->properties)==1) selected @endif>Need to hide when apple review process</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2" for="channel-icon">Icon Url:</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="icon_name" placeholder="Enter icon url..." id="channel-icon" value="{{old('icon_name',$channel->icon_name)}}"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2" for="channel-notes">Notes:</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="notes" placeholder="" id="channel-notes">{{old('notes',$channel->notes)}}</textarea>
                    </div>
                </div>
                <div class="ta-c mb-4">
                    <button type="submit" class="btn btn-success">Cập Nhật Kênh</button>
                </div>
            </form>
        </div>

        @foreach($channel->url as $url)
            <div class="col-12 col-lg-8 m-auto mt-2">
                <div class="border-bottom border-dark ta-c">
                    <b class="pb-2 pX-30 d-block">#{{$loop->index+1}} - ID: {{$url->id}}</b>
                </div>
                <div class="row ta-c mt-2">
                    <div class="col-3">
                        <div><b>{{$url->num_caching}}</b></div>
                        <span>Num Caching</span>
                    </div>
                    <div class="col-3">
                        <div><b>{{$url->num_rtmfp}}</b></div>
                        <span>Num RTMFP</span>
                    </div>
                    <div class="col-3">
                        <div><b>{{$url->rtmfp_running}}</b></div>
                        <span>RTMFP Running</span>
                    </div>
                    <div class="col-3">
                        <div><b>{{$url->port_publish??"None"}}</b></div>
                        <span>Port Publish</span>
                    </div>
                </div>
                <form action="{{route('admin.ustv.url.update',$url->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-sm-2" for="url-rtmfp">RTMFP link:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="url-rtmfp" value="{{$url->RTMFP_link}}" disabled/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2" for="url">URL:</label>
                        <div class="col-sm-10">
                            <input class="form-control" placeholder="url" name="url" id="url" value="{{old('url',$url->url)}}" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2" for="priority">Priority:</label>
                        <div class="col-sm-10">
                            <select class="custom-select" name="priority" id="priority">
                                <option value="-1" @if(old('priority',$url->priority)==-1) selected @endif>-1</option>
                                <option value="0" @if(old('priority',$url->priority)==0) selected @endif>0</option>
                                <option value="1" @if(old('priority',$url->priority)==1) selected @endif>1</option>
                                <option value="2" @if(old('priority',$url->priority)==2) selected @endif>2</option>
                                <option value="3" @if(old('priority',$url->priority)==3) selected @endif>3</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2" for="cache_video">Cache Video:</label>
                        <div class="col-sm-10">
                            <select class="custom-select" name="cache_video" id="cache_video">
                                <option value="0" @if(old('cache_video',$url->cache_video)==0) selected @endif>No Caching</option>
                                <option value="1" @if(old('cache_video',$url->cache_video)==1) selected @endif>RTMFP Caching</option>
                                <option value="2" @if(old('cache_video',$url->cache_video)==2) selected @endif>Local Caching</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2" for="last_update">Last Update:</label>
                        <div class="col-sm-10">
                            <input class="form-control" placeholder="" id="last_update" value="{{old('last_update',$url->last_update)}}" disabled/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2" for="website">Website:</label>
                        <div class="col-sm-10">
                            <input class="form-control" placeholder="website" id="website" name="website" value="{{old('website',$url->website)}}"/>
                        </div>
                    </div>
                    <div class="form-group row jc-fe mx-0">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <button type="button" class="btn btn-danger ml-2">Xóa</button>
                    </div>
                </form>
            </div>
        @endforeach
    @endif
@endsection
