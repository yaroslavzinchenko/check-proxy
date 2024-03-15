<?php
declare(strict_types=1);

namespace App\Actions;

use Illuminate\Foundation\Http\FormRequest as Request;

class CheckProxyAction {
    public function execute(string $url, int $timeout, array $proxyTypes, string $proxyStr, Request $request): array {
        $result = ['ip:port: ' => $proxyStr,];
        $loadingTime = microtime(true);

        $theHeader = curl_init($url);
        curl_setopt($theHeader, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($theHeader, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($theHeader, CURLOPT_PROXY, $proxyStr);
        curl_setopt($theHeader, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($theHeader, CURLOPT_SSL_VERIFYPEER, 0);
        foreach ($proxyTypes as $proxyType) {
            curl_setopt($theHeader, CURLOPT_PROXYTYPE, $proxyType);
            $curlResponse = curl_exec($theHeader);
            if ($curlResponse === false) {
                $result['Status: '] = 'Not working.';
            } else {
                if ($proxyType === CURLPROXY_HTTP) {
                    $type = 'http';
                } else {
                    $type = 'socks';
                }
                $result['Proxy type: '] = $type;
                $result['Status: '] = 'Working.';
                $result['Timeout: '] = floor((microtime(true) - $loadingTime) * 1000);

                if ($request->server('HTTP_X_FORWARDED_FOR')) {
                    $result['Real ip: '] = $request->server('HTTP_X_FORWARDED_FOR');
                } elseif ($request->server('REMOTE_ADDR')) {
                    $result['Real ip: '] = $request->server('REMOTE_ADDR');
                } elseif ($request->server('HTTP_CLIENT_IP')) {
                    $result['Real ip: '] = $request->server('HTTP_CLIENT_IP');
                }
            }
        }

        return $result;
    }
}
