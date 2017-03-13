<?php
namespace app\components;

/**
* Dextep - simple template engine for PHP.
* Version 1.0 (2010-11-02)
* 2010 (c) Alexey Burkov
* Licensed under the terms of the BSD License.
*/
class Dextep{

	const VARIABLE = '(?:\$|%|\$%)[\w]+(?:\.%?[\w]+)*';	// regexp for variables
	const OPERATOR = '[\s!|><&)(:^?%.\/*+=-]';			// regexp for operators
	const NUMBER = '[0-9.]+?';							// regexp for numbers

	protected $pool;	// stack for checking inclusions
	protected $vars;	// storage for passed variables

	/**
	* Configuration variables
	*/
	protected $cacheEnabled = true;			// true = caching enabled, false = disabled
	protected $cachePath = 'cache/';		// path to cache folder
	protected $templatePath = 'templates/'; // path to templates folder
	protected $templateExt = '.html';		// templates extension


	/**
	* Object constructor
	*/
	public function __construct(){
		$this->vars = array();
	}

	/**
	* Returns template variable with name $key
	*/
	public function getVar($key){
		$value = &$this->vars;
		foreach(explode('.', $key) as $v){
			if (!isset($value[$v])) return null;
			$value = &$value[$v];
		}
		return $value;
	}

	/**
	* Sets template variable with name $key to $value
	*/
	public function setVar($key, $value){
		$vars = &$this->vars;
		$parts = explode('.', $key);
		for($i=0, $len=count($parts); $i<$len-1; $i++){
			if (!isset($vars[$parts[$i]]) || !is_array($vars[$parts[$i]])) $vars[$parts[$i]] = array();
			$vars = &$vars[$parts[$i]];
		}
		$vars[$parts[count($parts)-1]] = $value;
	}

	/**
	* Executes and returns template $name
	* If $recache = true then overrides cache (if caching is used)
	*/
	public function getTemplate($template){
		//$cachefile = $this->cachePath . str_replace('/','-',$name).'.cache';
		//if (!$this->cacheEnabled || $recache || !file_exists($cachefile)){
			//if (!$template = $this->preprocessing($content)) return false;	// parse comments and {include}
			$template = 'ob_start();' . PHP_EOL . 'echo \''.strtr($template, array("\\"=>"\\\\","'"=>"\'")).'\';' . PHP_EOL . '$result = ob_get_clean();' . PHP_EOL;
			$template = preg_replace_callback('/{@?(('.self::OPERATOR.'|'.self::NUMBER.'|'.self::VARIABLE.')+)}/U', array($this, 'callbackExpression'), $template); // parse expressions
			//$template = preg_replace_callback('/{foreach\s+('.self::VARIABLE.')\s+as\s+(?:%([\w]+)\s*=>\s*)?%([\w]+)\s*}/U', array($this, 'callbackForeach'), $template); // parse {foreach}
			//$template = preg_replace_callback('/{for\s+var\s*=\s*(%[\w]+)\s+from\s*=((?:'.self::OPERATOR.'|'.self::NUMBER.'|'.self::VARIABLE.')+)\s+to\s*=((?:'.self::OPERATOR.'|'.self::NUMBER.'|'.self::VARIABLE.')+)\s+step\s*=\s*(-?'.self::NUMBER.')\s*}/U', array($this, 'callbackFor'), $template); // parse {for}
			$template = preg_replace_callback('/{(else)?if\s+(('.self::OPERATOR.'|'.self::NUMBER.'|'.self::VARIABLE.')+)}/U', array($this, 'callbackIf'), $template); // parse {if}, {elseif}
			$template = preg_replace('/{else\s*}/', '\';' . PHP_EOL . '} else {' . PHP_EOL . 'echo \'', $template); // parse {else}
			$template = preg_replace('/{\/(foreach|if|for)\s*}/', '\';' . PHP_EOL . '}' . PHP_EOL . 'echo \'', $template); // parse closing tags
			//$template = preg_replace('/{\s*lb\s*}/', '{', $template); // parse {lb}
			//$template = preg_replace('/{\s*rb\s*}/', '}', $template); // parse {rb}
			//if ($this->cacheEnabled) file_put_contents($cachefile, $template); // save cache
		//} else $template = file_get_contents($cachefile); // load from cache

		@eval($template);		
		return isset($result) ? $result : false;
	}

	/**
	* Processes error. $str - error message.
	*/
	protected function error($str){
		die($str);
	}

	/**
	* Parses template comments and {include} tags
	*/
	protected function preprocessing($name, $included = array()){
		$tplfile = $this->templatePath . $name . $this->templateExt;
		if (!file_exists($tplfile)) $this->error('Template &laquo;<code>'.$tplfile.'</code>&raquo; not found.');
		$template = file_get_contents($tplfile);
		if ($template){
			$template = preg_replace('/{\*(.*)\*}/sU', '', $content); // parse comments
			$this->pool = count($included) ? $included : array($name); // use pool to check for self-inclusions
			$template = preg_replace_callback('/{include\s+([\'"]?)([\w\/]+)\1\s*}/U', array($this, 'callbackIncludes'), $template); // parse {include}
		}
		return $template;
	}

	/**
	* Callback functions used with regular expressions
	*/
	
	protected function callbackIncludes($param){
		$name = $param[2];
		$pool = $this->pool;
		if (in_array($name, $this->pool)) $this->error('Self-inclusion of &laquo;<code>'.$name.'</code>&raquo; template.');
		$result = $this->preprocessing($name, array_merge($this->pool, array($name)));
		$this->pool = $pool;
		return $result;
	}

	protected function callbackForeach($param){
		$result = '\';' . PHP_EOL;
		$result .= 'foreach('.$this->getVariableStr($param[1]).' as '.(strlen($param[2]) ? '$_'.$param[2].' => ' : '').'$_'.$param[3].'){' . PHP_EOL;
		$result .= 'echo \'';
		return $result;
	}

	protected function callbackIf($param){
		$result = '\';' . PHP_EOL;
		$result .= ($param[1]=='else'?'}else':'').'if('.preg_replace_callback('/'.self::VARIABLE.'/', array($this, 'callbackExpressionVariables'), $param[2]).'){' . PHP_EOL;
		$result .= 'echo \'';
		return $result;
	}

	protected function callbackFor($param){
		$var = $this->getVariableStr($param[1]);
		$step = $param[4];
		$result = '\';' . PHP_EOL;
		$result .= 'for('.$var.'=('.preg_replace_callback('/'.self::VARIABLE.'/', array($this, 'callbackExpressionVariables'), $param[2]).');'.$var.($step>0?'<=':'>=').'('.preg_replace_callback('/'.self::VARIABLE.'/', array($this, 'callbackExpressionVariables'), $param[3]).');'.$var.'='.$var.'+('.$step.')){' . PHP_EOL;
		$result .= 'echo \'';
		return $result;
	}

	protected function callbackExpression($param){
		$result = preg_replace_callback('/'.self::VARIABLE.'/', array($this, 'callbackExpressionVariables'), $param[1]);
		return $param[0]{1} == '@' ? '\';'.$result.';echo \'' : '\'.('. $result .').\'';
	}

	protected function callbackExpressionVariables($param){
		return $this->getVariableStr($param[0]);
	}

	protected function getVariableStr($s){
		$global = $s{0} == '$' ? true : false;
		if ($global) $s = substr($s, 1);
		$result = $global ? '$this->vars' : '';
		$p = explode('.', $s);
		for($i=0; $i<count($p); $i++) $result .= $p[$i]{0} == '%' ? (!$i && !$global ? '$_'.substr($p[$i], 1) : '[$_'.substr($p[$i], 1).']') : "['".$p[$i]."']";
		return $result;
	}

}
?>