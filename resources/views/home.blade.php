@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @include('metrix')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="container-fluid table-responsive py-5">
                @if($message = Session::get('success'))
                    <div class="alert alert-success" >
                        {{ $message }}
                    </div>
                @endif
                <div class="col-md-4 offset-8 ">
                    <form class="navbar-form" action="/search-student" method="post">
                        @csrf
                        <div class="mb-3 input-group">
                            <input class="form-control" placeholder="Student Search" name="studentSearch" type="text">
                            <div class="input-group-append">
                                <button class="btn btn-info btn-sm" type="submit" title="Refresh page">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">No..</th>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">DOB</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Class</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    @if (isset($students))
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($students as $student)
                            <tr>
                                <th scope="row">{{ $i++ }}</th>
                                <td>{{ $student->student_id }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->dob }}</td>
                                <td>{{ $student->phone }}</td>
                                <td>{{ $student->class_name }}</td>
                                <td>{{ $student->subjects->count() }}</td>
                                <td>
                                    <?php
                                  $status =   ($student->is_active == 1) ? "Active" : "Suspended" ;
                                  echo $status
                                    ?>
                                </td>
                                <td>{{ $student->created_at->diffForHumans() }}</td>
                                <th scope="col">
                                    <div class="btn-group">
                                        <form action="{{route('delete-student', $student->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a class="btn btn-primary" title="Edit student details" href="{{route('edit-student', $student->id)}}"><i class="fa fa-edit"></i></a>
                                            <a class="btn btn-warning" href="{{route('suspend', $student->id)}}" onclick="return confirm('Are you sure you want to suspend this student...?')" title="Suspend student" href=""><i class="fa fa-times"></i></a>
                                            <a class="btn btn-info" href="{{route('activate', $student->id)}}" onclick="return confirm('Are you sure you want to activate this student account...?')" title="Suspend student" href=""><i class="fa fa-refresh"></i></a>
                                            <button title="Remove student from list" onclick="return confirm('Are you sure you want to delete this...?')" class="btn btn-danger" href="#"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $students->links() }}
                @else
                <h1>
                    {{$message}}
                </h1>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection
