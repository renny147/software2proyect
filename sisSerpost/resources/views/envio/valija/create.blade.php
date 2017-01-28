@extends ('layouts.admin')
@section ('contenido')
 <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <h3>Nueva Valija</h3>
      @if (count($errors)>0)
      <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
          <li>{{$error}}</li>
        @endforeach
        </ul>
      </div>
      @endif
    </div>
 </div>

    {!!Form::open(array('url'=>'envio/valija','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}
            <!-- token-->

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="form-group">
                <label for="valija">Codigo Valija</label>
                <input type="number" name="idvalija" class="form-control" >
            </div>
        </div>


        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="form-group">
                <label for="descripcion">Descripcion</label>
                <input type="text" name="descripcion" class="form-control">
            </div>
        </div>

       <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="form-group">

                <button class="btn btn-primary" type="submit">Guardar</button>
                <button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
        </div>
    </div>
{!!Form::close()!!}
@endsection
