@extends('layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="text-center mb-8">
      <img class="mb-5" style="height: 15rem;" src="{{asset('img/logo.png')}}" alt="logo">
    </div>
    <div class="col-md-4 col-xl-4 mx-auto">
      <div class="card">
        <div class="row">
        
          <div class="col-md-12 ps-md-0">
          
            <div class="auth-form-wrapper px-5 py-5">
              
              <h5 class="text-muted fw-normal mb-4 text-center">Iniciar Sesión</h5>
              <form class="forms-sample" method="post" action="{{route('login')}}">
              {{ csrf_field() }}
                <div class="mb-3">
                  <label for="userEmail" class="form-label">Usuario</label>
                  <input type="text" class="form-control" id="userEmail" placeholder="Usuario" name="usuario">
                  @error('usuario')
                    <span class="error-message" style="color:red">{{ $message }}</span>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="userPassword" class="form-label">Password</label>
                  <input type="password" class="form-control" id="userPassword" autocomplete="current-password" placeholder="Password"  name="password">
                  @error('password')
                    <span class="error-message" style="color:red">{{ $message }}</span>
                  @enderror
                </div>
                <div style="text-align: end;">
                    <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0" >Iniciar Sesion</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection