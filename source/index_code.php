<?php
/**
 * ��ȫ��֤��
 * 
 * ��ѡ���� ����֤������Ť������ת��ʹ�ò�ͬ���壬��Ӹ�����
 *
 * @author �⿭
 *
 */
class Security_Secoder {
    /**
     * ��֤���session���±�
     * 
     * @var string
     */
    public static $seKey = 'seccode';
    public static $expire = 300; //��֤�����ʱ�䣨s��
    /**
     * ��֤����ʹ�õ��ַ���01IO2Z5S���׻���������
     *
     * @var string
     */
    public static $codeSet = '346789ABCDEFGHJKLMNPQRTUVWXY';
    public static $fontSize = 18;     // ��֤�������С(px)
    public static $useCurve = true;   // �Ƿ񻭻�������
    public static $useNoise = true;   // �Ƿ�����ӵ�    
    public static $imageH = 40;       // ��֤��ͼƬ��
    public static $imageW = 120;      // ��֤��ͼƬ��
    public static $length = 4;        // ��֤��λ��
    public static $bg = array(230, 240, 230);  // ����
    protected static $_image = null;  // ��֤��ͼƬʵ��
    protected static $_color = null;  // ��֤��������ɫ

    /**
     * �����֤�벢����֤���ֵ�����session��
     * ��֤�뱣�浽session�ĸ�ʽΪ�� $_SESSION[self::$seKey] = array('code' => '��֤��ֵ', 'time' => '��֤�봴��ʱ��');
     */
    public static function entry() {
        // ͼƬ��(px)
        self::$imageW ; 
        // ͼƬ��(px)
        self::$imageH ;
        // ����һ�� self::$imageW x self::$imageH ��ͼ��
        self::$_image = imagecreate(self::$imageW, self::$imageH); 
        // ���ñ���
        imagecolorallocate(self::$_image, self::$bg[0], self::$bg[1], self::$bg[2]); 
        // ��֤�����������ɫ34 139 34
        self::$_color = imagecolorallocate(self::$_image, 34, 139, 34);
        // ��֤��ʹ��������� 
        //$ttf = 'images/ttfs/' . mt_rand(1, 20) . '.ttf';  
		$ttf = 'images/ttfs/4.ttf';
        if (self::$useNoise) {
            // ���ӵ�
            self::_writeNoise();
        } 
        if (self::$useCurve) {
            // �������
            self::_writeCurve();
        }
        //ѩ������
        for ($i=1; $i<=25; $i++) { 
            imagestring(self::$_image, mt_rand(1, 5), mt_rand(0, self::$imageW), mt_rand(0, self::$imageH), "*", imageColorAllocate(self::$_image, mt_rand(200,230), mt_rand(200,230), mt_rand(200,230))); 
        }
        //����֤��
        $code = array(); // ��֤��
        $codeNX = -10; // ��֤���N���ַ�����߾�
        for ($i = 0; $i<self::$length; $i++) {
            $code[$i] = self::$codeSet[mt_rand(0, 27)];
            $codeNX += mt_rand(self::$fontSize*1.2, self::$fontSize*1.6);
            // дһ����֤���ַ�
            imagettftext(self::$_image, self::$fontSize, mt_rand(-40, 70), $codeNX, self::$fontSize*1.5, self::$_color, $ttf, $code[$i]);
        }
        // ������֤��
       
        //cookie ��֤��
        ssetcookie('seccode', authcode(join('', $code), 'ENCODE'));
		//isset($_SESSION) || session_start();
        //$_SESSION[self::$seKey]['code'] = join('', $code); // ��У���뱣�浽session
        //$_SESSION[self::$seKey]['time'] = time();  // ��֤�봴��ʱ��

        header('Cache-Control: private, max-age=0, no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header("content-type: image/png");

        // ���ͼ��
        imagepng(self::$_image);
        imagedestroy(self::$_image);
    }

    /** 
     * ��һ������������һ�𹹳ɵ�������Һ���������������(����Ըĳɸ�˧�����ߺ���) 
     *      
     *      ���е���ѧ��ʽզ����������д����
     *        �����ͺ�������ʽ��y=Asin(��x+��)+b
     *      ������ֵ�Ժ���ͼ���Ӱ�죺
     *        A��������ֵ������������ѹ���ı�����
     *        b����ʾ������Y���λ�ù�ϵ�������ƶ����루�ϼ��¼���
     *        �գ�����������X��λ�ù�ϵ������ƶ����루����Ҽ���
     *        �أ��������ڣ���С������T=2��/�O�بO��
     *
     */
    protected static function _writeCurve() {
        $A = mt_rand(1, self::$imageH/2);                  // ���
        $b = mt_rand(-self::$imageH/4, self::$imageH/4);   // Y�᷽��ƫ����
        $f = mt_rand(-self::$imageH/4, self::$imageH/4);   // X�᷽��ƫ����
        $T = mt_rand(self::$imageH*1.5, self::$imageW*2);  // ����
        $w = (2* M_PI)/$T;
                        
        $px1 = 0;  // ���ߺ�������ʼλ��
        $px2 = mt_rand(self::$imageW/2, self::$imageW * 0.667);  // ���ߺ��������λ��             
        for ($px=$px1; $px<=$px2; $px=$px+ 0.9) {
            if ($w!=0) {
                $py = $A * sin($w*$px + $f)+ $b + self::$imageH/2;  // y = Asin(��x+��) + b
                $i = (int) ((self::$fontSize - 6)/4);
                while ($i > 0) {    
                    imagesetpixel(self::$_image, $px + $i, $py + $i, self::$_color);  // ���ﻭ���ص��imagettftext��imagestring����Ҫ�úܶ�                    
                    $i--;
                }
            }
        }
        
        $A = mt_rand(1, self::$imageH/2);                  // ���
        $f = mt_rand(-self::$imageH/4, self::$imageH/4);   // X�᷽��ƫ����
        $T = mt_rand(self::$imageH*1.5, self::$imageW*2);  // ����
        $w = (2* M_PI)/$T;        
        $b = $py - $A * sin($w*$px + $f) - self::$imageH/2;
        $px1 = $px2;
        $px2 = self::$imageW;
        for ($px=$px1; $px<=$px2; $px=$px+ 0.9) {
            if ($w!=0) {
                $py = $A * sin($w*$px + $f)+ $b + self::$imageH/2;  // y = Asin(��x+��) + b
                $i = (int) ((self::$fontSize - 8)/4);
                while ($i > 0) {            
                    imagesetpixel(self::$_image, $px + $i, $py + $i, self::$_color);  // ����(while)ѭ�������ص��imagettftext��imagestring�������Сһ�λ�����������whileѭ��������Ҫ�úܶ�    
                    $i--;
                }
            }
        }
    }

    /**
     * ���ӵ�
     * ��ͼƬ��д��ͬ��ɫ����ĸ������
     */
    protected static function _writeNoise() {
        for($i = 0; $i < 10; $i++){
            //�ӵ���ɫ
            $noiseColor = imagecolorallocate(
                              self::$_image, 
                              mt_rand(150,225), 
                              mt_rand(150,225), 
                              mt_rand(150,225)
                          );
            for($j = 0; $j < 5; $j++) {
                // ���ӵ�
                imagestring(
                    self::$_image,
                    5, 
                    mt_rand(-10, self::$imageW), 
                    mt_rand(-10, self::$imageH), 
                    self::$codeSet[mt_rand(0, 27)], // �ӵ��ı�Ϊ�������ĸ������
                    $noiseColor
                );
            }
        }
    }

    /**
     * ��֤��֤���Ƿ���ȷ
     *
     * @param string $code �û���֤��
     * @param bool �û���֤���Ƿ���ȷ
     */
    public static function check($code) {
        isset($_SESSION) || session_start();
        // ��֤�벻��Ϊ��
        if(empty($code) || empty($_SESSION[self::$seKey])) {
            return false;
        }
        // session ����
        if(time() - $_SESSION[self::$seKey]['time'] > self::$expire) {
            unset($_SESSION[self::$seKey]);
            return false;
        }
        if($code == $_SESSION[self::$seKey]['code']) {
            return true;
        }
        return false;
    }
}

// useage
Security_Secoder::$useNoise = false;  // Ҫ����ȫ�Ļ��ĳ�true
Security_Secoder::$useCurve = false;
Security_Secoder::entry();