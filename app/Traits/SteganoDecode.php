<?php

namespace App\Traits;

trait SteganoDecode
{
    public function extractMessageFromImage($imageData)
    {
        // Create an image resource from the string
        $img = imagecreatefromstring($imageData);
        if (!$img) {
            throw new \Exception("Failed to create image from data");
        }

        // Get image dimensions
        $img_w = imagesx($img);
        $img_h = imagesy($img);

        // Extract the metadata and the message from the image
        $meta = $this->_extract($img, 0, 1);
        $data = $this->_extract($img, 1, $img_h);

        imagedestroy($img);

        return $data;
    }

    private function _extract($img, $start_line, $end_line)
    {
        $img_w = imagesx($img);
        $str = '';

        for ($y = $start_line; $y < $end_line; $y++) {
            for ($x = 0; $x < $img_w; $x++) {
                $rgb = $this->_imagecolorat($img, $x, $y);

                // Get the least significant bits of the RGB channels
                $red = decbin($rgb['r']);
                $str .= $red[strlen($red) - 1];

                $green = decbin($rgb['g']);
                $str .= $green[strlen($green) - 1];

                $blue = decbin($rgb['b']);
                $str .= $blue[strlen($blue) - 1];
            }
        }

        // Convert binary string back to characters
        $final = '';
        $t_str = str_split($str, 8);
        $l = count($t_str);

        for ($i = 0; $i < $l; $i++) {
            $c = chr(bindec($t_str[$i]));
            if ($c == '*') {
                break;
            } else {
                $final .= $c;
            }
        }

        // Decode base64 message
        return base64_decode($final);
    }
}
