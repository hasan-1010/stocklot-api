<?php

namespace common\components;

use Yii;
use DateTime;
use Exception;
use SendGrid;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Util
 *
 * @author thanhlbk
 */

class Util {

	public static function getUrlImage( $image ) {
		return Yii::$app->request->baseUrl . "/uploads/" . $image;
	}

	public static function uploadFile( $file, $fileName ) {
		try {
			if ( $file ) {
				$uploadPath = Yii::getAlias( '@uploadPath' );
				$file->saveAs( $uploadPath . '/' . $fileName);

				return true;
			}

			return false;	
		} catch(Exception $e) {
			return false;
		}
	}	

	public static function deleteFile( $fileName ) {
		$uploadPath = Yii::getAlias( '@uploadPath' );
		@unlink( Yii::getAlias( $uploadPath . '/' . $fileName ) );
	}

	public static function trimText( $text ) {
		$result = strtolower( str_replace( ' ', '', $text ) );
		return $result;
	}

	public static function formatDateTime( $format, $date ) {
		return date($format, $date);
	}

	public static function randomImageUrl( $extension ) {
		return Yii::$app->security->generateRandomString() . '.' . $extension;
	}

	public static function randomUsername() {
		return Yii::$app->security->generateRandomString();
	}

	public static function sendMail($from, $to, $subject, $content) {
		$email = new SendGrid\Mail\Mail();
		$apiKey = Yii::$app->params['sendGridKey'];
		$email->setFrom($from);
		$email->setSubject($subject);
		$email->addTo($to);
		$email->addContent(
			"text/html", $content
		);
		$sendGrid = new SendGrid($apiKey);
		try {
		    $sendGrid->send($email);
			return true;
		} catch (Exception $e) {
			return false;
		}
	}

	public static function validateDateFormat($date) {
		$matches = array();
		$pattern = '/^([0-9]{1,2})\\/([0-9]{1,2})\\/([0-9]{4})$/';
		if (!preg_match($pattern, $date, $matches)) return false;
		if (!checkdate($matches[2], $matches[1], $matches[3])) return false;
		return true;
	}

	public static function getColorList(){
		$colors = [
			'black' => 'Black',
			'red' => 'Red',
			'green' => 'Green', 
			'Blue' => 'Yellow',
			'Orange' => 'Orange'
		];
		return $colors;
	}
	public static function getFabricList(){
		$fabrics = [
			'black' => 'Black',
			'red' => 'Red',
			'green' => 'Green', 
			'Blue' => 'Yellow',
			'Orange' => 'Orange'
		];
		return $fabrics;
	}
	public static function getBrandList(){
		$brands = [
			'black' => 'Black',
			'red' => 'Red',
			'green' => 'Green', 
			'Blue' => 'Yellow',
			'Orange' => 'Orange'
		];
		return $brands;
	}
	public static function getQualityList(){
		$qualities = [
			'black' => 'Black',
			'red' => 'Red',
			'green' => 'Green', 
			'Blue' => 'Yellow',
			'Orange' => 'Orange'
		];
		return $qualities;
	}

}
