<?php
if (!defined('Perfect')) exit('Blocking access to this script');
/**
 * 分页类
 * @author  xiaojiong & 290747680@qq.com
 * @date 2011-08-17
 * 
 * show(2)  1 ... 62 63 64 65 66 67 68 ... 150
 * 分页样式 
 * #page{font:12px/16px arial}
 * #page span{float:left;margin:0px 3px;}
 * #page a{float:left;margin:0 3px;border:1px solid #ddd;padding:3px 7px; text-decoration:none;color:#666}
 * #page a.now_page,#page a:hover{color:#fff;background:#05c}
*/
 
class Page
{
	public     $first_row;        //起始行数
 
	public     $list_rows;        //列表每页显示行数
	 
	protected  $total_pages;      //总页数
 
	protected  $total_rows;       //总行数
	 
	protected  $now_page;         //当前页数
	 
	protected  $goto = '';
	 
	protected  $page_name;        //分页参数的名称
	 
	public     $plus = 3;         //分页偏移量
	 
	protected  $url;
	 
	 
	/**
	 * 构造函数
	 * @param unknown_type $data
	 */
	public function __construct($data = array())
	{
		$this->total_rows = $data['total_rows'];
 
		$this->goto         = !empty($data['goto']) ? $data['goto'] : '';

		$this->list_rows         = !empty($data['list_rows']) && $data['list_rows'] <= 100 ? $data['list_rows'] : 15;
		$this->total_pages       = ceil($this->total_rows / $this->list_rows);
		$this->page_name         = !empty($data['page_name']) ? $data['page_name'] : 'onPage';
		 
		/* 当前页面 */
		if(!empty($data['now_page']))
		{
			$this->now_page = intval($data['now_page']);
		}else{
			$this->now_page   = !empty($_GET[$this->page_name]) ? intval($_GET[$this->page_name]):1;
		}
		$this->now_page   = $this->now_page <= 0 ? 1 : $this->now_page;
	 
		 
		if(!empty($this->total_pages) && $this->now_page > $this->total_pages)
		{
			$this->now_page = $this->total_pages;
		}
		$this->first_row = $this->list_rows * ($this->now_page - 1);
	}   
	 
	public function _set_url($page){
		return $url = $this->goto.'&onPage='.$page;
	}
	/**
	 * 得到当前连接
	 * @param $page
	 * @param $text
	 * @return string
	 */
	protected function _get_link($page,$text)
	{
		$url = $this->_set_url($page);
		return '<a href="' .$url . '">' . $text . '</a>' . "\n";
	}
	 
	/**
	 * 得到第一页
	 * @return string
	 */
	public function first_page($name = '首页')
	{
		if($this->now_page > 5)
		{
			return $this->_get_link('1', $name);
		}   
		return '';
	}
	 
	/**
	 * 最后一页
	 * @param $name
	 * @return string
	 */
	public function last_page($name = '尾页')
	{
		if($this->now_page < $this->total_pages - 5)
		{
			return $this->_get_link($this->total_pages, $name);
		}   
		return '';
	}  
	 
	/**
	 * 上一页
	 * @return string
	 */
	public function up_page($name = '上一页')
	{
		if($this->now_page != 1)
		{
			return $this->_get_link($this->now_page - 1, $name);
		}
		return '';
	}
	 
	/**
	 * 下一页
	 * @return string
	 */
	public function down_page($name = '下一页')
	{
		if($this->now_page < $this->total_pages)
		{
			return $this->_get_link($this->now_page + 1, $name);
		}
		return '';
	}

	public function showPage($type='links'){
		return $this->$type();
	}

	/**
	 *  display Pager 
	 */
	public function drop()
	{
		if($this->total_rows < 1)
		{
			return '<span>无记录</span>';
		}
		$plus = $this->plus;
		if( $plus + $this->now_page > $this->total_pages)
		{
			$begin = $this->total_pages - $plus * 2;
		}else{
			$begin = $this->now_page - $plus;
		}       
		$begin = ($begin >= 1) ? $begin : 1;
		$return = '<span>总计 <font>' .$this->total_rows. '</font> 个记录分为 <font>' .$this->total_pages. '</font> 页, 当前第 <font>' . $this->now_page . '</font> 页 ';
		$return .= ',每页 <font> '.$this->list_rows.' </font>条记录，';
		$return .= $this->first_page()."\n";
		$return .= $this->up_page()."\n"; 
		$return .= $this->down_page()."\n";
		$return .= $this->last_page()."\n";
		$return .= '跳转至 <select onchange="gotoPages(\''.$this->goto.'\',this.value)" id="gotoPage" style="height: 20;width: auto;">';
		for ($i = $begin;$i<=$begin+10;$i++)
		{
			if($i>$this->total_pages)
			{
				break;
			}           
			if($i == $this->now_page)
			{
				$return .= '<option selected="true" value="'.$i.'">'.$i.'</option>';
			}
			else
			{
				$return .= '<option value="' .$i. '">' .$i. '</option>';
			}           
		}
		 $return .= '</select> 页<span>';
		return $return;
	}

	public function links(){
		$onPage = $this->now_page;
		if($this->total_rows>0){

			$nextPage=$onPage+1;
			$prePage=$onPage-1;

			if($nextPage>$this->total_pages) $nextPage=$this->total_pages;
			if($prePage<1) $prePage=1;

			$tmp=$onPage-5;
			if($tmp<1) $tmp=1;
			$tmpTotalPage=$tmp;
			for($i=0;$i<9;$i++){
				$tmpTotalPage++;
			}
			if($tmpTotalPage>$this->total_pages) $tmpTotalPage=$this->total_pages;
			$show = '';
			for($i=$tmp;$i<=$tmpTotalPage;$i++){
				if($i==$onPage){
					$show.='<td style="height:24px;line-height:24px;text-align:center;width:50px;border-left:#DCDCDC 1px solid;font-size:20px;color:#398ACA;font-weight:bold">'.$i.'</td>';
				}else{
					$show.='<td style="height:24px;line-height:24px;text-align:center;width:50px;border-left:#DCDCDC 1px solid"><a class="Apage" href="'.$this->goto.'&onPage='.$i.'" title="第'.$i.'页">'.$i.'</a></td>';
				}
			}
			$pageList='<table width="100%" style="margin-top:2px;height:24px;background:#EFEFEF;line-height:24px;border:#DCDCDC 1px solid;">';
			$pageList.='<tr style="border:1px solid #DCDCDC">';
			$pageList.='<td style="text-indent:8px"><span style="margin-right:2px;text-decoration:none;">当前共有<font style="font-size:12px;font-weight:bold">'.$this->total_rows.'</font>条记录，分<font style="font-size:12px;font-weight:bold">'.$this->total_pages.'</font>页，每页<font style="font-size:12px;font-weight:bold">'.$this->list_rows.'</font>条记录，当前为第<font style="font-size:12px;font-weight:bold">'.$onPage.'</font>页&nbsp;</span></td>';
			$pageList.='<td  style="text-align:center;width:60px;border-left:#DCDCDC 1px solid"><a class="Apage" href="'.$this->goto.'&onPage=1" title="首页">首页</a></td>';
			$pageList.='<td style="text-align:center;width:60px;border-left:#DCDCDC 1px solid"><a class="Apage" href="'.$this->goto.'&onPage='.$prePage.'" title="上一页">上一页</a></td>'.$show;
			$pageList.='<td style="text-align:center;width:60px;border-left:#DCDCDC 1px solid"><a class="Apage" href="'.$this->goto.'&onPage='.$nextPage.'" title="下一页">下一页</a></td>';
			$pageList.='<td style="text-align:center;width:60px;border-left:#DCDCDC 1px solid"><a class="Apage" href="'.$this->goto.'&onPage='.$this->total_pages.'" title="尾页">尾页</a></td></tr>';
			$pageList.='</table>';
		}else{
			$pageList='<table width="100%" height="24" style="border:1px solid #DCDCDC;margin-top:5px;text-align:center">';
			$pageList.='<tr><td><font style="color:#333333">无记录</font></td></tr>';
			$pageList.='</table>';
		}
		return $pageList;
	}
}