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
 *	define("DBMOLE_COLLECT_STATISTICS",DEVELOPMENT);
 *
 *	// file: app/controllers/application_base.php
 *	function _application_after_filter(){
 *		if(DBMOLE_COLLECT_STATISTICS){
 *			$bar = Tracy\Debugger::getBar();
 *			$bar->addPanel(new DbMolePanel($this->dbmole));
 *		}
 *	}
 */
class DbMolePanel implements Tracy\IBarPanel{

	var $dbmole;

	function __construct($dbmole){
		$this->dbmole = $dbmole;
	}

	function getTab(){
		return "<strong>SQL</strong> ".$this->dbmole->getQueriesExecuted();
	}

	function getPanel(){
		if(!defined("DBMOLE_COLLECT_STATISTICS") || !constant("DBMOLE_COLLECT_STATISTICS")){
			return '<p>Collecting of db queries is disabled.<br>Please enable it by setting the constant DBMOLE_COLLECT_STATISTICS to true.</p>';
		}

		$out = array();
		$out[] = '<div style="overflow: auto;">';
		$out[] = "<code>";
		$out[] = $this->dbmole->getStatistics(array("format" => "html"));
		$out[] = "</code>";
		$out[] = '</div>';
		return join("\n",$out);
	}
}
