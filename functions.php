<?php
function str_startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}
function str_endsWith($haystack, $needle)
{
    $length = strlen($needle);
    $start  = $length * -1; //negative
    return (substr($haystack, $start) === $needle);
}
$_map = NULL;
function getMap()
{
	if (!$_map) {
		$string = file_get_contents("map.json");
		$_map = json_decode($string, true);
	}
	return $_map;
}

function getModules()
{
	return array_keys(getMap());
}
function getUnits($q)
{
	$arr = getMap();
	return array_keys($arr[$q[0]]);
}
function getChapters($q) 
{
	$arr = getMap();
	return array_keys($arr[$q[0]][$q[1]]);
}
function getExercises($q)
{
	$arr = getMap();
	return array_keys($arr[$q[0]][$q[1]][$q[2]]);
}
function getQuestions($q)
{
	$arr = getMap();
	$questions = $arr[$q[0]][$q[1]][$q[2]][$q[3]];
	if (sizeof($questions) == 1) {
		$questions = array_map("strval",range(1, $questions[0]));
	}
	return $questions;
}

function getChapterName($q)
{
    $module = $q[0];
    $unit = $q[1];
    $chapter = $q[2];
	$moduleLC = strtolower($module);
	
	$chrev = "_ch";
	if (str_startsWith($chapter,"_mex")) {
		$chrev = "";
	}
	
	if (str_startsWith($chapter, "Review ")) {
		$chrev = "_rev";
		$chapter = str_replace("Review ", "", $chapter);
	}
	$xml = @simplexml_load_file("./$module/$unit/$moduleLC$unit$chrev$chapter.xml");
	if (!$xml) {
		ob_clean();
		readfile("http://jonathanb.co.uk/404.html");
		exit();
/* 		Header("Location: /404.html"); */
	}
	
	$title = $xml->Subject->Level->ExamBoard->ProductTitle->SubjectArea->Unit->Section->Chapter->attributes()->title;
	return $title;
}
function getSolution($q)
{
    $module = $q[0];
    $unit = $q[1];
    $chapter = $q[2];
    $exerciseReq = $q[3];
    $questionReq = $q[4];
	$moduleLC = strtolower($module);
	
	$chrev = "_ch";
	if (str_startsWith($chapter,"_mex")) {
		$chrev = "";
	}
	
	if (str_startsWith($chapter, "Review ")) {
		$chrev = "_rev";
		$chapter = str_replace("Review ", "", $chapter);
	}
	$xml = @simplexml_load_file("./$module/$unit/$moduleLC$unit$chrev$chapter.xml");
	if (!$xml) {
		ob_clean();
		readfile("http://jonathanb.co.uk/404.html");
		exit();
/* 		Header("Location: /404.html"); */
	}
	
	$exercises = $xml->Subject->Level->ExamBoard->ProductTitle->SubjectArea->Unit->Section->Chapter->Exercise;
	$disc = $xml->xpath("//Exercise[@letter='$exerciseReq']//QuestionData[@number=$questionReq]");
	
	$xmlout = $disc[0]->asXML();
	$question = $disc[0]->Question->asXML();
	$solution = $disc[0]->Solution->asXML();
	
	return array('question' => $question, 'solution' => $solution);
}
function populateSelect($listitems, $selection) {
	foreach ($listitems as $item) {
		$ss = "";
		if ($item == $selection) {
			$ss = " selected='selected'";
		}
		echo "<option".$ss.">".$item."</option>";
	}
}

?>