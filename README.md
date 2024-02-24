# Laravel File Library

This is a file management library for Laravel.

## How to use

### Install

```bash
composer require ikepu-tp/larave-file-library
```

### Publish configuration etc

```bash
php artisan vendor:publish --provider="ikepu_tp\FileLibrary\FileLibraryServiceProvider"
```

### Routing

| HTTP Method | URI                     | Action  | Route Name           | Description                                  |
| ----------- | ----------------------- | ------- | -------------------- | -------------------------------------------- |
| GET         | /file/lib               | index   | file-library.index   | Display a list of files in the file library. |
| GET         | /file/lib/create        | create  | file-library.create  | Display a form for uploading a new file.     |
| POST        | /file/lib               | store   | file-library.store   | Upload a file.                               |
| GET         | /file/lib/{fileId}      | show    | file-library.show    | Display details of a specific file.          |
| GET         | /file/lib/{fileId}/edit | edit    | file-library.edit    | Display a form for editing a specific file.  |
| PUT         | /file/lib/{fileId}      | update  | file-library.update  | Update a specific file.                      |
| DELETE      | /file/lib/{fileId}      | destroy | file-library.destroy | Delete a specific file.                      |

> [!NOTE]
> `{fileId}` means uuid.

#### Upload File

```bash
POST http://your-project.com/file/lib
```

| Key   | Type               | Accepted Values | Required |
| ----- | ------------------ | --------------- | -------- |
| files | Array<int, File>   |                 | Y        |
| names | Array<int, string> | max length: 250 | Y        |

#### Edit File

```bash
PUT http://your-project.com/file/lib/{fileId}
```

| Key  | Type   | Accepted Values | Required |
| ---- | ------ | --------------- | -------- |
| name | string | max length: 250 | Y        |

## Contributing

We welcome contributions to the project! You can get involved through the following ways:

Issue: Use for bug reports, feature suggestions, and more.

Pull Requests: We encourage code contributions for new features and bug fixes.

## License

See [LICENSE](./LICENSE).
