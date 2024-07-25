<x-frontend.app-layout>
    @section('title')
        {{ localize('Order Success') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
    @endsection

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Khand:wght@500&display=swap');

    .wrapperAlert {
      width: 60%;
      height: 410px;
      overflow: hidden;
      border-radius: 12px;
      border: thin solid #ddd;
      margin: 0 auto ;
    }

    .topHalf {
      /* width: 100%; */
      color: white;
      overflow: hidden;
      position: relative;
      padding: 40px 0;
      background: rgb(0, 0, 0);
      background: -webkit-linear-gradient(45deg, #019871, #a0ebcf);
    }

    svg {
      fill: white;
    }

    .topHalf h1 {
      font-size: 2rem;
      display: block;
      font-weight: 500;
      letter-spacing: 0.15rem;
      text-shadow: 0 2px rgba(128, 128, 128, 0.6);
    }

    .bg-bubbles {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1;
    }

    li {
      position: absolute;
      list-style: none;
      display: block;
      width: 40px;
      height: 40px;
      background-color: rgba(255, 255, 255, 0.15);
      /* fade(green, 75%);*/
      bottom: -160px;

      -webkit-animation: square 20s infinite;
      animation: square 20s infinite;

      -webkit-transition-timing-function: linear;
      transition-timing-function: linear;
    }

    li:nth-child(1) {
      left: 10%;
    }

    li:nth-child(2) {
      left: 20%;

      width: 80px;
      height: 80px;

      animation-delay: 2s;
      animation-duration: 17s;
    }

    li:nth-child(3) {
      left: 25%;
      animation-delay: 4s;
    }

    li:nth-child(4) {
      left: 40%;
      width: 60px;
      height: 60px;

      animation-duration: 22s;

      background-color: rgba(white, 0.3);
      /* fade(white, 25%); */
    }

    li:nth-child(5) {
      left: 70%;
    }

    li:nth-child(6) {
      left: 80%;
      width: 120px;
      height: 120px;

      animation-delay: 3s;
      background-color: rgba(white, 0.2);
      /* fade(white, 20%); */
    }

    li:nth-child(7) {
      left: 32%;
      width: 160px;
      height: 160px;

      animation-delay: 7s;
    }

    li:nth-child(8) {
      left: 55%;
      width: 20px;
      height: 20px;

      animation-delay: 15s;
      animation-duration: 40s;
    }

    li:nth-child(9) {
      left: 25%;
      width: 10px;
      height: 10px;

      animation-delay: 2s;
      animation-duration: 40s;
      background-color: rgba(white, 0.3);
      /*fade(white, 30%);*/
    }

    li:nth-child(10) {
      left: 90%;
      width: 160px;
      height: 160px;

      animation-delay: 11s;
    }

    @-webkit-keyframes square {
      0% {
        transform: translateY(0);
      }

      100% {
        transform: translateY(-500px) rotate(600deg);
      }
    }

    @keyframes square {
      0% {
        transform: translateY(0);
      }

      100% {
        transform: translateY(-500px) rotate(600deg);
      }
    }

    .bottomHalf {
      align-items: center;
      padding: 1.5rem 2rem 2rem;
      margin-bottom: 0;
    }

    .bottomHalf p {
      font-weight: 500;
      font-size: 1.05rem;
      margin-bottom: 20px;
    }

    .invoice_btn {
      border: none;
      color: white;
      cursor: pointer;
      border-radius: 12px;
      padding: 10px 18px;
      background-color: #019871;
      text-shadow: 0 1px rgba(128, 128, 128, 0.75);
    }

    .invoice_btn:hover {
      background-color: #85ddbf;
    }

    @media(max-width:992px) {
      .wrapperAlert {
        width: 100%;
        margin: 3rem 0;
      }

    }

    .thankyou_wrapper {
      min-height: calc(100vh - 170px);
    }
  </style>
    <section class="flex-1">
        <div class="space-5"></div>
        <div class="container thankyou_wrapper">
            <div class="row">
                <div class="col-lg-12 mx-auto text-center">
                    <div class="wrapperAlert">
                        <div class="contentAlert">
            
                        <div class="row align-items-center">
                                <div class="topHalf col-6">
                
                                <p><svg viewBox="0 0 512 512" width="100" title="check-circle">
                                    <path
                                        d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z" />
                                    </svg>
                                </p>
                                <h1>Congratulations</h1>
                
                                <ul class="bg-bubbles">
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                                </div>
                                <div class=" col-6">
                                <img src="{{ asset('frontend/assets/images/background/qr_code.webp') }}" class="img-fluid mx-auto">
                                <p class="fw-500 mt-2">Please pay your order amount by scanning above QR Code.</p>
                                </div>
                        </div>
            
                        <div class="bottomHalf">
                            <!-- <p>{{ getSetting('invoice_thanksgiving') }} </p> -->
                            <p class="mb-0">Thank You! Your Order Placed SuccessFully.</p>
                            <p class="text-danger"><b>Note: </b>Your order will be book once your payment received.</p>
                            <a class="invoice_btn" href="{{route('checkout.invoice',$order->order_code)}}" id="alertMO">Download
                            Invoice</a>
            
                        </div>
            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-frontend.app-layout>
