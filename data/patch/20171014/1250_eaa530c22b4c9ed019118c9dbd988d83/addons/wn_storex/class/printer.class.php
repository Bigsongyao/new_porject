<?php
 load()->func("\x63\x6f\155\155\165\x6e\x69\143\141\164\x69\157\x6e"); class Printer { private $user = ''; private $key = ''; private $sn = ''; private $times = 1; private $api = "\x68\x74\x74\x70\72\x2f\57\x61\160\x69\x2e\x66\x65\151\145\x79\x75\x6e\56\x63\x6e\57\101\160\x69\57\117\160\x65\156\57"; private $sig = ''; private $stime = TIMESTAMP; private $params = array(); public function __construct($user, $key, $sn) { goto hmugm; hmugm: $this->user = $user; goto irsIu; irsIu: $this->key = $key; goto vLtxb; vLtxb: $this->sn = $sn; goto JTpQk; JTpQk: $this->params = array("\x75\163\x65\162" => $user, "\x73\164\151\x6d\145" => TIMESTAMP, "\163\x69\x67" => sha1($user . $key . TIMESTAMP)); goto swyZU; swyZU: } public function printOrderAction($content, $times = 1) { goto Fi1x3; CGkpd: if ($SQluy) { goto zsD3i; } goto OioNx; ON6E3: $this->params["\x74\151\x6d\x65\x73"] = $times; goto jugeG; dWusc: zsD3i: goto zH55S; zH55S: $result = @json_decode($result["\x63\157\x6e\164\x65\x6e\164"], true); goto jzvpk; Fi1x3: $this->params["\163\x6e"] = $this->sn; goto u3TxO; O4mCI: $SQluy = !is_error($result); goto CGkpd; u3TxO: $this->params["\141\x70\151\156\x61\x6d\x65"] = "\117\160\145\x6e\x5f\x70\162\x69\156\164\x4d\x73\147"; goto DbfsU; OioNx: return error(-1, "\xe9\224\231\xe8\xaf\257\x3a\x20{$result["\155\145\x73\163\x61\147\145"]}"); goto dWusc; DbfsU: $this->params["\143\157\x6e\x74\145\156\x74"] = implode($content); goto ON6E3; jzvpk: return $result; goto Z122Z; jugeG: $result = ihttp_post($this->api, $this->params); goto O4mCI; Z122Z: } public function queryOrderStateAction($orderindex) { goto pcmcN; pcmcN: $this->params["\x61\160\x69\x6e\141\x6d\145"] = "\x4f\160\x65\x6e\137\161\165\x65\x72\171\x4f\162\144\145\162\x53\x74\141\x74\x65"; goto OUIOI; rMMLH: $result = ihttp_post($this->api, $this->params); goto lAIe8; m0fn8: if ($SQluy) { goto Kfttt; } goto kcwRo; cxKiK: return $result; goto kzmu0; kcwRo: return error(-1, "\xe9\224\231\350\xaf\xaf\72\x20{$result["\x6d\145\x73\163\x61\147\x65"]}"); goto CZCOK; CZCOK: Kfttt: goto OBYDE; OUIOI: $this->params["\x6f\x72\144\145\x72\x69\144"] = $orderindex; goto rMMLH; lAIe8: $SQluy = !is_error($result); goto m0fn8; OBYDE: $result = @json_decode($result["\143\157\x6e\164\145\156\164"], true); goto cxKiK; kzmu0: } public function queryPrinterStatusAction() { goto kOTTT; Yp2OO: $result = @json_decode($result["\143\157\x6e\x74\145\x6e\x74"], true); goto TZxB8; TZxB8: return $result; goto txKuk; Dk8Wc: $result = ihttp_post($this->api, $this->params); goto BMZKZ; kOTTT: $this->params["\141\x70\151\156\x61\155\x65"] = "\x4f\x70\x65\156\137\x71\165\145\162\171\x50\162\151\156\164\x65\x72\x53\164\141\x74\165\163"; goto k33sx; bG2_u: EkXad: goto Yp2OO; k33sx: $this->params["\x73\156"] = $this->sn; goto Dk8Wc; b6XRb: if ($SQluy) { goto EkXad; } goto T2H2J; T2H2J: return error(-1, "\xe9\x94\x99\350\257\257\x3a\x20{$result["\x6d\145\x73\x73\x61\147\145"]}"); goto bG2_u; BMZKZ: $SQluy = !is_error($result); goto b6XRb; txKuk: } }