<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait SteganoEncode
{
    public function hideTextInImage($text, $imageBase64)
    {
        // Decode base64 image
        $imageData = base64_decode($imageBase64);

        // Create an image resource from the string
        $img = imagecreatefromstring($imageData);
        if (!$img) {
            throw new \Exception("Failed to create image from data");
        }

        // Convert text to base64 and prepare to inject
        $meta = base64_encode("text_input") . '*';
        $msg = base64_encode($text) . '*';

        // Get image dimensions
        $img_w = imagesx($img);
        $img_h = imagesy($img);
        $line_length = ($img_w * 3) / 8;
        $max_length = $line_length * ($img_h - 1);

        if ($max_length < strlen($msg) || $line_length < strlen($meta)) {
            throw new \Exception("Message is too long or image is too small");
        }

        // Inject the data into the image
        $this->inject($img, $meta, 0);
        $this->inject($img, $msg, 1);

        // Output image as base64 PNG
        ob_start();
        imagepng($img);
        $outputImage = ob_get_contents();
        ob_end_clean();

        imagedestroy($img);

        return base64_encode($outputImage);
    }

    private function inject($img, $data, $start_line)
    {
        $img_w = imagesx($img);
        $str = '';
        for ($i = 0; $i < strlen($data); $i++) {
            $str .= sprintf("%08b", ord($data[$i]));
        }

        $x = 0;
        $y = $start_line;
        $l = strlen($str);

        for ($i = 0; $i < $l; ) {
            $rgb = $this->_imagecolorat($img, $x, $y);

            if ($i < $l) {
                $red = decbin($rgb['r']);
                $red[strlen($red) - 1] = $str[$i++];
                $rgb['r'] = bindec($red);
            }

            if ($i < $l) {
                $green = decbin($rgb['g']);
                $green[strlen($green) - 1] = $str[$i++];
                $rgb['g'] = bindec($green);
            }

            if ($i < $l) {
                $blue = decbin($rgb['b']);
                $blue[strlen($blue) - 1] = $str[$i++];
                $rgb['b'] = bindec($blue);
            }

            $this->_imagesetpixel($img, $x, $y, $rgb);

            $x++;
            if ($x == $img_w) {
                $x = 0;
                $y++;
            }
        }
    }

    private function _imagesetpixel($img, $x, $y, $rgb)
    {
        $color = imagecolorallocate($img, $rgb['r'], $rgb['g'], $rgb['b']);
        imagesetpixel($img, $x, $y, $color);
        imagecolordeallocate($img, $color);
    }

    private function _imagecolorat($img, $x, $y)
    {
        $rgb = imagecolorat($img, $x, $y);
        return ['r' => ($rgb >> 16) & 0xFF, 'g' => ($rgb >> 8) & 0xFF, 'b' => $rgb & 0xFF];
    }
}
