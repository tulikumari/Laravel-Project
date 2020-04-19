<?php

namespace App\Helpers;

use App\Http\Controllers\Controller;
use App\Mail\ApproveMail;
use App\Mail\CelebrityAddMail;
use App\Mail\ForgotPasswordMail;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMail extends Controller
{
    /**
     * Send mail according to types
     *
     * @param array $mailData
     * @param integer $type
     * @return void
     */
    public static function mail(array $mailData, int $type)
    {
        try {
            switch ($type) {
                case config('config.CELEB_ADDED'):
                    Mail::to($mailData['to'])->queue(new CelebrityAddMail($mailData));
                    break;
                case config('config.CELEB_APPROVED'):
                    Mail::to($mailData['to'])->queue(new ApproveMail($mailData));
                    break;
                case config('config.FORGOT_PASS'):
                    Mail::to($mailData['to'])->queue(new ForgotPasswordMail($mailData));
                    break;
                case config('config.ADMIN_ADDED'):
                    Mail::to($mailData['to'])->queue(new AdminAddMail($mailData));
                    break;
                default:
                    throw new Exception(trans('celeb.noMailType'));
                    break;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
