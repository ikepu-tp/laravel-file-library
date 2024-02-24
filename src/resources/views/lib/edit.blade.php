@props(['file' => []])

@extends('SecureAuth::layout')
@section('contents')
  <div class="my-2">

    <div class="mb-3">
      <a href="{{ route('file-library.index') }}">ファイル一覧</a>
    </div>

    <h2>ファイルの編集</h2>
    @if (session('status'))
      <div class="alert alert-info">
        {{ session('status') }}
      </div>
    @endif

    <div class="my-2">
      <div>
        <iframe src="{{ route('file-library.show', ['file' => $file->fileId]) }}" frameborder="0" class="border-0"></iframe>
      </div>
      <a href="{{ route('file-library.show', ['file' => $file->fileId]) }}" target="_blank">
        {{ $file->name }}
      </a>
    </div>

    <form action="{{ route('file-library.update', ['file' => $file]) }}" method="post" enctype="multipart/form-data">
      @csrf
      @method('put')
      <div class="input-group my-2">
        <div class="input-group-text">ファイル名</div>
        <input type="text" name="name" class="form-control" placeholder="file name" title="Type file name."
          value="{{ $file->name }}" required>
      </div>
      <div class="mt-2">
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </form>

    <form action="{{ route('file-library.destroy', ['file' => $file]) }}" method="post">
      @csrf
      @method('delete')
      <button type="submit" class="btn btn-link text-danger">Remove</button>
    </form>

  </div>
@endsection
