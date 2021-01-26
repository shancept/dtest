<?php
/**
 * Created by PhpStorm.
 * User: Shancept
 * Date: 17.04.19
 * Time: 16:15
 */

namespace app\modules\api\models;


use app\components\Helper;
use yii\base\Model;

class FileUpload extends Model implements UploadInterface
{
	public $file;
	public $path_save;
	public $file_name_save;
	public $max_file_size;
	public $extension;

	public function init()
	{
		$this->max_file_size = 20 * 1024 * 1024;
	}

	/**
	 * @param $file
	 * @param $category
	 */
	public function setFile($file, $category)
	{
		$this->file = $file;
		$file_info = new \SplFileInfo($this->file['name']);
		$this->extension = $file_info->getExtension();
		$this->file_name_save = $category.'_'.Helper::randStr(6).'.'.$this->extension;
	}

	public function getFileName()
	{
		return $this->file_name_save;
	}

	public function validateFileName()
	{
		if (is_file($this->path_save.DIRECTORY_SEPARATOR.$this->file_name_save.'.'.$this->extension)) {
			$this->addError('file_name_save', 'Файл с именем '.$this->file_name_save.' уже существует');
		}
	}

	public function validateFile()
	{
		if ($this->file['size'] || $this->file['name']) {
			if (!in_array(strtolower($this->extension), ['png', 'jpg', 'jpeg', 'doc', 'pdf', 'docx'])) {
				$this->addError('file', 'Допустимые расширения файла: png, jpg, doc, pdf');
			}
			if ($this->file['size'] > $this->max_file_size) {
				$this->addError('file', 'Размер файла превышает допустимый');
			}
		} else {
			$this->addError('file', 'Ошибка обработки файла');
		}
	}

	public function uploadFile()
	{
		if ($this->validate()) {
			if (!file_exists($this->path_save) && !mkdir($concurrentDirectory = $this->path_save) && !is_dir($concurrentDirectory)) {
				throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
			}
			return (bool)move_uploaded_file($this->file['tmp_name'], $this->path_save.DIRECTORY_SEPARATOR.$this->file_name_save);
		}
		return false;
	}

	public function rules()
	{
		return [
			[['path_save', 'file'], 'required'],
			['max_file_size', 'integer'],
			['file', 'validateFile'],
			['file_name_save', 'validateFileName']
		];
	}

}