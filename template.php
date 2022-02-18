<?php
/** 
 * 
 * @author Jad Haddouch <jad.haddouch@prezenz.com>
 * @docauthor Jad Haddouch <jad.haddouch@prezenz.com>
 * @copyright Copyright 2019 Prezenz
 */

class template {
	
	/**
	 * __construct
	 */
	public function __construct () {}
	
	
	
	/**
	 * __destruct
	 */
	public function __destruct () {}
	
	
	
	/**
	 * vars
	 */
	public function vars ($html, $vars) {
		$html = preg_replace('#\{([[:alnum:]_\-]+)\}#','<?php echo isset($vars[\'$1\']) ? $vars[\'$1\'] : \'\'; ?>', $html);
		$html = preg_replace('#\{([[:alnum:]_\-]+)\.([[:alnum:]_\-]+)\}#','<?php echo isset($vars[\'$1\'], $vars[\'$1\'][$i], $vars[\'$1\'][$i][\'$2\']) ? $vars[\'$1\'][$i][\'$2\'] : \'\'; ?>', $html);
		$html = preg_replace('#\{([[:alnum:]_\-]+)\.([[:alnum:]_\-]+)\.([[:alnum:]_\-]+)\}#','<?php echo isset($vars[\'$1\'], $vars[\'$1\'][$i], $vars[\'$1\'][$i][\'$2\'], $vars[\'$1\'][$i][\'$2\'][\'$3\']) ? $vars[\'$1\'][$i][\'$2\'][\'$3\'] : \'\'; ?>', $html);
		
		return $html;
	}
	
	
	
	/**
	 * boucle
	 */
	public function boucle ($html, $vars) {
		$boucle = '<?php $fin = sizeof($vars[\'$1\']); for($i=0;$i<$fin;$i++) { ?>';
		$html = preg_replace('#\{loop ([[:alnum:]_\-]+)\}#', $boucle, $html);
		$html = preg_replace('#\{end loop\}#','<?php } ?>', $html);
		return $html;	
	}
	
	
	
	/**
	 * teste
	 */
	public function teste ($html, $vars) {	
		$teste = '<?php if(isset($vars[\'$1\']) && $vars[\'$1\']!=\'\'){ ?>';
		$html = preg_replace('#\{if ([[:alnum:]_\-]+)\}#', $teste, $html);
		$teste = '<?php if(isset($vars[\'$1\'][$i][\'$2\']) && $vars[\'$1\'][$i][\'$2\']!=\'\'){ ?>';
		$html = preg_replace('#\{if ([[:alnum:]_\-]+)\.([[:alnum:]_\-]+)\}#', $teste, $html);
		
		$teste = '<?php if(!(isset($vars[\'$1\']) && $vars[\'$1\']!=\'\')){ ?>';
		$html = preg_replace('#\{if !([[:alnum:]_\-]+)\}#', $teste, $html);
		$teste = '<?php if(!(isset($vars[\'$1\'][$i][\'$2\']) && $vars[\'$1\'][$i][\'$2\']!=\'\')){ ?>';
		$html = preg_replace('#\{if !([[:alnum:]_\-]+)\.([[:alnum:]_\-]+)\}#', $teste, $html);
		
		$teste = '<?php if(isset($vars[\'$1\'][$i][\'$2\']) && $vars[\'$1\'][$i][\'$2\']==\'$3\'){ ?>';
		$html = preg_replace('#\{if ([[:alnum:]_\-]+)\.([[:alnum:]_\-]+)==([[:alnum:]_\-]+)\}#', $teste, $html);
		
		$teste = '<?php } else if(isset($vars[\'$1\'][$i][\'$2\']) && $vars[\'$1\'][$i][\'$2\']==\'$3\'){ ?>';
		$html = preg_replace('#\{end if else_if ([[:alnum:]_\-]+)\.([[:alnum:]_\-]+)==([[:alnum:]_\-]+)\}#', $teste, $html);
		
		$teste = '<?php if(isset($vars[\'$1\'][$i][\'$2\']) && $vars[\'$1\'][$i][\'$2\']!=\'$3\'){ ?>';
		$html = preg_replace('#\{if ([[:alnum:]_\-]+)\.([[:alnum:]_\-]+)\!=([[:alnum:]_\-]+)\}#', $teste, $html);
		
		$html = preg_replace('#\{else if\(true\)\}#','<?php else{ ?>', $html);
		
		$html = preg_replace('#\{end if else\}#','<?php } else { ?>', $html);
		
		$html = preg_replace('#\{end if\}#','<?php } ?>', $html);
		
		return $html;
	}
	
	
	
	/**
	 * parse
	 */
	public function parse ($html, $vars) {		
		ob_start();
		
		$vars['template_vars'] = '<pre>' . print_r($vars, true) . '</pre>';
		
		$html = $this->vars($html, $vars);
		$html = $this->boucle($html, $vars);
		$html = $this->teste($html, $vars);
		
		eval('?>' . $html);
		
		return ob_get_clean();
	}
}
?>