@extends('en.Emails.Layouts.Master')

@section('message_content')
Hello,<br><br>

Your order for the event <b>{{$order->event->title}}</b> was successful.<br><br>

Your tickets are attached to this email. You can also view you order details and download your tickets at: {{route('showOrderDetails', ['order_reference' => $order->order_reference])}}


<h3>Order Details</h3>
Order Reference: <b>{{$order->order_reference}}</b><br>
Order Name: <b>{{$order->full_name}}</b><br>
Order Date: <b>{{$order->created_at->toDayDateTimeString()}}</b><br>
Order Email: <b>{{$order->email}}</b><br>

<h3>Order Items</h3>
<div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">
    <table style="width:100%; margin:10px;">
        <tr>
            <td>
                <b>Ticket</b>
            </td>
            <td>
                <b>Qty.</b>
            </td>
            <td>
                <b>Price</b>
            </td>
            <td>
                <b>Fee</b>
            </td>
            <td>
                <b>Total</b>
            </td>
        </tr>
        @foreach($order->orderItems as $order_item)
                                <tr>
                                    <td>
                                        {{$order_item->title}}
                                    </td>
                                    <td>
                                        {{$order_item->quantity}}
                                    </td>
                                    <td>
                                        @if((int)ceil($order_item->unit_price) == 0)
                                        FREE
                                        @else
                                       {{money($order_item->unit_price, $order->event->currency)}}
                                        @endif

                                    </td>
                                    <td>
                                        @if((int)ceil($order_item->unit_price) == 0)
                                        -
                                        @else
                                        {{money($order_item->unit_booking_fee, $order->event->currency)}}
                                        @endif

                                    </td>
                                    <td>
                                        @if((int)ceil($order_item->unit_price) == 0)
                                        FREE
                                        @else
                                        {{money(($order_item->unit_price + $order_item->unit_booking_fee) * ($order_item->quantity), $order->event->currency)}}
                                        @endif

                                    </td>
                                </tr>
                                @endforeach
        <tr>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
                Sub Total
            </td>
            <td colspan="2">
               {{money($order->amount + $order->order_fee, $order->event->currency)}}
            </td>
        </tr>
        <tr>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
                {{$event->organiser->taxname}}
            </td>
            <td colspan="2">
               {{money(($order->amount*($event->organiser->taxvalue)/100), $event->currency)}}
            </td>
        </tr>
        <tr>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
                <b>Total</b>
            </td>
            <td colspan="2">
               {{money($order->amount+($order->amount*($event->organiser->taxvalue)/100), $event->currency)}}
            </td>
        </tr>
    </table>

    <br><br>
</div>
<br><br>
Thank you
@stop