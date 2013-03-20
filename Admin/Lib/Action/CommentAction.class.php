<?php
    class CommentAction extends Action
    {   
        /*评论模块*/
        public function manage()
        {
		    if(isset($_POST['duoxuanHidden'])) {
			    $id = $_POST['duoxuanHidden'];
			
			    $model = M("Comment");
			    $map['id'] = array('in',$id);
			    $result = $model->where($map)->delete();
		    }

    	    $CommentList = array();
    	    $page = isset($_GET['p'])? $_GET['p'] : '1';  //默认显示首页数据


        $CommentList = array();
        $Comment = M("Comment");
        $Comment= $Comment->order('id desc')->select();
    	while (list($key, $val) = each($Comment)) {
    	    array_push($CommentList,$val);
    	}	
    	import("ORG.Util.Page");// 导入分页类
    	$count = count($CommentList);// 查询满足要求的总记录数
    	$length = 10;
    	$offset = $length * ($page - 1);
    	$Page = new Page($count,$length,$page);// 实例化分页类 传入总记录数和每页显示的记录数和当前页数
    	$Page->setConfig('theme',' %upPage%   %linkPage%  %downPage%');
    	$show = $Page->show();// 分页显示输出
    	$this->assign("CommentList",$CommentList);
    	$this->assign("offset",$offset);
    	$this->assign("length",$length);
    	$this->assign("page",$show);
            $this->display();
        }
        /*添加评论*/
        public function add()
        {
            if(isset($_POST['name']))
            {
                $data = array();
                $data['name']  = $_POST['name'];
                $data['email'] = $_POST['email'];
                $data['comment'] = $_POST['comment'];
                $data['posttime']=time();
                $Comment = M('Comment');
                $result = $Comment->add($data);
            
                if($result)
                {
                    echo "{'result':'success'}";
                }
                else
                {
                    echo "{'result':'fail'}"; 
                }
            }
            else
            { 
			    $this->display();
            }
        }
        public function del()
        {
            $this->assign("jumpUrl",U('Comment/manage'));
            $commentid = $_GET['id'];
    
           
            $condition['id'] = $commentid;
            $Comment = M('Comment');
            $result = $Comment->where($condition)->delete();
            if ($result) {
                //成功提示
                $this->success('留言删除成功');
            } else {
                //错误提示
                $this->error('留言删除失败');
            }
         }
        

}
