<?php
namespace Compras\Controllers;
use Compras\Models\Image;
use Symfony\Component\HttpFoundation\JsonResponse;

class ImageController
{
	public function getImage($id)
	{
		$image = Image::find($id);
		$response = new JsonResponse();
		if ($image) {
			$response->setContent(json_encode($image));
		} else {
			$response->setContent(json_encode(array("error" => "No image found with id $id.")));
			$response->setStatusCode(404);
		}
		return $response->send();
	}
}