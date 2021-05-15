@extends('layouts.app')

@section('content')

    

<h1>タスク一覧</h1>

    @if (count($tasks) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>ステータス</th>
                    <th>メッセージ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                <tr>
                    {{-- 詳細ページへのリンク --}}
                    <td>{!! link_to_route('tasks.show', $task->id, ['task' => $task->id]) !!}</td>
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->content }}</td>
                </tr>
        
                @endforeach
            </tbody>
        </table>
    @endif

    {!! link_to_route('tasks.create', '作成ページ', [], ['class' => 'btn btn-primary']) !!}
    
    {!! link_to_route('tasks.edit', '編集', ['task' => $task->id], ['class' => 'btn btn-light']) !!}
    
    

@endsection