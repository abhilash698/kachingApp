<?php
namespace App\Http\Controllers;

use App\Cities;
use App\Countries;
use App\States;
use App\AppElement;
 

class ElementService extends Controller {
	
	 public function getCities(){
	 	return response()->json(['response_code' => 'RES_CTY' , 'messages' => 'Cities' , 'data' => Cities::get()]);
	 }

	 public function getStates(){
	 	return response()->json(['response_code' => 'RES_STS' , 'messages' => 'States' , 'data' => States::get()]);
	 }

	 public function getCountries(){
	 	return response()->json(['response_code' => 'RES_CTS' , 'messages' => 'Countries' , 'data' => Countries::get()]);
	 }

	 public function appElements(){
	 	$AppElement = AppElement::find(1);
	 	return response()->json(['response_code' => 'RES_SE' , 'messages' => 'App Elemets','data' => $AppElement ]);
	 }
}