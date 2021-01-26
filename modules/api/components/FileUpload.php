<?php

namespace app\modules\api\components;


use app\modules\api\models\ImageUpload;
use app\modules\api\models\UploadInterface;
use yii\base\Component;

class FileUpload extends Component
{
	private $file = false;
	/**
	 * @var UploadInterface
	 */
	private $file_model = false;
	private $category = 'image';
	private $max_file_size = 3 * 1024 * 1024;
	private $path_save;
	private $web_path;
	private $type = false;

	public function init()
	{
		if ($_FILES) {
			$keys_files = array_keys($_FILES);
			$param = array_shift($keys_files);
			$this->file = $_FILES[$param];
		}
		$this->path_save = \Yii::$app->basePath.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'files';
		$this->web_path = DIRECTORY_SEPARATOR.'files';
	}

	public function setFile($file, $category = false)
	{
		$this->file = $file;
		if ($category) {
			$this->category = $category;
		}
	}

	public function setType($type)
	{
		$this->type = $type;
	}

	public function setImageModel(UploadInterface $file_model)
	{
		$this->file_model = $file_model;
	}

	public function setCategory($category)
	{
		$this->category = $category;
	}

	public function upload()
	{
		if ($this->type !== false) {
			$this->max_file_size = \Yii::$app->params[$this->type]['maxFileSize'];
			$this->path_save = \Yii::$app->params[$this->type]['localPath'];
			$this->web_path = \Yii::$app->params[$this->type]['webPath'];
		}
		if ($this->file !== false) {
			if (!$this->file_model) {
				$this->file_model = new \app\modules\api\models\FileUpload();
			}
			$this->file_model = $this->uploadFile($this->file_model);
		}
	}

	private function uploadFile(UploadInterface $file_model)
	{
		$file_model->setFile($this->file, $this->category);
		$file_model->path_save = $this->path_save;
		if (!isset($file_model->max_file_size)) {
			$file_model->max_file_size = $this->max_file_size;
		}
		$file_model->uploadFile();
		return $file_model;
	}

	public function getWebPathFile(): string
	{
		return $this->file_model !== false ? $this->web_path.DIRECTORY_SEPARATOR.$this->file_model->getFileName() : '';
	}

	public function getImageModel()
	{
		return $this->file_model;
	}

	public function issetFile(): bool
	{
		return (bool)$this->file;
	}

}