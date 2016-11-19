<?php
namespace Tools;

class Page{

	protected $total;
	public $page;
	protected $pagesize;
	protected $url;
	protected $pagenum;
	protected $bothnum;
	protected $sign;
                protected $query;
	
   	public function __construct($total,$pagesize, $query='') {

   		$this->total = $total;
   		$this->pagesize = $pagesize;
   		$this->pagenum = ceil($this->total / $this->pagesize);

   		$this->page = intval($this->getPage());
   		$this->pagesize = $pagesize;
   		$this->url = $this->getUrl();
   		$this->bothnum = 3;
                         $this->query = $query;
        
   	}

   	/**
   	 * 获取url去掉page
   	 */
	public function getUrl() {
		$url = $_SERVER['REQUEST_URI'];
		
		$par = parse_url($url);
		$this->sign = '?';
		return $par['path'];
	}

	/**
   	 * 获取当前页
   	 */
	public function getPage() {  
                if (!empty($_GET['page'])) {  
	       if ($_GET['page'] > 0) {  
                
                        if ($_GET['page'] > $this->pagenum) {  
                            return $this->pagenum;  
                        } else {  
                            return $_GET['page'];  
                        } 

                    }else {  
                        return 1;  
                    }  
                } else {  
                    return 1;  
                }  
            } 

            public function first() {  
    	   if ($this->page > $this->bothnum+1) {  
                    return ' <a href="'.$this->url.'">1</a> <a  class="point">...</a>';  
                }else{
        	       return '';
                }
            }

            public function prev() {  
                if ($this->page == 1) {  
                    return '<a class="disabled">上一页</a>';  
                }  
        	   return ' <a href="'.$this->url.$this->sign.'page='.($this->page-1).'&' .$this->query .'">上一页</a> '; 
            }  

            private function pageList() {  
    	   $pagelist ="";
                for ($i=$this->bothnum; $i>=1; $i--) {  
                    $page = $this->page-$i; 
                    if ($page < 1) {
            	           continue; 
                    } 
            	       $pagelist .= ' <a href="'.$this->url.$this->sign.'page='.$page.'&' .$this->query .'">'.$page.'</a> ';
                } 
	   $pageadd = $page+1;
        
                $pagelist .= ' <a class="disabled" style="background:#f04a4b !important; color:#fff;" href="'.$this->url.$this->sign.'page='.$pageadd.'&' .$this->query .'">'.$this->page.'</a> ';
       
                for ($i=1;$i<=$this->bothnum;$i++) {  
                    $page = $this->page+$i;  
                    if ($page > $this->pagenum) {
            	       break;
                }  
                $pagelist .= ' <a href="'.$this->url.$this->sign.'page='.$page.'&' .$this->query .'">'.$page.'</a> ';
            }  
            return $pagelist;  
        }  


        public function next() {  
            if ($this->page == $this->pagenum) {  
                return '<a class="disabled">下一页</a>';  
            }  
	$url = str_replace('?', "", $this->url);
        	return ' <a href="'.$url.$this->sign.'page='.($this->page+1).'&' .$this->query .'">下一页</a> ';
        }  


        public function last() {  
            if ($this->pagenum - $this->page > $this->bothnum) {  
                return ' <a>...</a><a href="'.$this->url.$this->sign.'page='.$this->pagenum.'&' .$this->query .'">'.$this->pagenum.'</a> ';  
            }  
        } 

        public function more(){
    	return '<p>共<span>'.$this->pagenum.'</span>页，到第<input type="text" value="'.$this->page.'" />页</p><a class="page-goin" href="" >确定</a>';
        }

        public function show() { 
    	$page = "";
    	$page .= $this->prev(); 
            $page .= $this->first();  
            $page .= $this->pageList();  
            $page .= $this->last();  
            $page .= $this->next();  
            // $page .= $this->more();
            return $page;  
        }
}
