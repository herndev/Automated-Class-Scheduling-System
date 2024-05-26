<?php

namespace App\Listeners;

use App\Events\NewPostAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class PlaySoundOnNewPost
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NewPostAdded $event)
    {
        // Get the post from the event
        $post = $event->post;

        // Play a sound (replace this with the appropriate sound command for your system)
        // exec('afplay ../../public/assets/alarm.mp3');
        // echo "<script>const audio = new Audio('assets/alarm.mp3'); audio.play();</script>";

        // You can also log a message or perform any other action here
        Log::info('Play Sound Activated! | By: '.auth()->user()->name);
    }
}
