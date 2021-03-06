## Backblaze B2 for PHP

`backblaze-b2` is a client library for working with Backblaze's B2 storage service.
[![Latest Version on Packagist](https://img.shields.io/packagist/v/gliterd/backblaze-b2.svg?style=flat-square)](https://packagist.org/packages/gliterd/backblaze-b2)
[![Software License][ico-license]](LICENSE.md)
[![Build Status](https://img.shields.io/travis/gliterd/backblaze-b2/master.svg?style=flat-square)](https://travis-ci.org/gliterd/backblaze-b2)
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads](https://img.shields.io/packagist/dt/gliterd/backblaze-b2.svg?style=flat-square)](https://packagist.org/packages/gliterd/backblaze-b2)


## Install

Via Composer

``` bash
$ composer require gliterd/backblaze-b2
```

## Usage

``` php
use BackblazeB2\Client;
use BackblazeB2\Bucket;

$client = new Client('accountId', 'applicationKey');
```
#### Returns a bucket details
``` php
$bucket = $client->createBucket([
    'BucketName' => 'my-special-bucket',
    'BucketType' => Bucket::TYPE_PRIVATE // or TYPE_PUBLIC
]);
```

#### Change the bucket Type
``` php
$updatedBucket = $client->updateBucket([
    'BucketId' => $bucket->getId(),
    'BucketType' => Bucket::TYPE_PUBLIC
]);
```

#### List all buckets
``` php
$buckets = $client->listBuckets();
```
#### Delete a bucket
``` php
$client->deleteBucket([
    'BucketId' => 'YOUR_BUCKET_ID'
]);
```

#### File Upload
``` php
$file = $client->upload([
    'BucketName' => 'my-special-bucket',
    'FileName' => 'path/to/upload/to',
    'Body' => 'I am the file content'

    // The file content can also be provided via a resource.
    // 'Body' => fopen('/path/to/input', 'r')
]);
```

#### File Download
``` php
$fileContent = $client->download([
    'FileId' => $file->getId()

    // Can also identify the file via bucket and path:
    // 'BucketName' => 'my-special-bucket',
    // 'FileName' => 'path/to/file'

    // Can also save directly to a location on disk. This will cause download() to not return file content.
    // 'SaveAs' => '/path/to/save/location'
]);
```

#### File Delete
``` php
$fileDelete = $client->deleteFile([
    'FileId' => $file->getId()

    // Can also identify the file via bucket and path:
    // 'BucketName' => 'my-special-bucket',
    // 'FileName' => 'path/to/file'
]);
```

#### List all files
``` php
$fileList = $client->listFiles([
    'BucketId' => 'YOUR_BUCKET_ID'
]);
```


## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

```bash
$ vendor/bin/phpunit
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email mhetreramesh@gmail.com instead of using the issue tracker.

## Credits

- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/gliterd/backblaze-b2.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/gliterd/backblaze-b2/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/gliterd/backblaze-b2.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/gliterd/backblaze-b2.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/gliterd/backblaze-b2.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/gliterd/backblaze-b2
[link-travis]: https://travis-ci.org/gliterd/backblaze-b2
[link-scrutinizer]: https://scrutinizer-ci.com/g/gliterd/backblaze-b2/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/gliterd/backblaze-b2
[link-downloads]: https://packagist.org/packages/gliterd/backblaze-b2
[link-author]: https://github.com/gliterd
[link-contributors]: ../../contributors