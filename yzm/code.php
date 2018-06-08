<?php
session_start();
header("Content-type: image/png");
$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$stl = "";
for($i=0; $i<4; $i++) {
    $stl = $stl.$chars[rand(0,61)];
}
class yzm {
    private $stl;
    public $yzm_img;
    function __construct( $stl ) {
        $this->stl = $stl;
        $this->creat_yzm();
    }

    /**
     * @param string $stl 验证码字符4-6个
     */
    private function creat_yzm() {
        $stl = $this->stl;
        $len = strlen($stl);
        $this->yzm_img = Imagecreate(150,55);
        $back = ImageColorAllocate($this->yzm_img,255, 255, 255);
        $text = ImageColorAllocate($this->yzm_img, 0, 255, 0);
        Imagefill($this->yzm_img, 0, 0, $back);
        $del = 140/($len);
        $font_file = 'msyh.TTF';
        for($i=0, $x=10; $i<$len; $i++) {
            $i%2==0?$k=-1:$k=1;
            $random1 = rand(-5, 5);
            $random2 = $k * rand(0, 3);
            $angle = rand(-10, 30);
            imagettftext($this->yzm_img, $del+$random1, $angle, $x, 45+$random2, $text, $font_file, $stl[$i]);
            $x += $del+$random1-4;
        }

        return;
    }

    /**
     * @param$this->yzm_img 需要加波浪线的图片
     */
    function add_line() {
        $A = rand(5, 10);
        $T = rand(80, 100);
        $color = ImageColorAllocate($this->yzm_img, 0, 255, 0);
        for($i=10; $i<140; ++$i) {
            $del = ceil($A*sin(3.14*$i/$T));
            for($j= 25; $j<28; $j++) {
                imagesetpixel($this->yzm_img , $i , $j+$del , $color );
            }
        }

        return;
    }

    /**
     * @param$this->yzm_img 需要扭曲的图片
     */
    function contort(){
        $A = rand(3, 5);
        $T = 20;
        $yzm_img = Imagecreate(150,55);
        for($i=0; $i<55; $i+=2) {
            imagecopy($yzm_img, $this->yzm_img, $A*sin(3.14*$i/$T), $i, 0, $i, 150, 2);
        }
        $this->yzm_img = $yzm_img;
        return;
    }
}
$_SESSION['code'] = strtolower($stl);
$yzm_img = new yzm($stl);
$yzm_img->add_line();
$yzm_img->contort();
Imagepng($yzm_img->yzm_img);