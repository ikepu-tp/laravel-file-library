@props(['files' => []])

@extends('SecureAuth::layout')
@section('contents')
  <div class="contaier my-2">
    <div class="row justify-content-end">
      <div class="col-auto mb-2">
        <a href="{{ route('file-library.create') }}" class="btn btn-primary">アップロード</a>
      </div>
    </div>
    <div class="row">
      @foreach ($files as $file)
        <div class="col-auto">
          <div class="card my-2">
            <div class="card-header">
              {{ $file->name }}
            </div>
            <div class="card-body">
              <iframe src="{{ route('file-library.show', ['file' => $file->fileId]) }}" frameborder="0"
                class="border-0"></iframe>
            </div>
            <div class="card-footer text-end">
              <a href="{{ route('file-library.edit', ['file' => $file]) }}" class="btn btn-success">編集</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    {{ $files->links() }}
  </div>
@endsection
