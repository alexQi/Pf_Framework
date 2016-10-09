<?php
if (!defined('Perfect')) exit('Blocking access to this script');
/**
 * 后台首页相关功能控制器类
 */
class mainController extends baseController {

	public function indexAction(){
		$unTouchArr = array();
		$MENULIST = $this->Menu;
		$userTouch = $_SESSION[Perfect]['manageTouch'];
		$tmpMenus = array();
		$expMenu = array();
		$menuIcoBox = array(
			'01'=>'icon-ete0',
			'100'=>'icon-ete1',
		);
		if($_SESSION[Perfect]['root']===false || is_null($_SESSION[Perfect]['root'])){
			$touchArrTmp = explode('|',$userTouch);
			foreach($touchArrTmp as $key => $value)
			{
				$temp = explode('-',$value);
				$viewItem[] = $temp[0];
			}

			foreach($MENULIST['ITEM'] as $key => $value)
			{
				if(!in_array($key,$viewItem)) unset($MENULIST['ITEM'][$key]);
			}

			foreach($MENULIST['ITEM'] as $key => $value)
			{
				$tmpMenus[$value['F']][]= $value;
			}

			$tmpMenu = array_keys($tmpMenus);
			$switchMenus = array();
			foreach($this->Menu['MENU'] as $key => $value){
				if(in_array($key,$tmpMenu)) array_push($switchMenus,$key);
			}

			$tmpMenu = $switchMenus;
			foreach($tmpMenu as $father)
			{
				$temp='';
				$temp = '{"menuid":"'.$father.'","icon":"'.$menuIcoBox[$father].'","menuname":"'.$this->Menu['MENU'][$father].'","menus":[';

				foreach($tmpMenus[$father] as $k=>$v){
					if(strtolower($v['M'])=='index' && strtolower($v['A'])=='index') continue;
					$detailTmp[] = '{"menuname":"'.$v['T'].'","icon":"'.$menuIcoBox[$father].'","url":"'.'index.php?r=back/'.$v['M'].'/'.$v['A'].'"}';
				}
				$temp .= join(',',$detailTmp);
				$temp .= "]}";
				unset($detailTmp);
				$expMenu[]=$temp;
			}
		}else{
			foreach($MENULIST['ITEM'] as $key => $value){
				$value['menuid'] = $key;
				$tmpMenus[$value['F']][]= $value;
			}
			foreach($MENULIST['MENU'] as $key => $father){
				$temp='';
				$temp = '{"menuid":"'.$key.'","icon":"'.$menuIcoBox[$key].'","menuname":"'.$father.'","menus":[';
				foreach($tmpMenus[$key] as $v){
					if(strtolower($v['M'])=='index' && strtolower($v['A'])=='index') continue;
					$detailTmp[] = '{"menuname":"'.$v['T'].'","icon":"'.$menuIcoBox[$key].'","url":"'.'index.php?controller='.$v['M'].'&action='.$v['A'].'"}';
				}
				$temp .= join(',',$detailTmp);
				$temp .= "]}";
				unset($detailTmp);
				$expMenu[]=$temp;
			}
		}
		$data['manageMenu'] = join(',',$expMenu);
		$this->display('index',$data);
	}

	public function welcomeAction(){
		echo "welcome to My this World";
	}
}
