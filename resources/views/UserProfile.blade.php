<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    {{-- @include('profile.partials.update-profile-information-form') --}}

                    <form method="POST" action="">
                        @csrf
                
                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                
                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                
                            <x-text-input id="password" class="block mt-1 w-full"
                                            type="password"
                                            name="password"
                                            required autocomplete="current-password" />
                
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Phone Number -->
                        <div class="mt-4">
                            <x-input-label for="PhoneNumber" :value="__('Phone Number')"/>
                            <x-text-input id="PhoneNumber" class="block mt-1 w-full" type="text" name="PhoneNumber"  />
                        </div>

                        <!-- Profile Picture -->
                        <div class="mt-4">
                            <x-input-label for="Profile_picture" :value="__('Profile Picture')"/>
                            <x-text-input id="Profile_picture" class="block mt-1 w-full" type="file" name="Profile_picture"  />
                        </div>

                        <!-- Location -->
                        <div class="mt-4">
                            <x-input-label for="Adress" :value="__('City/Adress')"/>
                            <x-text-input id="Adress" class="block mt-1 w-full" type="text" name="Adress"  />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="CV" :value="__('CV')"/>
                            <x-text-input id="CV" class="block mt-1 w-full" type="file" name="CV"  />
                        </div>

                        <x-primary-button class="mt-6">{{ __('Save') }}</x-primary-button>



                    </form>

                </div>
            </div>

            
        </div>
    </div>
</x-app-layout>