@props(['files' => []])

@extends('FileLibrary::layout')
@section('contents')
  <div class="contaier my-2">
    <div class="row justify-content-end">
      <div class="col-auto mb-2">
        <a href="{{ route('file-library.create') }}" class="btn btn-primary">
          {{ __('FileLibrary::file-library.upload') }}
        </a>
      </div>
    </div>
    <div class="row">
      @foreach ($files as $file)
        <div class="col-auto">
          <div class="card my-2">
            <div class="card-header">
              <a href="{{ route('file-library.show', ['file' => $file->fileId]) }}" target="_blank">
                {{ $file->name }}
              </a>
            </div>
            <a href="{{ route('file-library.show', ['file' => $file->fileId]) }}" class="card-body" target="_blank">
              <iframe src="{{ route('file-library.show', ['file' => $file->fileId]) }}" frameborder="0"
                class="border-0"></iframe>
            </a>
            <div class="card-footer">
              <div class="row justify-content-end">
                <div class="col-auto text-secondary" style="font-size: .75em;">
                  <div class="text-end">
                    {{ __('FileLibrary::file-library.created_at') }}：{{ $file->created_at->format('Y/m/d H:i') }}
                  </div>
                  <div class="text-end">
                    {{ __('FileLibrary::file-library.updated_at') }}：{{ $file->updated_at->format('Y/m/d H:i') }}
                  </div>
                </div>
                <div class="col-auto">
                  <a href="{{ route('file-library.edit', ['file' => $file]) }}" class="btn btn-success">
                    {{ __('FileLibrary::file-library.edit') }}
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    {{ $files->links() }}
  </div>
@endsection
