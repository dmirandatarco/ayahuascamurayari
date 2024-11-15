@extends('layout.master')

@section('content')
<div class="row inbox-wrapper">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <h4 class="mb-3">Editar Rol</h4>
          <form action="{{ route('roles.update', $role) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-5">
              <input type="text" class="form-control" name="name" placeholder="Nombre del Rol" value="{{ $role->name }}">
              @error('name')
                <span class="error-message" style="color: red">{{ $message }}</span>
              @enderror
            </div>
            <h4 class="mb-3">Permisos</h4>
            <div class="form-group row">
              @php $categoria = null @endphp
              @foreach($permissions as $permission)
                @if($permission->categoria != $categoria)
                  {!! $categoria !== null ? '</div>' : '' !!}
                  <div class="col-md-3 mb-3">
                    <h5 class="mb-2 text-danger">{{ $permission->categoria }}</h5>
                    @php $categoria = $permission->categoria @endphp
                @endif
                <div class="form-check form-switch mb-2">
                  <input type="checkbox" class="form-check-input chekes" id="formSwitch{{$permission->id}}" name="permissions[]" value="{{ $permission->id }}" {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                  <label class="h6" for="formSwitch{{$permission->id}}">{{ $permission->description }}</label>
                </div>
              @endforeach
            </div>
          </div>
          <button type="button"  data-bs-toggle="tooltip" data-bs-title="Marcar" onclick="marcar(this);" class="btn btn-success mt-3">Marcar Todo</button>
        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Desmarcar" onclick="marcar2(this);" class="btn btn-danger mt-3">DesMarcar Todo</button>
          <button type="submit" class="btn btn-primary mt-3">Guardar</button>
          </form>
      </div>
    </div>
  </div>
</div>

@endsection
@push('custom-scripts')

<script>

function marcar(source)
	{
		$('.chekes').attr("checked", "checked");
	}

  function marcar2(source)
	{
		$('.chekes').removeAttr("checked");
	}
</script>

@endpush
