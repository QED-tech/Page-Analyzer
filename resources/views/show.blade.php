@extends('layouts.app')
@section('content')

    @include('flash::message')
    <div class="container-lg">
        <h1 class="mt-5 mb-3">Сайт: {{ $url->name }}</h1>

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tbody>
                <tr>
                    <td>ID</td>
                    <td>{{ $url->id }}</td>
                </tr>
                <tr>
                    <td>Имя</td>
                    <td>{{ $url->name }}</td>
                </tr>
                <tr>
                    <td>Дата создания</td>
                    <td>{{ $url->created_at }}</td>
                </tr>
                <tr>
                    <td>Дата обновления</td>
                    <td>{{ $url->updated_at }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <h2 class="mt-5 mb-3">Проверки</h2>

        <form method="post" action="{{ route('checks.store', $url->id) }}">
            @csrf
            <input type="submit" class="btn btn-primary" value="Запустить проверку">
        </form>

        <table class="table table-bordered table-hover text-nowrap mt-3">
            <tbody>
            <tr>
                <th>ID</th>
                <th>Код ответа</th>
                <th>h1</th>
                <th>keywords</th>
                <th>description</th>
                <th>Дата создания</th>
            </tr>
            @foreach($urlChecks as $urlCheck)
                <tr>
                    <th>{{ $urlCheck->id }}</th>
                    <th>{{ $urlCheck->status_code }}</th>
                    <th>{{ \Illuminate\Support\Str::limit($urlCheck->h1, 30) }}</th>
                    <th>{{ \Illuminate\Support\Str::limit($urlCheck->keywords, 30) }}</th>
                    <th>{{ \Illuminate\Support\Str::limit($urlCheck->description, 30) }}</th>
                    <th>{{ $urlCheck->created_at }}</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
