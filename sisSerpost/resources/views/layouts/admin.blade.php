<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Serpost-Tocache</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skinsfolder instead of downloading all of them to reduce the load.
     -->
    <!--agregamo asset para decirle que estan en public-->
    <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
    <link rel="apple-touch-icon" href="{{asset('img/apple-touch-icon.png')}}">
    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">


  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">

        <!-- Logo -->
        <a href="#" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>S</b>T</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>SERPOST</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->

              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <small class="bg-red">Online</small>
                  <span class="hidden-xs"></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">

                    <p>
                      Universidad Nacional Agraria de la Selva - Ing Software II
                      <!--<small>abel.miraval@unas.edu.pe</small>-->
                    </p>
                  </li>

                  <!-- Menu Footer-->
                  <li class="user-footer">

                    <div class="pull-right">
                      <a href="{{url('/logout')}}" class="btn btn-default btn-flat">Cerrar</a>
                    </div>
                  </li>
                </ul>
              </li>

            </ul>
          </div>

        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->

          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"></li>
            @if (auth::user()->tipo_usuario=="1") 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Datos Estadisticos</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url('grafico/graficoEncomienda')}}"><i class="fa fa-circle-o"></i>Grafico Envio Encomiendas</a></li>
                <li><a  href="javascript:void(0);" onclick="cargarlistado(1);"><i class="fa fa-circle-o"></i> Reporte Envio Encomienda</a></li>
              </ul>
            </li>  
            @endif

             @if (auth::user()->tipo_usuario=="1")
            <li class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Correspondecia</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url('correspondencia/tipoCorrespondencia')}}"><i class="fa fa-circle-o"></i>Tipo de Correspondecia</a></li>
                <li><a href="{{url('correspondencia/subTipoCorrespondencia')}}" onclick=""><i class="fa fa-circle-o"></i> Sub tipo de Correspondencia</a></li>
              </ul>
            </li>
            @endif

            @if (auth::user()->tipo_usuario=="1")
            <li class="treeview">
              <a href="#">
                <i class="fa fa-th"></i>
                <span>Tarifa</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              
                <li><a href="{{url('tarifa/departamento')}}"><i class="fa fa-circle-o"></i> Departamentos</a></li>
           
                
                <li><a href="{{url('tarifa/departamentoEntrega')}}"><i class="fa fa-circle-o"></i> Departamentos Entrega</a></li>
                <li><a href="{{url('tarifa/peso')}}"><i class="fa fa-circle-o"></i> Peso</a></li>
                <li><a href="{{url('tarifa/zona')}}"><i class="fa fa-circle-o"></i> Zona Entrega</a></li>
         
              </ul>
            </li>

            @endif

            
            <li class="treeview">
              <a href="#">
                <i class="fa fa-shopping-cart"></i>
                <span>Envios</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url('envio/cliente')}}"><i class="fa fa-circle-o"></i> Clientes</a></li>
                <li><a href="{{url('envio/envioEncomienda')}}"><i class="fa fa-circle-o"></i>Envios Correspondecia</a></li>
                <li><a href="{{url('envio/valija')}}"><i class="fa fa-circle-o"></i>Valija</a></li>
              </ul>
            </li>

              
            @if (auth::user()->tipo_usuario=="1") 
             <li class="treeview">
              <a href="#">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>Personal</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url('personal/trabajador')}}"><i class="fa fa-circle-o"></i> Trabajadores</a></li>
                <li><a href="{{url('personal/liquidacionMovilidad')}}"><i class="fa fa-circle-o"></i> Liquidacion de Movilidad</a></li>

              </ul>
            </li>
            @endif



            @if (auth::user()->tipo_usuario=="1") 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-folder"></i> <span>Acceso</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{url('seguridad/usuario')}}"><i class="fa fa-circle-o"></i> Usuarios</a></li>

              </ul>
            </li>
            @endif

            @if (auth::user()->tipo_usuario=="1") 
             <li>
              <a href="#">
                <i class="fa fa-plus-square"></i> <span>Ayuda</span>
                <small class="label pull-right bg-red">PDF</small>
              </a>
            </li>
            @endif

            @if (auth::user()->tipo_usuario=="1") 
            <li>
              <a href="#">
                <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
                <small class="label pull-right bg-yellow">IT</small>
              </a>
            </li>
            @endif

          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>





       <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">

          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Sistema Serpost</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                      <div class="col-md-12">
                              <!--Contenido-->
                                <!--Una vista dinamica, le voy a decir a laravel que cuando hago referencia a esta plantilla
                                blade pueda agregar un seccion contenido-->
                              @yield('contenido')
                              <!--Fin Contenido-->
                           </div>
                        </div>

                      </div>
                    </div><!-- /.row -->
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section><!-- /.content -->
    
    


      </div><!-- /.content-wrapper -->
      <!--Fin-Contensido-->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b></b>
        </div>
        <strong>UNAS - <a href="#">Ing. Software II</a></strong>
      </footer>


    <!-- jQuery 2.1.4 -->
    <script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
    <!-- Para agregar codigo java script a cualquiera de las vistas-->
    @stack('scripts')<!-- la funcion stack de laravel -->

    <!-- Bootstrap 3.3.5 -->


    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('js/app.min.js')}}"></script>
    
    <script src="{{asset('js/sis-serpost.js')}}"></script>
  </body>
</html>
