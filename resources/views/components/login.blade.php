<x-layout>
    <div class="w-1/4 bg-white mx-auto mt-10 p-3 px-10 rounded h-80">
        <h1 class="text-center font-bold">Login</h1>

        <form method="POST" action="/login">
{{--            @csrf--}}
            {{ csrf_field() }}

            <div class="mt-5">
                <div class="w-full">
                    <label class="hidden" for="email"><?= __('Email') ?></label>
                    <input class="p-2 w-full border-solid border border-black border-round" type="email" name="email"
                           id="email" placeholder="Email">
                    @if($errors->has('email') && $errors->get('email'))
                        <p>{{$errors->get('email')[0] }}</p>
                    @endif
                </div>
            </div>
            <div class="mt-5">
                <div class="w-full">
                    <label class="hidden" for="password"><?= __('Password') ?></label>
                    <input class="p-2 w-full border-solid border border-black border-round" type="password"
                           name="password" id="password" placeholder="Password">
                    @if($errors->has('password') && $errors->get('password'))
                        <p>{{$errors->get('password')[0] }}</p>
                    @endif
                </div>
            </div>

            <div class="mt-10 rounded">
                <button class="font-bold rounded w-full p-3 bg-sky-500"><?= __('Submit') ?></button>
            </div>

            @if($errors->has('credentials') && $errors->get('credentials'))
                <p>{{$errors->get('credentials')[0] }}</p>
            @endif
        </form>
    </div>
</x-layout>
