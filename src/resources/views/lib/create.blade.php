@extends('SecureAuth::layout')
@section('contents')
  <div>
    <h2>ファイルのアップロード</h2>
    <form action="{{ route('file-library.store') }}" method="post">
      @csrf
      <button type="button" class="btn btn-outline-secondary" onclick="addItem()">ファイル追加</button>
      <div id="__upload-list" class="list-group my-2">
        <div class="list-group-item">
          <div class="input-group">
            <input type="file" name="files[]" class="form-control" title="Select file." required>
            <input type="text" name="names[]" id="" class="form-control" placeholder="file name"
              title="Type file name." required>
            <button type="button" class="btn btn-danger" onclick="removeItem(this)">削除</button>
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Upload</button>
    </form>
  </div>
  <script>
    function removeItem(e) {
      if (!confirm("Do you want to remove this item?")) return;
      e.parentNode.parentNode.remove();
    }

    function addItem() {
      const upload_list = document.getElementById("__upload-list");
      const item = document.createElement("div");
      item.classList.add("list-group-item");
      item.innerHTML = `
          <div class="input-group">
            <input type="file" name="files[]" class="form-control" title="Select file." required>
            <input type="text" name="names[]" id="" class="form-control" placeholder="file name"
              title="Type file name." required>
            <button type="button" class="btn btn-danger" onclick="removeItem()">削除</button>
          </div>
      `;
      upload_list.appendChild(item);
    }
  </script>
@endsection
