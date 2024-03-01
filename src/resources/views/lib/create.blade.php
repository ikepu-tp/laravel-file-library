@extends('FileLibrary::layout')
@section('contents')
  <div class="my-2">
    <div class="mb-3">
      <a href="{{ route('file-library.index') }}">
        {{ __('FileLibrary::file-library.list') }}
      </a>
    </div>
    <h2>{{ __('FileLibrary::file-library.upload_file') }}</h2>
    @if (session('status'))
      <div class="alert alert-info">
        {{ session('status') }}
      </div>
    @endif
    <form action="{{ route('file-library.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      <button type="button" class="btn btn-outline-secondary" onclick="addItem()">
        {{ __('FileLibrary::file-library.add_file') }}
      </button>
      <div id="__upload-list" class="list-group my-2">
        <div class="list-group-item">
          <div class="input-group">
            <input type="file" name="files[]" class="form-control"
              title="{{ __('FileLibrary::file-library.select_file') }}" required>
            <input type="text" name="names[]" class="form-control"
              placeholder="{{ __('FileLibrary::file-library.file_name') }}"
              title="{{ __('FileLibrary::file-library.type_file_name') }}" required>
            <button type="button" class="btn btn-danger" onclick="removeItem(this)">
              {{ __('FileLibrary::file-library.remove') }}
            </button>
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">
        {{ __('FileLibrary::file-library.upload') }}
      </button>
    </form>
  </div>
  <script>
    function removeItem(e) {
      if (!confirm("{{ __('FileLibrary::file-library.confirming_remove_file') }}")) return;
      e.parentNode.parentNode.remove();
    }

    function addItem() {
      const upload_list = document.getElementById("__upload-list");
      const item = document.createElement("div");
      item.classList.add("list-group-item");
      item.innerHTML = `
          <div class="input-group">
            <input type="file" name="files[]" class="form-control"
              title="{{ __('FileLibrary::file-library.select_file') }}" required>
            <input type="text" name="names[]" class="form-control"
              placeholder="{{ __('FileLibrary::file-library.file_name') }}"
              title="{{ __('FileLibrary::file-library.type_file_name') }}" required>
            <button type="button" class="btn btn-danger" onclick="removeItem(this)">
              {{ __('FileLibrary::file-library.remove') }}
            </button>
          </div>
      `;
      upload_list.appendChild(item);
    }
  </script>
@endsection
