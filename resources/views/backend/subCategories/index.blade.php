@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - sub-categories</title>
@stop

@section('content')

    @if($subcategories->isEmpty())
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <p class="text-center">There are no sub-categories to display. Please <a
                                href="{{ action('Backend\SubCategoriesController@create') }}"> add some</a></p>
                </div>
                <br/>

                <p>Subcategories help group products in a specific category together. This will also be displayed in the
                    site's navigation bar, under their related category</p>
            </div>

        </div>

    @else
        <h3>Product sub-categories</h3>
        <p>Subcategories help group products in a specific category together. This will also be displayed in the site's
            navigation bar, under their related category</p>
        <hr/>
        <div class="row">
            <div class="col-md-8 col-md-offset-4">
                <div class="pull-right">
                    <a href="#" data-toggle="modal" data-target="#addSubCategory">
                        <button class="btn btn-success">
                            <i class="fa fa-plus"></i>&nbsp;Create new Subcategory
                        </button>

                    </a>
                </div>
            </div>

            <div class="col-md-12" style="margin-top: 20px">
                <!-- /input-group -->
                <div class="table-responsive">
                    <table data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true"
                           data-sort-name="subcat_id"
                           data-sort-order="asc" data-search="true"
                           data-show-toggle="true"
                           data-show-columns="true">
                        <thead>
                        <tr>
                            <th data-field="subcat_id" data-sortable="true">ID</th>
                            <th data-field="subcat_name" data-sortable="true">Name</th>
                            <th data-field="subcat_category" data-sortable="true">Related Category</th>
                            <th data-field="subcat_created" data-sortable="true">Date created</th>
                            <th data-field="subcat_edited" data-sortable="true">Date Modified</th>
                            <th data-field="edit">Edit</th>
                            <th data-field="delete">Remove</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($subcategories as $subcategory)
                            <tr>
                                <td>{{ $subcategory->id }}</td>
                                <td>
                                    <a href="#" data-toggle="modal"
                                       data-target="#editSubCategory{{ $subcategory->id }}">
                                        {{ $subcategory->name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('backend.categories.show', ['id' => $subcategory->category->id]) }}">
                                        {{ $subcategory->category->name }}
                                    </a>
                                </td>
                                <td>{{ $subcategory->created_at }}</td>
                                <td>{{ $subcategory->updated_at }}</td>
                                <td>
                                    <p data-placement="top" data-toggle="tooltip" title="Edit">
                                        <a href="#" data-toggle="modal"
                                           data-target="#editSubCategory{{ $subcategory->id }}">
                                            <button class="btn btn-primary btn-xs"><span
                                                        class="glyphicon glyphicon-edit"></span>&nbsp;Edit
                                            </button>
                                        </a>

                                    </p>
                                </td>
                                <td>
                                    <p data-placement="top">
                                        <a href="#" data-toggle="modal"
                                           data-target="#deleteSubCategory{{ $subcategory->id }}">
                                            <button class="btn btn-warning btn-xs">
                                                <span class="glyphicon glyphicon-remove"></span>&nbsp;Delete
                                            </button>
                                        </a>
                                    </p>
                                </td>
                            </tr>
                            @include('_partials.modals.actionModals.delete', ['elementID' => 'deleteSubCategory'.$subcategory->id, 'route' => route('backend.subcategories.destroy', ['id' => $subcategory->id])])
                            @include('_partials.modals.subcategories.editSubCategory', ['elementID' => 'editSubCategory'.$subcategory->id])
                        @endforeach
                        </tbody>
                    </table>

                    {!! $subcategories->render() !!}
                </div>
            </div>
        </div>
    @endif
    @include('_partials.modals.subcategories.addSubCategory', ['elementID' => 'addSubCategory'])
@stop