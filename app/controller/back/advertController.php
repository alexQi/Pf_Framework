<?php
if (!defined('Perfect')) exit('Blocking access to this script');

/**
 * 广告控制器
 */
class advertController extends baseController
{
	function advertDealAction(){
		$AdvertModel = new AdvertModel();
		$handledRedis = $this->connectHandledRedis();
		$dType = trim($_REQUEST['dType']);
		if($dType=='createAdvert'){
			$this->createAdvert(microtime());
			exit;
		}elseif($dType=='advertModify'){
			$this->advertModify(microtime());
			exit;
		}elseif($dType=='advertDirect'){
			$this->advertDirect(microtime());
			exit;
		}elseif($dType=='revocationAdvert'){
			$intoData['ad_id'] = intval($_REQUEST['ad_id']);
			$intoData['status'] = 5;
			if($AdvertModel->setAdvertField($intoData)){
				$logData['module'] = 'Advert';
				$logData['type'] = 'revocation';
				$logData['table'] = "{$this->TABLE['TB_advert']}";
				$logData['content'] = "广告ID:".$intoData['ad_id'].",撤销广告";
				$this->Log($logData);

				$handledRedis->setex('adStatusAdmin_'.$intoData['ad_id'],1);
				$this->Alert('操作成功!');
			}else{
				$this->Alert('操作失败!');
			}
		}elseif($dType=='passAdvert'){
			$intoData['ad_id'] = intval($_REQUEST['ad_id']);
			$intoData['status'] = 2;

			$advertInfo = $AdvertModel->getAdvertDetailById($intoData['ad_id']);

			if($AdvertModel->setAdvertField($intoData)){
				$logData['module'] = 'Advert';
				$logData['type'] = 'pass';
				$logData['table'] = "{$this->TABLE['TB_advert']}";
				$logData['content'] = "广告ID:".$intoData['ad_id'].",审核广告";
				$this->Log($logData);

				$handledRedis->setex('adStatus_'.$intoData['ad_id'], 86400,1);
				$handledRedis->setex('adStatusAdmin_'.$intoData['ad_id'], 86400,2);
				$handledRedis->setex("adToDayTotalNum_".date("Ymd",time())."_".$intoData['ad_id'],86400,$advertInfo['now_amount']);
				$handledRedis->setex("adTotalNum_".$intoData['ad_id'],86400,$advertInfo['total_amount']);
				$this->Alert('操作成功!');
			}else{
				$this->Alert('操作失败!');
			}
			
		}elseif($dType=='refuseAdvert'){
			$intoData['ad_id'] = intval($_REQUEST['ad_id']);
			$intoData['status'] = 4;
			if($AdvertModel->setAdvertField($intoData)){
				$logData['module'] = 'Advert';
				$logData['type'] = 'refuse';
				$logData['table'] = "{$this->TABLE['TB_advert']}";
				$logData['content'] = "广告ID:".$intoData['ad_id'].",拒绝广告";
				$this->Log($logData);

				$handledRedis->setex('adStatusAdmin_'.$intoData['ad_id'],1);
				$this->Alert('操作成功!');
			}else{
				$this->Alert('操作失败!');
			}
		}elseif($dType=='pauseAdvert'){
			$intoData['ad_id'] = intval($_REQUEST['ad_id']);
			$intoData['status'] = 3;
			if($AdvertModel->setAdvertField($intoData)){
				$logData['module'] = 'Advert';
				$logData['type'] = 'pause';
				$logData['table'] = "{$this->TABLE['TB_advert']}";
				$logData['content'] = "广告ID:".$intoData['ad_id'].",暂停广告";
				$this->Log($logData);
				$handledRedis->setex('adStatusAdmin_'.$intoData['ad_id'],1);
				$handledRedis->setex('adStatus_'.$intoData['ad_id'],3);
				$this->Alert('操作成功!');
			}else{
				$this->Alert('操作失败!');
			}
		}elseif($dType=='advertArrived'){
			$intoData['ad_id'] = intval($_REQUEST['ad_id']);
			$advertInfo = $AdvertModel->getAdvertDetailById($intoData['ad_id']);
			if ($advertInfo['isarrive']==1) {
				$intoData['isarrive'] = 2;
				$logData['content'] = "广告ID:".$intoData['ad_id'].",启用广告到达代码";
			}else{
				$intoData['isarrive'] = 1;
				$logData['content'] = "广告ID:".$intoData['ad_id'].",停用广告到达代码";
			}
			if($AdvertModel->setAdvertField($intoData)){
				$logData['module'] = 'Advert';
				$logData['type'] = 'arrive';
				$logData['table'] = "{$this->TABLE['TB_advert']}";
				
				$this->Log($logData);

				$this->Alert('操作成功!');
			}else{
				$this->Alert('操作失败!');
			}
		}elseif($dType=='getSiteMaster'){
			$SiteMasterModel = new SiteMasterModel;
			$username = trim($_REQUEST['name']);
			$MasterInfo = $SiteMasterModel->getOneSiteMaster($username);
			if($MasterInfo){
				$code = 2;
			}else{
				$code = 1;
			}
			echo $code;
		}elseif($dType=='modifyTodayTotal'){
			$intoData['ad_id'] = intval($_REQUEST['ad_id']);
			$intoData['now_amount'] = intval($_REQUEST['now_amount']);
			if($AdvertModel->setAdvertField($intoData)){
				$logData['module'] = 'Advert';
				$logData['type'] = 'addTodayTotal';
				$logData['table'] = "{$this->TABLE['TB_advert']}";
				$logData['content'] = "广告ID:".$intoData['ad_id'].",修改今日广告投放总量".$intoData['now_amount'];
				$this->Log($logData);
				$data['result'] = true;
			}else{
				$data['result'] = false;
			}
			echo json_encode($data);
		}elseif($dType=='modifyTotal'){
			$intoData['ad_id'] = intval($_REQUEST['ad_id']);
			$least = trim($_REQUEST['least']);
			if( strpos($least,'+',1) ){
				$delimiter = '+';
			}elseif( strpos($least,'-',1) ){
				$delimiter = '-';
			}else{
				$error = true;
			}
			if (!$error) {
				$advertInfo = $AdvertModel->getAdvertDetailById($intoData['ad_id']);
				$temp = explode($delimiter, $least);
				if ($temp[0]!='') {
					$after_num = $temp[1];
				}else{
					$after_num = $temp[2];
				}
				if ($delimiter=='-') {
					$intoData['total_amount'] = $advertInfo['total_amount']-$after_num;
				}else{
					$intoData['total_amount'] = $advertInfo['total_amount']+$after_num;
				}
				if($AdvertModel->setAdvertField($intoData))
				{
					$logData['module'] = 'Advert';
					$logData['type'] = 'addTotal';
					$logData['table'] = "{$this->TABLE['TB_advert']}";
					$logData['content'] = "广告ID:".$intoData['ad_id'].",变更投放总量 $least";
					$this->Log($logData);

					$handledRedis = $this->connectHandledRedis();
					$data['message'] = iconv("GBK","UTF-8//IGNORE",'操作成功');
					$data['num'] = $intoData['total_amount']-$handledRedis->get("adCurrentTotalNum_".$intoData['ad_id']);
					$data['result'] = true;
				}else{
					$data['message'] = iconv("GBK","UTF-8//IGNORE",'操作失败');
					$data['result'] = false;
				}
				
			}else{
				$data['message'] = iconv("GBK","UTF-8//IGNORE",'运算错误，请检查数据');
				$data['result'] = false;
			}
			echo json_encode($data);

		}elseif($dType=='hourModify'){
			$advertDirectModel = new AdvertDirectModel;
			$intoData['ad_id'] = intval($_REQUEST['ad_id']);
			$intoData['hours'] = trim($_REQUEST['hours']);
			$directInfo = $advertDirectModel->getAdvertDirectDetailById($intoData['ad_id']);
			if ($directInfo) {
				if($advertDirectModel->setAdvertDirectFieldByAdvertId($intoData)){
					$logData['module'] = 'Advert';
					$logData['type'] = 'hourModify';
					$logData['table'] = "{$this->TABLE['TB_advert_direct']}";
					$logData['content'] = "广告ID:".$intoData['ad_id'].",修改广告定时为".$intoData['hours'];
					$this->Log($logData);

					$this->Alert('操作成功!');
				}else{
					$this->Alert('操作失败!');
				}
			}else{
				if($advertDirectModel->createAdvertDirect($intoData)){
					$logData['module'] = 'Advert';
					$logData['type'] = 'hourModify';
					$logData['table'] = "{$this->TABLE['TB_advert_direct']}";
					$logData['content'] = "广告ID:".$intoData['ad_id'].",添加广告定时为".$intoData['hours'];
					$this->Log($logData);
					$this->Alert('操作成功!');
				}else{
					$this->Alert('操作失败!');
				}
			}
			
		}elseif($dType=='priceModify'){
			$intoData['id'] = intval($_REQUEST['id']);
			$intoData['price'] = trim($_REQUEST['price']);
			$intoData['uid'] = $_SESSION[Perfect]['userId'];
			$intoData['utime'] = date("Y-m-d H:i:s");
			if($AdvertModel->setAdvertSitePriceField($intoData)){
				$logData['module'] = 'Advert';
				$logData['type'] = 'priceModify';
				$logData['table'] = "{$this->TABLE['TB_advert_site_price']}";
				$logData['content'] = "单价ID:".$intoData['ad_id'].",修改广告单价:".$intoData['price'];
				$this->Log($logData);
				$this->Alert('操作成功!',"index.php?controller=advert&action=specialAdvertPrice&searchById=".$intoData['id']);
			}else{
				$this->Alert('操作失败!',"index.php?controller=advert&action=specialAdvertPrice&searchById=".$intoData['id']);
			}
		}elseif($dType=='createSpecialPrice'){
			$this->createSpecialPrice(microtime());
			exit;
		}elseif($dType=='deleteSpecialPrice'){
			$id = intval($_REQUEST['id']);
			if($AdvertModel->deleteAdvertSitePrcie($id)){
				$this->Alert('操作成功!',"index.php?controller=advert&action=specialAdvertPrice&searchById=".$intoData['id']);
			}else{
				$this->Alert('操作失败!',"index.php?controller=advert&action=specialAdvertPrice&searchById=".$intoData['id']);
			}
		}elseif($dType=='addAdvertDataReturnRate'){
			$intoData['banner_id'] = trim($_REQUEST['exceptAd']);
			$intoData['adm_id'] = trim($_REQUEST['siteMember']);
			$intoData['update_time'] = date('Y-m-d H:i:s');
			$intoData['return_rate'] = trim($_REQUEST['specialRate']);
			$intoData['return_time'] = trim($_REQUEST['specialTime']);

			if($AdvertModel->checkAdvertDataRateExists($intoData)){
				$this->Alert('数据微调记录已经存在！');
				exit;
			}else{
				if($AdvertModel->setAdvertReturnDataRateAdd($intoData)){
					$this->Alert('操作成功！');
				}else{
					$this->Alert('操作失败！');
				}
			}
		}elseif($dType=='startAdvertDataReturnRate'){
			$intoData['id'] = intval($_REQUEST['returnId']);
			$intoData['return_rate'] = trim($_REQUEST['returnRate']);
			$intoData['return_time'] = intval($_REQUEST['returnTime']);
			$intoData['status'] = 1;
			$intoData['update_time'] = date('Y-m-d H:i:s');
			if($intoData['id']==0){
				$this->Alert('参数错误！');
				exit();
			}
			if($AdvertModel->setAdvertReturnDataRateParme($intoData)){
				$this->Alert('操作成功！');
			}else{
				$this->Alert('操作失败！');
			}
			exit;
		}elseif($dType=='pauseAdvertDataReturnRate'){
			$intoData['id'] = intval($_REQUEST['returnId']);
			$intoData['status'] = 0;
			$intoData['update_time'] = date('Y-m-d H:i:s');
			if($intoData['id']==0){
				$this->Alert('参数错误！');
				exit();
			}
			if($AdvertModel->setAdvertReturnDataRateParme($intoData)){
				$this->Alert('操作成功！');
			}else{
				$this->Alert('操作失败！');
			}
			exit;
		}elseif($dType=='deleteAdvertDataReturnRate'){
			$returnId = intval($_REQUEST['returnId']);
			if($returnId==0){
				$this->Alert('参数错误！');
				exit();
			}
			if($AdvertModel->setAdvertReturnDataRateDelete($returnId)){
				$this->Alert('操作成功！');
			}else{
				$this->Alert('操作失败！');
			}
			exit;
		}else{
			exit('非法操作！');
		}
	}

	public function indexAction(){
		
		$AdvertModel = new AdvertModel();
		$searchTag = isset($_REQUEST['searchTag']) ? trim($_REQUEST['searchTag']) : '';
		$market_id = isset($_REQUEST['market']) ? trim($_REQUEST['market']) : '';
		$sickType = isset($_REQUEST['sickType']) ? trim($_REQUEST['sickType']) : '';
		$search_point = isset($_REQUEST['search_point']) ? trim($_REQUEST['search_point']) : '';
		$searchTagById = isset($_REQUEST['searchTagById']) ? trim($_REQUEST['searchTagById']) : '';
		$onPage = isset($_REQUEST['onPage']) ? max(intval($_REQUEST['onPage']),1) : 1;
		$pageSize = 30;
		
		if ($_SESSION[Perfect]['roleType']==3 && $_SESSION[Perfect]['root']===false) {
			$filter = 'AD.`admin_id`='.$_SESSION[Perfect]['userId'];
		}else{
			$filter = '1=1';
		}
		
		if (empty($searchTagById)) {
			if($sickType!='') {
				if ($sickType!=-1) {
					$filter .= " AND `AD`.status=$sickType";
				}
			}else{
				$filter .= " AND `AD`.status=2";
				$sickType=2;
			}
			if(!empty($search_point)) {
				if ($search_point!=0) {
					$filter .= " AND `AD`.charge_point=$search_point";
				}
			}
			if(!empty($searchTag)) {
				$filter .= " AND name LIKE ('%$searchTag%')";
			}
			if(!empty($market_id)) {
				$filter .= " AND ADT.admin_id=$market_id";
			}
		}else{
			$filter .= " AND `AD`.advert_id=$searchTagById";
		}
		
		$filter .= " order by `AD`.status ASC,`AD`.advert_id DESC";
		$advertList = $AdvertModel->getAdvertList($onPage,$pageSize,$filter);

		#连接Redis
		// $handledRedis = $this->connectHandledRedis();
		// foreach ($advertList['list'] as $key => $advert) {
		// 	$advertList['list'][$key]['currentTotalNum'] = $handledRedis->get("adCurrentTotalNum_".$advert["advert_id"]);
		// 	$advertList['list'][$key]['currentTodayNum'] = $handledRedis->get("adToDayCurrentNum_".date("Ymd",time())."_".$advert["advert_id"]);
		// }

		$adminModel = new adminModel();
		$markets = $adminModel->getMemberRows("user_role=4 AND is_closed=0");

		$advertStatus = $this->Perfect->config['advertStatus'];
		$advertPoint = $this->Perfect->config['countPoint'];

		$params = array(
		            'total_rows'=>$advertList['count'],
		            'goto' =>$this->Url."&sickType=$sickType&searchTag=$searchTag&search_point=$search_point&market=$market_id",
		            'now_page'  =>$onPage,
		            'list_rows' =>$pageSize,
		);
		$page = new Page($params);

		$data['searchTag'] = $searchTag;
		$data['searchTagById'] = $searchTagById;
		$data['markets'] = $markets;
		$data['market_id'] = $market_id;
		$data['advertList'] = $advertList['list'];
		$data['sickType'] = $sickType;
		$data['search_point'] = $search_point;
		$data['advertStatus'] = $advertStatus;
		$data['advertPoint'] = $advertPoint;
		$data['page'] = $page->showPage();

		$this->display('index',$data);
	}

	public function createAdvert(){
		$AdvertModel = new AdvertModel();
		$searchTag = trim($_REQUEST['searchTag']);
		$aType = trim($_REQUEST['aType']);
		$advert = $_POST['advert'];
		$material = $_POST['material'];

		if(!empty($searchTag)){
			$advertiserModel = new AdvertiserModel();
			$adverInfo = $advertiserModel->getOneAdvertiser($searchTag);
			$this->Views->assign('adverInfo',$adverInfo);
			$this->Views->assign('searchTag',$searchTag);
		}

		if ($aType=='createAdvert') {
			switch ($advert['charge_point']) {
				case 1:
					$advert['ad_type'] = 'spot';
					break;
				case 2:
					$advert['ad_type'] = 'jump';
					break;
				case 3:
					$advert['ad_type'] = 'banner';
					break;
				case 4:
					$advert['ad_type'] = 'inbanner';
					break;
				default:
					//do nothing
					break;
			}
			$advert['addtime'] = date('Y-m-d H:i:s',time());
			$advert['usertime'] = date('Y-m-d',time());
			try{
				if ( $AdvertModel->createAdvert($advert) ) {
					$is_upload = trim($_REQUEST['is_upload']);

					if ($is_upload==2) {
						$material_path = $this->CONFIG['FILE_UPLOAD']['path'];
						$material_url = $this->CONFIG['FILE_UPLOAD']['url'];

						$FileUpload = new FileUpload;
						$FileUpload->set("path", $material_path);
						$FileUpload->set("maxsize", 2000000);
						$FileUpload->set("allowtype", array("gif", "png", "jpg","jpeg"));
						$FileUpload->set("israndname", true);

						if($FileUpload->upload("material_img")) {
							$material['img_url'] = $material_url.$FileUpload->getFileName();
						} else {
							throw new Exception($FileUpload->getErrorMsg());
						}
					}
					$material['ad_id'] = mysql_insert_id();
					$advertMaterialModel = new AdvertMaterialModel;
					$material['down_url'] = isset($_POST['down_url'])?$_POST['down_url']:'';
					$material['update_time'] = date('Y-m-d H:i:s',time());

					if ($advertMaterialModel->createAdvertMaterial($material)) {
						$logData['module'] = 'Advert';
						$logData['type'] = 'create';
						$logData['table'] = "{$this->TABLE['TB_advert']}";
						$logData['content'] = "广告ID:".$material['ad_id'].",创建广告";
						$this->Log($logData);
						$this->Alert('添加广告成功','index.php?controller=advert&action=advertList');
					}else{
						throw new Exception('添加素材失败');
					}
				}
			}catch(Exception $e){
				$this->Alert($e->getMessage());
			}
		}
		$kind = $this->CONFIG['countKind'];
		$point = $this->CONFIG['countPoint'];
		$advertStatus = $this->CONFIG['advertStatus'];
		$clientType = $this->CONFIG['clientType'];
		$advertPutType = $this->CONFIG['advertPutType'];
		$advertSize = $AdvertModel->getAdvertSize();
		$mainAdvert = $AdvertModel->getMainAdvert();

		$this->Views->assign('kind',$kind);
		$this->Views->assign('point',$point);
		$this->Views->assign('advert',$advert);
		$this->Views->assign('material',$material);
		$this->Views->assign('advertStatus',$advertStatus);
		$this->Views->assign('clientType',$clientType);
		$this->Views->assign('advertPutType',$advertPutType);
		$this->Views->assign('advertSize',$advertSize);
		$this->Views->assign('mainAdvert',$mainAdvert);

		$this->Views->display('advert_add.html');
	}

	public function advertModify(){
		$AdvertModel = new AdvertModel();
		$advertiserModel = new AdvertiserModel();
		$ad_id = intval($_REQUEST['ad_id']);
		$aType = trim($_REQUEST['aType']);
		$advert = $_POST['advert'];
		if ($aType=='advertModify') {
			switch ($advert['charge_point']) {
				case 1:
					$advert['ad_type'] = 'spot';
					break;
				case 2:
					$advert['ad_type'] = 'jump';
					break;
				case 3:
					$advert['ad_type'] = 'banner';
					break;
				case 4:
					$advert['ad_type'] = 'inbanner';
					break;
				default:
					//do nothing
					break;
			}
			try{
				if ( $AdvertModel->setAdvertField($advert) ) {
					$logData['module'] = 'Advert';
					$logData['type'] = 'modify';
					$logData['table'] = "{$this->TABLE['TB_advert']}";
					$logData['content'] = "广告ID:".$advert['ad_id'].",修改广告";
					$this->Log($logData);
					$this->Alert('修改广告成功','index.php?controller=advert&action=advertList');
				}else{
					throw new Exception('修改广告失败');
				}
			}catch(Exception $e){
				$this->Alert( $e->getMessage() );
			}
		}else{
			if ($ad_id) {
				$advert = $AdvertModel->getAdvertDetailById($ad_id);
				$adverInfo = $advertiserModel->getAdvertiserDetailById($advert['adm_id']);
			}else{
				$this->Alert('未查找到当前广告信息');
			}
		}
		$kind = $this->CONFIG['countKind'];
		$point = $this->CONFIG['countPoint'];
		$advertStatus = $this->CONFIG['advertStatus'];
		$clientType = $this->CONFIG['clientType'];
		$advertPutType = $this->CONFIG['advertPutType'];

		$advertSize = $AdvertModel->getAdvertSize();
		$mainAdvert = $AdvertModel->getMainAdvert();

		$this->Views->assign('adverInfo',$adverInfo);
		$this->Views->assign('kind',$kind);
		$this->Views->assign('point',$point);
		$this->Views->assign('advert',$advert);
		$this->Views->assign('advertStatus',$advertStatus);
		$this->Views->assign('clientType',$clientType);
		$this->Views->assign('advertPutType',$advertPutType);
		$this->Views->assign('advertSize',$advertSize);
		$this->Views->assign('mainAdvert',$mainAdvert);

		$this->Views->display('advert_modify.html');
	}

	public function advertDirect(){
		$advertModel = new AdvertModel();
		$advertDirectModel = new AdvertDirectModel;
		$ad_id = intval($_REQUEST['ad_id']);
		$aType = trim($_REQUEST['aType']);
		$direct = $_POST['direct'];

		$advertModel->setAdvertField(array('ad_id'=>$ad_id,'isbuild'=>1));
		
		if ($aType=='advertDirect') {
			$hours = $_POST['hours'];
			$area = $_POST['area'];
			$hours = implode(',',$hours);
			$area = implode(',',$area);
			$direct['hours'] = $hours;
			$direct['area'] = $area;
			$users = explode(',', $direct['only_user']);
			$advertModel->deleteSiteBlank($direct['ad_id']);

			try{
				$siteMasterModel = new SiteMasterModel();
				foreach($users as $user)
				{
					$smInfo = $siteMasterModel->getOneSiteMaster($user);
					if($smInfo)
					{
						$intoData['ad_id'] = $direct['ad_id'];
						$intoData['sitem_id'] = $smInfo['sitem_id'];
						$advertModel->createSiteBlank($intoData);
					}
				}

				if(isset($direct['direct_id']))
				{
					if ( $advertDirectModel->setAdvertDirectField($direct) ) {
						$logData['module'] = 'Advert';
						$logData['type'] = 'advertDirectModify';
						$logData['table'] = "{$this->TABLE['TB_advert_direct']}";
						$logData['content'] = "广告ID:".$direct['ad_id'].",修改广告定向";
						$this->Log($logData);
						$this->Alert('修改广告定向成功','index.php?controller=advert&action=advertList');
					}else{
						throw new Exception('修改广告定向失败');
					}
				}else{
					if ( $advertDirectModel->createAdvertDirect($direct) ) {
						$logData['module'] = 'Advert';
						$logData['type'] = 'createAdvertDirect';
						$logData['table'] = "{$this->TABLE['TB_advert_direct']}";
						$logData['content'] = "广告ID:".$direct['ad_id'].",创建广告定向";
						$this->Log($logData);
						$this->Alert('创建广告定向成功','index.php?controller=advert&action=advertList');
					}else{
						throw new Exception('创建广告定向失败');
					}
				}
			}catch(Exception $e){
				$this->Alert( $e->getMessage() );
			}
		}else{
			if ($ad_id) {
				$advert = $advertModel->getAdvertDetailById($ad_id);
				$direct = $advertDirectModel->getAdvertDirectDetailById($ad_id);
				if ($direct) {
					$direct['hours'] = array_filter(explode(',', $direct['hours']));
					$direct['area'] = array_filter(explode(',', $direct['area']));
					$this->Views->assign('direct',$direct);
				}
			}else{
				$this->Alert('未查找到当前广告信息');
			}
		}
		$hours = array();
		for ($i=0; $i < 24; $i++) {
			$hours[] = $i;
		}
		$province = $this->CONFIG['regBankProvince'];

		$this->Views->assign('advert',$advert);
		$this->Views->assign('hours',$hours);
		$this->Views->assign('province',$province);
		$this->Views->display('advert_direct.html');
	}

	public function specialAdvertPriceAction(){
		$advertModel = new AdvertModel();
		$searchTag = trim($_REQUEST['searchTag']);
		$searchTagById = trim($_REQUEST['searchTagById']);
		$onPage = max(intval($_REQUEST['onPage']),1);
		$pageSize = 30;

		$filter = " 1=1 ";
		if (empty($searchTagById)) {
			if(!empty($searchTag)) {
				$filter .= " AND AD.`name` LIKE ('%$searchTag%')";
			}
		}else{
			$filter .= " AND `AD`.ad_id=$searchTagById";
		}
		
		$advertPriceList = $advertModel->getSpecialAdvertPrice($onPage,$pageSize,$filter);
		
		$this->Views->assign('advertPriceList',$advertPriceList['list']);
		$goToUrl = "index.php?controller=advert&action=specialAdvertPrice&searchTag=$searchTag";
		$this->Views->assign('searchTag',$searchTag);
		if (! empty($searchTagById)) {
			$this->Views->assign('searchTagById',$searchTagById);
		}
		$this->Views->assign('pageList',$this->pagelist($advertPriceList['count'],$pageSize,$goToUrl));
		$this->Views->display('advertSpecialPriceList.html');
	}

	public function createSpecialPrice(){
		$advertModel = new AdvertModel();
		$advertList = $advertModel->getAllAdvert();
		$aType = trim($_REQUEST['aType']);
		$advert = trim($_REQUEST['advert']);
		if ($aType=='createSpecialPrice') {
			$advert = $_POST['advert'];
			$advert['utime'] = date("Y-m-d H:i:s");
			$advert['addtime'] = $advert['utime'];
			$advert['uid'] = $_SESSION[Perfect]['userId'];
			if ($advertModel->createAdvertSitePrice($advert)) {
				$logData['module'] = 'Advert';
				$logData['type'] = 'createSpecialPrice';
				$logData['table'] = "{$this->TABLE['TB_advert_site_price']}";
				$logData['content'] = "广告ID:".$direct['ad_id'].",创建广告特殊单价";
				$this->Log($logData);
				$this->Alert('添加成功','index.php?controller=advert&action=specialAdvertPrice');
			}else{
				$this->Alert("添加失败");
			}
		}
		$this->Views->assign('advertList',$advertList);
		$this->Views->display('createSpecialPrice.html');
	}

	/**
	 +----------------------------------------------------------
	 * 广告数据微调（广告主加数据）
	 +----------------------------------------------------------
	 */
	function advertDataReturnAction() {
		$AdvertModel = new AdvertModel();
		@$aType = trim($_REQUEST['aType']);
		if($aType=='getAds'){
			@$adm_id = intval($_REQUEST['adm_id']);
			$adList = $AdvertModel->getAdvertByAdmid($adm_id);
			$exportList = array();
			foreach($adList as $value){
				array_push($exportList,array('name'=>iconv('gbk','utf-8',$value['name']),'ad_id'=>$value['ad_id']));
			}
			echo json_encode($exportList);
			exit;
		}
		unset($aType);

		//获取所有广告主
		$AdvertiserModel =  new AdvertiserModel();
		$advertMemberList = array();
		$advertMemberList = $AdvertiserModel->getAllAdvertiser();
		$this->Views->assign('advertMemberList',$advertMemberList);
		
		//微调速率
		$fateRateTimeSelect = array();
		for($i=1;$i<100;$i++){
			array_push($fateRateTimeSelect,array('title'=>$i,'value'=>$i));
		}
		$this->Views->assign('fateRateTimeSelect',$fateRateTimeSelect);


		@$searchTag = trim($_REQUEST['searchTag']);

		@$onPage = max(intval($_REQUEST['onPage']),1);
		$pageSize =20;
		$filter = '';
		if(!empty($searchTag)) {
			$filter .= " and (ADR.adm_id='{$searchTag}' or ADR.banner_id='{$searchTag}' or AD.name like '%{$searchTag}%' or ADM.username like '{$searchTag}')";
		}
		$tempSiteList = $AdvertModel->getAdvertDataReturnList($onPage,$pageSize,$filter);

		$goToUrl = "index.php?controller=advert&action=advertDataReturn&searchTag=$searchTag";
		$this->Views->assign('siteList',$tempSiteList['list']);
		$this->Views->assign('pageList',$this->pagelist($tempSiteList['count'],$pageSize,$goToUrl));

		$this->Views->assign('searchTag',$searchTag);
		$this->Views->display('advertDataReturn.html');
	}

}


?>