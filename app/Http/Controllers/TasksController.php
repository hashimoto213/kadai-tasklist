<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        
        // もし、ログイン済みなら
        if(\Auth::check()){
        
            //   ログインユーザーを取得し、
            $user = \Auth::user();
            //   ユーザーのタスクデータを$tasksに代入
            $tasks = $user->tasks()->orderBy('created_at','desc')->paginate(10);
            
            $data = [
                    'user' => $user,
                    'tasks' => $tasks,
            ];
            //   tasks.indexビューに引き渡す。
            return view('tasks.index',$data);
         
        }
        
        // そうでなかったら
        //   welcomeビューをreturnする。
        return view('welcome', $data);
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $task = new Task;

        // メッセージ作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|max:10',   
            'content' => 'required|max:10',
        ]);
        
        // $task = new Task;
        // $task->user_id = \Auth::id(); // ログインユーザーのid
        // $task->status = $request->status;    // 追加
        // $task->content = $request->content;    // 追加
        // $task->save();
       
        
        $request->user()->tasks()->create([
            'status' => $request->status,
            'content' => $request->content,
        ]);

        
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        
        // TODO: もし、自分(=ログインユーザー)の$taskでなければ、トップページにリダイレクトする
        if (\Auth::check()) {
            return redirect('/');
        }
        
        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);

        // TODO: もし、自分(=ログインユーザー)の$taskでなければ、トップページにリダイレクトする
        if (\Auth::check()) {
            return redirect('/');
        }
    
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'status' => 'required|max:255',   
            'content' => 'required|max:255',
        ]);
        
        $task = Task::findOrFail($id);
        
        // TODO: もし、自分(=ログインユーザー)の$taskでなければ、トップページにリダイレクトする
        if (\Auth::check()) {
            return redirect('/');
        }
    
        //更新
        $task->status = $request->status;    // 追加
        $task->content = $request->content;
        $task->save();
        
        
        
        
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        
        // TODO: もし、自分(=ログインユーザー)の$taskでなければ、トップページにリダイレクトする
        if (\Auth::check()) {
            return redirect('/');
        }
    
        // メッセージを削除
        //$task->delete();
        
        if (\Auth::id() === $tasks->user_id) {
            $tasks->delete();
        }
        
        return redirect('/');
    }
}
