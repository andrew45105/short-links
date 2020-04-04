<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;

/**
 * Class LinkController
 * @package App\Http\Controllers
 */
class LinkController extends Controller
{
    /**
     * Переход по короткой ссылке
     *
     * @param string $token
     *
     * @return RedirectResponse
     */
    public function get(string $token)
    {
        $link = DB::table('links')->where('token', $token)->first();
        if ($link) {
            // если ссылка существует, переходим по url
            return redirect($link->url);
        } else {
            // если ссылки нет, редиректим на главную
            return redirect()->route('index');
        }
    }

    /**
     * Создание короткой ссылки
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|unique:links|max:256'
        ]);

        $url = trim(strip_tags(request('url')));

        $validator->after(function ($validator) use ($url) {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $validator->errors()->add('url', 'Ссылка не соответствует формату!');
            }
        });

        $validator->validate();

        if ($validator->fails()) {
            // если не прошла валидация, то редиректим на главную
            return redirect()->route('index');
        }

        // генерируем токен ссылки
        $letters    = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $token      = substr(str_shuffle($letters),0, 6);

        $link           = new Link();
        $link->url      = $url;
        $link->token    = $token;
        $link->save();

        return redirect()->route('index');
    }
}
