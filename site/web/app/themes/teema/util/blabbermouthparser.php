<?php

libxml_use_internal_errors(true); // Disable DOMDocument warnings

class BlabbermouthParser {

	function __construct($url) {
		$this->url = $url;
		$this->contents = file_get_contents($url);
		$this->doc = new DOMDocument();
		$this->doc->loadHTML($this->contents);
	}

	function getDateFromSpan() {
		$span = $this->doc->getElementsByTagName('span');
		// Quick and dirty; this should be done using xpath maby
		$monthsArray = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		foreach ($span as $v) {
			foreach($monthsArray as $month) {
				if (strpos($v->textContent, $month) !== false) {
					return $v->textContent;
				}
			}
		}
	}

	function getTitle() {
		return $this->doc->getElementsByTagName('title')[0]->textContent;
	}
}


if(!isset($_GET["url"]) && empty($_GET["url"])) {
	print_r("Give a blabbermouth news url as GET param (url).");
}
else {

	$blabbermouthParser = new BlabbermouthParser($_GET["url"]);

	$result = [
		"title" => $blabbermouthParser->getTitle(),
		"date" => $blabbermouthParser->getDateFromSpan()
	];

	print_r(json_encode($result));
}




?>