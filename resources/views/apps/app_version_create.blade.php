@extends('layouts.main')
@section('title', 'New App Version')
@section('css')

@endsection
@section('js')
    <script src="/js/app/create.js"></script>
@endsection
@section('content')
    <nav>
        <ol class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item justify-content-center">
                <a href="{{route('admin.apps.index')}}">Apps</a>
            </li>
            @if($app && $app->App)
                <li class="breadcrumb-item justify-content-center">
                    <a href="{{route('admin.apps.show',$app->App->app_id)}}">{{$app->App->app_name}}</a>
                </li>
            @endif
            <li class="breadcrumb-item justify-content-center">
                Add App Version
            </li>

            <li class="ml-auto">
            </li>
        </ol>
    </nav>

    @if($app)
        <form class="pb-2" action="{{route('admin.apps.store_version',[Route::input('appId'), Route::input("platform")])}}" method="post">
            @csrf

            <input type="hidden" name="app_version_id" value="{{$app->app_version_id}}">
            <div class="row">
                <div class="col-12 col-sm-6">
                    @include('apps.create_form_input_group',['name'=>'icon_url','label'=>'Icon','require'=>true, 'defaultValue'=>$app->icon_url??""])
                </div>
                <div class="col-12 col-sm-6">
                    @include('apps.create_form_input_group',['name'=>'app_version_name','label'=>'App version name','require'=>true, 'defaultValue'=>$app->app_version_name??""])
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6">
                    @include('apps.create_form_input_group',['name'=>'app_version_subname','label'=>'Version sub name', 'defaultValue'=>$app->app_version_subname??""])
                </div>
                <div class="col-12 col-sm-6">
                    @include('apps.create_form_input_group',['name'=>'package_name','label'=>'Package name','require'=>true, 'defaultValue'=>$app->package_name??""])
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6">
                    @include('apps.create_form_select_group',['name'=>'platform_id', 'label'=>'Platform', 'options'=>\App\Models\Apps\Platform::all(), 'fieldValue'=>'platform_id', 'fieldName'=>'name', 'defaultValue'=>$app->platform_id??null])
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6">
                    @include('apps.create_form_input_group',['name'=>'version_name','label'=>'Version','require'=>true])
                </div>
                <div class="col-12 col-sm-6">
                    @include('apps.create_form_input_group',['name'=>'size','label'=>'Size', 'defaultValue'=>$app->size??null])
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6">
                    @include('apps.create_form_input_group',['name'=>'ads_image','label'=>'Ads image', 'defaultValue'=>$app->ads_image??null])
                </div>
                <div class="col-12 col-sm-6">
                    @include('apps.create_form_input_group',['name'=>'download_url','label'=>'Download URL'])
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6">
                    @include('apps.create_form_input_group',['name'=>'playstoreURL','label'=>'Playstore URL', 'defaultValue'=>$app->playstoreURL??null])
                </div>
                <div class="col-12 col-sm-6">
                    @include('apps.create_form_input_group',['name'=>'appleUrl','label'=>'Apple URL', 'defaultValue'=>$app->appleUrl??null])
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6">
                    @include('apps.create_form_input_group',['name'=>'amazoneUrl','label'=>'Amazone URL', 'defaultValue'=>$app->amazoneUrl??null])
                </div>
                <div class="col-12 col-sm-6">
                    @include('apps.create_form_input_group',['name'=>'portableUrl','label'=>'Portable URL', 'defaultValue'=>$app->portableUrl??null])
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6">
                    @include('apps.create_form_input_group',['name'=>'requires','label'=>'Requires', 'defaultValue'=>$app->requires??null])
                </div>
                <div class="col-12 col-sm-6">
                    @include('apps.create_form_input_group',['name'=>'portuguese_requires','label'=>'Portuguese Requires', 'defaultValue'=>$app->portuguese_requires??null])
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6">
                    @include('apps.create_form_text_area_group',['name'=>'what_new','label'=>'What new', 'defaultValue'=>$app->what_new??null])
                </div>
                <div class="col-12 col-sm-6">
                    @include('apps.create_form_text_area_group',['name'=>'portuguese_what_new','label'=>'Portuguese What new', 'defaultValue'=>$app->portuguese_what_new??null])
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6">
                    @include('apps.create_form_text_area_group',['name'=>'description','label'=>'Description', 'defaultValue'=>$app->description??null])
                </div>
                <div class="col-12 col-sm-6">
                    @include('apps.create_form_text_area_group',['name'=>'portuguese_description','label'=>'Portuguese Description', 'defaultValue'=>$app->portuguese_description??null])
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="image">ImageURLs:</label>
                        @php
                            $images = old('Image',$app->appResources->filter(function($resource){return $resource->type=="Image";})->pluck('link')->toArray()??[]);
                            if(empty($images)) $images=[""];
                        @endphp
                        @foreach($images as $image)
                            <input type="text" class="form-control @error('Image[]') is-invalid @enderror" id="image" name="Image[]" value="{{$image}}">
                        @endforeach
                        @error('Image[]')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="button" class="btn btn-success btn-add" title="Add Image Url">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <div class="col-12 col-sm-6">
                    @include('apps.create_form_input_group',['name'=>'Video','label'=>'Video URL', 'defaultValue'=>$app->appResources->filter(function($resource){return $resource->type=="Video";})->first()->link??null])
                </div>
            </div>

            <button class="btn btn-success d-block mx-auto mt-2" type="submit">Add</button>
        </form>
    @else
        <div class="mb-2">
            <b>Not found!</b>
        </div>
    @endif
@endsection
