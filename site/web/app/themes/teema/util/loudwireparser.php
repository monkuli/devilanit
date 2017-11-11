<?php
/*
 Return title and date from a news from Blabbermouth website
*/

libxml_use_internal_errors(true); // Disable DOMDocument warnings

class LoudwireParser {

	function __construct($url) {
		$this->url = $url;
		$this->contents = file_get_contents($url);
		$this->doc = new DOMDocument();
		$this->doc->loadHTML($this->contents);
	}

	function getDateFromSpan() {
		return $this->doc->getElementsByTagName('time')[0]->nodeValue;
	}

	function getTitle() {
		return $this->doc->getElementsByTagName('title')[0]->textContent;
	}
}


if(!isset($_GET["url"]) && empty($_GET["url"])) {
	print_r("Give a blabbermouth news url as GET param (url).");
}
else {

	$loudwireParser = new LoudwireParser($_GET["url"]);

	$result = [
		"title" => $loudwireParser->getTitle(),
		"date" => $loudwireParser->getDateFromSpan()
	];

	print_r(json_encode($result));
}




?>