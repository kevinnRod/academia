<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use League\Flysystem\AzureBlobStorage\AzureBlobStorageAdapter;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;

class AzureFilesystemServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Storage::extend('azure', function ($app, $config) {
            $client = BlobRestProxy::createBlobService(
                "DefaultEndpointsProtocol=https;AccountName={$config['name']};AccountKey={$config['key']};EndpointSuffix=core.windows.net"
            );

            $adapter = new AzureBlobStorageAdapter(
                $client,
                $config['container']
            );

            return new FilesystemAdapter(
                new Filesystem($adapter),
                $adapter,
                $config
            );
        });
    }
}
