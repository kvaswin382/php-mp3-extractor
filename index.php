<?php

function fileName($length = 16) {
  $char = 'ABCDEFGHIJKLMONPWRSTUVWXYZabcdefghijklmnopqrtsuvwxyz0123456789';
  $str = '';
  for ($i = 0; $i < $length; $i++) {
    $str .= $char[rand(0, strlen($char) - 1)];
  }
  return $str;
}

require 'vendor/autoload.php';

if (isset($_REQUEST['url'])) {

  $url = urldecode($_REQUEST['url']);
  $ffmpeg = FFMpeg\FFMpeg::create();;
  // Open your video file
  $video = $ffmpeg->open($url);

  // Set an audio format
  $audio_format = new FFMpeg\Format\Audio\Mp3();

  // Extract the audio into a new file as mp3
  $filename = fileName(16);
  $video->save($audio_format, $filename.'.mp3');

  // Set the audio file
  $audio = $ffmpeg->open($filename.'.mp3');

  // Create the waveform
  $waveform = $audio->waveform();
  $waveform->save($filename.'.png');

  echo json_encode(array('ok' => true,'mp3' => $filename.'.mp3'));
}

?>
