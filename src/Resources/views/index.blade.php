@extends(config('categorizable.layout'))

@section('content')

<div class="container">
    <h1 class="float-left">{{config('categories.name')}}</h1>
    <button class="create-category float-right btn btn-dark" data-route="{{route('category.store')}}">Create a category</button>
    <div class="clearfix"></div>

    <form class="form-inline" method="get" action="{{route('category.index')}}">  
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
            <a class="edit-category" href="#" data-route="{{route('category.update',$category)}}" data-name="{{$category->name}}"><span id="category_name_{{$category->id}}">{{$category->name}}</span></a>                
            </td> 
            <td class="text-nowrap">{{isset($category->created_at) ? $category->created_at->format("M d, Y") : ''}}</td>
            <td class="text-nowrap">{{isset($category->updated_at) ? $category->updated_at->format("M d, Y") : ''}}</td>
            <td >
                <a data-route="{{route('category.destroy', $category)}}" class="delete-category text text-danger" data-toggle="confirmation" data-title="Are you sure to delete this category completely?"><i class="fa fa-times"></i></a>
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
 

<script type="text/javascript">
</script>
@stop
