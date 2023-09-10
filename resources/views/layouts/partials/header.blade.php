    <header class="flex items-center justify-between py-3 px-6 border-b border-gray-100">
        <div id="header-left" class="flex items-center">
            <div class="text-gray-800 font-semibold">
                <span class="text-yellow-500 text-xl">&lt;YELO&gt;</span> Code
            </div>
            <div class="top-menu ml-10">
                <ul class="flex space-x-4">
                    <li>
                        <a class="flex space-x-2 items-center hover:text-yellow-900 text-sm text-yellow-500"
                            href="http://127.0.0.1:8000">
                            Home
                        </a>
                    </li>

                    <li>
                        <a class="flex space-x-2 items-center hover:text-yellow-500 text-sm text-gray-500"
                            href="http://127.0.0.1:8000/blog">
                            Blog
                        </a>
                    </li>

                    <li>
                        <a class="flex space-x-2 items-center hover:text-yellow-500 text-sm text-gray-500"
                            href="http://127.0.0.1:8000/blog">
                            About Us
                        </a>
                    </li>

                    <li>
                        <a class="flex space-x-2 items-center hover:text-yellow-500 text-sm text-gray-500"
                            href="http://127.0.0.1:8000/blog">
                            Contact Us
                        </a>
                    </li>

                    <li>
                        <a class="flex space-x-2 items-center hover:text-yellow-500 text-sm text-gray-500"
                            href="http://127.0.0.1:8000/blog">
                            Terms
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <div id="header-right" class="flex items-center md:space-x-6">

            @guest

                @include('layouts.partials.header-right-guest')
            @endguest

            @auth
                @include('layouts.partials.header-right-auth')
            @endauth

        <div x-data="window.themeSwitcher()" x-init="switchTheme()" @keydown.window.tab="switchOn = false" class="flex items-center justify-center space-x-2">
    <input id="thisId" type="checkbox" name="switch" class="hidden" :checked="switchOn">

    <button
        x-ref="switchButton"
        type="button"
        @click="switchOn = ! switchOn; switchTheme()"
        :class="switchOn ? 'bg-blue-600' : 'bg-neutral-200'"
        class="relative inline-flex h-6 py-0.5 ml-4 focus:outline-none rounded-full w-10">
        <span :class="switchOn ? 'translate-x-[18px]' : 'translate-x-0.5'" class="w-5 h-5 duration-200 ease-in-out bg-white rounded-full shadow-md"></span>
    </button>

    <label @click="$refs.switchButton.click(); $refs.switchButton.focus()" :id="$id('switch')"
        :class="{ 'text-blue-600': switchOn, 'text-gray-400': ! switchOn }"
        class="text-sm select-none">
        Dark Mode
    </label>
</div>


        </div>
        </div>

        </div>
    </header>
