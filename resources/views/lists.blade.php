@extends('layouts.app')

@section('content')
    <div class="container">

        {{--<div class="panel-group">--}}
            <div class="col-sm-offset-2 col-sm-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        New List
                    </div>

                    <div class="panel-body">
                        <!-- Display Validation Errors -->
                        @include('common.errors')

                        <!-- New List Form -->
                        <form action="{{ url('lists')}}" method="POST" class="form-horizontal">
                            {{ csrf_field() }}

                            <!-- List Name -->
                            <div class="form-group">
                                <label for="task-list-name" class="col-sm-3 control-label">List</label>

                                <div class="col-sm-6">
                                    <input type="text" name="name" id="task-list-name" class="form-control" value="{{ old('lists') }}">
                                </div>
                            </div>

                            <!-- Add List Button -->
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fa fa-btn fa-plus"></i>Add List
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Current Lists -->
                @if (count($lists) > 0)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Current Lists
                        </div>

                        <div class="panel-body">
                            <table class="table table-striped task-list-table">
                                <thead>
                                    <th>List</th>
                                    <th>&nbsp;</th>
                                </thead>
                                <tbody>
                                    @foreach ($lists as $list)
                                        <tr>
                                            <td class="table-text"><div>{{ $list->name }}</div></td>

                                            <!--Show List's Tasks Button -->
                                            <td width="10%">
                                                <form action="/tasks/{{$list->id}}">

                                                    <button type="submit" class="btn"  >
                                                        <i class="fa fa-btn "></i> Show Tasks
                                                    </button>
                                                </form>

                                            </td>


                                            <!-- List Delete Button -->
                                            <td>
                                                <form action="/lists/{{ $list->id }}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}

                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fa fa-btn fa-trash"></i>Delete
                                                    </button>
                                                </form>
                                            </td>



                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
    </div>
@endsection
