    <nav class="flex items-center justify-between py-3 px-6 border-b border-gray-100">
        <div id="nav-left" class="flex items-center">
            <a href="{{ route('home') }}">
                <x-application-mark />
            </a>
            <div class="top-menu ml-10">
                <div class="flex space-x-4">

                    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('posts.index') }}" :active="request()->routeIs('posts.index')">
                        {{ __('Blog') }}
                    </x-nav-link>

                </div>
            </div>
        </div>
        <div id="nav-right" class="flex items-center md:space-x-6">

            @auth
                @include('layouts.partials.header-right-auth')
            @else
                @include('layouts.partials.header-right-guest')
            @endauth



            <!-- theme switcher mainly for darkmode -->
            <div x-data="window.themeSwitcher()" x-init="switchTheme()" @keydown.window.tab="switchOn = false"
                class="flex items-center justify-center space-x-2">
                <input id="thisId" type="checkbox" name="switch" class="hidden" :checked="switchOn">

                <button x-ref="switchButton" type="button" @click="switchOn = ! switchOn; switchTheme()"
                    :class="switchOn ? 'bg-blue-600' : 'bg-neutral-200'"
                    class="relative inline-flex h-6 py-0.5 ml-4 focus:outline-none rounded-full w-10">
                    <span :class="switchOn ? 'translate-x-[18px]' : 'translate-x-0.5'"
                        class="w-5 h-5 duration-200 ease-in-out bg-white rounded-full shadow-md"></span>
                </button>

                <label @click="$refs.switchButton.click(); $refs.switchButton.focus()" :id="$id('switch')"
                    :class="{ 'text-blue-600': switchOn, 'text-gray-400': !switchOn }" class="text-sm select-none">
                    Dark Mode
                </label>
            </div>


        </div>
        </div>

        </div>
    </nav>
