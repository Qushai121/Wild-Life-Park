
<?php

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

function generateQRCode($data, string|null $logo, string $label)
{
    $writer = new PngWriter();

    // Create QR code
    $qrCode = QrCode::create(json_encode($data))
        ->setEncoding(new Encoding('UTF-8'))
        ->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)
        ->setSize(300)
        ->setMargin(10)
        ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
        ->setForegroundColor(new Color(0, 0, 0))
        ->setBackgroundColor(new Color(255, 255, 255));

    // Create generic logo
    $logo = Logo::create(empty($logo) ? 'upload/avatars/default.jpg' : "$logo")
        ->setResizeToWidth(50)
        ->setPunchoutBackground(true);

    // Create generic label
    $label = Label::create($label)
        ->setTextColor(new Color(255, 0, 0));

    $result = $writer->write($qrCode, $logo, $label);
    return $result;
}
