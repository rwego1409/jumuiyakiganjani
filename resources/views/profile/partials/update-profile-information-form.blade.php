<section>
  <header>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
      {{ __('Profile Picture') }}
    </h2>
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
      {{ __('Update your profile image') }}
    </p>
  </header>

  <div class="flex flex-col items-center my-6">
    <div class="h-24 w-24 rounded-full bg-teal-500 flex items-center justify-center text-white text-xl font-medium mb-4">
      {{ isset($user->name) ? substr($user->name, 0, 2) : 'CC' }}
    </div>
    
    <form action="{{ route('profile.update-picture') }}" method="post" enctype="multipart/form-data" class="w-full">
      @csrf
      @method('patch')
      
      <div class="relative">
        <label for="profile_picture" class="w-full py-3 bg-teal-50 text-teal-500 rounded flex items-center justify-center cursor-pointer">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" />
          </svg>
          {{ __('Upload new image') }}
        </label>
        <input id="profile_picture" name="profile_picture" type="file" accept="image/jpeg,image/png" class="hidden" onchange="this.form.submit()">
      </div>
      
      <p class="text-center text-gray-500 text-sm mt-2">JPG or PNG. Max size 2MB.</p>
      <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
    </form>
  </div>
</section>

<section>
  <header>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
      {{ __('Profile Information') }}
    </h2>
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
      {{ __("Update your account's profile information and email address.") }}
    </p>
  </header>
  <form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
  </form>

  <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
    @csrf
    @method('patch')

    <!-- Name -->
    <div>
      <x-input-label for="name" :value="__('Name')" />
      <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
      <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <!-- Email -->
    <div>
      <x-input-label for="email" :value="__('Email')" />
      <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
      <x-input-error class="mt-2" :messages="$errors->get('email')" />
      
      @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div>
          <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
            {{ __('Your email address is unverified.') }}
            <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
              {{ __('Click here to re-send the verification email.') }}
            </button>
          </p>
          @if (session('status') === 'verification-link-sent')
            <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
              {{ __('A new verification link has been sent to your email address.') }}
            </p>
          @endif
        </div>
      @endif
    </div>

    <!-- Phone -->
    <div>
      <x-input-label for="phone" :value="__('Phone')" />
      <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" />
      <x-input-error class="mt-2" :messages="$errors->get('phone')" />
    </div>

    <!-- Address -->
    @if(isset($member))
    <div>
        <x-input-label for="address" :value="__('Address')" />
        <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $member->address)" />
        <x-input-error class="mt-2" :messages="$errors->get('address')" />
    </div>

    <!-- Birth Date -->
    <div>
        <x-input-label for="birth_date" :value="__('Birth Date')" />
        <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="old('birth_date', $member->birth_date)" />
        <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
    </div>

    <!-- Jumuiya Selection -->
    <div>
        <x-input-label for="jumuiya_id" :value="__('Community (Jumuiya)')" />
        <select id="jumuiya_id" name="jumuiya_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            @foreach ($jumuiyas as $jumuiya)
                <option value="{{ $jumuiya->id }}" {{ $member->jumuiya_id == $jumuiya->id ? 'selected' : '' }}>
                    {{ $jumuiya->name }}
                </option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('jumuiya_id')" />
    </div>
    @endif

    <div class="flex items-center gap-4">
      <x-primary-button>{{ __('Save') }}</x-primary-button>
      @if (session('status') === 'profile-updated')
        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
      @endif
    </div>
  </form>
</section>
