<!doctype html>
<html lang="{{$data['keys']->local}}">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        table{
            font-size: x-small;
        }
        tfoot tr td{
            font-weight: bold;
            font-size: x-small;
        }
    </style>

</head>
<body>

<table width="100%">
    <tr>
        <td valign="top"><img src="https://coatandclothes.shop/static/favicon.png" alt="Logo CoatNClothes" width="150"/></td>
        <td align="right">
            <h3>{{$data['keys']->bill}}</h3>
        </td>

    </tr>
    <tr>
        <td align="right">
            <h3>{{$data['values']['custommer']->users_completeName}}</h3>
            <pre>
                {{$data['values']['custommer']->adresses_street}}
                {{$data['values']['custommer']->adresses_locality}} {{$data['values']['custommer']->adresses_npa}}
                {{$data['values']['custommer']->adresses_state}}
            </pre>
        </td>
    </tr>

</table>

<br/>

<table width="100%">
    <thead style="background-color: lightgray;">
    <tr>
        <th>{{$data['keys']->orders_id}}</th>
        <th>{{$data['keys']->orders_name}}</th>
        <th>{{$data['keys']->orders_quantity}}</th>
        <th>{{$data['keys']->orders_price}} CHF</th>
        <th>{{$data['keys']->orders_priceTotal}} CHF</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['values']['products'] as $item)
        <tr>
            <th scope="row">{{$item->products_id}}</th>
            <td>{{$item->products_name}}</td>
            <td align="right">{{$item->orders_quantity}}</td>
            <td align="right">{{$item->orders_price}}</td>
            <td align="right">{{$item->orders_priceTotal}}</td>
        </tr>
    @endforeach
    </tbody>

    <tfoot>
    <tr>
        <td colspan="3"></td>
        <td align="right">{{$data['keys']->total}} CHF</td>
        <td align="right">{{$data['values']['total']}}</td>
    </tr>
    </tfoot>
</table>

</body>
</html>