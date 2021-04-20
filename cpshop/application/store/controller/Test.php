<?php
/**
 * Create Time: 2021/4/9 16:18
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\store\controller;
use app\store\controller\Base;

class Test extends Base
{

    public function test()
    {
        $demoarray=array(
            0=>array(
                'name'=>"玫瑰",
                'is_status'=>0,
                'age'=>12,
            ), 1=>array(
                'name'=>"月季",
                'is_status'=>1,
                'age'=>12,
            ),2=>array(
                'name'=>"薰衣草",
                'is_status'=>0,
                'age'=>11,
            )
        );

        $democard=[11,15,16];
        /*
         * array_filter过滤
         * */
        $data1=array_filter($demoarray,function($val) use ($democard){
            return in_array($val['age'],$democard)?false:true;
        });

        /*
         * array_map
         * */
        $a=array_map(function($val) use($democard){
            $val=in_array($val['age'],$democard) ? array():  $val;
            return $val;

        },$demoarray);
        $data2=array_filter($a);

        /*
         * array_reduce
         * */
        $data3=array_map(function($val) use($democard){
            $val['update']=array_reduce($democard,function($a,$v) use ($val){
                if($val['age']==$v){
                    $a="匹配成功";
                }
                return $a;
            },"匹配失败");
            return $val;

        },$demoarray);

       /* print_r(($data1));
        echo('<br>');
        print_r(($data2));
        echo('<br>');
        print_r(($data3));*/
        $green=$blue=$red=[];
        for($i=2;$i<=100;$i+=2){
            $i%2==0&&$arr[$i]=$i;
            if($i%4==0&&$i%6!=0){
                array_push($green,$arr[$i]);
                echo '<span style="color: green">'.$i.'</span>'.'#';
            } else if($i%6==0&&$i%4!=0){
                array_push($blue,$arr[$i]);
                echo '<span style="color: blue">'.$i.'</span>'.'#';
            } else if($i%6==0&&$i%4==0){
                array_push($red,$arr[$i]);
                echo '<span style="color: red">'.$i.'</span>'.'#';
            } else{
                echo '<span style="color: black">'.$i.'</span>'.'#';
            }
            if($i%20==0) {
                echo '<br>';
            }
        }
            print_r($green);
            echo '<br>';
            print_r($blue);
            echo '<br>';
            print_r($red);
    }


}