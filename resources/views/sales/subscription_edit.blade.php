@extends('layouts.main')
@section('title', 'Edit Subscription')
@section('css')
@endsection

@section('js')
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb bg-white border-bottom rounded-0">
            <li class="breadcrumb-item " aria-current="page">
                <a href="{{route('admin.sales.subscription')}}">Subscription</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>

        </ul>
    </nav>

    @if(isset($subscription))
        <form action="{{route('admin.sales.subscription.update', $subscription->SubscriptionID)}}" method="post">
            @method('PUT')
            @csrf
            <div class="d-flex flex-wrap">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="subscriptionid">Subscription Id:</label>
                        <input class="form-control" id="subscriptionid" value="{{$subscription->SubscriptionID}}" disabled/>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input class="form-control {{$errors->has('Email')?'is-invalid':''}}" id="email" name="Email" value="{{old('Email',$subscription->Email)}}" required/>
                        @if($errors->has('Email'))
                            <div class="text-danger">{{$errors->first('Email')}}</div>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="facebookid">Facebook ID:</label>
                        <input class="form-control {{$errors->has('FacebookID')?'is-invalid':''}}" id="facebookid" name="FacebookID" value="{{old('FacebookID',$subscription->FacebookID)}}"/>
                        @if($errors->has('FacebookID'))
                            <div class="text-danger">{{$errors->first('FacebookID')}}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="deviceid">DeviceID:</label>
                        <input class="form-control" id="deviceid" value="{{$subscription->DeviceID}}" disabled/>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="account-type">Account Type:</label>
                        <select class="custom-select {{$errors->has('AccountType')?'is-invalid':''}}" id="account-type" name="AccountType">
                            <option value="0" {{old("AccountType",$subscription->AccountType)=="0"?"selected":""}}>Email</option>
                            <option value="1" {{old("AccountType",$subscription->AccountType)=="1"?"selected":""}}>Facebook</option>
                            <option value="2" {{old("AccountType",$subscription->AccountType)=="2"?"selected":""}}>Device</option>
                            <option value="3" {{old("AccountType",$subscription->AccountType)=="3"?"selected":""}}>Apple</option>
                        </select>
                        @if($errors->has('AccountType'))
                            <div class="text-danger">{{$errors->first('AccountType')}}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="payment-method">Payment Method:</label>
                        <select class="custom-select {{$errors->has('PaymentMethod')?'is-invalid':''}}" id="PaymentMethod" name="PaymentMethod">
                            <option value="0" {{old('PaymentMethod',$subscription->PaymentMethod)=="0"?"selected":""}}>Key</option>
                            <option value="1" {{old('PaymentMethod',$subscription->PaymentMethod)=="1"?"selected":""}}>Paymall</option>
                            <option value="2" {{old('PaymentMethod',$subscription->PaymentMethod)=="2"?"selected":""}}>Phone Card</option>
                            <option value="3" {{old('PaymentMethod',$subscription->PaymentMethod)=="3"?"selected":""}}>Amazon</option>
                            <option value="4" {{old('PaymentMethod',$subscription->PaymentMethod)=="4"?"selected":""}}>Apple</option>
                            <option value="5" {{old('PaymentMethod',$subscription->PaymentMethod)=="5"?"selected":""}}>Paypal</option>
                            <option value="6" {{old('PaymentMethod',$subscription->PaymentMethod)=="6"?"selected":""}}>License Key</option>
                            <option value="7" {{old('PaymentMethod',$subscription->PaymentMethod)=="7"?"selected":""}}>MDC Admin</option>
                        </select>
                        @if($errors->has('PaymentMethod'))
                            <div class="text-danger">{{$errors->first('PaymentMethod')}}</div>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="TransactionDate">Transaction Date:</label>
                        <input class="form-control {{$errors->has('TransactionDate')?'is-invalid':''}}" id="TransactionDate" name="TransactionDate" value="{{old('TransactionDate',$subscription->TransactionDate)}}" required/>
                        @if($errors->has('TransactionDate'))
                            <div class="text-danger">{{$errors->first('TransactionDate')}}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="ExpiresDate">Expires Date:</label>
                        <input class="form-control {{$errors->has('ExpiresDate')?'is-invalid':''}}" id="ExpiresDate" name="ExpiresDate" value="{{old('ExpiresDate',$subscription->ExpiresDate)}}" required/>
                        @if($errors->has('ExpiresDate'))
                            <div class="text-danger">{{$errors->first('ExpiresDate')}}</div>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="PayPalSubscriberID">PayPal Subscriber ID:</label>
                        <input class="form-control" id="PayPalSubscriberID" value="{{$subscription->PayPalSubscriberID}}" disabled/>
                    </div>
                    <div class="form-group">
                        <label for="PayPalEmail">PayPal Email:</label>
                        <input class="form-control" id="PayPalEmail" value="{{$subscription->PayPalEmail}}" disabled/>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="OrderId">Order Id:</label>
                        <input class="form-control {{$errors->has('OrderId')?'is-invalid':''}}" id="OrderId" name="OrderId" value="{{old('OrderId',$subscription->OrderId)}}"/>
                        @if($errors->has('OrderId'))
                            <div class="text-danger">{{$errors->first('OrderId')}}</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="text-center mb-3">
                <button class="btn btn-success m-a">Save</button>
            </div>
        </form>
    @endif

@endsection
