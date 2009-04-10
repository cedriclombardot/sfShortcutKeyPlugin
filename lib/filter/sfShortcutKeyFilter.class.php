<?php

/**
 * Set the javascript to analyse your shorkuts key
 * defined into the shortcuts.yml
 *
 */
class sfShortcutKeyFilter extends sfFilter{
	
  /**
   * Executes this filter.
   *
   * @param sfFilterChain $filterChain A sfFilterChain instance
   */
	public function execute ($filterChain)
	  {
	  	//Execute Next Filter
	  	$filterChain->execute();
	  	
	  	require_once(sfContext::getInstance()->getConfigCache()->checkConfig('config/shortcuts.yml'));
	  	
	  	//Keys only
	  	$this->keys=sfConfig::get('shc_shortcuts_keys');
	  
	  	//CTRL+ <key>
	  	$this->ctrl=sfConfig::get('shc_shortcuts_ctrl');
	  	
	  	//ALT+<key>
	  	$this->alt=sfConfig::get('shc_shortcuts_alt');
	  	
	  	//SHIFT+<key>
	  	$this->shift=sfConfig::get('shc_shortcuts_shift');
	  	
	  	$response = $this->getContext()->getResponse();
	  	
	  	$response_content=$response->getContent();
	  	
	  	$js=$this->buildJs();
	  	$response_content=str_replace('</body>',$js.'</body>',$response_content);
	  	$response_content=str_replace('<body','<body onkeydown="sfShortcutkeyDown(event)" onkeypress="sfShortcutkeyPress(event)" onkeyup="sfShortcutkeyUp(event)" ',$response_content);
	  
	  	$response->setContent($response_content);
	  	
	  	
	  }
	  
	  private function buildJs(){
	  	$r=null;
	  	$r.='<script type="text/javascript">
/* <![CDATA[ */
	  	
/**
* Detect shorcuts
* @package sfShorcutKeyPlugin
* @author Cedric Lombardot <cedric.lombardot@spyrit.net>
* @see http://symfony.spyrit.net
* @generated at '.date('Y-m-d H:i:s').'
*/
var sfShortcutKeyCodeDown = 0;
var sfShortcutKeyCodePress = 0;
var sfShortcutKeyCodeUp = 0;
var keyPressed = "" ;
var keyUp= "";
var oldDown=0;
function sfShortcutkeyDown(event){
	oldDown=sfShortcutKeyCodeDown;
	sfShortcutKeyCodeDown = (window.Event) ? event.which : event.keyDown; 
	document.getElementById("down").innerHTML=sfShortcutKeyCodeDown+" "+String.fromCharCode(sfShortcutKeyCodeDown);
	return false;
}
function sfShortcutkeyPress(event){
	sfShortcutKeyCodePress = (window.Event) ? event.which : event.keyPress;
	keyPressed = String.fromCharCode(sfShortcutKeyCodePress);  
	return false;
}
function sfShortcutKeyAction(code,complement){
	';
	  	
	if(sizeof($this->keys)>0){
		$r.='if(complement==null){
';
		foreach($this->keys as $key=>$action){
	  		$r.='if(code=="'.$key.'"){ ';
	  		if(array_key_exists('url',$action)){
	  			$r.='return document.location="'.sfContext::getInstance()->getController()->genUrl($action['url'],true).'"';
	  		}
	  		$r.=' }
	  		
';
	  	}
	  $r.='}';
	}
	
	if(sizeof($this->alt)>0){
		$r.='if(complement=="ALT"){
';
		foreach($this->alt as $key=>$action){
	  		$r.='if(code=="'.$key.'"){ ';
	  		if(array_key_exists('url',$action)){
	  			$r.='return document.location="'.sfContext::getInstance()->getController()->genUrl($action['url'],true).'"';
	  		}
	  		$r.=' }
	  		
';
	  	}
	  $r.='}';
	}
	if(sizeof($this->ctrl)>0){
		$r.='if(complement=="CTRL"){
';
		foreach($this->ctrl as $key=>$action){
	  		$r.='if(code=="'.$key.'"){ ';
	  		if(array_key_exists('url',$action)){
	  			$r.='return document.location="'.sfContext::getInstance()->getController()->genUrl($action['url'],true).'"';
	  		}
	  		$r.=' }
	  		
';
	  	}
	  $r.='}';
	}
	if(sizeof($this->shift)>0){
		$r.='if(complement=="SHIFT"){
';
		foreach($this->shift as $key=>$action){
	  		$r.='if(code=="'.$key.'"){ ';
	  		if(array_key_exists('url',$action)){
	  			$r.='return document.location="'.sfContext::getInstance()->getController()->genUrl($action['url'],true).'"';
	  		}
	  		$r.=' }
	  		
';
	  	}
	  $r.='}';
	}
$r.='
}
function sfShortcutkeyUp(event){
	sfShortcutKeyCodeUp = (window.Event) ? event.which : event.keyDown; 
	if (sfShortcutKeyCodePress > 0) { 
		switch(sfShortcutKeyCodeDown) { 
			case 13: keyUp= "Enter" ; break
			case 8: keyUp= "backspace" ; break
			case 32: keyUp= "space" ; break 
		}
		switch(oldDown){
			case 16: sfShortcutKeyAction(keyPressed,"SHIFT"); break;
			case 17: sfShortcutKeyAction(keyPressed,"CTRL"); break;
			case 18: sfShortcutKeyAction(keyPressed,"ALT"); break;
			default: sfShortcutKeyAction(keyPressed,null); break;
	    }
		
	 }else{
		switch(sfShortcutKeyCodeDown) { 
			case 17: keyUp= "Ctrl" ; break
		    case 91: keyUp= "Start" ; break
		    case 18: keyUp= "Alt" ; break
	        case 93: keyUp= "Menu" ; break
	        case 40: keyUp= "bottom arrow" ; break
	        case 39: keyUp= "right arrow" ; break
	        case 38: keyUp= "top arrow" ; break
	        case 37: keyUp= "left arrow" ; break
	        case 16: keyUp= "Schift" ; break
	        case 20: keyUp= "Lock" ; break
	        case 45: keyUp= "Inser" ; break
	        case 46: keyUp= "Del" ; break
	        case 36: keyUp= "digonal arrow" ; break
	        case 35: keyUp= "End" ; break
	        case 33: keyUp= "Quick top" ; break
	        case 34: keyUp= "Quick Bottom" ; break
	        case 27: keyUp= "Echap" ; break
	        case 112: keyUp= "F1" ; break
	        case 113: keyUp= "F2" ; break
	        case 114: keyUp= "F3" ; break
	        case 115: keyUp= "F4" ; break
	        case 116: keyUp= "F5" ; break
	        case 117: keyUp= "F6" ; break
	        case 118: keyUp= "F7" ; break
	        case 119: keyUp= "F8" ; break
	        case 120: keyUp= "F9" ; break
	        case 121: keyUp= "F10" ; break
	        case 122: keyUp= "F11" ; break
	        case 123: keyUp= "F12" ; break
	        case 145: keyUp= "End défil" ; break
	        case 19: keyUp= "Pause Attn" ; break 
		}
		if (sfShortcutKeyCodeDown > 0){
			sfShortcutKeyAction(keyPressed,null);
	  } 
	}
';
	  	
	  	$r.=' 
	sfShortcutKeyCodeDown = 0;
	sfShortcutKeyCodePress = 0;
	sfShortcutKeyCodeUp = 0;
	keyPressed = "" ;
	keyUp= "";
	oldDown=0;
	return false;
}
';
	  	$r.='/* ]]> */</script>';
	  	return $r;
	  }
}
?>