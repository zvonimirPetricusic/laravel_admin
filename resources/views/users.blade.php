@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Users') }}</span>
                    <a href="#addUser" data-toggle="modal" class="btn btn-primary">
                        {{ __('Add user') }}
                    </a>
                </div>
                
                <div class="card-body"> 
                    <table class="table table-separate table-head-custom table-checkable" id="users">
                        <thead>
                            <tr>
                                <th> {{ _('Name') }} </th>
                                <th> {{ _('Email') }} </th>
                                <th> {{ _('Role') }} </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUser" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add user</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="name" class="col-form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Please enter name">
          </div>
          <div class="form-group">
            <label for="email" class="col-form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Please enter email">
          </div>
          <div class="form-group">
            <label for="password" class="col-form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Please enter email">
          </div>
          <div class="form-group">
            <label for="role_od" class="col-form-label">Role</label>
            <select id="role_id" name="role_id" class="form-control">
                <option value="1">Admin</option>
                <option value="2">Moderator</option>
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
<script src="{{ asset('js/users.js') }} "></script>
@endsection
