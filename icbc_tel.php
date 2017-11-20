<?php
function http($url, $data='', $method='GET'){
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    if($method=='POST'){
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        if ($data != ''){
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        }
    }
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $tmpInfo = curl_exec($curl); // 执行操作
    curl_close($curl); // 关闭CURL会话
    return $tmpInfo; // 返回数据
}

//连接数据库
function db()
{
    $db_host = 'localhost';
    $db_name = 'icbc';
    $db_user = 'root';
    $db_pwd = 'root12';
    $mysqli = new mysqli($db_host, $db_user, $db_pwd, $db_name);
    return $mysqli;
}

//查询是否有重复数据
function isnotRepeat(&$db,$val)
{
	$res = $db->query("select id,tel from icbc_tel where tel=$val");
	$row = $res->fetch_all();

    if($row)
    { 
        return false;
    }
    else
    {
        return true;
    }
}

//url备份 https://m.10010.com/queen/icbc/fill.html?product=2&channel=1
//运行
for ($i=0;$i<30000;$i++)
{
    $url = 'https://m.10010.com/NumApp/NumberCenter/qryNum?callback=jsonp_queryMoreNums&provinceCode=71&cityCode=710&monthFeeLimit=0&groupKey=40236873&searchCategory=3&net=01&amounts=200&codeTypeCode=&searchValue=&qryType=02&goodsNet=4&_=1504699494352';
    $res = str_replace('jsonp_queryMoreNums(','',http($url));
    $res = json_decode(str_replace(');','',$res),true)['numArray'];
    $res = array_filter($res);
    $con = mysqli_connect("localhost","root","123",'icbc');
    $db = db();
    foreach ($res as $k=>$v)
    {
        if (strlen($v)<10)
        {
            unset($res[$k]);
        }
        else
        {
        	$v = '13277999531';
            if (isnotRepeat($db,$v))
            {
                $sql = "insert into icbc_tel (tel) values ('$v')";
                $info = $db->query($sql);    
                echo "<pre>插入成功";            
            }
        }
    }
}

var_dump('成功');