@extends(layout("app"))

@section('title_page','Productos')

@section('css')
    
@endsection

@section('content')
    <form action="{{route("producto/save")}}" method="post">
        <input type="text" value="{{$this->Csrf()}}" name="_token">

        <button>enviar</button>
    </form>
@endsection

@section('js')
    
@endsection

