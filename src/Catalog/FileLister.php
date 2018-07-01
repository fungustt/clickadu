<?php
namespace Catalog;

use Catalog\Validator\ValidatorInterface;
use Exception;

class FileLister implements FileListerInterface
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
     * FileLister constructor.
     *
     * @param FilePathsExtractorInterface $filePathExtractor
     * @param ValidatorInterface[] ...$validators
     */
    public function __construct(
        FilePathsExtractorInterface $filePathExtractor,
        ValidatorInterface ...$validators
    ) {
        $this->filePathExtractor = $filePathExtractor;
        $this->validators = $validators;
    }

    /**
     * @param null|string $fileDir
     *
     * @return \Generator
     *
     * @throws Exception
     */
    public function getFileList(string $fileDir): \Generator
    {
        return $this->getFilesGenerator($this->filePathExtractor->getFilePaths($fileDir));
    }

    private function getFilesGenerator(\Generator $filePaths)
    {
        foreach($filePaths as $filePath) {
            foreach ($this->validators as $validator) {
                if ($validator->validate($filePath)) {
                    yield $validator->getFile($filePath);
                }
            }
        }
    }
}