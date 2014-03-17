<?php

/**
 * 基于Imagick的图像处理类
 * @author

  ImageImagick is free software; you can redistribute it and/or modify
  it under the terms of the GNU Lesser General Public License as published by
  the Free Software Foundation;

 *
 * */
namespace Gy\CoreBundle\Common;

class ImageImagick {

    // 源
    private $source = array(
        // 图片路径
        'file' => null,
        // 图片原句柄
        'res' => null,
        // 文件类型，如：jpg
        'type' => null,
        // mime类型
        'mime' => null,
        'width' => null,
        'height' => null
    );
    // 目标
    private $target;

    public function __construct($src = null) {

        if (!empty($src) && is_readable($src)) {

            $res = new \Imagick($src);

            $ext = strtolower($res->getImageFormat());

            $whxy = $res->getImagePage();

            $this->source = array(
                'res' => $res,
                'file' => $src,
                'mime' => $this->ext2mime($ext),
                'type' => $ext,
                'width' => $whxy['width'],
                'height' => $whxy['height']
            );
        } else {
            $this->source = array(
                'res' => new \Imagick(),
                'type' => 'png',
                'width' => 1,
                'height' => 1
            );
        }

        $this->target = $this->source;

        return $this;
    }

    /**
     * 基于宽高比例的放大、缩小 
     *
     * @param String $direction 基准边
     * @param String $base 基准值
     */
    public function scale($direction, $base) {

        $s = $this->target;

        $direction = strtolower($direction);

        // 基于宽度
        if ($direction == 'x') {
            $w = is_numeric($base) && $base > 0 ? intval($base) : $s['width'];
            //$scale = $base / $s['width'];
            $h = 0;
        }
        // 基于高度
        else {
            $h = is_numeric($base) && $base > 0 ? intval($base) : $s['height'];
            //$scale = $base / $s['height'];
            $w = 0;
        }

        // 新尺寸
        //$width  = (int)( $s['width'] * $scale );
        //$height = (int)( $s['height'] * $scale );

        if ('gif' == $s['type']) {

            $res = $s['res']->coalesceImages();

            do {
                //$res->thumbnailImage($width, $height);
                $res->scaleImage($w, $h);
            } while ($res->nextImage());

            $s['res'] = $res->deconstructImages();
        } else {
            //$s['res']->thumbnailImage($width, $height);
            $s['res']->scaleImage($w, $h);
        }

        $whxy = $s['res']->getImagePage();

        $s['width'] = $whxy['width'];
        $s['height'] = $whxy['height'];

        return $this;
    }

    // 拉伸
    public function stretch($width, $height) {

        $s = $this->target;

        if ('gif' == $s['type']) {

            $res = $s['res']->coalesceImages();

            do {
                $res->resizeImage($width, $height, Imagick::FILTER_POINT, 1);
            } while ($res->nextImage());

            $s['res'] = $res->deconstructImages();
        } else {

            $s['res']->resizeImage($width, $height, Imagick::FILTER_POINT, 1);
        }

        $s['width'] = $width;
        $s['height'] = $height;

        return $this;
    }

    // 剪裁
    public function crop($width, $height, $x = 0, $y = 0) {

        $s = $this->target;

        // 避免超出范围，获取内容为空时的异常
        if ($x >= $s['width'] || $y >= $s['height']) {
            $res = $s['res'];
            $res->clear();
            $res->newImage($width, $height, new \ImagickPixel('transparent'), 'png');
            $res->setImageOpacity(0);

            $draw = new ImagickDraw();

            $draw->setFillColor(new \ImagickPixel('#ffffff'));
            $draw->setStrokeColor(new \ImagickPixel('#cccccc'));
            $draw->setStrokeWidth(3);
            $draw->rectangle(1, 1, $width - 2, $height - 2);
            $draw->setStrokeWidth(1);
            $draw->line(3, 3, $width - 3, $height - 3);

            $res->drawImage($draw);

            $draw->clear();
            $draw->destroy();

            unset($draw);
        } else {

            if ('gif' == $s['type']) {

                $res = $s['res']->coalesceImages();

                do {
                    $res->cropImage($width, $height, $x, $y);
                    // 去掉画布空白
                    $res->setImagePage(0, 0, 0, 0);
                } while ($res->nextImage());

                $s['res'] = $res->deconstructImages();
            } else {
                $s['res']->cropImage($width, $height, $x, $y);
            }
        }

        $s['width'] = $width;
        $s['height'] = $height;

        return $this;
    }

    // 缩略图，基于指定的宽度比例先裁剪，后再放大、缩小
    public function thumb($width, $height) {

        $s = $this->target;

        if ('gif' == $s['type']) {
            foreach ($s['res'] as $frame) {
                $p = $frame->getImagePage();
                $frame->setImagePage($s['width'], $s['height'], $p['x'] / 2, $p['y'] / 2);
                $frame->cropthumbnailImage($width, $height);
                $frame->setImagePage(0, 0, 0, 0);
            }
        } else {
            $s['res']->cropThumbnailImage($width, $height);
        }

        $s['width'] = $width;
        $s['height'] = $height;

        return $this;
    }

    // 适应
    public function adapt($width, $height) {

        // 以宽为基准
        if ($this->target['width'] / $this->target['height'] >= $width / $height) {
            $base = $width;
            $direction = 'x';
        }
        // 以高为基准
        else {
            $base = $height;
            $direction = 'y';
        }

        return $this->scale($direction, $base);
    }

    // 文本
    public function text($text, $font, $color = '#ffffff', $size = 12, $shadow = false, $ox = 0, $oy = 0, $deep = 1) {

        $t = $this->target;

        $this->destroy();

        $res = new \Imagick();

        $draw = new \ImagickDraw();

        $draw->setFont($font);

        $draw->setFontSize($size);

        $draw->setTextAntialias(true);

        $metrics = $res->queryFontMetrics($draw, $text);

        $draw->setFillColor(new \ImagickPixel($color));

        $draw->annotation($ox, $metrics['ascender'] + $oy, $text);

        $w = $metrics['textWidth'] + 12;
        $h = $metrics['textHeight'];

        $res->newImage($w, $h, new \ImagickPixel('transparent'), 'png');

        $res->setImageOpacity(0);

        $res->drawImage($draw);

        // 阴影
        if ($shadow) {
            $shadow = $res->clone();
            $shadow->modulateImage(0, 100, 100);
            $res->compositeImage($shadow, imagick::COMPOSITE_OVERLAY, $deep, $deep);
        }

        $t['res'] = $res;
        $t['type'] = 'png';
        $t['mime'] = 'image/png';
        $t['width'] = $w;
        $t['height'] = $h;

        $draw->clear();
        $draw->destroy();

        unset($draw);

        return $this;
    }

    // 水印
    public function water($mask, $pos = 'right-bottom', $alpha = 0.6, $ox = 5, $oy = 5) {

        $s = $this->target;

        $iw = $s['width'];
        $ih = $s['height'];

        $mt = $mask->getTarget();

        $mw = $mt['width'] + $ox;
        $mh = $mt['height'] + $oy;

        // 重新计算水印的大小
        if ($mw > $iw || $mh > $ih) {

            if (($iw / $ih) > ($mw / $mh)) {
                // 缩小
                $scaleh = ( $mh > $ih ? $ih : $mh ) / 3;
                $scalew = intval($scaleh * $mw / $mh);
            } else {
                // 缩小
                $scalew = ( $mw > $iw ? $iw : $mw ) / 3;
                $scaleh = intval($scalew * $mh / $mw);
            }

            // 拉伸
            $mask->stretch($scalew, $scaleh);
        }

        $m = $mask->getTarget();

        // 起始坐标
        $xy = $this->getXY($pos, $s['width'], $s['height'], $m['width'], $m['height'], $ox, $oy);

        $mim = $m['res'];

        if ('png' == $m['type']) {
            $mim->evaluateImage(Imagick::EVALUATE_MULTIPLY, $alpha, Imagick::CHANNEL_ALPHA);
        } else {
            $mim->setImageOpacity($alpha);
        }

        if ('gif' == $s['type']) {

            $res = $s['res']->coalesceImages();

            foreach ($res as $frame) {
                $frame->compositeImage($mim, Imagick::COMPOSITE_OVER, $xy['x'], $xy['y']);
            }

            $s['res'] = $res->optimizeImageLayers();
        } else {
            $s['res']->compositeImage($mim, Imagick::COMPOSITE_OVER, $xy['x'], $xy['y']);
        }

        return $this;
    }

    // 输出到浏览器
    public function display($quality = null) {

        $t = $this->target;

        $res = $t['res'];

        if (is_null($quality)) {
            $quality = 100;
        }

        $res->setImageFormat($t['type']);

        $res->setCompressionQuality($quality);

        header('Content-Type: ' . $this->ext2mime($t['type']));

        echo $res->getImagesBLOB();

        $this->destroy();

        exit;
    }

    // 保存
    public function save($file = null, $quality = null) {

        $t = $this->target;

        $res = $t['res'];

        if (is_null($quality)) {
            $quality = 100;
        }

        $res->setImageFormat($t['type']);

        $res->setCompressionQuality($quality);

        // 创建白色的背景
        if (!in_array($t['type'], array('gif', 'png'))) {
            $bg = new \Imagick();
            $bg->newImage($t['width'], $t['height'], new \ImagickPixel('#ffffff'), $t['type']);
            $res->compositeImage($bg, \Imagick::COMPOSITE_DSTOVER, 0, 0);
            $bg->clear();
            $bg->destroy();
        }

        if ('gif' == $t['type']) {
            $res->writeImages($file ? $file : $t['file'], true);
        } else {
            $res->writeImage($file ? $file : $t['file']);
        }

        return $this;
    }

    // 
    public function getTarget($key = null) {

        $d = $this->target;

        if (!empty($key) && array_key_exists($key, $d)) {
            return $d[$key];
        } else {
            return $d;
        }
    }

    // 
    public function getSource($key = null) {

        $d = $this->source;

        if (!empty($key) && array_key_exists($key, $d)) {
            return $d[$key];
        } else {
            return $d;
        }
    }

    // 设置目标格式
    public function setTargetType($format) {

        $t = $this->target;

        $t['file'] = str_replace($t['type'], $format, $t['file']);

        $t['type'] = $format;

        return $this;
    }

    // 释放资源，一个连串处理的最后调用
    public function destroy() {

        $sim = $this->source['res'];

        if ($sim && is_resource($sim)) {
            $sim->clear();
            $sim->destroy();
        }

        $tim = $this->target['res'];

        if ($tim && is_resource($tim)) {
            $tim->clear();
            $tim->destroy();
        }
    }

    public function __destruct() {
        $this->destroy();
    }

    private function ext2mime($ext) {

        static $mime = array(
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
        );

        if (!array_key_exists($ext, $mime)) {
            trigger_error("mime undefined. ($ext)", E_USER_ERROR);
        }

        return $mime[$ext];
    }

    // 水印位置
    private function getXY($pos, $iw, $ih, $mw, $mh, $ox = 5, $oy = 5) {

        switch ($pos) {

            case 'right-bottom':
                // 右下
                $x = $iw - $mw - $ox;
                $y = $ih - $mh - $oy;
                break;

            case 'center':
                // 左上
                $x = ( $iw - $mw ) / 2;
                $y = ( $ih - $mh ) / 2;
                break;

            case 'left-top':
                // 左上
                $x = $ox;
                $y = $oy;
                break;

            case 'left-bottom':
                // 左下
                $x = $ox;
                $y = $ih - $mh - $oy;
                break;

            case 'right-top':
                // 右上
                $x = $iw - $mw - $ox;
                $y = $oy;
                break;

            default:
                // 默认将水印放到右下,偏移指定像素
                $x = $iw - $mw - $ox;
                $y = $ih - $mh - $oy;
                break;
        }

        return array('x' => $x, 'y' => $y);
    }

}
