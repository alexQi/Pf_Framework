<?php

/**
 * 后台首页相关功能控制器类
 */
class IndexController extends Controller {

	/**
	 * 首页
	 */
	public function IndexAction() {
		$onPage = isset($_REQUEST['onPage']) ? intval($_REQUEST['onPage']) : 1;
		$pageSize = 10;
		$IndexModel = new IndexModel;
		$filter = ' 1=1 ';
		$result = $IndexModel->queryAll($onPage,$pageSize,$filter);

		$params = array(
		            'total_rows'=>$result['count'],
		            'goto' =>$this->Url,
		            'now_page'  =>$onPage,
		            'list_rows' =>$pageSize,
		);
		$page = new Page($params);
		$data['page'] = $page->showPage();
		$data['list'] = $result['list'];
		$this->display('index',$data);
	}

	public function testAction(){
		try {
			
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		$this->display('test');
	}
}
