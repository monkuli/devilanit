<?php 

/*
 Return title and date from a news from Metalsucks website
*/

libxml_use_internal_errors(true); // Disable DOMDocument warnings

class MetalsucksParser {

	function __construct($url) {
		$this->url = $url;
		$this->contents = file_get_contents($url);
		$this->doc = new DOMDocument();
		$this->doc->loadHTML($this->contents);
	}

	function getDate() {
		return $this->doc->getElementsByTagName('time')[0]->nodeValue;
	}

	function getTitle() {
		return $this->doc->getElementsByTagName('title')[0]->textContent;
	}
}


if(!isset($_GET["url"]) && empty($_GET["url"])) {
	print_r("Give a metalsucks news url as GET param (url).");
}
else {

	$metalsucksParser = new metalsucksParser($_GET["url"]);

	$result = [
		"title" => $metalsucksParser->getTitle(),
		"date" => $metalsucksParser->getDate()
	];

	print_r(json_encode($result));
}

?>
