<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

final class ThemeSampleImageUploader
{
    private const MAX_BYTES = 5_242_880;

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
        $base = $nameHint ? (string) $this->slugger->slug($nameHint)->lower() : 'theme-sample';
        $safeName = sprintf('%s-%s.%s', $base, uniqid('', true), $extension);
        $file->move($this->targetDirectory, $safeName);

        return 'uploads/theme-samples/'.$safeName;
    }

    public function delete(?string $relativePath): void
    {
        if (!$relativePath) {
            return;
        }

        $relativePath = ltrim(str_replace('\\', '/', $relativePath), '/');
        $fullPath = $this->targetDirectory.'/'.basename($relativePath);
        if ($this->filesystem->exists($fullPath)) {
            $this->filesystem->remove($fullPath);
        }
    }

    public function deleteMany(array $relativePaths): void
    {
        foreach ($relativePaths as $path) {
            if (is_string($path)) {
                $this->delete($path);
            }
        }
    }
}
