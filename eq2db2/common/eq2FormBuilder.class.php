<?php
if (!defined('IN_EDITOR'))
	die();


class eq2FormBuilder
{
	private $OpenContainer = '<div id="%s">';
	private $CloseContainer = '</div>';
	public $FormBody;
	
	public function __construct()
	{
		
	}
	
	public function NewContainer($css)
	{
		printf($this->OpenContainer, $css);
		print($this->CloseContainer);
	}
	
	public function NewTable($prop)
	{
		printf('<div id="Table" class="%s">Hi</div>', $prop['div']);
	}
	
}

?>