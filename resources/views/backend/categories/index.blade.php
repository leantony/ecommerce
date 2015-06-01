@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - Categories</title>
@stop

@section('content')
    @if($categories->isEmpty())
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <p class="text-center">There are no categories to display. Please <a
                                href="{{ route('backend.categories.create') }}"> add some</a></p>
                </div>
            </div>
            <br/>

            <p>Categories help to group similar products</p>
        </div>
    @else
        <h3>Product Categories</h3>
        <p>Categories help to group similar products. This categories listed below will be displayed on the site's
            navigation bar</p>
        <hr/>
        <div class="row">
            <div class="col-md-8 col-md-offset-4">
                <div class="pull-right">
                    <a href="#" data-toggle="modal" data-target="#addCategory">
                        <button class="btn btn-success">
                            <i class="fa fa-plus"></i>&nbsp;Create Category
                        </button>
                    </a>
                </div>
            </div>
            <hr/>
            <div class="col-md-12 m-t-20">
                <div class="table-responsive">
                    <table data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true"
                           data-sort-name="category_id"
                           data-sort-order="asc" data-search="true"
                           data-show-toggle="true"
                           data-show-columns="true">
                        <thead>
                        <tr>
                            <th data-field="category_id" data-sortable="true">Category ID</th>
                            <th data-field="category_name" data-sortable="true">Name</th>
                            <th data-field="category_alias" data-sortable="true">Alias</th>
                            <th data-field="category_created" data-sortable="true">Date created</th>
                            <th data-field="category_edited" data-sortable="true">Date Modified</th>
                            <th data-field="edit">Edit</th>
                            <th data-field="delete">Remove</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#editCategory{{ $category->id }}">
                                        {{ $category->name }}
                                    </a>
                                </td>
                                @if(empty($category->alias))
                                    <td>None</td>
                                @else
                                    <td>{{ $category->alias }}</td>
                                @endif
                                <td>{{ $category->created_at }}</td>
                                <td>{{ $category->updated_at }}</td>
                                <td>
                                    <p data-placement="top" data-toggle="tooltip" title="Edit">
                                        <a href="#" data-toggle="modal" data-target="#editCategory{{ $category->id }}">
                                            <button class="btn btn-primary btn-xs">
                                                <span class="glyphicon glyphicon-edit"></span>&nbsp;Edit
                                            </button>
                                        </a>

                                    </p>
                                </td>
                                <td>
                                    <p data-placement="top">
                                        <a href="#" data-toggle="modal"
                                           data-target="#deleteCategory{{ $category->id }}">
                                            <button class="btn btn-warning btn-xs">
                                                <span class="glyphicon glyphicon-remove"></span>&nbsp;Delete
                                            </button>
                                        </a>
                                    </p>
                                </td>
                            </tr>
                            @include('_partials.modals.actionModals.delete', ['elementID' => 'deleteCategory'.$category->id, 'route' => route('backend.categories.destroy', ['id' => $category->id])])
                            @include('_partials.modals.categories.editCategory', ['elementID' => 'editCategory'.$category->id])
                        @endforeach
                        </tbody>

                    </table>
                    {!! $categories->render() !!}
                </div>
            </div>
            @endif
            @include('_partials.modals.categories.addCategory', ['elementID' => 'addCategory'])
        </div>

@stop