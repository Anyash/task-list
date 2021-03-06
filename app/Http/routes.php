<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

use App\Task;
use App\TasksList;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;

Route::group(['middleware' => ['web']], function () {
    /**
     * Show Task Dashboard
     */
    Route::get('/', function () {
        return view('lists', [
            'lists' => TasksList::orderBy('created_at', 'asc')->get(),
        ]);
    });

    Route::get('/lists', function () {
        return view('lists', [
            'lists' => TasksList::orderBy('created_at', 'asc')->get()
        ]);
    });

    Route::get('/tasks/{list_id}', function ($list_id) {
        $sort_by_task_name_order=Input::get('sort_by_task_name');
        $sort_by_date_order=Input::get('sort_by_date');

        if ($sort_by_task_name_order!=NULL)
                return view('tasks', [
                    'tasks' => Task::orderBy('name', $sort_by_task_name_order)->where('tasks_list_id', $list_id)->paginate(10),
                    'list_id' => $list_id,
                ]);
        elseif ($sort_by_date_order!=NULL)
            return view('tasks', [
                'tasks' => Task::orderBy('created_at', $sort_by_date_order)->where('tasks_list_id', $list_id)->paginate(10),
                'list_id' => $list_id,
            ]);
        else
            return view('tasks', [
                'tasks' => Task::where('tasks_list_id', $list_id)->paginate(10),
                'list_id' => $list_id,
            ]);
    });
    /**
     * Add New Task
     */
    Route::post('/task', function (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'tasks_list_id' =>'required',

        ]);

        if ($validator->fails()) {
            return redirect('/tasks/'.$request->tasks_list_id)
                ->withInput()
                ->withErrors($validator);
        }

        $task = new Task;
        $task->name = $request->name;
        $task->tasks_list_id = $request->tasks_list_id;
        $task->save();

        return redirect('/tasks/'.$request->tasks_list_id);
    });

    /**
     * Add New List
     */
    Route::post('/lists', function (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        $list = new TasksList;
        $list->name = $request->name;
        $list->save();

        return redirect('/lists');
    });

    /**
     * Delete Task
     */
    Route::delete('/task/{id}/{tasks_list_id}', function ($id, $tasks_list_id) {
        Task::findOrFail($id)->delete();

        return redirect('/tasks/'.$tasks_list_id);
    });

    /**
     * Delete List
     */
    Route::delete('/lists/{id}', function ($id) {
        TasksList::findOrFail($id)->delete();

        return redirect('/lists');
    });
});
