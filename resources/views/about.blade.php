<x-app-layout>
    <x-slot name="header">
        {{ __('About us') }}
    </x-slot>

    <div class="bg-black overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-red-700 text-white text-center font-bold"
            style="padding-bottom: 5%; padding-top: 5%;text-align:-webkit-center;">
            <image src="/assets/BFP.png"/>
            <h4 style="margin-top: 2%">ABOUT BFP</h4>
        </div>
        <div class="p-6 border-b border-red-700 text-white text-center font-bold">
            {{ __('BFP VISION') }}
        </div>
        <div class="p-6 border-b border-red-700 text-white text-center font-bold"
            style="padding-bottom: 5%; padding-top: 5%">
            A modern fire service fully capable of ensuring a fire safe nation by 2034.
        </div>
        <div class="p-6 border-b border-red-700 text-white text-center font-bold">
            {{ __('BFP MISSION') }}
        </div>
        <div class="p-6 border-b border-red-700 text-white text-center font-bold"
            style="padding-bottom: 5%; padding-top: 5%">
            We commit to prevent and suppress destructive fires, investigate its causes; enforce Fire code and other
            related laws; respond to man-made and natural disasters and other emergencies.
        </div>
    </div>
</x-app-layout>