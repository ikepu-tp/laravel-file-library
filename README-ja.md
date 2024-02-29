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

## API Documentation

### ファイルライブラリ

#### ファイルライブラリリソース

```json
{
  "fileId": "string",
  "name": "string",
  "url": "string",
  "mime_type": "string",
  "created_at": "string",
  "updated_at": "string"
}
```

#### 一覧

ファイルライブラリのファイル一覧を取得します。

```bash
GET http://your-project.com/file/lib
```

##### 一覧サンプル

```json:Response
{
    "status":{
        "result":true,
        "code":200,
    },
    "payloads":{
        "meta": {
            "currentPage": 1,
            "lastPage": 1,
            "length": 1,
            "getLength": 0,
            "per":1,
        },
        "items":[
                {
                    "fileId": "uuid",
                    "name": "file name",
                    "url": "http://your-project.com/file/lib/uuid",
                    "mime_type": "application/json",
                    "created_at": "2024-01-01T00:00:00Z",
                    "updated_at": "2024-01-01T00:00:00Z"
                }
        ]
    }
}
```

#### 登録

ファイルをアップロードします。

```bash
POST http://your-project.com/file/lib
```

##### 登録サンプル

```json:Response
{
    "status":{
        "result":true,
        "code":201,
    },
    "payloads": [
        {
            "fileId": "uuid",
            "name": "file name",
            "url": "http://your-project.com/file/lib/uuid",
            "mime_type": "application/json",
            "created_at": "2024-01-01T00:00:00Z",
            "updated_at": "2024-01-01T00:00:00Z"
        }
    ]
}
```

#### 詳細

特定のファイルライブラリの詳細を取得します。

```bash
GET http://your-project.com/file/lib/{fileId}
```

#### 更新

特定のファイルライブラリの登録情報を変更します。

```bash
PUT http://your-project.com/file/lib/{fileId}
```

#### 削除

特定のファイルライブラリを削除します。

```bash
DELETE http://your-project.com/file/lib/{fileId}
```

## 貢献

貢献は歓迎します！以下の方法で参加できます。

Issue: バグの報告や新機能の提案などに使用してください。
Pull Requests: バグの修正や新機能の追加等の貢献も歓迎します。

## ライセンス

[ライセンス](./LICENSE)を確認してください。
