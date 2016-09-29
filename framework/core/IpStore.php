<?php
class IpStore{
	var $startIP = 0;
	var $endIP   = 0;
	var $Country = '';
	var $Local   = '';
	var $CountryFlag = 0;
	var $fp;
	var $FirstStartIp = 0;
	var $LastStartIp = 0;
	var $EndIpOff = 0 ;
	function getStartIp($RecNo) {
		$offset = $this->FirstStartIp + $RecNo * 7 ;
		@fseek( $this->fp,$offset,SEEK_SET);
		$buf = @fread($this->fp,7);
		$this->EndIpOff = ord($buf[4]) + (ord($buf[5])*256) + (ord($buf[6])* 256*256);
		$this->startIP = ord($buf[0]) + (ord($buf[1])*256) + (ord($buf[2])*256*256) + (ord($buf[3])*256*256*256);
		return $this->startIP;
	}

	function getEndIp() {
		@fseek ($this->fp,$this->EndIpOff,SEEK_SET);
		$buf = @fread($this->fp,5);
		$this->endIP = ord($buf[0]) + (ord($buf[1])*256) + (ord($buf[2])*256*256) + (ord($buf[3])*256*256*256);
		$this->CountryFlag = ord ($buf[4]);
		return $this->endIP;
	}

	function getCountry() {
		switch ($this->CountryFlag){
			case 1:
			case 2:
				$this->Country = $this->getFlagStr($this->EndIpOff+4);
				$this->Local = (1==$this->CountryFlag)?'':$this->getFlagStr($this->EndIpOff+8);
				break;
			default:
				$this->Country = $this->getFlagStr($this->EndIpOff+4);
				$this->Local = $this->getFlagStr(ftell($this->fp));
		}
	}

	function getFlagStr($offset) {
		$flag = 0;
		while (1){
			@fseek($this->fp,$offset,SEEK_SET);
			$flag = ord(fgetc($this->fp));
			if($flag == 1 || $flag == 2){
				$buf = @fread($this->fp,3);
				if($flag == 2){
					$this->CountryFlag = 2;
					$this->EndIpOff = $offset - 4;
				}
				$offset = ord($buf[0]) + (ord($buf[1])*256) + (ord($buf[2])* 256*256);
			}else{
				break ;
			}
		}
		if($offset < 12)
		return '';
		@fseek($this->fp,$offset,SEEK_SET );
		return $this->getStr();
	}

	function getStr() {
		$str = '' ;
		while(1){
			$c = @fgetc($this->fp);
			if(ord($c[0]) == 0)
			   break;
			$str .= $c;
		}
		return $str;
	}

	function qqwry($dotip) {
		$nRet;
		if ($dotip=="::1") $dotip = '127.0.0.1';
		$ip = $this->IpToInt($dotip);
		$this->fp= fopen(FRAMEWORK_PATH . DS . 'libraries' . DS .'IP.Dat',"rb");
		if($this->fp==NULL) {
			$szLocal= "OpenFileError";
			return 1;
		}
		@fseek($this->fp,0,SEEK_SET);
		$buf = @fread($this->fp,8);
		$this->FirstStartIp = ord($buf[0]) + (ord($buf[1])*256) + (ord($buf[2])*256*256) + (ord($buf[3])*256*256*256);
		$this->LastStartIp  = ord($buf[4]) + (ord($buf[5])*256) + (ord($buf[6])*256*256) + (ord($buf[7])*256*256*256);
		$RecordCount= floor(($this->LastStartIp-$this->FirstStartIp )/7);
		if($RecordCount <= 1){
			$this->Country = "FileDataError";
			@fclose($this->fp);
			return 2;
		}
		$RangB= 0;
		$RangE= $RecordCount;
		while($RangB < $RangE-1){
			$RecNo= floor(($RangB + $RangE) / 2);
			$this->getStartIp($RecNo);
			if($ip == $this->startIP){
				$RangB = $RecNo ;
				break;
			}
			if($ip > $this->startIP){
				$RangB= $RecNo;
			}else{
				$RangE= $RecNo;
			}
		}
		$this->getStartIp($RangB);
		$this->getEndIp();
		if(($this->startIP<= $ip) && ($this->endIP >= $ip)) {
			$nRet = 0 ;
			$this->getCountry();
		}else{
			$nRet = 3;
			$this->Country = '未知';
			$this->Local = '';
		}
		@fclose($this->fp);
		return $nRet ;
	}

	function IpToInt($Ip) {
		$array=@explode('.',$Ip);
		$Int=($array[0] * 256*256*256) + ($array[1]*256*256) + ($array[2]*256) + $array[3];
		return $Int;
	}

	function _isPrivate($ip) {
		$i = explode('.',$ip);
		if($i[0]==10) return true;
		if($i[0]==172 && $i[1]>15 && $i[1]<32) return true;
		if($i[0]==192 && $i[1]==168) return true;
		if($ip=='127.0.0.1') return true;
		if($ip=='::1') return true;
		return false;
	}

}

?>