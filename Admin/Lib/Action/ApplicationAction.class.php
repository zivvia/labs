 <?php
 	class ApplicationAction extends CommonAction{

 		public function add()
 		{
			if(isset($_POST["name"]))
			{
				$data = array();
				$data["name"]	= $_POST["name"];
                $data["url"] =   $_POST['url'];
                $data["author"] =   $_POST['author'];
                $data["phone"] =   $_POST['phone'];
                $data["remarks"] =   $_POST['remarks'];
				$data["intro"] 		= $_POST["intro"];

				$Application = M('Application');
				$result = $Application->add($data);
			     if ( $result ){
				        //成功提示
				        $this->success('增加应用成功',U('Application/manage'));
				}
				else{
				        //错误提示
				        $this->error('增加应用失败');
				}
				
		   	}
			else
			{
				$this->display();
			}
 		}
 	public function edit()
 	{
        if(isset($_POST["id"]))
        {
            $data = array();
            $data["name"]   = $_POST["name"];
            $data["url"] =   $_POST['url'];
            $data["author"] =   $_POST['author'];
            $data["phone"] =   $_POST['phone'];
            $data["remarks"] =   $_POST['remarks'];
            $data["intro"]      = $_POST["intro"];
            $Application = M('Application');
            $condition['id'] = $_POST['id'];

            //编辑数据
           // var_dump($data);
            $result = $Application->where($condition)->save($data);

            if ($result)
            {
                //成功提示
                $this->success('编辑应用成功',U('Application/manage'));
            }
            else
            {
                //错误提示
                $this->error('编辑应用失败',U('Application/manage'));
            }
            
        }
        else
        {
 			$classid = $_GET['id'];           
            $Application = M("Application");
            $condition['id'] = $_GET['id'];
            $Application = $Application->where($condition)->find();
            $this->assign("Application",$Application);
            $this->display();
        }
 	}
 	public function manage()
 	{
 		if(isset($_POST['duoxuanHidden'])) {
 			$id = $_POST['duoxuanHidden'];
 			
 			$model = M("Application");
 			$map['id'] = array('in',$id);
 			$result = $model->where($map)->delete();
 		}

 		$ApplicationList = array();
 		$Application = M("Application");
 		$page = isset($_GET['p'])? $_GET['p'] : '1';  //默认显示首页数据

 		$Application= $Application->order('id desc')->select();
 		while (list($key, $val) = each($Application)) {
 		    array_push($ApplicationList,$val);
 		}
 		import("ORG.Util.Page");// 导入分页类
 		$count = count($ApplicationList);// 查询满足要求的总记录数
 		$length = 10;
 		$offset = $length * ($page - 1);
 		$Page = new Page($count,$length,$page);// 实例化分页类 传入总记录数和每页显示的记录数和当前页数
 		$Page->setConfig('theme',' %upPage%   %linkPage%  %downPage%');
 		$show = $Page->show();// 分页显示输出
 		$this->assign("ApplicationList",$ApplicationList);
 		$this->assign("offset",$offset);
 		$this->assign("length",$length);
 		$this->assign("page",$show);
 		$this->display();		
 	}


 	public function del()
 	{
        $this->assign("jumpUrl",U('Application/manage'));
        $Applicationid = $_GET['id'];

        $condition['id'] = $Applicationid;
        $Application = M('Application');     
	    $result = $Application->where($condition)->delete();
        if ($result) {
            //成功提示
            $this->success('应用删除成功');
        } else {
            //错误提示
            $this->error('应用删除失败');
        }
 	}

 }