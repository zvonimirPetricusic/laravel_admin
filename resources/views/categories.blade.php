@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Users') }}</span>
                    <a href="#addCategory" data-toggle="modal" class="btn btn-primary">
                        {{ __('Add category') }}
                    </a>
                </div>
                
                <div class="card-body"> 
                    <table class="table table-separate table-head-custom table-checkable" id="categories">
                        <thead>
                            <tr>
                                <th> {{ _('Category') }} </th>
                                <th> {{ _('Subcategory') }} </th>
                                <th> {{ _('Sub-Subcategory') }} </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="addCategory" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="title" class="col-form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Please enter category title">
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
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-toggle="save-form">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- JS -->
<script src="{{ asset('js/categories.js') }} "></script>
@endsection
