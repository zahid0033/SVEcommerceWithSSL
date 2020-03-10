@extends('vendor.master')
@section('title','Category Management')
@section('Category_management','active')
@section('content')
    <div class="container-fluid">
        <div id="Categories" class="tab-pane fade in active">

                <div class="row">
                    <div class="col-md-12 text-center" style="overflow: auto">
                        @if($categories->count() == 0 or $categories->count() == 1  )
                            @if(is_null($parent_id))
                                <p class="small-heading"><a class="btn btn-success" data-toggle="modal" data-target="#modal_category_add" onclick="setParentId({{$parent_id}})" data-whatever="@mdo"><i class="fas fa-plus"> Add Category</i></a></p>
                            @else
                                <p class="small-heading"><a class="btn btn-success" data-toggle="modal" data-target="#modal_category_add" onclick="setParentId({{$parent_id}})" data-whatever="@mdo"><i class="fas fa-plus"> Add Sub-Category</i></a></p>
                            @endif
                        @else
                            @if(is_null($parent_id))
                                <p class="small-heading"><a class="btn btn-default" title="Restricted" ><i class="fas fa-plus"> Add Category</i></a></p>
                            @else
                                <p class="small-heading"><a class="btn btn-success" data-toggle="modal" data-target="#modal_category_add" onclick="setParentId({{$parent_id}})" data-whatever="@mdo"><i class="fas fa-plus"> Add Sub-Category</i></a></p>
                            @endif
                        @endif
                            @foreach ($categories as $s)
                            <div class="col-md-3 news mb-2 mar-bott">
                                <div class="head img_hover">
                                    @if(is_null($parent_id))
                                        <a  href="{{route('subCategoryView',$s->id)}}"  >
                                            @if(empty($s->image))
                                            <img src="{{ asset('assets/vendor/images/icon/no_image.jpg') }}" class="img" alt="" title="Click to see Sub-Category">
                                            @else
                                            <img src="{{ asset('assets/vendor/images/categories/') }}/{{$s->image}}" class="img" alt="" title="Click to see Sub-Category">
                                            @endif
                                        </a>
                                    @else
                                        @if(empty($s->image))
                                            <img src="{{ asset('assets/vendor/images/icon/no_image.jpg') }}" class="img" alt="" title="You cant have more sub-category now">
                                        @else
                                            <img src="{{ asset('assets/vendor/images/categories/') }}/{{$s->image}}" class="img" alt="" title="You cant have more sub-category now">
                                        @endif

                                    @endif
                                    <div class="overlay">
                                      @if (in_array($s->id,$sub))
                                        <a class="btn btn-default btn-xs"  title="Restricted" ><i class="fa fa-trash"></i></a>
                                      @else
                                        <a class="btn btn-danger btn-xs" href="{{route('categoryRemove',$s->id)}}"  title="Remove" onclick="return confirm('Delete this?')"><i class="fa fa-trash"></i></a>
                                      @endif
                                        <a class="btn btn-success" data-toggle="modal" data-target="#modal_category_update" onclick="setCatUpdate('{{$s->id}}','{{$s->name}}','{{$s->description}}')" data-whatever="@mdo" title="Edit"><i class="fa fa-edit"></i></a>
                                        <sub><mark>{{$s->status}}</mark></sub>
                                    </div>
                                </div>
                                <div class=" text-center ">
                                    <h3><b>{{$s->name}}</b></h3>
                                    <h5><b>{{$s->description}}</b></h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {!! $categories->Links() !!}
                </div>
            </div>
    </div>
@endsection
