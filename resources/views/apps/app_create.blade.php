@extends('layouts.main')
@section('title', 'New App')
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
            <li class="breadcrumb-item justify-content-center">
                Create New App
            </li>

            <li class="ml-auto">
            </li>
        </ol>
    </nav>

    <form class="pb-2" action="{{route('admin.apps.store')}}" method="post">
        @csrf

        <div class="row">
            <div class="col-12 col-sm-6">
                @include('apps.create_form_input_group',['name'=>'icon_url','label'=>'Icon','require'=>true])
            </div>
            <div class="col-12 col-sm-6">
                @include('apps.create_form_input_group',['name'=>'app_version_name','label'=>'App version name','require'=>true])
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('apps.create_form_input_group',['name'=>'app_version_subname','label'=>'Version sub name'])
            </div>
            <div class="col-12 col-sm-6">
                @include('apps.create_form_input_group',['name'=>'package_name','label'=>'Package name','require'=>true])
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('apps.create_form_select_group',['name'=>'platform_id', 'label'=>'Platform', 'options'=>\App\Models\Apps\Platform::all(), 'fieldValue'=>'platform_id', 'fieldName'=>'name'])
            </div>
            <div class="col-12 col-sm-6">
                @include('apps.create_form_select_group',['name'=>'category_id', 'label'=>'Category', 'options'=>\App\Models\Apps\Category::all(), 'fieldValue'=>'category_id', 'fieldName'=>'name', 'defaultValue'=>10])
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('apps.create_form_input_group',['name'=>'version_name','label'=>'Version','require'=>true])
            </div>
            <div class="col-12 col-sm-6">
                @include('apps.create_form_input_group',['name'=>'size','label'=>'Size'])
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('apps.create_form_input_group',['name'=>'ads_image','label'=>'Ads image'])
            </div>
            <div class="col-12 col-sm-6">
                @include('apps.create_form_input_group',['name'=>'download_url','label'=>'Download URL'])
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('apps.create_form_input_group',['name'=>'playstoreURL','label'=>'Playstore URL'])
            </div>
            <div class="col-12 col-sm-6">
                @include('apps.create_form_input_group',['name'=>'appleUrl','label'=>'Apple URL'])
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('apps.create_form_input_group',['name'=>'amazoneUrl','label'=>'Amazone URL'])
            </div>
            <div class="col-12 col-sm-6">
                @include('apps.create_form_input_group',['name'=>'portableUrl','label'=>'Portable URL'])
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('apps.create_form_input_group',['name'=>'requires','label'=>'Requires'])
            </div>
            <div class="col-12 col-sm-6">
                @include('apps.create_form_input_group',['name'=>'portuguese_requires','label'=>'Portuguese Requires'])
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('apps.create_form_text_area_group',['name'=>'what_new','label'=>'What new'])
            </div>
            <div class="col-12 col-sm-6">
                @include('apps.create_form_text_area_group',['name'=>'portuguese_what_new','label'=>'Portuguese What new'])
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('apps.create_form_text_area_group',['name'=>'description','label'=>'Description'])
            </div>
            <div class="col-12 col-sm-6">
                @include('apps.create_form_text_area_group',['name'=>'portuguese_description','label'=>'Portuguese Description'])
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="image">ImageURLs:</label>
                    @php
                        $images = old('Image',[]);
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
                @include('apps.create_form_input_group',['name'=>'Video','label'=>'Video URL'])
            </div>
        </div>

        <button class="btn btn-success d-block mx-auto mt-2" type="submit">Add</button>
    </form>
@endsection
