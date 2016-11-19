
<?php
class UserModel extends CoreModel
{
	public function auth($sUser, $sPasswd)
	{
		$oQuery = $this->oPDO->prepare("SELECT * FROM user WHERE login=:login AND passwd=:passwd");
		$oQuery->bindParam(":login", $sUser);
		$oQuery->bindParam(":passwd", md5($sPasswd));
		$oQuery->execute();
		$this->aUser = $oQuery->fetch(PDO::FETCH_ASSOC);
		if ($this->aUser)
			$_SESSION['user_id'] = $this->aUser['ID'];
		else
			unset($_SESSION['user_id']);
		return ($this->aUser);
	}

	public function existName( $sName )
	{
		$oQuery = $this->oPDO->prepare("SELECT COUNT(*) FROM user WHERE login=:login");
		$oQuery->bindParam(":login", $sName);
		$oQuery->execute();
		$aUserCount = $oQuery->fetch(PDO::FETCH_NUM);
		return intval($aUserCount[0]);
	}

	public function add( $sName, $sMail, $sPasswd )
	{
		$oQuery = $this->oPDO->prepare("INSERT INTO user SET login=:login, passwd=:passwd, email=:email");
		$oQuery->bindParam(":login", $sName);
		$oQuery->bindParam(":email", $sMail);
		$oQuery->bindParam(":passwd", md5($sPasswd));
		$oQuery->execute();
	}
}
