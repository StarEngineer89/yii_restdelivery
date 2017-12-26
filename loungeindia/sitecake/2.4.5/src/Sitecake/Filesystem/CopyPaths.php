<?php
namespace Sitecake\Filesystem;

use League\Flysystem\Plugin\AbstractPlugin;

/**
 * Class CopyPaths
 *
 * @method void copyPaths(array $paths, string $source, string $destination, callable|null $callback)
 *
 * @package Sitecake\Filesystem
 */
class CopyPaths extends AbstractPlugin
{
    public function getMethod()
    {
        return 'copyPaths';
    }

    /**
     * Copies the given list of file paths, relative to the
     * given source path, to the given destination path.
     *
     * @param  array $paths a list of paths to be copied.
     * @param  string $source the source path
     * @param  string $destination the destination path
     * @param  callable|null $callback Optional. If passed should decide weather file should be copied
     *
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function handle($paths, $source, $destination, $callback = null)
    {
        foreach ($paths as $path) {
            $metadata = $this->filesystem->getMetadata($path);

            if ($metadata['type'] == 'file' && (!$callback || $callback($path))) {
                $destinationFile = substr($path, strlen($source));
                $newPath = $destination . '/' .
                           (strpos($destinationFile, '/') === 0 ? substr($destinationFile, 1) : $destinationFile);
                if (!$this->filesystem->has($newPath)) {
                    $this->filesystem->copy($path, $newPath);
                } else {
                    $this->filesystem->update($newPath, $this->filesystem->read($path));
                }
            }
        }
    }
}
