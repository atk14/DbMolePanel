<?php
/**
 * A panel for Tracy Debugger with DbMole statistics
 *
 * Basic usage:
 *
 *	$bar = Tracy\Debugger::getBar();
 *	$bar->addPanel(new DbMolePanel($dbmole));
 *
 *
 * Usage in an ATK14 built upon Atk14Skelet:
 *
 *	// file: config/settings.php 
 *	define("DBMOLE_COLLECT_STATICTICS",DEVELOPMENT);
 *
 *	// file: app/controllers/application_base.php
 *	function _application_after_filter(){
 *		if(DBMOLE_COLLECT_STATICTICS){
 *			$bar = Tracy\Debugger::getBar();
 *			$bar->addPanel(new DbMolePanel($this->dbmole));
 *		}
 *	}
 */
class DbMolePanel implements Tracy\IBarPanel{
	function __construct($dbmole){
		$this->dbmole = $dbmole;
	}

	function getTab(){
		return "<strong>SQL</strong> ".$this->dbmole->getQueriesExecuted();
	}

	function getPanel(){
		$out = array();
		$out[] = '<div style="height: 500px; width: 800px; overflow:scroll;">';
		$out[] = "<code>";
		$out[] = $this->dbmole->getStatistics();
		$out[] = "</code>";
		$out[] = '</div>';
		return join("\n",$out);
	}
}
