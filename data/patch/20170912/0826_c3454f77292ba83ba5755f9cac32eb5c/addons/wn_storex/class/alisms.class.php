<?php
 load()->func("\x63\157\155\155\165\156\151\143\141\x74\151\x6f\156"); class Alisms { private $api = "\150\164\164\160\72\x2f\x2f\144\171\163\155\x73\141\x70\x69\x2e\x61\154\151\171\x75\x6e\143\163\56\143\x6f\155\x2f\77"; private $accessKeyId = ''; private $signName = ''; private $accessKeySecret = ''; private $dateTimeFormat = "\x59\55\155\55\x64\134\124\x48\72\151\x3a\x73\134\x5a"; protected $format = "\x4a\123\x4f\x4e"; public function setFormat($format) { goto K0Jr7; tZoLN: if ($knWUK) { goto LMjtx; } goto DsU7V; K0Jr7: $knWUK = !in_array($format, array("\x52\x41\x57", "\x58\115\114", "\112\x53\117\x4e")); goto tZoLN; b1qwX: LMjtx: goto aN0zI; DsU7V: $this->format = $format; goto b1qwX; aN0zI: } public function __construct($accessKeyId, $accessKeySecret, $signName) { goto nYeuo; nYeuo: $this->accessKeyId = $accessKeyId; goto ke9TX; gqxdg: $this->signName = $signName; goto AUK_F; ke9TX: $this->accessKeySecret = $accessKeySecret; goto gqxdg; AUK_F: } public function send($mobile, $TemplateParam, $outOrderId = '', $TemplateCode) { goto NFoEW; NFoEW: $params = $this->params($mobile, $TemplateParam, $outOrderId, $TemplateCode); goto cdqzs; FvsHD: $params["\x53\x69\147\156\141\164\165\x72\145"] = $sign; goto OVKSO; wPDAB: return $result; goto WCZcO; OVKSO: $querydata = http_build_query($params); goto DT7u1; cdqzs: $sign = $this->computeSignature($params, $this->accessKeySecret); goto FvsHD; DT7u1: $apiurl = $this->api . $querydata; goto biir7; biir7: $result = ihttp_get($apiurl); goto wPDAB; WCZcO: } private function params($mobile, $TemplateParam, $outOrderId, $TemplateCode) { goto r0EpI; r0EpI: date_default_timezone_set("\x47\x4d\124"); goto HRWJ0; HRWJ0: $params = array("\120\x68\x6f\x6e\145\x4e\x75\155\142\145\x72\163" => $mobile, "\123\x69\x67\156\x4e\x61\155\x65" => $this->signName, "\x54\145\x6d\x70\154\141\x74\x65\103\x6f\144\145" => $TemplateCode, "\124\145\155\160\x6c\141\164\145\120\x61\x72\x61\x6d" => $TemplateParam, "\117\165\x74\x49\x64" => $outOrderId, "\122\x65\147\151\x6f\156\x49\144" => "\x63\156\55\150\x61\x6e\x67\172\150\157\x75", "\101\x63\143\x65\x73\x73\113\145\171\x49\x64" => $this->accessKeyId, "\x46\x6f\162\x6d\141\x74" => $this->format, "\123\x69\x67\x6e\141\x74\x75\x72\145\115\x65\164\150\x6f\144" => "\x48\x4d\x41\x43\55\x53\x48\x41\x31", "\123\151\x67\x6e\141\x74\165\162\145\126\x65\x72\x73\151\x6f\156" => "\x31\56\x30", "\x53\x69\147\x6e\141\164\x75\162\145\116\157\156\x63\x65" => uniqid(), "\x54\151\155\x65\163\164\141\x6d\x70" => date($this->dateTimeFormat), "\x41\143\164\x69\x6f\x6e" => "\123\x65\156\x64\123\155\163", "\126\145\162\x73\x69\157\x6e" => "\x32\60\61\x37\x2d\x30\x35\55\x32\x35"); goto Qg924; Qg924: return $params; goto oXjXM; oXjXM: } private function computeSignature($parameters, $accessKeySecret) { goto YzZ9i; d7hX3: $stringToSign = "\x47\105\124" . "\x26\x25\x32\106\x26" . $this->percentencode(substr($canonicalizedQueryString, 1)); goto dHkro; AEYZz: vbWTO: goto d7hX3; JzgTd: foreach ($parameters as $key => $value) { $canonicalizedQueryString .= "\46" . $this->percentEncode($key) . "\75" . $this->percentEncode($value); y6VB7: } goto Ju0M9; j6lRa: return $signature; goto ykpma; YzZ9i: ksort($parameters); goto DD9Y9; Ju0M9: R4SQS: goto AEYZz; DD9Y9: $canonicalizedQueryString = ''; goto otBFA; dHkro: $signature = $this->signString($stringToSign, $accessKeySecret . "\46"); goto j6lRa; otBFA: $ZFyll = !(!empty($parameters) && is_array($parameters)); goto EwSi8; EwSi8: if ($ZFyll) { goto vbWTO; } goto JzgTd; ykpma: } protected function signString($source, $accessSecret) { return base64_encode(hash_hmac("\x73\150\x61\x31", $source, $accessSecret, true)); } protected function percentEncode($str) { goto DyKVp; UDiGH: $result = preg_replace("\57\x5c\52\57", "\45\x32\x41", $result); goto k_Gd2; xqAdE: return $result; goto omQNM; llrNr: $result = preg_replace("\57\x5c\x2b\57", "\45\62\x30", $result); goto UDiGH; DyKVp: $result = urlencode($str); goto llrNr; k_Gd2: $result = preg_replace("\x2f\45\67\105\x2f", "\176", $result); goto xqAdE; omQNM: } }