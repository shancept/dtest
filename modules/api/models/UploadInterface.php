<?php
/**
 * Created by PhpStorm.
 * User: Shancept
 * Date: 18.04.19
 * Time: 15:34
 */

namespace app\modules\api\models;


interface UploadInterface
{
	public function setFile($file, $category);

	public function uploadFile();

	public function getErrors();

	public function getFileName();
}