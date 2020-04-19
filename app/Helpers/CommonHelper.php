<?php

namespace App\Helpers;

use App\Models\Admin;
use App\Models\Coupon;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * Description of ParcelHelper
 *
 * @author Appinventiv Technologies
 */
class CommonHelper
{

    public static function checkAjaxRequest(Request $request)
    {

        if (!$request->ajax()) {
            $response = [
                "CODE" => config('httpCodes.required'),
                "MESSAGE" => trans('celeb.noDirectAccess'),
                "RESULT" => [],
            ];

            (new Response($response, config('httpCodes.required')))->header('Content-Type', 'application/json')->send();
            exit;
        }
    }

    /**
     *
     * @param type $exception
     * @return type
     */
    public static function showException($exception)
    {
        $code = $exception->getCode() ? $exception->getCode() : 500;
        //setting message
        $message = self::isProduction() ? Config('ErrorCode.' . $code) : $exception->getMessage();

        $exceptionErrorResponse = [
            "CODE" => $code,
            "MESSAGE" => $message,
            "RESULT" => [],
            "LINE" => $exception->getLine(),
            "FILE" => $exception->getFile(),
        ];

        Log::error($exception->getMessage());
        $responseCode = (is_numeric($code) && $code > 0) ? $code : config('httpCodes.fail');
        (new Response($exceptionErrorResponse, $responseCode))->header('Content-Type', 'application/json')->send();
        exit;
    }

    /**
     *
     * @param array $post
     * @param array $rules
     */
    public static function validateRequest(array $post, array $rules)
    {
        $validator = Validator::make($post, $rules);
        if ($validator->fails()) {
            $validationErrorResponse = [
                "CODE"    => config('httpCodes.required'),
                "MESSAGE" => $validator->messages()->first(),
                "RESULT"  => [],
            ];
            (new Response($validationErrorResponse,config('httpCodes.success')))->header('Content-Type', 'application/json')->send();
            exit;
        }
    }

    /**
     * Send ajax success response
     * @param type $validator
     */
    public static function sendAjaxResponse($msg = 'Success!', $response = [], $code = 200)
    {
        $response = [
            'CODE' => $code,
            'MESSAGE' => $msg,
            'RESULT' => $response,
        ];

        (new Response($response, config('httpCodes.success')))->header('Content-Type', 'application/json')->send();
        exit;
    }

    /**
     * Send ajax exception
     * @param type $validator
     */
    public static function sendAjaxException($exception)
    {
        $response = [
            'CODE' => $exception->getCode(),
            'MESSAGE' => $exception->getMessage(),
            'LINE' => $exception->getLine(),
            'FILE' => $exception->getFile(),
            'RESULT' => [],
        ];
        Log::error($exception->getMessage());
        (new Response($response, config('httpCodes.serverError')))->header('Content-Type', 'application/json')->send();
        exit;
    }

    /**
     *
     * @param type $validator
     */
    public static function sendNewResponse(array $response, $code = 200)
    {
        (new Response($response, $code))->header('Content-Type', 'application/json')->send();
        exit;
    }

    /**
     *
     * @param type $response
     * @return type
     */
    public static function sendResponse(array $response, $code = 200)
    {
        try {
            return (new Response($response, $code))->send();
            exit;
        } catch (Exception $ex) {
            showException($ex);
        }
    }

    /**
     * to check Environment is Production or development or staging
     *
     * @return boolean
     */
    public static function isProduction()
    {
        $flag = true;
        // The environment is either local OR staging...
        if (app()->environment('local', 'staging')) {
            $flag = false;
        }
        return $flag;
    }

    /**
     * Used to set default values to needed array index
     * pass to array First for values and Second for default values with same indexes
     * If in value array index has value then Ok
     * Otherwise second array index value will set
     *
     *
     * @function defaultValue
     * @description To set default value to the arrays required fields
     *
     * @param array $value array to check values
     * @param array $default Array having default values
     */
    public static function defaultValue($value = array(), $default = array())
    {
        $response = array();
        foreach ($default as $key => $values) {
            $response[$key] = (isset($value[$key]) && !empty($value[$key])) ? $value[$key] : $default[$key];
        }
        return ($response);
    }

    /*
     * method to return all required values used for pagination
     *
     */

    public static function paginatorSubsets($limit = '', $page = '')
    {
        $page = !empty($page) ? $page : 1;
        return [
            !empty($limit) ? $limit : PAGE_LIMIT,
            $page,
            ($page - 1) * $limit,
        ];
    }

    /**
     * Used to set Validation messages
     *
     * @return Array
     */
    public static function validationMessage()
    {
        return [
            'required' => __('lang.required'),
            'required_with' => __('lang.required'),
            'numeric' => __('lang.numeric'),
            'unique' => __('lang.unique'),
            'integer' => __('lang.integer'),
            'date' => __('lang.date'),
            'courier_id.required_if' => 'The courier id field is required when package type is incoming',
            'package_status.unique' => 'This action is already performed',
            'signing_person_name.required_if' => 'Plesae provide sigining person name',
            'signature_image_url.required_if' => 'Plesae provide signature image',
            'courier_id_number.required_if' => 'Courier Id Number is required, when adding courier',
            'floor_rep_id.exists' => trans('Messages.noFloorReps'),
        ];
    }

    /**
     * Get User IP Address
     *
     * @return type
     */
    public static function getIp()
    {
        foreach (array(
            'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR',
        ) as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
    }

    /**
     * @function encryptDecrypt
     * @description A common function to encrypt or decrypt desired string
     *
     * @param string $string String to Encrypt
     * @param string $type option encrypt or decrypt the string
     * @return type
     */
    public static function encryptDecrypt($string, $type = 'encrypt')
    {

        if ($type == 'decrypt') {
            #$enc_string = decrypt_with_openssl($string);
            $enc_string = self::base64decryption($string);
        }
        if ($type == 'encrypt') {
            #$enc_string = encrypt_with_openssl($string);
            $enc_string = self::base64encryption($string);
        }
        return $enc_string;
    }

    /**
     * @funciton base64encryption
     * @description will Encrypt data in base64
     *
     * @param type $string
     */
    private static function base64encryption($string)
    {
        return base64_encode($string);
    }

    /**
     * @funciton base64decryption
     * @description will decrypt data in base64
     *
     * @param type $string
     */
    private static function base64decryption($string)
    {
        return base64_decode($string);
    }

    public static function accessDenied($msg)
    {
        $message = '' != $msg ? $msg : 'Access Denied';
        abort(ACCESS_DENIED, $message);
    }

    /**
     * phone formatting
     *
     * @param type $phone_number
     * @return type
     */
    public function formatTelephone($phoneNumber = '')
    {
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        if (strlen($phoneNumber) > 6) {
            //$countryCode = substr($phoneNumber, 0, strlen($phoneNumber)-10);
            $areaCode = substr($phoneNumber, 0, 3);
            $nextThree = substr($phoneNumber, 3, 3);
            $lastFour = substr($phoneNumber, 6);
            $phoneNumber = $areaCode . '-' . $nextThree . '-' . $lastFour;
        } else if (strlen($phoneNumber) > 3) {
            $areaCode = substr($phoneNumber, 0, 3);
            $nextThree = substr($phoneNumber, 3);
            $phoneNumber = $areaCode . '-' . $nextThree;
        }
        return $phoneNumber;
    }

    public function localeTime($utcDatetime, $format)
    {
        $gmt = session()->get('tz');
        //$utcDatetime = Carbon::createFromTimestampUTC($utcDatetime);
        return $utcDatetime->setTimezone($gmt)->format($format);
    }

    public function returnAgeByDob($dob)
    {
        $dobArr = explode('-', $dob);
        return Carbon::create($dobArr[0], $dobArr[1], $dobArr[2])->diff(Carbon::now())->format('%y years, %m months and %d days');
    }

    /**
     * To check if variable is set and not empty & replace with replacer
     *
     * @param [type] $param
     * @param string $replace
     * @return void
     */
    public static function ifEmpty($param, $replace = '')
    {
        if (!isset($param) || empty($param)) {
            $param = $replace;
        }

        return $param;
    }

    /**
     * To check key is exist & replace with replacer
     *
     * @param [type] $key
     * @param [type] $array
     * @param boolean $replace
     * @return boolean
     */
    public static function isKeyExists($key, array $array, $replace = false)
    {
        return array_key_exists($key, $array) ? $array[$key] : ($replace ? $replace : '');
    }

    /**
     *
     * @param type $response
     * @return type
     */
    public static function sendDataTableResponse(array $response, $code = 200)
    {
        return (new Response($response, $code))->header('Content-Type', 'application/json')->send();
    }
    /**
     * Localize a date to users timezone.
     *
     * @param null $dateField
     *
     * @return Carbon
     */
    public static function localize($dateField = null)
    {
        $dateValue = is_null($dateField) ? (Carbon::now()) : $dateField;

        return self::inUsersTimezone($dateValue);
    }

    /**
     * Change timezone of a carbon date.
     *
     * @param $dateValue
     *
     * @return Carbon
     */
    public static function inUsersTimezone($dateValue)
    {
        try {
            $carbon = new Carbon();
            $timezone = Session::get('timezone') ? (Session::get('timezone')) : 'UTC';
            $date = $carbon->createFromFormat('Y-m-d H:i:s', $dateValue, 'UTC');
            $date->setTimezone($timezone);
        } catch (Exception $ex) {
            $date = $carbon->createFromFormat('Y-m-d H:i:s', $dateValue, 'UTC');
            $date->setTimezone('UTC');
        }
        $date = $carbon->setTimeFromTimeString($date)->format('M d Y');

        return $date;
    }

    /**
     * Use to upload files on Amazon S3 server.
     *
     * @param file
     * @param string|prefix
     *
     * @return string|url
     */
    public static function uploadFile($file, $prefix = false)
    {

        if (!empty($file)) {
            $prefix ? $prefix : $prefix = config('config.PROJECT_NAME');
            $file_name = $prefix . '/' . time() . '.' . $file->getClientOriginalExtension();
            $uploaded = Storage::disk('s3')->put($file_name, file_get_contents($file), 'public');

            if ($uploaded) {
                return Storage::disk('s3')->url($file_name);
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    /**
     * Setting admin data to sesion
     *
     * @param [type] $admin
     * @return void
     */
    public static function setAdminToSession($admin)
    {
        $adminInfo = [
            'name' => $admin->name,
            'email' => $admin->email,
            'id' => $admin->_id,
            'profilePicUrl' => $admin->profilePicUrl,
            'permissions' => $admin->permissions,
            'userType' => $admin->userType,
        ];

        if (session_status() == PHP_SESSION_NONE) {
            ini_set('session.gc_maxlifetime', 7200);
            session_start();
        }
        $_SESSION['admin'] = $adminInfo;
    }

    public static function setTokenToSession($token)
    {
        if (session_status() == PHP_SESSION_NONE) {
            ini_set('session.gc_maxlifetime', 7200);
            session_start();
        }
        $_SESSION['token'] = $token;
    }

    /**
     * Get logged in user info
     *
     * @return array
     */
    public static function adminInfo(): array
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $admin = [
            'name' => '',
            'email' => '',
            'id' => '',
            'profilePicUrl' => '/assets/img/profiles/avatar-01.jpg',
            'permissions' => '',
        ];

        if (!empty($_SESSION['admin'])) {

            $adminInfo = Admin::find($_SESSION['admin']['id']);
            $admin['name'] = $adminInfo->name;
            $admin['email'] = $adminInfo->email;
            $admin['_id'] = $adminInfo->_id;
            $admin['profilePicUrl'] = $adminInfo->profilePicUrl;
            $admin['permissions'] = $adminInfo->permissions;
            $admin['password'] = $adminInfo->password;
        }

        return $admin;
    }

    /**
     * Download file
     *
     * @param [type] $file
     * @param [type] $name
     * @param string $mime_type
     * @return void
     */
    public static function outputFile($file, $name, $mime_type = '')
    {
        if (!is_readable($file)) {
            die('File not found or inaccessible!');
        }

        $size = filesize($file);
        $name = rawurldecode($name);
        $known_mime_types = array(
            "htm" => "text/html",
            "exe" => "application/octet-stream",
            "zip" => "application/zip",
            "doc" => "application/msword",
            "jpg" => "image/jpg",
            "php" => "text/plain",
            "xls" => "application/vnd.ms-excel",
            "ppt" => "application/vnd.ms-powerpoint",
            "gif" => "image/gif",
            "pdf" => "application/pdf",
            "txt" => "text/plain",
            "html" => "text/html",
            "png" => "image/png",
            "jpeg" => "image/jpg",
        );

        if ($mime_type == '') {
            $file_extension = strtolower(substr(strrchr($file, "."), 1));
            if (array_key_exists($file_extension, $known_mime_types)) {
                $mime_type = $known_mime_types[$file_extension];
            } else {
                $mime_type = "application/force-download";
            };
        };

        //turn off output buffering to decrease cpu usage
        @ob_end_clean();

        // required for IE, otherwise Content-Disposition may be ignored
        if (ini_get('zlib.output_compression')) {
            ini_set('zlib.output_compression', 'Off');
        }

        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: attachment; filename="' . $name . '"');
        header("Content-Transfer-Encoding: binary");
        header('Accept-Ranges: bytes');

        // multipart-download and download resuming support
        if (isset($_SERVER['HTTP_RANGE'])) {
            list($a, $range) = explode("=", $_SERVER['HTTP_RANGE'], 2);
            list($range) = explode(",", $range, 2);
            list($range, $range_end) = explode("-", $range);
            $range = intval($range);
            if (!$range_end) {
                $range_end = $size - 1;
            } else {
                $range_end = intval($range_end);
            }

            $new_length = $range_end - $range + 1;
            header("HTTP/1.1 206 Partial Content");
            header("Content-Length: $new_length");
            header("Content-Range: bytes $range-$range_end/$size");
        } else {
            $new_length = $size;
            header("Content-Length: " . $size);
        }

        /* Will output the file itself */
        $chunksize = 1 * (1024 * 1024); //you may want to change this
        $bytes_send = 0;
        if ($file = fopen($file, 'r')) {
            if (isset($_SERVER['HTTP_RANGE'])) {
                fseek($file, $range);
            }

            while (
                !feof($file) && (!connection_aborted()) && ($bytes_send < $new_length)
            ) {
                $buffer = fread($file, $chunksize);
                echo ($buffer);
                flush();
                $bytes_send += strlen($buffer);
            }
            fclose($file);
        } else
        //If no permissiion
        {
            die('Error - can not open file.');
        }

        //die
        die();
    }

    public static function getRandomNumber($length):string
    {
        $isUniqueCode = 0;
        while($isUniqueCode==0){
            $str_result   = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            $randomNumber = substr(str_shuffle($str_result), 0, $length);
            $couponData   = Coupon::where('code',$randomNumber)->get();
            if ($couponData->count()<1) {
                $isUniqueCode = 1;
            }
        }
        return $randomNumber;
    }



    public static function dde($e)
    {
        dd($e->getMessage(), $e->getFile(), $e->getLine());
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function invalidImage()
    {
        return 'https://dummyimage.com/200x200/401c2e/f2eff2.png&text=Invalid+Image';
    }

    public static function arrayToCSV($array, $header ="",$download = "")
    {
        if ($download != "")
        {
            $fp = fopen('php://output', 'w');
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename='.$download);
        }
        ob_start();
        $n = 0;
        // put header
        if(!fputcsv($fp, $header))
        {
                show_error("Can't write line $n: $line");
        }

        // put data
        foreach ($array as $line)
        {
            $n++;
            if (!fputcsv($fp, $line))
            {
                show_error("Can't write line $n: $line");
            }
        }
        fclose($fp) or show_error("Can't close php://output");
        $str = ob_get_contents();
        ob_end_clean();
        if ($download == "")
        {
            return $str;
        }
        else
        {
            echo $str;
        }
    }


   public static function callAPI($method, $url, $data="",$headers = false){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        switch ($method){
        case "POST":
            curl_setopt($curl, CURLOPT_POST, true);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode($data));
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        if(!$headers){
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
            'Content-Type: application/json',
            ));
        }else{
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            $headers
            ));
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        // EXECUTE:
        $result = curl_exec($curl);
        $result = json_decode($result,true);
        curl_close($curl);
        return $result;
    }
}
