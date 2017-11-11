<?php 

/*
 Return title and date from a news from Metalinjection website
*/

libxml_use_internal_errors(true); // Disable DOMDocument warnings

class MetalinjectionParser {

	function __construct($url) {
		$this->url = $url;
		$this->contents = file_get_contents($url);
		$this->doc = new DOMDocument();
		$this->doc->loadHTML($this->contents);
	}

	function my_substr_function($str, $start, $end) // https://stackoverflow.com/questions/7033167/how-to-extract-substring-by-start-index-and-end-index
	{
 		return mb_substr($str, $start, $end - $start);
	}

	function getDate() {
		$monthsArray = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		// Ps, like plural of p
		$ps = $this->doc->getElementsByTagName('p');

		foreach($ps as $p) {
			foreach ($monthsArray as $month) {
				if (strpos($p->textContent, $month) !== false) {
					// Example string: Posted by Robert Pasbani on November 10, 2017 at 7:35 pm Follow on Twitter | Follow on Instagram

					// This is where November starts
					$monthStartPosition = strpos($p->textContent, $month); 
					// This is where the first 'Follow' starts, we assume string 'Follow' is in every post
					$followPosition = strpos($p->textContent, "Follow");
					// This is where the year ends
					$yearEndPosition = $followPosition - 12;

					$date = $this->my_substr_function($p->textContent, $monthStartPosition, $yearEndPosition);

					return $date;
				}
			}
		}
	}

	function getTitle() {
		return $this->doc->getElementsByTagName('title')[0]->textContent;
	}
}


if(!isset($_GET["url"]) && empty($_GET["url"])) {
	print_r("Give a metalsucks news url as GET param (url).");
}
else {

	$metalinjectionParser = new metalinjectionParser($_GET["url"]);

	$result = [
		"title" => $metalinjectionParser->getTitle(),
		"date" => $metalinjectionParser->getDate()
	];

	print_r(json_encode($result));
}

?>
