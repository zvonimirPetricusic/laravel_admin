@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body"> 

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="filter_category_id" class="col-form-label">Category</label>
                                <select name="filter_category_id" id="filter_category_id" class="form-control">
                                
                                </select>
                            </div>
                            <div class="form-group" id="filter_subcategoryContainer" style="display: none">
                                <label for="filter_subcategory_id" class="col-form-label">Subcategory</label>
                                <select name="filter_subcategory_id" id="filter_subcategory_id" class="form-control">
                                
                                </select>
                            </div>
                            <div class="form-group" id="filter_sub_subcategoryContainer" style="display: none">
                                <label for="filter_sub_subcategory_id" class="col-form-label">Sub-Subcategory</label>
                                <select name="filter_sub_subcategory_id" id="filter_sub_subcategory_id" class="form-control">
                                
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price_min" class="col-form-label">Price Min</label>
                                <input type="number" class="form-control" id="filter_price_min" name="filter_price_min" placeholder="Please enter or leave empty">
                            </div>
                            <div class="form-group">
                                <label for="price_max" class="col-form-label">Price Max</label>
                                <input type="number" class="form-control" id="filter_price_max" name="filter_price_max" placeholder="Please enter or leave empty">
                            </div>
                            <div class="form-group text-right">
                                <button type="button" id="filterBtn" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Products') }}</span>
                    @can('admin-only', Auth::user())
                        <a href="#addProduct" data-toggle="modal" class="btn btn-primary">
                            {{ __('Add product') }}
                        </a>
                    @endcan
                </div>
                
                <div class="card-body"> 
                    <div class="row" id="productContainer">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="addProduct" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data">
          <div class="form-group">
            <label for="name" class="col-form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="5" placeholder="Please enter description"></textarea>
          </div>
          <div class="form-group">
            <label for="price" class="col-form-label">Price</label>
            <input type="text" class="form-control" id="price" name="price" placeholder="Please enter price">
          </div>
          <div class="form-group">
            <label for="category_id" class="col-form-label">Category</label>
            <select name="category_id" id="category_id" class="form-control">
               
            </select>
          </div>
          <div class="form-group" id="subcategoryContainer" style="display: none">
            <label for="subcategory_id" class="col-form-label">Subcategory</label>
            <select name="subcategory_id" id="subcategory_id" class="form-control">
               
            </select>
          </div>
          <div class="form-group" id="sub_subcategoryContainer" style="display: none">
            <label for="sub_subcategory_id" class="col-form-label">Sub-Subcategory</label>
            <select name="sub_subcategory_id" id="sub_subcategory_id" class="form-control">
               
            </select>
          </div>
          <div class="form-group">
            <label for="imageDropzone" class="col-form-label">Images</label>
            <div class="dropzone" id="dropzone">
        <span class="dropzone-text">Drop images here</span>
    </div>
    <div id="image-list"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-toggle="save-form">Save</button>
      </div>
    </div>
  </div>
</div>

<link rel="stylesheet" href="{{ asset('css/products.css') }}">
<!-- JS -->
<script src="{{ asset('js/products.js') }}"></script>
@endsection
