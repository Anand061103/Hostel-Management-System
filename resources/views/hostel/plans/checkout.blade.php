<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Complete Payment - HostelHub</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="min-h-screen bg-slate-950 text-white">


    <div class="min-h-screen flex items-center justify-center px-6">

        <div class="w-full max-w-lg">


            {{-- LOGO --}}

            <div class="text-center mb-8">

                <a href="{{ route('home') }}" class="text-3xl font-bold">
                    <span class="text-white">Hostel</span><span class="text-blue-500">Hub</span>
                </a>

            </div>


            {{-- PAYMENT CARD --}}

            <div
                class="rounded-2xl
                       border border-slate-800
                       bg-slate-900
                       p-8
                       shadow-2xl">

                <div class="text-center">


                    <p
                        class="text-sm uppercase
                               tracking-widest
                               text-blue-400">
                        Complete Payment
                    </p>


                    <h1 class="mt-3 text-3xl
                               font-bold">
                        {{ $planName }}
                    </h1>


                    <div class="mt-6">

                        <span class="text-5xl font-bold">
                            ₹{{ number_format($planAmount) }}
                        </span>

                        <span class="text-slate-500">
                            / month
                        </span>

                    </div>


                    <p
                        class="mt-4 text-sm
                               leading-6
                               text-slate-400">
                        Complete your payment to continue
                        with hostel setup.
                    </p>


                    {{-- PAY BUTTON --}}

                    <button id="pay-button" type="button"
                        class="mt-8 w-full rounded-xl
                               bg-blue-600
                               px-6 py-4
                               text-sm font-semibold
                               text-white
                               transition
                               hover:bg-blue-500">
                        Pay ₹{{ number_format($planAmount) }}
                    </button>


                    <p class="mt-5 text-xs
                               text-slate-600">
                        Secure payment powered by Razorpay
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- Razorpay Checkout --}}

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>


    <script>
        const payButton = document.getElementById('pay-button');


        payButton.addEventListener('click', function() {

            payButton.disabled = true;

            payButton.innerText = 'Opening Payment...';


            const options = {

                key: @json($key),

                amount: @json($amount),

                currency: 'INR',

                name: 'HostelHub',

                description: @json($planName),

                order_id: @json($orderId),


                prefill: {

                    name: @json($signupData['name'] ?? ''),

                    email: @json($signupData['email'] ?? ''),

                    contact: @json($signupData['mobile_number'] ?? ''),

                },


                theme: {

                    color: '#2563eb',

                },


                handler: function(response) {


                    /*
                    |--------------------------------------------------------------------------
                    | Send Payment Response To Laravel
                    |--------------------------------------------------------------------------
                    */

                    const form = document.createElement('form');

                    form.method = 'POST';

                    form.action =
                        @json(route('hostel.plans.payment.verify'));


                    const csrf = document.createElement('input');

                    csrf.type = 'hidden';

                    csrf.name = '_token';

                    csrf.value =
                        @json(csrf_token());

                    form.appendChild(csrf);


                    const paymentId =
                        document.createElement('input');

                    paymentId.type = 'hidden';

                    paymentId.name =
                        'razorpay_payment_id';

                    paymentId.value =
                        response.razorpay_payment_id;

                    form.appendChild(paymentId);


                    const orderId =
                        document.createElement('input');

                    orderId.type = 'hidden';

                    orderId.name =
                        'razorpay_order_id';

                    orderId.value =
                        response.razorpay_order_id;

                    form.appendChild(orderId);


                    const signature =
                        document.createElement('input');

                    signature.type = 'hidden';

                    signature.name =
                        'razorpay_signature';

                    signature.value =
                        response.razorpay_signature;

                    form.appendChild(signature);


                    document.body.appendChild(form);

                    form.submit();

                },


                modal: {

                    ondismiss: function() {

                        payButton.disabled = false;

                        payButton.innerText =
                            'Pay ₹{{ number_format($planAmount) }}';

                    }

                }

            };


            const razorpay =
                new Razorpay(options);


            razorpay.open();

        });
    </script>

</body>

</html>
