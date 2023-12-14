<?php

namespace App\Jobs;

use App\Models\Advertisement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class testJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach (Advertisement::all() as $ad) {
            $ad->update(['hits' => $ad->hits * 2]);
        }
        foreach (Advertisement::all() as $ad) {
            $ad->update(['hits' => $ad->hits * 2]);
        }
        foreach (Advertisement::all() as $ad) {
            $ad->update(['hits' => $ad->hits / 2]);
        }
        foreach (Advertisement::all() as $ad) {
            $ad->update(['hits' => $ad->hits / 2]);
        }
        foreach (Advertisement::all() as $ad) {
            $ad->update(['hits' => $ad->hits / 2]);
        }
        foreach (Advertisement::all() as $ad) {
            $ad->update(['hits' => $ad->hits / 2]);
        }
    }
}
