# Laravel File Library

これはLaravel用のファイル管理ライブラリです。

## How to use

### インストール

```bash
composer require ikepu-tp/larave-file-library
```

### 設定等のpublish

```bash
php artisan vendor:publish --provider="ikepu_tp\FileLibrary\FileLibraryServiceProvider"
```

### ルーティング

| HTTPメソッド | URI                     | アクション | ルート名             | 簡単な説明                                                   |
| ------------ | ----------------------- | ---------- | -------------------- | ------------------------------------------------------------ |
| GET          | /file/lib               | index      | file-library.index   | ファイルライブラリの一覧を表示します。                       |
| GET          | /file/lib/create        | create     | file-library.create  | 新しいファイルをアップロードするためのフォームを表示します。 |
| POST         | /file/lib               | store      | file-library.store   | ファイルをアップロードします。                               |
| GET          | /file/lib/{fileId}      | show       | file-library.show    | 特定のファイルの詳細を表示します。                           |
| GET          | /file/lib/{fileId}/edit | edit       | file-library.edit    | 特定のファイルの編集フォームを表示します。                   |
| PUT/PATCH    | /file/lib/{fileId}      | update     | file-library.update  | 特定のファイルを更新します。                                 |
| DELETE       | /file/lib/{fileId}      | destroy    | file-library.destroy | 特定のファイルを削除します。                                 |

> [!NOTE]
> `{fileId}` はUUIDです。

#### ファイルのアップロード

```bash
POST http://your-project.com/file/lib
```

| Key   | Type               | Accepted Values | Required |
| ----- | ------------------ | --------------- | -------- |
| files | Array<int, File>   |                 | Y        |
| names | Array<int, string> | max length: 250 | Y        |

#### ファイルの編集

```bash
PUT http://your-project.com/file/lib/{fileId}
```

| Key  | Type   | Accepted Values | Required |
| ---- | ------ | --------------- | -------- |
| name | string | max length: 250 | Y        |

## 貢献

貢献は歓迎します！以下の方法で参加できます。

Issue: バグの報告や新機能の提案などに使用してください。
Pull Requests: バグの修正や新機能の追加等の貢献も歓迎します。

## ライセンス

[ライセンス](./LICENSE)を確認してください。
