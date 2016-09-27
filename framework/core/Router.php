<?php
if (!defined('Perfect')) exit('Blocking access to this script');
/**
 * router
 */
class Router{

	public $uri_param = array();
	public $default_config;

	public function __construct($router){
		$this->default_config = $router;
		$this->getParams();
	}

	public function getParams(){
		
		$controller = '';
		$action = '';
		$module = '';
		
		
		if (isset($_REQUEST['r']) && trim($_REQUEST['r'])!='') 
		{
			$param = trim($_REQUEST['r']);
			$tempParam = explode('/', $param);
			
			if ($this->default_config['enable_module']) {
				if (count($tempParam)!=0) 
				{
					array_filter($tempParam);
					$module = isset($tempParam[0])?$tempParam[0]:'';
					$controller = isset($tempParam[1])?$tempParam[1]:'';
					$action = isset($tempParam[2])?$tempParam[2]:'';
				}else{
					$module = $param;
				}
				$moduleStatus = true;
			}else{
				if (count($tempParam)!=0) 
				{
					array_filter($tempParam);
					$controller = isset($tempParam[0])?$tempParam[0]:'';
					$action = isset($tempParam[1])?$tempParam[1]:'';
				}else{
					$controller = $param;
				}
				$moduleStatus = false;
			}
		}
		$uri_param['module'] = $module!='' && isset($module) ? $module : $this->default_config['default_module'];
		$uri_param['controller'] = $controller!='' && isset($controller) ? $controller : $this->default_config['default_controller'];
		$uri_param['action'] = $action!='' && isset($action) ? $action : $this->default_config['default_action'];
		$uri_param['moduleStatus'] = $moduleStatus;

		return $this->uri_param = $uri_param;
	}
}


?>