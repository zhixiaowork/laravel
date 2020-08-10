<?php

/**
 * api格式化
 *
 * @param int    $code    返回码
 * @param string $message 返回说明
 * @param object|array $data    返回数据
 *
 * @return array
 */
function apiFormat($code, $message, $data)
{
    $res['code'] = $code;
    $res['message'] = $message;
    if ($data == '') {
        $data = (object)[];
    }
    $res['data'] = $data;

    return $res;
}

/**
 * api里的api统一返回
 *
 * @param int    $code    返回码
 * @param string $message 返回说明
 * @param string $data    返回数据
 * @param boolean $log    是否记录日志
 *
 * @return \Illuminate\Http\JsonResponse
 */
function apiReturn($code, $message, $data = '', $log = true)
{
    $guard = 'api';

    if (env('APP_LOG') && $log) {
        dispatch(new \App\Jobs\Log(compact('code', 'message', 'data', 'guard')));
    }

    return response()->json(apiFormat($code, $message, $data), 200);
}


/**
 * 获取当前时间
 *
 * @return string
 */
function getNowTime()
{
    return date('Y-m-d H:i:s');
}

/**
 * 获取当前时间戳
 *
 * @return string
 */
function getNowTimestamp()
{
    return time();
}

/**
 * 时间戳转换为时间
 *
 * @param string    $timestamp    时间戳
 *
 * @return string
 */
function getTimeByTimestamp($timestamp)
{
    return date('Y-m-d H:i:s', $timestamp);
}

/**
 * 获取毫秒
 *
 * @return float
 */
function getMillisecond() {
    list($s1, $s2) = explode(' ', microtime());
    return (float)sprintf('%f', (floatval($s1) + floatval($s2)));
}

/**
 * curl get
 *
 * @param string $url 地址
 *
 * @return string
 */
function curlGet($url) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_USERAGENT, 'user_agent');
    $return = curl_exec($curl);
    curl_close($curl);

    return $return;
}

/**
 * curl get
 *
 * @param string $url 地址
 * @param array $data 数据
 *
 * @return string
 */
function curlPost($url, $data) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_USERAGENT, 'user_agent');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    $return = curl_exec($curl);
    curl_close($curl);

    return $return;
}

/**
 * 生成token
 *
 * @return string
 */
function generateToken()
{
    return md5(time().rand(1000, 9999));
}

/**
 * 获取api user ID
 *
 * @param string $token token
 *
 * @return int
 */
function getUserId()
{
    $token = Request::header('token');
    if ($token) {
        $user = App\Models\Token::where('token', $token)->first();
        $now = \Carbon\Carbon::now();
        if (! empty($user) && ($now < $user->expired_at)) {
            return $user->user_id;
        }
    }

    return 0;
}

/**
 * 获取当前api用户
 *
 * @param string $token token
 *
 * @return string
 */
function getUserInfo()
{
    $token = Request::header('token');
    if ($userId = getApiUserId($token)) {
        $user = App\Models\User::where('id', $userId)->first();
        return $user;
    }

    return [];
}

// 保留小数
function decimalFormat($number, $length = 1)
{
    return sprintf("%." . $length . "f", $number);
}
