<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

final class ServicePackageImageUploader
{
    private const MAX_BYTES = 5_242_880; // 5 MB

    private const ALLOWED_MIME = [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/gif',
    ];

    public function __construct(
        private readonly string $targetDirectory,
        private readonly SluggerInterface $slugger,
        private readonly Filesystem $filesystem = new Filesystem(),
    ) {
    }

    public function upload(UploadedFile $file, ?string $nameHint = null): string
    {
        if ($file->getSize() > self::MAX_BYTES) {
            throw new FileException('Image must be 5 MB or smaller.');
        }

        $mime = $file->getMimeType();
        if (!in_array($mime, self::ALLOWED_MIME, true)) {
            throw new FileException('Please upload a JPG, PNG, WebP, or GIF image.');
        }

        $this->filesystem->mkdir($this->targetDirectory);

        $extension = $file->guessExtension() ?: 'jpg';
        $base = $nameHint ? (string) $this->slugger->slug($nameHint)->lower() : 'service-package';
        $safeName = sprintf('%s-%s.%s', $base, uniqid('', true), $extension);
        $file->move($this->targetDirectory, $safeName);

        return 'uploads/service-packages/'.$safeName;
    }

    public function delete(?string $relativePath): void
    {
        if (!$relativePath) {
            return;
        }

        $fullPath = $this->resolveAbsolutePath($relativePath);
        if ($this->filesystem->exists($fullPath)) {
            $this->filesystem->remove($fullPath);
        }
    }

    private function resolveAbsolutePath(string $relativePath): string
    {
        $relativePath = ltrim(str_replace('\\', '/', $relativePath), '/');
        if (str_starts_with($relativePath, 'uploads/service-packages/')) {
            return $this->targetDirectory.'/'.basename($relativePath);
        }

        return $this->targetDirectory.'/'.basename($relativePath);
    }
}
