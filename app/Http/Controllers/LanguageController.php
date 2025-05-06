<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Xử lý yêu cầu thay đổi ngôn ngữ
     *
     * @param  string  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch($locale)
    {
        // Thêm log để debug
        \Log::info('LanguageController::switch called with locale: ' . $locale);
        
        // Xác thực locale có nằm trong danh sách ngôn ngữ hỗ trợ hay không
        $availableLocales = ['en', 'vi'];
        
        if (in_array($locale, $availableLocales)) {
            // Lưu locale vào session
            Session::put('locale', $locale);
            // Thiết lập ngôn ngữ hiện tại
            App::setLocale($locale);
            
            // Debug log
            \Log::info('Language switched to: ' . $locale);
            \Log::info('Session locale after switch: ' . Session::get('locale'));
            \Log::info('App locale after switch: ' . App::getLocale());
            \Log::info('Session ID: ' . Session::getId());
        }
        
        // Chuyển hướng người dùng quay lại trang trước đó
        return redirect()->back();
    }
}