@extends(config('categorizable.layout'))

@section('header')
  <link rel="stylesheet" href="{{ asset('css/categories.css') }}">
@stop

@section('content')

<div class="container">
    <h1 class="float-left">{{config('categories.name')}}</h1>
    <button class="create-category float-right btn btn-dark">Create a category</button>
    <div class="clearfix"></div>

    <form class="form-inline" method="get" action="{{route('post.index')}}">  
      <div class="form-group mb-2">  
        <input type="text" name="q" class="form-control" placeholder="Search" value="{{$q}}">
      </div>
      <button type="submit" class="btn btn-primary mx-sm-2 mb-2"><i class="fas fa-search"></i></button>
    </form>

    @if(isset($categories) && $categories->count())

    <div class="card mb-2">

      <table class="table table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
          <tr>
            <td> 
            <a class="edit-category" href="#" data-href="{{route('category.update',$category)}}" data-name="{{$category->name}}"><span id="category_name_{{$category->id}}">{{$category->name}}</span></a>                
            </td> 
            <td class="text-nowrap">{{isset($category->created_at) ? $category->created_at->format("M d, Y") : ''}}</td>
            <td class="text-nowrap">{{isset($category->updated_at) ? $category->updated_at->format("M d, Y") : ''}}</td>
            <td >
                <a data-href="{{route('category.destroy', $category)}}" class="delete-category text text-danger" data-toggle="confirmation" data-title="Are you sure to delete this category completely?"><i class="fa fa-times"></i></a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>

    </div>

    {{ $categories->appends(compact("q","category_name","author_name"))->links() }}

    @else
        <div class="alert alert-danger">No category found.</div>
    @endif

</div>

@stop



@section("script")

<script src="{{  asset('js/categories.js')  }}"></script>

<script type="text/javascript">
  $(function () {
 
    $("button.create-category").click(function () {

      alertify.prompt("Category","Name", '',
        function(evt, value ){

          axios.post('{{route('category.store')}}',{
            name:value
          })
          .then(function (response) { 
            location.reload()
          })
          .catch(function (error) {
            alertify.alert(error.response.data.message)
          });          

        },
        function(){ 
      });

    });

    $("a.edit-category").click(function () {
        var url  = $(this).data("href");
        var value = $(this).data("name");

        alertify.prompt("Category","Name", value,
            function(evt, value ){

                axios.put(url,{
                    name:value
                })
                .then(function (response) {  
                    $("#category_name_"+response.data.category.id).html(response.data.category.name)
                })
                .catch(function (error) {  
                    alertify.alert('Category',error.response.data.message)
                });          

        },
        function(){ 
        });
    });    

    $('[data-toggle=confirmation]').confirmation({
      rootSelector: '[data-toggle=confirmation]',
      // other options
    });     

    $("a.delete-category").click(function () {

      axios.delete($(this).data("href"))
      .then(function (response) {
        location.reload()
      })
      .catch(function (error) {
        alertify.alert(error.message)
      });

    });

  });

</script>
@stop
