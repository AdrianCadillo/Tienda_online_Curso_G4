@extends(layout("app"))

@section('title_page','Productos')

@section('css')
    
@endsection

@section('content')
    <form action="{{route("producto/save")}}" method="post">
   
        <button>enviar</button>
    </form>
@endsection

@section('js')
    
@endsection

