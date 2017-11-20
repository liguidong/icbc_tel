<?php
//连接数据库 分支
function db()
{
    $db_host = 'localhost';
    $db_name = 'icbc';
    $db_user = 'root';
    $db_pwd = '1234';
    $mysqli = new mysqli($db_host, $db_user, $db_pwd, $db_name);
    return $mysqli;
}
$db = db();
$res = $db->query("select id,tel from icbc_tel ");
$row = $res->fetch_all();

//开始查靓号

foreach ($row as $k=>$v)
{

	    //任意连续6位为AABBCC的号码
    if (preg_match('/^(?=\d*(\d)\1(\d)\2(\d)\3)1[358]\d{9}$/',$v[1]))
    {
        $tel8[] = $v[1];
    }

	    //任意连续8位为ABCDABCD的号码
    if (preg_match('/^(?=\d*(\d)(\d)(\d)(\d)\1\2\3\4)1[358]\d{9}$/',$v[1]))
    {
        $tel9[] = $v[1];
    }

    	    //末尾4位为ABCD的连续号码
    if (preg_match('/^(?=\d*(0(?=1|$)|1(?=2)|2(?=3)|3(?=4|$)|4(?=5|$)|5(?=6|$)|6(?=7|$)|7(?=8|$)|8(?=9|$)|9(?=0|$)){4}$)1[358]\d{9}$/',$v[1]))
    {
        $tel10[] = $v[1];
    }

        	    //末尾6位为ABCABC的号码
    if (preg_match('/^(?=\d*(\d)(\d)(\d)\1\2\3$)1[358]\d{9}$/',$v[1]))
    {
        $tel11[] = $v[1];
    }

        	    //末尾4位为ABAB的号码
    if (preg_match('/^(?=\d*(\d)\1(\d)\2$)1[358]\d{9}$/',$v[1]))
    {
        $tel12[] = $v[1];
    }



/*****************************/


    //6位递增或递减
    if (preg_match('/(?:(?:0(?=1)|1(?=2)|2(?=3)|3(?=4)|4(?=5)|5(?=6)|6(?=7)|7(?=8)|8(?=9)){5}|(?:9(?=8)|8(?=7)|7(?=6)|6(?=5)|5(?=4)|4(?=3)|3(?=2)|2(?=1)|1(?=0)){5})\d/',$v[1]))
    {
        $tel1[] = $v[1];
    }

    //匹配4-9位连续的数字
    if (preg_match('/(?:(?:0(?=1)|1(?=2)|2(?=3)|3(?=4)|4(?=5)|5(?=6)|6(?=7)|7(?=8)|8(?=9)){3,}|(?:9(?=8)|8(?=7)|7(?=6)|6(?=5)|5(?=4)|4(?=3)|3(?=2)|2(?=1)|1(?=0)){3,})\d/',$v[1]))
    {
        $tel2[] = $v[1];
    }

    //匹配3位以上的重复数字
    if (preg_match('/([\d])\1{2,}/',$v[1]))
    {
        $tel3[] = $v[1];
    }

    //匹配33111类型的
    if (preg_match('/([\d])\1{1,}([\d])\2{2,}/',$v[1]))
    {
        $tel5[] = $v[1];
    }

    //匹配5331533类型的
    if (preg_match('/(([\d]){1,}([\d]){1,})\1{1,}/',$v[1]))
    {
        $tel6[] = $v[1];
    }

    //匹配22334,123355类型的
    if (preg_match('/([\d])\1{1,}([\d])\2{1,}/',$v[1]))
    {
        $tel7[] = $v[1];
    }

}

echo "<h3>任意连续6位为AABBCC的号码</h3><br/>";
foreach ($tel8 as $k=>$v)
{
    echo $v."<br/>";
}

echo "<h3>任意连续8位为ABCDABCD的号码</h3><br/>";
foreach ($tel9 as $k=>$v)
{
    echo $v."<br/>";
}

echo "<h3>末尾4位为ABCD的连续号码</h3><br/>";
foreach ($tel10 as $k=>$v)
{
    echo $v."<br/>";
}

echo "<h3>末尾6位为ABCABC的号码</h3><br/>";
foreach ($tel11 as $k=>$v)
{
    echo $v."<br/>";
}

echo "<h3>末尾4位为ABAB的号码</h3><br/>";
foreach ($tel12 as $k=>$v)
{
    echo $v."<br/>";
}


echo "**********************************************</br>";

echo "<h3>6位递增或递减</h3><br/>";
foreach ($tel1 as $k=>$v)
{
    echo $v."<br/>";
}


echo "<h3>匹配4-9位连续的数字</h3><br/>";
foreach ($tel2 as $k=>$v)
{
    echo $v."<br/>";
}

echo "<h3>匹配3位以上的重复数字</h3><br/>";
foreach ($tel3 as $k=>$v)
{
    echo $v."<br/>";
}

echo "<h3>匹配33111类型的</h3><br/>";
foreach ($tel5 as $k=>$v)
{
    echo $v."<br/>";
}

echo "<h3>匹配5331533类型的</h3><br/>";
foreach ($tel6 as $k=>$v)
{
    echo $v."<br/>";
}

echo "<h3>匹配22334,123355类型的</h3><br/>";
foreach ($tel7 as $k=>$v)
{
    echo $v."<br/>";
}