<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ localize('INVOICE') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="UTF-8">
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Baloo+Bhaijaan+2:wght@400;500&family=Hanuman:wght@300;400;700&family=Hind+Siliguri:wght@400;500&family=Kanit:wght@400;500&family=Open+Sans:wght@400;500&family=Roboto:wght@400;500&display=swap');

        * {
            box-sizing: border-box;
            font-family: '<?php echo $font_family; ?>';
        }

        pre,
        p {
            padding: 0;
            margin: 0;
            font-family: '<?php echo $font_family; ?>';
        }

        table {
            width: 100%;
            border-collapse: collapse;
            padding: 1px;
            font-family: '<?php echo $font_family; ?>';
        }

        td,
        th {
            text-align: left;
            font-family: '<?php echo $font_family; ?>';
        }

        .visibleMobile {
            display: none;
            font-family: '<?php echo $font_family; ?>';
        }

        .hiddenMobile {
            display: block;
            font-family: '<?php echo $font_family; ?>';
        }

        .text-left {
            text-align: <?php echo $default_text_align; ?>;
            font-family: '<?php echo $font_family; ?>';
        }

        .text-right {
            text-align: <?php echo $reverse_text_align; ?>;
            font-family: '<?php echo $font_family; ?>';
        }
    </style>
</head>

<body>
    {{-- header start --}}
    <table style="width: 100%; table-layout: fixed">
        <tr>
            <td colspan="4"
                style="border-right: 1px solid #e4e4e4; width: 300px; color: #323232; line-height: 1.5; vertical-align: top;">
                <p style="font-size: 15px; color: #5b5b5b; font-weight: bold; line-height: 1; vertical-align: top; ">
                    {{ localize('INVOICE') }}</p>
                <br>
                <p style="font-size: 12px; color: #5b5b5b; line-height: 24px; vertical-align: top;">
                    {{ localize('Invoice No') }} : {{ getSetting('order_code_prefix') }}
                    {{ $order->order_code }}<br>
                    {{ localize('Order Date') }} : {{ date('d M, Y', strtotime($order->created_at)) }}
                </p>
            </td>
            <td colspan="4" align="right"
                style="width: 300px; text-align: right; padding-left: 50px; line-height: 1.5; color: #323232;">
                <img src="{{ uploadedAsset(getSetting('navbar_logo')) }}" alt="{{getSetting('system_title')}}" border="0" />
               
                <p style="font-size: 12px; color: #5b5b5b; line-height: 24px; vertical-align: top;">
                    {{ getSetting('topbar_location') }}<br>
                    {{ localize('Phone') }}: {{ getSetting('navbar_contact_number') }}
                </p>
            </td>
        </tr>
        <tr class="visibleMobile">
            <td height="10"></td>
        </tr>
        <tr>
            <td colspan="10" style="border-bottom:1px solid #e4e4e4"></td>
        </tr>
    </table>
    {{-- header end --}}

    {{-- billing and shipping start --}}
    <table class="table" style="width: 100%;">
        <tbody style="display: table-header-group">
            <tr class="visibleMobile">
                <td height="20"></td>
            </tr>
            <tr style=" margin: 0;">
                <td colspan="4" style="width: 300px;">
                    <p
                        style="font-size: 12px; font-weight: bold; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                        {{ localize('SHIPPING INFORMATION') }}</p>
                    <br/>
                    @php
                        $shippingAddress = $order->billingAddress;
                    @endphp
                    <p style="font-size: 12px; color: #5b5b5b; line-height: 24px; vertical-align: top;">

                       {{ optional($order->user)->name }} <br/>

                        @if (!empty($shippingAddress))
                            {{ $shippingAddress->address }} 
                        @endif

                        @if ($order->phone_no)
                            <br>
                            {{ localize('Phone') }}: {{ $order->phone_no }}
                        @endif
                    </p>
                </td>

            </tr>
        </tbody>
    </table>
    {{-- billing and shipping end --}}

    <div style="text-align:center;backgroud:rgb(244, 246, 248);">
        <h6 style="margin-bottom:0;padding:0.5rem auto;color:red;">Order Type : {{$order->delivery_type ==1 ? 'Delivery' : ' Take Away'}}</h6>
    </div>

    {{-- item details start --}}
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
        <tbody>
            <tr>
                <td>
                    <table width="600" border="0" cellpadding="0" cellspacing="0" align="center"
                        class="fullTable" bgcolor="#ffffff">
                        <tbody>
                            <tr class="visibleMobile">
                                <td height="40"></td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center"
                                        class="fullPadding">
                                        <tbody>
                                            <tr>
                                                <th style="font-size: 12px; color: #000000; font-weight: normal;
                                                    line-height: 1; vertical-align: top; padding: 0 10px 7px 0;"
                                                    width="52%" align="left">
                                                    {{ localize('Item') }}
                                                </th>
                                                <th style="font-size: 12px; color: #000000; font-weight: normal;
                                                    line-height: 1; vertical-align: top; padding: 0 0 7px;"
                                                    align="left">
                                                    {{ localize('Price') }}
                                                </th>
                                                <th style="font-size: 12px; color: #000000; font-weight: normal;
                                                    line-height: 1; vertical-align: top; padding: 0 0 7px; text-align: center; "
                                                    align="center">
                                                    {{ localize('Qty') }}
                                                </th>
                                                <th style="font-size: 12px; color: #000000; font-weight:
                                                    normal; line-height: 1; vertical-align: top; padding: 0 0 7px; text-align: right; "
                                                    align="right">
                                                    {{ localize('Subtotal') }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <td height="1" style="background: #e4e4e4;" colspan="4"></td>
                                            </tr>

                                            @foreach ($order->orderItems as $key => $product)
                                               
                                                <tr>
                                                    <td style="font-size: 12px; color: #5b5b5b;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                                                        class="article">
                                                        <div>{{ $product->product_name }}</div>
                                                        <div class="text-muted">
                                                            {{$product->product_variation ?? ''}}
                                                            @if ($product->product_type==2)
                                                             (AddOn)      
                                                            @endif
                                                        </div>
                                                        
                                                    </td>
                                                    <td
                                                        style="font-size: 12px; color: #646a6e;  line-height:
                                                        18px;  vertical-align: top; padding:10px 0;">
                                                        {{ formatPrice($product->unit_price) }}</td>
                                                    <td style="font-size: 12px; color: #646a6e;  line-height:
                                                        18px;  vertical-align: top; padding:10px 0; text-align: center;"
                                                        align="center">{{ $product->qty }}</td>
                                                    <td style="font-size: 12px; color: #1e2b33;  line-height:
                                                        18px;  vertical-align: top; padding:10px 0; text-transform: capitalize !important;"
                                                        align="right">
                                                        <strong style="font-weight: 800;">{{ formatPrice($product->total_price) }}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="1" style="background: #e4e4e4;" colspan="4"></td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="20"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    {{-- item details end --}}

    @if(!empty($order->order_note))
    <p style="margin-top: 1rem ;margin-bottom: 1rem;padiing:0 1rem;font-weight:500;">
        Order Note : {!! $order->order_note ?? '' !!}
    </p>
    @endif
    {{-- item total start --}}
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
        <tbody>
            <tr>
                <td>
                    <table width="600" border="0" cellpadding="0" cellspacing="0" align="center"
                        class="fullTable" bgcolor="#ffffff">
                        <tbody>
                            <tr>
                                <td>
                                    <!-- Table Total -->
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0"
                                        align="center" class="fullPadding">
                                        <tbody>
                                            <tr>
                                                <td
                                                    style="font-size: 12px; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                                    {{ localize('Subtotal') }}
                                                </td>
                                                <td style="font-size: 12px; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; white-space:nowrap;"
                                                    width="80">
                                                    {{ formatPrice($order->sub_total_amount) }}
                                                </td>
                                            </tr>

                                            @if(!empty($order->total_tax_amount))
                                            <tr>
                                                <td
                                                    style="font-size: 12px; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                                    {{ localize('Tax') }}
                                                </td>
                                                <td
                                                    style="font-size: 12px; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                                    {{ formatPrice($order->total_tax_amount) }}
                                                </td>
                                            </tr>
                                            @endif

                                            <tr>
                                                <td
                                                    style="font-size: 12px; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                                                    <strong style="font-weight: 800;">{{ localize('Grand Total') }}</strong>
                                                </td>
                                                <td
                                                    style="font-size: 12px; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                                                    <strong style="font-weight: 800;">{{ formatPrice($order->grand_total_amount) }}</strong>
                                                </td>
                                            </tr>

                                            @if ($order->payment_status == 3) 
                                            <tr>
                                                <td
                                                    style="font-size: 12px; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                                                    <strong style="font-weight: 800;">{{ localize('Paid Total') }}</strong>
                                                </td>
                                                <td
                                                    style="font-size: 12px; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                                                    <strong style="font-weight: 800;">{{ formatPrice($order->paid_amount ?? 0) }}</strong>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td
                                                    style="font-size: 12px; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                                                    <strong style="font-weight: 800;">{{ localize('Pending Total') }}</strong>
                                                </td>
                                                <td
                                                    style="font-size: 12px; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                                                    <strong style="font-weight: 800;">{{ formatPrice($order->pending_amount ?? 0) }}</strong>
                                                </td>
                                            </tr>

                                            @endif
                                        </tbody>
                                    </table>
                                    <!-- /Table Total -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    {{-- item total end --}}

    {{-- footer start --}}
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
        bgcolor="#ffffff">

        <tr>
            <td>
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center"
                class="fullTable" bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
                <tr>
                <tr class="hiddenMobile">
                    <td height="30"></td>
                </tr>
                <tr class="visibleMobile">
                    <td height="20"></td>
                </tr>
                <td>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center"
                        class="fullPadding">
                        <tbody>
                            <tr>
                                <td
                                    style="font-size: 12px; color: #5b5b5b; line-height: 18px; vertical-align: top; text-align: left;">
                                    <p
                                        style="font-size: 12px; color: #5b5b5b; line-height: 18px; vertical-align: top; text-align: left;">
                                        {{ localize('Hello') }}
                                        <strong>{{ optional($order->user)->name }},</strong>
                                        <br>
                                        {{ getSetting('invoice_thanksgiving') }}
                                    </p>
                                    <br><br>
                                    <p
                                        style="font-size: 12px; color: #5b5b5b; line-height: 18px; vertical-align: top; text-align: left;">
                                        {{ localize('Best Regards') }},
                                        <br>{{ getSetting('system_title') }} <br>
                                        {{ localize('Email') }}: {{ getSetting('topbar_email') }}<br>
                                        {{ localize('Website') }}: {{ route('home') }}
                                    </p>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                </tr>
            </table>
            </td>
        </tr>
    </table>
    {{-- footer end --}}
</body>

</html>
