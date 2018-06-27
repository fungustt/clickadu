<?php
namespace Catalog;

use Catalog\Validator\CSVValidator;
use Catalog\Validator\ValidatorInterface;
use File\FileInterface;
use Exception;

class FileLister
{
    /**
     * @var ValidatorInterface[]
     */
    private $validators;

    /**
     * @var FilePathsExtractorInterface
     */
    private $filePathExtractor;

    /**
     * @var string
     */
    private $appDir;

    /**
     * FileLister constructor.
     *
     * @param string $appDir
     */
    public function __construct(string $appDir)
    {
        $this->filePathExtractor = new FilePathsExtractor();

        $this->validators = [
            new CSVValidator()
        ];

        $this->appDir = $appDir;
    }

    /**
     * @param null|string $fileDir
     *
     * @return FileInterface[]
     *
     * @throws Exception
     */
    public function getFileListFromDir(?string $fileDir): array
    {
        if (!CatalogChecker::check($fileDir, $this->appDir)) {
            throw new Exception('Specified catalog not found or not exist. Please try again');
        }

        $dir = CatalogChecker::getFullPath($fileDir, $this->appDir);

        $result = [];
        $filePaths = $this->filePathExtractor->getFilePaths($dir);

        foreach ($filePaths as $filePath) {
            $file = $this->getFile($filePath);
            if (null !== $file) {
                $result []= $file;
            }
        }

        return $result;
    }

    private function getFile(string $filePath): ?FileInterface
    {
        foreach ($this->validators as $validator) {
            if ($validator::validate($filePath)) {
                return $validator::getFile($filePath);
            }
        }

        return null;
    }
}