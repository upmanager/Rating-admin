<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Auth;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;


class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sms_users = User::where('role', '!=', 0)->whereNotNull('phonenumber')->orderby('name')->get();
        $fcm_users = User::where('role', '!=', 0)->whereNotNull('fcm_token')->orderby('name')->get();
        $notifications = Notifications::select("*");
        if (Auth::user()->role != 0) {
            $notifications = $notifications->where('userid', Auth::user()->id);
        }
        $notifications = $notifications->orderby('created_at')->get();
        return view('notifications.index', compact('notifications', 'sms_users', 'fcm_users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $users = $request->fcm_users;
        $content = $request->content;
        $notify_type = $request->rad_notify;
        $type = 0;
        if ($notify_type == "sms") {
            $users = $request->sms_users;
            $type = 1;
        } else {
            $tokens = User::whereIn('id', $users)->pluck('fcm_token')->toArray();
            $this->sendFCM($content, $tokens);
        }
        foreach ($users as $key => $value) {
            Notifications::create(['userid' => $value, 'content' => $content, 'type' => $type]);
        }
        return redirect()->route('notifications.index')->withStatus(__('Successfully sent.'));
    }
    public function sendFCM($content, $tokens)
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder('Notification');
        $notificationBuilder->setBody($content)->setSound('default');
        $dataBuilder = new PayloadDataBuilder();

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notifications  $notifications
     * @return \Illuminate\Http\Response
     */
    public function show(Notifications $notifications)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notifications  $notifications
     * @return \Illuminate\Http\Response
     */
    public function edit(Notifications $notifications)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notifications  $notifications
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notifications $notifications)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notifications  $notifications
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notifications $notifications)
    {
        //
    }
}
