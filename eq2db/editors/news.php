<?php
// News & Updates that show up on the Index page 

showNews();

function showNews()
{
	global $eq2, $date_last;
	$query = "SELECT * FROM `eq2news_items` WHERE (is_active = 1 OR is_sticky = 1) ORDER BY created_date DESC";
	$data = $eq2->RunQueryMulti($query);

	$firstpass = true;
	$strHTML = "<table width='90%'>\n";
	$strHTML .= "  <tr>\n";
	$strHTML .= "    <td>\n";
	$strHTML .= "      News\n";
	foreach($data as $news)
	{
		if($date_last!=$news['created_date'])
		{
			if(!$firstpass)
			{
				$strHTML .= "      </fieldset>\n";
			}
			$firstpass=false;
			$strHTML .= "      <br>\n";
			$strHTML .= "      <fieldset width='90%'>\n";
			$strHTML .= "        <legend>" . $news['created_date'] . "</legend>\n";
		}
		$strHTML .= "          <table width='100%' border='0' cellpadding='0'>\n";
		$strHTML .= "            <tr>\n";
		$imgsrc = "../images/news_";
		if($news['type']==4)	{
			$imgsrc .= "content_";
		}elseif($news['subtype']==5){
			$imgsrc .= "code_";
		}elseif($news['subtype']==6){
			$imgsrc .= "editor_";
		}
		$imgsrc .= $news['badge'] . ".png";

		$strHTML .= "              <td align='left' width='50px' valign='top'><img src='" . $imgsrc . "'></td>\n";
		$strHTML .= "              <td align='left' width='*' bgcolor='#e0e0e0'>\n";
		$strHTML .= "                <h2>" . $news['title'] . "</h2>\n";
		$strHTML .= "                " . $news['description'] . "\n";
		$strHTML .= "                <hr>\n";
		$strHTML .= "                <b>" . $eq2->GetUserNameByID($news['author']) . "</b> [<i>" . $eq2->GetNewsTypeNameByID($news['type']) . "(" . $eq2->GetNewsSubTypeNameByID($news['subtype']) . ")</i>]\n";
		$strHTML .= "              </td>\n";
		$strHTML .= "            </tr>\n";
		$strHTML .= "          </table>\n";
		$date_last = $news['created_date'];
	}
	$strHTML .= "    </td>\n";
	$strHTML .= "  </tr>\n";
	$strHTML .= "</table>\n";
	print($strHTML);
}
?>