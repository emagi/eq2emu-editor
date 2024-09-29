<?php

class eq2Characters
{

	private $NavigationSections = array(
		"Summary"=>array(
			"Overview"=>"character_overview"
		),
		"Data"=>array(
			"Character"=>"characters",
			"Details"=>"character_details",
			"Colors"=>"char_colors",
			"Factions"=>"character_factions"
		),
		"Inventory"=>array(
			"Buy Back"=>"character_buyback",
			"House"=>"ni",
			//"House Access"=>"ni",
			//"House Deposit"=>"ni",
			//"House Spawn"=>"ni",
			"Items"=>"character_items"
		),
		"Knowledge"=>array(
			"Quests"=>"character_quests",
			"Quest Progress"=>"character_quest_progress",
			"Skill Bar"=>"character_skillbar",
			"Skills"=>"character_skills",
			"Spells"=>"character_spells",
			//"Achievements"=>"ni"
		),
		"Misc"=>array(
			//"Access"=>"ni",
			//"Friend List"=>"ni",
			//"Language"=>"ni",
			"Marcos"=>"character_macros",
			//"Pet"=>"ni",
			//"Timer"=>"ni",
			"Mail"=>"character_mail"
		)
	);

	function GetTabArray() {
        $ret = array(
            'char_1'=>'Equip', 
            'char_2'=>'Adorn',
            'char_3'=>'Effects',
            'char_4'=>'AAs',
            'char_5'=>'Wizard',
            'char_6'=>'High Elf',
            'char_7'=>'Spells',
            'char_8'=>'Ascent',
            'char_9'=>'Collect'
        );
        global $eq2;
        return $ret;
    }

	public function GenerateNavigationMenu() {
		$link = $_SERVER['SCRIPT_NAME'];
		$page = (isset($_GET['page'])?$_GET['page']:"");
		$id = (isset($_GET['id'])?$_GET['id']:"");

		$strReturn = "";
		$strReturn .= "<table class='SectionMenuLeft' cellspacing='0' border='0'>\n";
		foreach ($this->NavigationSections as $title=>$body)
		{
			$strReturn .= "  <tr>\n";
			$strReturn .= "    <td class='SectionTitle'>" . $title . "</td>\n";
			$strReturn .= "  </tr>\n";
			$strReturn .= "  <tr>\n";
			$strReturn .= "    <td class='SectionBody'>\n";
			foreach ($body as $name=>$page)
			{
				$strReturn .= "      <ul class='menu-list'>\n";
				$strReturn .= "        <li class='" . ($page == ""?"active-menu-list":"menu-list") . "'>\n";
				$strReturn .= "          &raquo;<a href='" . $link. "?page=" . $page . "&id=" . $id . "'>" . $name . "</a>\n";
				$strReturn .= "        </li>\n";
				$strReturn .= "      </ul>\n";
			}
			$strReturn .= "    </td>\n";
			$strReturn .= "  </tr>\n";
		}
		$strReturn .= "</table>\n";

		return($strReturn);
	}

	public function getAdventureClassNameByID($id)
	{
		global $eq2;
		$query = "SELECT emu_name AS name FROM `eq2meta_advClasses` WHERE emu_id = " . $id;
		$data = $eq2->RunQuerySingle($query);

		return($data['name']);
	}

	public function getSlotNameByNum($slot_num)
	{
		global $eq2;
		$query = "SELECT emu_name AS name FROM `eq2meta_slots` WHERE emu_id = ". $slot_num;
		$data = $eq2->RunQuerySingle($query);
		return($data['name']);
	}

	public function getItemNameBySlot($char_id, $slot_num)
	{
		global $eq2;
		$query = "SELECT ci.item_id as id, ";
		$query .= "       i.name as name ";
		$query .= "  FROM `" . ACTIVE_DB . "`.`character_items` AS ci ";
		$query .= "  JOIN `" . ACTIVE_DB . "`.`items` as i";
		$query .= "    ON ci.item_id = i.id ";
		$query .= " WHERE char_id = " . $char_id;
		$query .= " AND slot = " . $slot_num;
		$query .= " AND type = 'EQUIPPED'";
		$data = $eq2->RunQuerySingle($query);
		if (is_array($data))
		{
		 return($data['name']);
		}
	}

	public function getItemIDBySlot($char_id, $slot_num)
	{
		global $eq2;
		$query = "SELECT ci.item_id as id, ";
		$query .= "       i.name as name ";
		$query .= "  FROM `" . ACTIVE_DB . "`.`character_items` AS ci ";
		$query .= "  JOIN `" . ACTIVE_DB . "`.`items` as i";
		$query .= "    ON ci.item_id = i.id ";
		$query .= " WHERE char_id = " . $char_id;
		$query .= " AND slot = " . $slot_num;
		$query .= " AND type = 'EQUIPPED'";
		$data = $eq2->RunQuerySingle($query);
		if (is_array($data))
		{
		 return($data['id']);
		}
	}

	public function getItemIconBySlot($char_id, $slot_num,$side='')
	{
		global $eq2;
		$query = "SELECT ci.item_id as id, ";
		$query .= "       i.icon as icon, ";
		$query .= "       i.tier as tier ";
		$query .= "  FROM `" . ACTIVE_DB . "`.`character_items` AS ci ";
		$query .= "  JOIN `" . ACTIVE_DB . "`.`items` as i";
		$query .= "    ON ci.item_id = i.id ";
		$query .= " WHERE char_id = " . $char_id;
		$query .= " AND slot = " . $slot_num;
		$query .= " AND type = 'EQUIPPED'";
		$data = $eq2->RunQuerySingle($query);
		if(is_array($data))
		{
			$link = $eq2->GenerateItemHover($this->getItemIDBySlot($char_id, $slot_num),"eq2Icon.php?type=item&id=" . $data['icon'],$side);
		}else{
			$link = "<img width='42' height='42' src='eq2Icon.php?type=slots&id=" . $slot_num . "'>";
		}
		return ($link);
	}

	public function getTradeskillClassNameByID($id)
	{
		global $eq2;
		$query = "SELECT emu_name AS name FROM `eq2meta_tsClasses` WHERE emu_id = " . $id;
		$data = $eq2->RunQuerySingle($query);

		return($data['name']);
	}

	public function getHouseNameByID($id)
	{
		global $eq2;
		$query = "SELECT name FROM `" . ACTIVE_DB . "`.`houses` WHERE id =" . $id;
		$data = $eq2->RunQuerySingle($query);

		return($data['name']);
	}

	public function getHousesByCharID($char_id)
	{
		global $eq2;
		$query = "SELECT house_id as id FROM `" . ACTIVE_DB . "`.`character_houses` WHERE char_id = " . $char_id;
		$data = $eq2->RunQueryMulti($query);

		return($data);
	}

	public function getQuestNameByID($id)
	{
		global $eq2;
		
		$query = "SELECT name FROM `" . ACTIVE_DB . "`.`quests` WHERE quest_id = " . $id;
		$data = $eq2->RunQuerySingle($query);
		return $data['name'];
	}

	public function getSkillNameByID($id)
	{
		global $eq2;

		$query = "SELECT name FROM `" . ACTIVE_DB . "`.`skills` WHERE id = " . $id;
		$data = $eq2->RunQuerySingle($query);
		return $data['name'];
	}

	public function getSkillTypeNameByID($id)
	{
		global $eq2;

		$query = "SELECT emu_name AS name FROM `eq2meta_skills` WHERE emu_id = " . ($id + 1) . " AND emu_type='type'";
		$data = $eq2->RunQuerySingle($query);
		return $data['name'];

	}

	public function getSpellNameByID($id)
	{
		global $eq2;

		$query = "SELECT name FROM `" . ACTIVE_DB . "`.`spells` WHERE id = " . $id;
		$data = $eq2->RunQuerySingle($query);
		return $data['name'];

	}
}

?>