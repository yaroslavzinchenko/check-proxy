<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CheckProxyAction;
use App\Actions\CheckProxyMultipleAction;
use App\Http\Requests\CheckProxyRequest;

class ProxyController extends Controller
{
    private string $url = "http://ya.ru/";

    private int $timeout = 30;

    private array $proxyTypes = [
        CURLPROXY_HTTP,
        CURLPROXY_SOCKS4,
        CURLPROXY_SOCKS5,
        CURLPROXY_SOCKS4A,
        CURLPROXY_SOCKS5_HOSTNAME
    ];

    public function checkProxy(
        CheckProxyRequest $request,
        CheckProxyAction $checkProxyAction,
        CheckProxyMultipleAction $checkProxyMultipleAction
    ) {
        $proxyStr = $request->input('proxy');
        //dd($proxyStr);
        $proxyArr = explode('\n', $proxyStr);
        if (count($proxyArr) === 1) {
            $result = $checkProxyAction->execute(
                $this->url,
                $this->timeout,
                $this->proxyTypes,
                $proxyStr,
                $request
            );
        } else {
            $result = $checkProxyMultipleAction->execute();
        }


        return view('check-proxy-result', ['result' => $result]);
    }
}
