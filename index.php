<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <title>Solutions</title>
        <script>
            var map = <? include("map.json");?>;
        </script>
        <link type="text/css" rel="stylesheet" href="style.css" />
        <script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
        <script type="text/javascript" src="json2.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" ></script>
        <script type="text/javascript" src="functionsScript.js"></script>
        <script type="text/javascript" src="script.js"></script>
    </head>
    <body>
        <?  require_once("functions.php");
            $tokens = $_GET['q'];
            $sections = explode('_',$tokens);
            foreach ($sections as &$value) {
	            $upperValue = strtoupper($value);
                if (str_startsWith($upperValue,"REVIEW")) {
		            $upperValue = $value;
                }
                $value = urldecode($upperValue);
            }
            unset($value);
            if (sizeof($sections) != 5) { 
                $sections = array("C", "1", "1", "A", "1");
            }
            $arr = getSolution($sections);
        ?>
    	<div class="bar" id="header">
    		<table>
    			<tr>
    				<td>Module</td>
    				<td>Chapter</td>
    				<td>Exercise</td>
    				<td>Question</td>
    				<td id="goButton" rowspan="3">Go</td>
    			</tr>
    			<tr>
    			    <td>
    				<select id="moduleSelect">
    				    <? populateSelect(getModules(), $sections[0]);?>
    				</select>
    				<select id="unitSelect">
    				    <? populateSelect(getUnits($sections), $sections[1]);?>
    				</select>
    				</td>
    				<td>
    					<select id="chapterSelect">
    						<?populateSelect(getChapters($sections), $sections[2]);?>
    					</select>
    				</td>
    				<td>
    					<select id="exerciseSelect">
    						<? populateSelect(getExercises($sections), $sections[3]); ?>
    					</select>
    				</td>
    				<td>
    					<select id="questionSelect">
    						<? populateSelect(getQuestions($sections), $sections[4]); ?>
    					</select>
    				</td>
    			</tr>
    			<tr>
    		 		<td id="previous" colspan="2">Previous</td>
    				<td id="next" colspan="2">Next</td>
    			</tr>
    		</table>
    		<div id="messages">
    			<div id="title">
    				<span ><? echo getChapterName($sections); ?></span>
    			</div>
    			<div id="menu">
				    <div class="gray-triangle-up-right"></div>
    				<span>Code by <a href="http://jonathanb.co.uk">Jonathan Bailey</a>. <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=Q8C8EFAG6F3CQ&lc=GB&item_name=jonathanb%20cds&currency_code=GBP&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHostedGuest">Donate</a></span>
			</div>
            </div>
    	</div>
        <div id="content" >
	        <h1>Question</h1>
	        <div id="question">
		        <? if (sizeof($sections) == 5) { echo $arr["question"]; }?>
	        </div>
    	    <h1>Solution <button id="toggleSolution" type="button">Hide</button></h1>
    	    <div id="solution">
    		    <? if (sizeof($sections) == 5) { echo $arr["solution"]; }?>
    	    </div>
        </div>
    </body>
</html>
		