<?php

namespace Yangbx\CaptchaLumen;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Cache;
/**
 * Class CaptchaController
 * @package Mews\Captcha
 */
class LumenCaptchaController extends Controller
{

    /**
     * get CAPTCHA
     *
     * @param \Yangbx\CaptchaLumen\CaptchaService $captcha
     * @param string $config
     * @param $captchaId
     * @return \Intervention\Image\ImageManager->response
     */

    public function getCaptcha(Captcha $captcha, $type = 'default', $captchaId)
    {
        if(!Cache::has($captchaId))
        {
            return Response('', 403);
        }else{
            Cache::forget($captchaId);
        }
        return $captcha->createById($type, $captchaId);
    }

    /**
     * get CAPTCHA getCaptchaInfo API
     * @param Request $request
     * @param string $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCaptchaInfo(Request $request, $type = 'default')
    {
        if (!env('docker')) {
            $urlDomain = substr(str_replace($request->decodedPath(), '', $request->url()), 0, -1);
        } else {
            $url = parse_url($request->headers->get('referer'));
            $urlDomain =  isset($url['scheme']) && !empty($url['scheme']) ?
                $url['scheme']."://".$url['host'] : $url['host'];
        }
        
        $captchaUuid = $this->generate_uuid();

        Cache::put($captchaUuid,md5(uniqid(rand(), true)),5);

        $captchaData = [
            'captchaUrl'=>$urlDomain.'/api/captcha/'.$type.'/'.$captchaUuid,
            'captchaUuid'=>(string)$captchaUuid
        ];
        return response()->json($captchaData);
    }

    /**
     * generatge UUID
     * @return string
     */
    function generate_uuid(){
        $charId = md5(uniqid(rand(), true));
        $hyphen = chr(45);// "-"
        $uuid = substr($charId, 0, 8).$hyphen
            .substr($charId, 8, 4).$hyphen
            .substr($charId, 12, 4).$hyphen
            .substr($charId, 16, 4).$hyphen
            .substr($charId, 20, 12);
        return $uuid;
    }



}
