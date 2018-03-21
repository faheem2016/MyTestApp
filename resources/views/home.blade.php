@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @can('view-file')
                        <div style="float: right;">
                            <a href="{{route('cloud.viewFiles')}}"><button type="button" class="btn btn-outline-info btn-sm">View Files</button></a>
                        </div>
                    @endcan
                    @role('admin')
                        <div style="float: right; margin-right: 10px">
                            <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#modelAddUser">Add User</button>
                        </div>
                    @endrole

                    @can('upload-file')
                        <div class="col-sm-6" style="margin-bottom: 10px">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modelUpload">
                                Upload File
                            </button>
                        </div>
                    @endcan
                    @if(isset($files))
                        <div>
                            <table class="table">
                                    <thead>
                                    <tr>
                                        <th>File Name</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($files['files'] as $file)
                                        <tr>
                                            <td>
                                                {{ $file['fileName'] }}
                                            </td>
                                            <td>
                                                @can('delete-file')
                                                    <a href="{{route('cloud.delete', $file['fileName'])}}"><button type="button" class="btn btn-outline-danger">Delete</button></a>
                                                @endcan
                                                @can('download-file')
                                                    <a href="{{route('cloud.downloadFile', $file['fileId'])}}"><button type="button" class="btn btn-outline-success">Download</button></a>
                                                @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                        </div>
                    @endif

                    @if($flash = session('message'))
                        <div id="flash-message" class="alert alert-success" role="alert">
                            {{ $flash }}
                        </div>
                    @endif
                </div>

                <!-- Upload Modal -->
                <div class="modal fade" id="modelUpload" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modelTitleId">Upload File</h4>
                            </div>
                            <form method="POST" action="/upload" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    @include('layouts.errors')

                                    <div class="form-group">
                                        <label for="post"><b>Upload Photo</b></label>
                                        <input type="file" class="form-control-file" name="image" id="image" placeholder="Upload Photos">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-info">Upload</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Add User Modal -->
                <div class="modal fade" id="modelAddUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modelTitleId">Add User</h4>
                            </div>
                            <form method="POST" action="{{route('cloud.addUser')}}">
                                <div class="modal-body">
                                    @csrf

                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" id="email" name="email" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password:</label>
                                        <input type="password" id="password" name="password" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation">Password Confirmation:</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Select Permission (select one or hold CRTL for muliple values):</label>
                                        <select id="permission" name="permission[]" multiple>
                                            <option value="view-file">View files</option>
                                            <option value="upload-file">Upload files</option>
                                            <option value="delete-file">Delete files</option>
                                            <option value="download-file">Download files</option>
                                        </select>
                                    </div>

                                    @include('layouts.errors')

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
