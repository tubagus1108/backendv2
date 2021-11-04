@extends('layouts.authentication.master')
@section('title', 'Login')

@section('css')
@endsection

@section('style')
@endsection


@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-12">
         <div class="login-card">
            <div>
               <div style = "display: block;
               margin-left: auto;
               margin-right: auto;
               width: 150px; height: 150px"><a class="logo" href=""><img class="img-fluid for-light" src="{{ asset('assets/images/adaremit-logo--icon.png') }}"><img class="img-fluid for-dark" src="{{ asset('assets/images/adaremit-logo--icon.png') }}" alt="looginpage"></a></div>
               {{-- <div><img class="img-fluid for-light" src="{{ asset('assets/images/adaremit-logo--icon.png') }}" alt=""></div> --}}
               <div class="login-main">
                  <form method="POST"  action="{{route('login-post')}}" class="theme-form">@csrf
                     @if(session('failed'))
                     <div class="alert alert-success outline alert-dismissible fade show" role="alert"><i data-feather="thumbs-up"></i>
                         <p>{{session('failed')}}</p>
                         <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                     </div>
                     @endif
                     <h4>Sign in to account</h4>
                     <p>Enter your email & password to login</p>
                     <div class="form-group">
                        <label class="col-form-label">Email Address</label>
                        <input class="form-control" type="email" name="email" required="" placeholder="hello@gmail.com">
                     </div>
                     <div class="form-group">
                        <label class="col-form-label">Password</label>
                        <input class="form-control" type="password" name="password" required="" placeholder="*********">
                        <div class="show-hide"><span class="show">                         </span></div>
                     </div>
                     <div class="form-group mb-0">
                        <div class="checkbox p-0">
                           <input id="checkbox1" type="checkbox">
                           <label class="text-muted" for="checkbox1">Remember password</label>
                        </div>
                        <a class="link" href="">Forgot password?</a>
                        <button class="btn btn-primary btn-block" type="submit">Sign in</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('script')
@endsection
