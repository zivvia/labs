<?php
	class ApiAction extends Action
	{
		public function applist()
		{
			$Application = M("Application");
			$result = $Application->order('id desc')->select();
			//var_dump($result);
			echo json_encode($result);
		}
		public function comment()
		{
			if(isset($_POST['name']))
            {
                $data = array();
                $data['name']  = $_POST['name'];
                $data['email'] = $_POST['email'];
                $data['comment'] = $_POST['text'];
                $data['posttime']=time();
                $Comment = M('Comment');
                $result = $Comment->add($data);
            
                if($result)
                {
                    echo "发送成功";
                }
                else
                {
                    echo "发送失败"; 
                }
            }
            else
            {
            	echo "发送失败";
            }
		}
	}