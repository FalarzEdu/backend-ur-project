<?php

namespace App\Models;

use Core\Constants\Constants;
use Core\Database\ActiveRecord\BelongsTo;
use Core\Database\ActiveRecord\Model;
use Exception;
use Lib\Validations;

/**
 */
class Image extends Model
{
    protected static string $table = 'feedback_images';
    protected static array $columns = [
        'feedback_id',
        'path'
    ];

    public function __construct(array $params)
    {
        parent::__construct(params: $params);
    }

    public function validates(): void
    {
        Validations::notEmpty(attribute: 'path', obj: $this);
    }

    public function addImage(
        string $imageTmpName,
        string $imageName,
        string $saveFolder
    ): void {
        try {
            if (!empty($imageName)) {
                $newFileName =
                    $this->generateHashName(
                        imageTmpName: $imageTmpName
                    ) . $this->getFileExtension(fileName: $imageName);

                move_uploaded_file(
                    from: $imageTmpName,
                    to: $this->getStoreDir(saveFolder: $saveFolder) . $newFileName
                );

                $this->__set(
                    property: 'path',
                    value: "$saveFolder/$newFileName"
                );
                if (!$this->save()) {
                    throw new Exception(
                        message: 'Erro ao processar imagem de nome:' . $imageTmpName
                    );
                };
            }
        } catch (Exception $e) {
            error_log(
                message: 'Erro ao processar imagem de feedback: ' . $e->getMessage()
            );
        }
    }

    public function deleteImage(int $idFeedback): void
    {
        $images = Image::where(conditions: ['feedback_id' => $idFeedback]);
        foreach ($images as $img) {
            $img->destroy();
        }
    }

    protected function getStoreDir(string $saveFolder): string
    {
        $path = Constants::rootPath()->join(
            path: "public/assets/uploads/$saveFolder/"
        );
        if (!is_dir(filename: $path)) {
            mkdir(directory: $path, recursive: true);
        }

        return $path;
    }

    protected function getFileExtension(string $fileName): string
    {
        $splittedFile = explode(separator: '.', string: $fileName);
        return ".$splittedFile[1]";
    }

    protected function generateHashName(string $imageTmpName): string
    {
        return hash_file(
            algo: 'sha256',
            filename: $imageTmpName
        );
    }
}
