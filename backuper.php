<?php

/** *****************************************
 * 
 * LopTinBackuper hỗ trợ chuyển dữ liệu trực tiếp giữa 2 máy chủ, giúp sao lưu dữ liệu dễ dàng và nhanh chóng hơn.
 *
 * Chương trình này là phần mềm tự do, bạn có thể cung cấp lại và/hoặc chỉnh sửa nó theo những điều khoản của Giấy phép Công cộng của GNU do Tổ chức Phần mềm Tự do công bố; phiên bản 2 của Giấy phép, hoặc bất kỳ một phiên bản sau đó (tuỳ sự lựa chọn của bạn).
 * Chương trình này được cung cấp với hy vọng nó sẽ hữu ích, tuy nhiên KHÔNG CÓ BẤT KỲ MỘT BẢO HÀNH NÀO; thậm chí kể cả bảo hành về KHẢ NĂNG THƯƠNG MẠI hoặc TÍNH THÍCH HỢP CHO MỘT MỤC ĐÍCH CỤ THỂ. Xin xem Giấy phép Công cộng của GNU để biết thêm chi tiết.
 * Bạn phải nhận được một bản sao của Giấy phép Công cộng của GNU kèm theo chương trình này; nếu bạn chưa nhận, xin gửi thư về Tổ chức Phần mềm Tự do, 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * 
 * 
 *   
 * LopTinBackuper that help evrery one to backup and restore their data fast and easy via ftp account.
 *  
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *  
 * ##     ###### ######  ######## ## ##   ##
 * ##     ##  ## ##   ##    ##    ## ###  ##
 * ##     ##  ## ######     ##    ## ## # ##
 * ##     ##  ## ##         ##    ## ##  ###
 * ###### ###### ##         ##    ## ##   ##
 *
 * HTTP://LOPTIN.NET
 *
 * @author Original Hua Phuoc Truong <admin@loptin.net>
 * @copyright 2008
 ********************************************
*/

define('PHIENBAN',1.0);

session_start();
header('Content-type:text/html; charset=UTF-8');
set_time_limit(0);

//Kiểm tra phiên bản mới
$KetNoi=@file_get_contents('http://chuyentin.info/backuper/backuper.ver')."\n";
$PhienBan=substr($KetNoi,0,strpos($KetNoi,"\n"));
$CapNhat=substr($KetNoi,strpos($KetNoi,"\n"));
if ($PhienBan>PHIENBAN)
{
	echo "<i>Đã có phiên bản mới $PhienBan thay cho phiên bản hiện tại ".PHIENBAN."<br />
		Bạn có thể cập nhật tại địa chỉ <a href=\"http://chuyentin.info/backuper/\">http://chuyentin.info/backuper</a><br /><br />
		Thay đổi mới:<br /></i>
		<div style=\"width:80%;border:inset;background:#DFDFDF\">$CapNhat</div>";
	exit;
}

$ChuyenDi=new ChuyenDi;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<style>
	html
	{
		scrollbar-track-color: #EAEAEA;
		scrollbar-face-color: #FFFFFF;
		scrollbar-highlight-color: #F0F0F0;
		scrollbar-darkshadow-Color: #F0F0F0;
		scrollbar-3dlight-color:#F0F0F0;
	}
	body
	{
		font-family: Verdana, Tahoma, sans-serif;
		font-size: 12px;
	}
	a
	{
		text-decoration: none;
	}
	p
	{
		margin: 2px;
	}
	td
	{
		background: #F1F1F1;
		border: 1px outset;
	}
	td.On
	{
		border: 1px inset;
	}
	input
	{
		border: 1px dashed #7F9DB9;
	}
	.OK
	{
		border: 1px outset;
		background: #F1F1F1;
	}
</style>
<title>LopTin Backuper</title>
<body>
<?

switch($_GET['Mo']) //Mở một thư mục nào đó
{
	case 'ThuMuc': //Chuyển get thành POST để POST xử lý
		$_POST['Mo']='ThuMuc';
		$_POST['ThuMuc']=$_GET['ThuMuc'];
		break;
}

switch($_POST['Mo']) //Nhận dạng yêu cầu
{
	default: //Mở trang chủ
		$_POST['ThuMuc']='.';
		
	case 'ThuMuc': //Vào thư mục
		//Lấy danh sách
		$DanhSach=$ChuyenDi->DanhSach($_POST['ThuMuc']);
		?>
	<form method="post" action="<?=basename(__FILE__)?>" onsubmit="var KetQua='';var Tam=document.getElementsByName('LuaChon');for(i=0;i<Tam.length;i++){if(Tam[i].checked){KetQua+=Tam[i].value+';'}}this.TapTin.value=KetQua;if(!confirm('Xác nhận chuyển')){return false}" target="_blank">
		Chuyển đến: <input type="text" name="DenThuMuc" size="10" value="./" />
		<input type="hidden" name="Mo" value="ChuyenDi" />
		<input type="hidden" name="TapTin" />
		<input type="hidden" name="TuThuMuc" value="<?=$_POST['ThuMuc']?>" />
		Máy chủ: <input type="text" name="DiaChi" size="10" value="<?=$_SESSION['DiaChi']?>" />
		Tên đăn nhập: <input type="text" name="TenDangNhap" size="15" value="<?=$_SESSION['TenDangNhap']?>" />
		Mật khẩu: <input type="password" name="MatKhau" size="10" value="<?=$_SESSION['MatKhau']?>" />
		<input class="OK" type="submit" value="Thực thi" />
	</form>
	<div style="width:100%;height:100%;height:expression(document.documentElement.clientHeight-100);overflow:auto">
		<table width="96%">
		<?
		//Liệt kê nhưng thư mục đầu tiên
		foreach($DanhSach as $GiaTri)
		{
			if (is_dir($_POST['ThuMuc'].'/'.$GiaTri))
			{
				?>
			<tr onmouseover="var Tam=this.childNodes;for(i=0;i<Tam.length;i++)Tam[i].className='On'" onmouseout="var Tam=this.childNodes;for(i=0;i<Tam.length;i++)Tam[i].className=''">
				<td width="20px"><input type="checkbox" name="LuaChon" value="<?=$GiaTri?>" /></td>
				<td width="40%"><a style="color:#B1942E" href="?Mo=ThuMuc&ThuMuc=<?=$_POST['ThuMuc'].'/'.$GiaTri?>">►<?=$GiaTri?></a></td>
				<td width="10%" align="center" style="color:#B1942E">Thư mục</td>
				<td align="right" width="10%">0</td>
				<td width="10%">KB</td>
				<td width="10%" align="center"><?=substr(sprintf('%o', fileperms($_POST['ThuMuc'].'/'.$GiaTri)), -4)?></td>
				<td width="20%"><?=date('D d Y - H:i:s',filemtime($_POST['ThuMuc'].'/'.$GiaTri))?></td>
			</tr>
				<?
			}
		}
		//Liệt kê những tập tin khác
		foreach($DanhSach as $GiaTri)
		{
			if (!is_dir($_POST['ThuMuc'].'/'.$GiaTri))
			{
				?>
			<tr onmouseover="var Tam=this.childNodes;for(i=0;i<Tam.length;i++)Tam[i].className='On'" onmouseout="var Tam=this.childNodes;for(i=0;i<Tam.length;i++)Tam[i].className=''">
				<td width="20px"><input type="checkbox" name="LuaChon" value="<?=$GiaTri?>"></td>
				<td width="40%"><a style="color:#B1942E" target="_blank" href="<?=$_POST['ThuMuc'].'/'.$GiaTri?>"><?=$GiaTri?></a></td>
				<td width="10%" align="center" style="color:#B1942E">Tập tin</td>
				<td align="right" width="10%"><?=round(filesize($_POST['ThuMuc'].'/'.$GiaTri)/1024,2)?></td>
				<td width="10%">KB</td>
				<td width="10%" align="center"><?=substr(sprintf('%o', fileperms($_POST['ThuMuc'].'/'.$GiaTri)), -4)?></td>
				<td width="20%"><?=date('D d Y - H:i:s',filemtime($_POST['ThuMuc'].'/'.$GiaTri))?></td>
			</tr>
				<?
			}
		}
		?>
		</table>
	</div>
	<center>
		<i>Copyright 2008 <a href="http://chuyentin.info/backuper">A5 IT Class</a> - GNU license</i><br />
		Tải ChuyenTinBackuper mới nhất tại <a href="http://chuyentin.info/backuper">http://chuyentin.info/backuper</a>
	</center>
</body>
</html>
		<?
		break;
	
	case 'ChuyenDi': //Chuyển tập tin hoặc thư mục sang địa chỉ khác
		$_SESSION['DiaChi']=$_POST['DiaChi'];
		$_SESSION['TenDangNhap']=$_POST['TenDangNhap'];
		$_SESSION['MatKhau']=$_POST['MatKhau'];
		
		$ChuyenDi->Chuyen($_POST['DiaChi'],$_POST['TenDangNhap'],$_POST['MatKhau'],$_POST['TapTin'],$_POST['TuThuMuc'],$_POST['DenThuMuc']);
		break;
}

/** Phần thực thi chính */

class ChuyenDi
{
	function DanhSach($ThuMuc) //Lấy danh sách phần tử của một thư mục trả về dang mảng
	{
		$ThuMuc=opendir($ThuMuc);
		while($ThanhPhan=readdir($ThuMuc))
		{
			$KetQua[]=$ThanhPhan;
		}
		sort($KetQua);
		return $KetQua;
	}
	
	//Chuyển tới địa chỉ mới vào thư mục $DenThuMuc
	function Chuyen($DiaChi,$TenDangNhap,$MatKhau,$TapTin,$TuThuMuc,$DenThuMuc)
	{
		//Kết nối và kiểm tra đăng nhập
		$this->KetNoi=@ftp_connect($DiaChi);
		if (!@ftp_login($this->KetNoi,$TenDangNhap,$MatKhau))
		{
			echo 'Không đăng nhập được vào tài khoản FTP!';
			return false;
		}
		//Duyệt qua các thư mục tập tin
		$TapTin=explode(';',$TapTin);
		array_pop($TapTin);
		foreach($TapTin as $GiaTri)
		{
			//Nếu là thư mục thì chuyển hết toàn bộ những gì trong thư mục đó
			if (is_dir($TuThuMuc.'/'.stripslashes($GiaTri)))
			{
				echo '<br /><br />Tạo thư mục <b style="color:green">',$GiaTri,'</b>';
				$this->_Chuyen($TuThuMuc.'/'.$GiaTri,$DenThuMuc.'/'.$GiaTri);
			}
			//Nếu là tập tin thì chuyển thông thường
			else
			{
				echo '<br>Đang chuyển tập tin <b>',stripslashes($GiaTri).'</b> - ';
				ob_flush();
				flush();
				
				if (@ftp_fput($this->KetNoi,$DenThuMuc.'/'.stripslashes($GiaTri),fopen($TuThuMuc.'/'.stripslashes($GiaTri),'r'),FTP_BINARY))
				{
					echo '<b style="color:orange">Đã chuyển</b> ',stripslashes($GiaTri),' - ',filesize($TuThuMuc.'/'.stripslashes($GiaTri))==0 ? 100 : ftp_size($this->KetNoi,$DenThuMuc.'/'.stripslashes($GiaTri))/filesize($TuThuMuc.'/'.stripslashes($GiaTri))*100,'%';
				}
				else
				{
					echo '<b style="color:red">Không thể chuyển</b>';
				}
			}
			echo '<script>document.body.scrollTop=document.body.scrollHeight</script>';
			ob_flush();
			flush();
		}
	}
	
	function _Chuyen($ThuMuc,$ChuyenDen) //Chuyển đệ quy thư mục
	{
		//Tạo thư mục trên máy chủ mới
		@ftp_mkdir($this->KetNoi,$ChuyenDen);
		$DanhSach=$this->DanhSach($ThuMuc);
		//Duyệt qua thư mục $ThuMuc
		foreach($DanhSach as $GiaTri)
		{
			//Nếu gặp thư mục thì chuyển tiếp
			if (is_dir($ThuMuc.'/'.$GiaTri) && $GiaTri!='..' && $GiaTri!='.')
			{
				echo '<br /><br />Tạo thư mục <b style="color:green">',$GiaTri,'</b>';
				$this->_Chuyen($ThuMuc.'/'.$GiaTri,$ChuyenDen.'/'.$GiaTri);
			}
			//Chuyển tập tin thông thường
			elseif ($GiaTri!='..' && $GiaTri!='.')
			{
				echo '<br>Đang chuyển tập tin <b>',stripslashes($GiaTri).'</b> - ';
				ob_flush();
				flush();
				
				if (@ftp_fput($this->KetNoi,$ChuyenDen.'/'.stripslashes($GiaTri),fopen($ThuMuc.'/'.stripslashes($GiaTri),'r'),FTP_BINARY))
				{
					echo '<b style="color:orange">Đã chuyển</b> ',stripslashes($GiaTri),' - ',filesize($ThuMuc.'/'.stripslashes($GiaTri))>0 ? ftp_size($this->KetNoi,$ChuyenDen.'/'.stripslashes($GiaTri))/filesize($ThuMuc.'/'.stripslashes($GiaTri))*100 : 100,'%';
				}
				else
				{
					echo '<b style="color:red">Không thể chuyển!</b>';
				}
			}
			echo '<script>document.body.scrollTop=document.body.scrollHeight</script>';
			ob_flush();
			flush();
		}
	}
}

?>