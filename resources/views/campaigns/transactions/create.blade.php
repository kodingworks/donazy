<x-app>
    <header class="fixed top-0 inset-x-0 z-10">
        <x-bg-main>
            <x-container>
                <div class="flex items-center space-x-2 p-2">
                    <x-button-back />
                    <h3 class="line-clamp-1">{{ $campaign->name }}</h3>
                </div>
            </x-container>
        </x-bg-main>
    </header>

    <x-container>
        <main class="py-20">
            <form
                action="{{ route('campaigns.transactions.store', ['slug' => $campaign->slug]) }}"
                method="POST"
                x-data="FormComponent({
                    amount: '{{ old('amount') }}' ?? null,
                    name: '{{ old('name', $user->name ?? null) }}' ?? null,
                    payment_method_id: '{{ old('payment_method') }}' ?? null,
                    email: '{{ old('email', $user->email ?? null) }}' ?? null,
                    phone: '{{ old('phone', $user->phone ?? null) }}' ?? null,
                    message: '{{ old('name', $user->message ?? null) }}' ?? null,
                })"
                x-on:submit.prevent="handleSubmit"
            >
                @csrf
                <input type="hidden" name="meta" x-model="meta">
                <x-bg-main class="p-4">
                    <h3 class="text-center mb-4">Masukan nominal donasi</h3>
                    <div class="grid grid-cols-3 gap-2 mb-4">
                        @foreach ($amounts as $amount)
                            <button
                                type="button"
                                x-on:click="amount = {{ $amount }}"
                                x-bind:class="amount == {{ $amount }} ? 'border-primary' : 'border-gray-200'"
                                class="w-full px-3 py-2 font-semibold rounded border hover:border-primary focus:border-primary"
                            >
                                <span>@idr($amount)</span>
                            </button>
                        @endforeach
                    </div>
                    <div class="p-4 mb-4 rounded border border-gray-200">
                        <p class="text-sm mb-2">Nominal lain</p>
                        <label class="block w-full relative">
                            <span class="absolute top-0 left-0 bottom-0 px-3 py-2 font-semibold">Rp</span>
                            <input
                                type="number"
                                name="amount"
                                x-model="amount"
                                class="w-full pl-10 rounded border border-gray-200 focus:border-primary focus:ring-primary"
                            />
                        </label>
                    </div>
                    <div class="p-4 mb-4 rounded border border-gray-200 flex flex-col items-center">
                        <p>Metode Pembayaran</p>
                    <div class="flex flex-col gap-5">
                        <div class="inline-flex space-x-2">
                            <select
                                name="payment_method_id"
                                class="text-sm rounded font-semibold focus:border-primary focus:shadow-outline-primary"
                            >
                                @foreach ($paymentMethod as $paymentMethod)
                                    <option class="font-semibold" value="{{ $paymentMethod->id }}" @if($paymentMethod->id == $paymentMethod->id) selected @endif>{{ $paymentMethod->name }}, {{ $paymentMethod->account_holder_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <p
                            x-show="showCopiedFeedback"
                            class="text-xs text-primary"
                        >Tersalin</p>
                    </div>
                </div>
                    @if (!$user)
                        <div class="mb-4">
                            <p class="text-center">
                                <a href="{{ route('login') }}" class="text-primary">Masuk</a>
                                <span>atau isi form di bawah</span>
                            </p>
                        </div>
                    @else
                        <div class="mb-4">
                            <p class="text-center">Informasi Donatur</p>
                        </div>
                    @endif
                    <div class="mb-4">
                        <x-input
                            type="text"
                            name="name"
                            x-model="name"
                            placeholder="Nama"
                            class="w-full"
                        />
                    </div>
                    <div class="mb-4">
                        <x-input
                            type="email"
                            name="email"
                            x-model="email"
                            placeholder="Email"
                            class="w-full"
                        />
                    </div>
                    <div class="mb-4">
                        <x-input
                            type="text"
                            name="phone"
                            x-model="phone"
                            placeholder="Nomor HP (opsional)"
                            class="w-full"
                        />
                    </div>
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input
                                type="checkbox"
                                name="anonymous"
                                value="1"
                                class="text-primary focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray"
                            />
                            <span class="ml-2">Sembunyikan nama saya</span>
                        </label>
                    </div>
                    <div>
                        <textarea
                            name="message"
                            x-model="message"
                            rows="4"
                            placeholder="Pesan untuk program ini (opsional)"
                            class="w-full rounded-md shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                        ></textarea>
                    </div>
                </x-bg-main>

                <div class="p-4">
                    <button
                        type="submit"
                        x-bind:disabled="!isCanBeSubmitted()"
                        x-bind:class="isCanBeSubmitted() ? 'opacity-100' : 'opacity-50'"
                        class="block w-full py-2 px-3 rounded bg-primary text-white text-center font-semibold focus:outline-none"
                    >Lanjut pembayaran</button>
                </div>
            </form>
            <script>
                function FormComponent(props) {
                    return {
                        amount: props.amount,
                        name: props.name,
                        email: props.email,
                        phone: props.phone,
                        message: props.message,
                        meta: null,
                        showCopiedFeedback: false,
                        isAmountValid() {
                            return this.amount && this.amount >= {{ $minAmount }};
                        },
                        isNameValid() {
                            return Boolean(this.name);
                        },
                        isEmailValid() {
                            return /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(this.email);
                        },
                        isCanBeSubmitted() {
                            return this.isAmountValid() && this.isEmailValid();
                        },
                        copyToClipboard(value) {
                            var tempInput = document.createElement('input');
                            tempInput.value = value;
                            document.body.appendChild(tempInput);
                            tempInput.select();
                            document.execCommand('copy');
                            document.body.removeChild(tempInput);

                            this.showCopiedFeedback = true;

                            setTimeout(() => this.showCopiedFeedback = false, 1000);
                        },
                        handleSubmit(event) {
                            this.meta = document.querySelector('meta[name="subscription"]').getAttribute('content');

                            setTimeout(() => event.target.submit(), 350);
                        }
                    };
                }
            </script>
        </main>
    </x-container>
</x-app>
