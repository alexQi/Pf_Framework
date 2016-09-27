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

	/**
	 *  display Pager 
	 */
	public function showPage()
	{
		if($this->total_rows < 1)
		{
			return '';
		}
		$plus = $this->plus;
		if( $plus + $this->now_page > $this->total_pages)
		{
			$begin = $this->total_pages - $plus * 2;
		}else{
			$begin = $this->now_page - $plus;
		}       
		$begin = ($begin >= 1) ? $begin : 1;
		$return = '<form class="form-inline">总计 <font class="text-info">' .$this->total_rows. '</font> 个记录分为 <font class="text-info">' .$this->total_pages. '</font> 页, 当前第 <font class="text-info">' . $this->now_page . '</font> 页 ';
		$return .= ',每页 <font class="text-info"> '.$this->list_rows.' </font>条记录，';
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
		 $return .= '</select> 页</form>';
		return $return;
	}
}