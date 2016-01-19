<?php
defined('THINK_PATH') or exit();
//添加数据
class ZdAction extends CommAction {
	
	//自动注册
	public function registered($id=20){	
		for($i=1;$i<=$id;$i++){
			$username=$this->get_password(8);
			$model=D('User');
			$ufees=M('ufees');
			$money=M('money');
			$vip_points=M('vip_points');
			$promote_integral=M('promote_integral');
			$userinfo=M('userinfo');
			$create['time']=time();
			$create['username']=$username;
			$create['email']=$username.'@gftdsfsdfsdfsdfsd.com';
			$create['password']=$model->userMd5($username);
			$create['pay_password']=$model->userPayMd5($username);
			$result = $model->add($create);
			//记录添加点
			$ufees->add(array('uid'=>$result));	//会员积分
			$money->add(array('uid'=>$result,'total_money'=>1000000000,'available_funds'=>1000000000));	//资金表
			$vip_points->add(array('uid'=>$result));	//VIP积分
			$promote_integral->add(array('uid'=>$result));	//推广积分
			$userinfo->add(array('uid'=>$result,'cellphone'=>'13012345654','cellphone_audit'=>2,'certification'=>2,'email_audit'=>2,'name'=>'丁茁匡','born'=>'1431446400','idcard'=>'511827197511097577','idcard_img'=>'1431309478.4204.jpg,1431309480.6778.png','idcard_img'=>'6 80 748','location'=>'2 52 500'));	//用户资料表(手机注册)
			$this->userLog('会员注册成功',$result);	//会员记录
			$this->silSingle(array('title'=>'会员注册成功','sid'=>$result,'msg'=>$username.'您的账号已注册成功！'));//站内信
			$this->integralAdd($arr);	//积分操作
			$this->moneyLog(array(0,'注册奖励',1000000000,'平台',1000000000,1000000000,0,$result),6);	//资金记录
			unset($create);
			unset($result);
			unset($username);
			
		}
	}
	
	//用户名随机产生
	public function get_password( $length = 8 ){
		$str = substr(md5(microtime(true)), 2, $length);
		return $str;
	}
	
	//随机数据
	public function random($array){
		$type=array_rand($array);
		return $array[$type];
		
	}
	
	
}