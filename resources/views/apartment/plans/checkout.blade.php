<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Complete Payment - ApartmentHub</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="min-h-screen bg-slate-950 text-white">

    {{-- =========================================================
        PAGE
    ========================================================== --}}

    <div class="min-h-screen">


        {{-- =====================================================
            HEADER
        ====================================================== --}}

        <header class="border-b border-slate-800 bg-slate-950">

            <div
                class="mx-auto flex max-w-7xl items-center
                       justify-between px-6 py-5
                       lg:px-10">

                <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight">

                    <span class="text-white">Apartment</span><span class="text-blue-500">Hub</span>

                </a>


                <div class="text-sm text-slate-500">

                    Secure Payment

                </div>

            </div>

        </header>



        {{-- =====================================================
            MAIN
        ====================================================== --}}

        <main class="mx-auto max-w-4xl px-6 py-16 lg:px-8">


            {{-- HEADING --}}

            <div class="text-center">

                <p class="text-sm font-semibold uppercase
                          tracking-widest text-blue-400">

                    Complete Your Payment

                </p>


                <h1 class="mt-4 text-4xl font-bold tracking-tight">

                    Choose {{ $plan['name'] }}

                </h1>


                <p class="mt-4 text-slate-400">

                    Complete the secure payment to continue
                    with your apartment setup.

                </p>

            </div>



            {{-- =================================================
                PAYMENT CARD
            ================================================== --}}

            <div
                class="mx-auto mt-12 max-w-2xl rounded-2xl
                       border border-slate-800
                       bg-slate-900
                       p-8 shadow-xl">


                {{-- PLAN DETAILS --}}

                <div
                    class="flex items-center justify-between
                           border-b border-slate-800
                           pb-6">

                    <div>

                        <p class="text-sm text-slate-500">
                            Selected Plan
                        </p>

                        <h2 class="mt-1 text-xl font-semibold">

                            {{ $plan['name'] }}

                        </h2>

                    </div>


                    <div class="text-right">

                        <p class="text-3xl font-bold">

                            ₹{{ number_format($plan['amount']) }}

                        </p>

                        <p class="text-sm text-slate-500">

                            / {{ $plan['duration_days'] }} days

                        </p>

                    </div>

                </div>



                {{-- FEATURES --}}

                <div class="py-6">

                    <p class="mb-4 text-sm font-semibold text-slate-300">

                        Plan includes:

                    </p>


                    @if ($selectedPlan === '399')
                        <div class="grid gap-3 sm:grid-cols-2">

                            <div class="flex gap-3 text-sm text-slate-300">
                                <span class="text-blue-400">✓</span>
                                Single property management
                            </div>

                            <div class="flex gap-3 text-sm text-slate-300">
                                <span class="text-blue-400">✓</span>
                                Building / block management
                            </div>

                            <div class="flex gap-3 text-sm text-slate-300">
                                <span class="text-blue-400">✓</span>
                                Flats & units
                            </div>

                            <div class="flex gap-3 text-sm text-slate-300">
                                <span class="text-blue-400">✓</span>
                                Resident management
                            </div>

                            <div class="flex gap-3 text-sm text-slate-300">
                                <span class="text-blue-400">✓</span>
                                Maintenance management
                            </div>

                            <div class="flex gap-3 text-sm text-slate-300">
                                <span class="text-blue-400">✓</span>
                                Complaints & notices
                            </div>

                        </div>
                    @elseif ($selectedPlan === '999')
                        <div class="grid gap-3 sm:grid-cols-2">

                            <div class="flex gap-3 text-sm text-slate-300">
                                <span class="text-purple-400">✓</span>
                                Multiple property management
                            </div>

                            <div class="flex gap-3 text-sm text-slate-300">
                                <span class="text-purple-400">✓</span>
                                Owner dashboard
                            </div>

                            <div class="flex gap-3 text-sm text-slate-300">
                                <span class="text-purple-400">✓</span>
                                Building / block management
                            </div>

                            <div class="flex gap-3 text-sm text-slate-300">
                                <span class="text-purple-400">✓</span>
                                Flats & units
                            </div>

                            <div class="flex gap-3 text-sm text-slate-300">
                                <span class="text-purple-400">✓</span>
                                Resident management
                            </div>

                            <div class="flex gap-3 text-sm text-slate-300">
                                <span class="text-purple-400">✓</span>
                                Maintenance management
                            </div>

                            <div class="flex gap-3 text-sm text-slate-300">
                                <span class="text-purple-400">✓</span>
                                Complaints & notices
                            </div>

                            <div class="flex gap-3 text-sm text-slate-300">
                                <span class="text-purple-400">✓</span>
                                Property-wise reports
                            </div>

                        </div>
                    @endif

                </div>



                {{-- =================================================
                    PAYMENT BUTTON
                ================================================== --}}

                <div class="border-t border-slate-800 pt-6">

                    <button id="pay-button" type="button"
                        class="w-full rounded-xl
                               bg-blue-600
                               px-5 py-4
                               text-sm font-semibold
                               text-white
                               transition
                               hover:bg-blue-500
                               disabled:cursor-not-allowed
                               disabled:opacity-60">

                        Pay ₹{{ number_format($plan['amount']) }}

                    </button>


                    <div class="mt-4 flex items-center justify-center gap-2">

                        <span class="text-xs text-slate-500">
                            🔒 Secure payment powered by Razorpay
                        </span>

                    </div>

                </div>

            </div>



            {{-- BACK --}}

            <div class="mt-8 text-center">

                <a href="{{ route('apartment.plans') }}"
                    class="text-sm text-slate-500 transition
                           hover:text-slate-300">

                    ← Back to plans

                </a>

            </div>

        </main>

    </div>



    {{-- =========================================================
        RAZORPAY
    ========================================================== --}}

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>


    <script>
        const payButton = document.getElementById('pay-button');


        payButton.addEventListener('click', function() {

            payButton.disabled = true;

            payButton.innerText = 'Opening Payment...';


            const options = {

                key: "{{ config('services.razorpay.key') }}",

                amount: "{{ $order['amount'] }}",

                currency: "{{ $order['currency'] }}",

                name: "ApartmentHub",

                description: "{{ $plan['name'] }}",

                order_id: "{{ $order['id'] }}",


                handler: function(response) {

                    submitPayment(response);

                },


                modal: {

                    ondismiss: function() {

                        payButton.disabled = false;

                        payButton.innerText =
                            "Pay ₹{{ number_format($plan['amount']) }}";

                    }

                },


                theme: {

                    color: "#2563eb"

                }

            };


            const razorpay = new Razorpay(options);


            razorpay.on('payment.failed', function(response) {

                alert(
                    response.error.description ||
                    'Payment failed. Please try again.'
                );


                payButton.disabled = false;

                payButton.innerText =
                    "Pay ₹{{ number_format($plan['amount']) }}";

            });


            razorpay.open();

        });



        function submitPayment(response) {

            const form = document.createElement('form');

            form.method = 'POST';

            form.action =
                "{{ route('apartment.plans.payment.verify') }}";


            const csrf = document.createElement('input');

            csrf.type = 'hidden';

            csrf.name = '_token';

            csrf.value =
                "{{ csrf_token() }}";


            const paymentId = document.createElement('input');

            paymentId.type = 'hidden';

            paymentId.name = 'razorpay_payment_id';

            paymentId.value =
                response.razorpay_payment_id;


            const orderId = document.createElement('input');

            orderId.type = 'hidden';

            orderId.name = 'razorpay_order_id';

            orderId.value =
                response.razorpay_order_id;


            const signature = document.createElement('input');

            signature.type = 'hidden';

            signature.name = 'razorpay_signature';

            signature.value =
                response.razorpay_signature;


            form.appendChild(csrf);

            form.appendChild(paymentId);

            form.appendChild(orderId);

            form.appendChild(signature);


            document.body.appendChild(form);

            form.submit();

        }
    </script>

</body>

</html>
