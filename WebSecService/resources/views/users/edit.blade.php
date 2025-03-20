@extends('layouts.master')
@section('title', 'Edit User')
@section('content')
@can('edit_users')
<div class="d-flex justify-content-center">
    <div class="row m-4 col-sm-8">
        <form action="{{ route('users_save', $user->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Use PUT for updating existing users -->

            <!-- Display Validation Errors -->
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    <strong>Error!</strong> {{ $error }}
                </div>
            @endforeach

            <!-- Name Field -->
            <div class="row mb-2">
                <div class="col-12">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" placeholder="Name" name="name" required value="{{ old('name', $user->name) }}">
                </div>
            </div>

            <!-- Roles Selection -->
            <div class="col-12 mb-2">
                <label for="roles" class="form-label">Roles:</label>
                <select multiple class="form-select" name="roles[]">
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" 
                            {{ in_array($role->name, $user->roles->pluck('name')->toArray()) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Direct Permissions Selection (Matching Roles) -->
            <div class="col-12 mb-2">
                <label for="permissions" class="form-label">Direct Permissions:</label>
                <select multiple class="form-select" name="permissions[]">
                    @foreach($permissions as $permission)
                        <option value="{{ $permission->id }}" 
                            {{ $user->permissions->pluck('id')->contains($permission->id) ? 'selected' : '' }}>
                            {{ $permission->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endcan
@endsection
