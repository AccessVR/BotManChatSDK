<?php

use OrchestrateXR\BotManChatSDK\BotManChat;
use Illuminate\Http\Request;

Route::get(BotManChat::config('frameEndpoint'), function (Request $request) {
    return BotManChat::view('chat', ['config' => ['isMobile' => $request->isMobile]]);
})->name('botman-web-widget.chat');

Route::get(BotManChat::config('beaconEndpoint'), function (Request $request) {
    return BotManChat::view('beacon', ['config' => ['isMobile' => $request->isMobile]]);
})->name('botman-web-widget.beacon');