<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config('app.name', '') }}</title>

        {{-- Si tu proyecto no usa Vite, puedes eliminar esta línea --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @fluxAppearance
    </head>

    <body class="min-h-screen bg-white font-sans antialiased dark:bg-neutral-900 dark:text-neutral-100">
        <div class="grid min-h-screen grid-cols-1 lg:grid-cols-2">
            {{-- Columna izquierda --}}
            <div class="relative hidden overflow-hidden p-8 lg:flex lg:flex-col lg:justify-between">
                {{-- Imagen centrada --}}
                <img
                    src="{{ asset('img/logo.png') }}"
                    alt="logo"
                    class="pointer-events-none absolute inset-0 h-full w-full object-contain object-center"
                />

                <a
                    href="{{ route('home') }}"
                    class="relative z-20 flex items-center gap-2 font-medium"
                    wire:navigate
                >
                    <span class="flex h-9 w-9 items-center justify-center rounded-md">
                        {{-- <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" /> --}}
                    </span>

                    {{ config('app.name', 'Laravel') }}
                </a>

                @php
                    [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
                @endphp

                <div class="relative z-20 mt-auto">
                    {{-- <blockquote class="space-y-2">
                        <flux:heading size="lg">
                            &ldquo;{{ trim($message) }}&rdquo;
                        </flux:heading>

                        <footer>
                            <flux:heading>
                                {{ trim($author) }}
                            </flux:heading>
                        </footer>
                    </blockquote> --}}
                </div>
            </div>

            {{-- Columna derecha --}}
            <div class="w-full lg:p-8">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                    <a
                        href="{{ route('home') }}"
                        class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden"
                        wire:navigate
                    >
                        <span class="flex h-9 w-9 items-center justify-center rounded-md">
                            {{-- <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" /> --}}
                        </span>

                        <span class="sr-only">{{ config('app.name', 'Iutepal') }}</span>
                    </a>

                    {{ $slot }}
                </div>
            </div>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>