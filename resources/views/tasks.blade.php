@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Task
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- New Task Form -->
                    <form action="{{ url('task')}}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Task Name -->
                        <div class="form-group">
                            <label for="task-name" class="col-sm-3 control-label">Task</label>

                            <div class="col-sm-6">
                                <input type="hidden" name="tasks_list_id" class="form-control" value="{{ $list_id }}">
                                <input type="text" name="name" id="task-name" class="form-control" value="{{ old('task') }}">
                            </div>
                        </div>

                        <!-- Add Task Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Add Task
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Tasks -->
            @if (count($tasks) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Current Tasks
                    </div>
                    <div class="panel-body">

                        <table class="table table-striped task-table">
                            <thead>
                                <th>
                                    <form action="/tasks/{{ $tasks[0]->tasks_list_id }}" method="GET">
                                        <input type="hidden" id="sort_name" name="sort_by_task_name" value="asc" />
                                        <button type="submit" class="btn btn-default" >
                                            <i class="fa fa-btn"></i>Task
                                        </button>
                                    </form>
                                </th>
                                <th>
                                    <form action="/tasks/{{ $tasks[0]->tasks_list_id }}" method="GET">
                                        <input type="hidden" name="sort_by_date" value="asc"/>
                                        <button type="submit" class="btn btn-default">
                                            <i class="fa fa-btn"></i>Created at
                                        </button>
                                    </form>
                                </th>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        <td class="table-text"><div>{{ $task->name }}</div></td>
                                        <td class="table-text"><div>{{ $task->created_at }}</div></td>
                                        <!-- Task Delete Button -->
                                        <td>
                                            <form action="/task/{{ $task->id }}/{{ $task->tasks_list_id }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa fa-btn fa-trash"></i>Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                {!! $tasks->links() !!}
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
