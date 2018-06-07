<!doctype html>
<html lang="{{$data['keys']->local}}">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        table, #adress{
            font-size: x-small;
        }
        tfoot tr td{
            font-weight: bold;
            font-size: x-small;
        }
        #adress{
            float: left;
            position: absolute;
            margin-left: 185px;
            top: 56px;
        }
        #custommerAdress{
            top: 56px;
            position: absolute;
            right: 10px;

        }
        #custommerAdress h3{
            margin-bottom: 0;
        }
        div span{
            display:block;
        }
        div .title{
            font-weight: bolder;
        }
        tfoot{
            border-top: 1px black solid;

        }
        footer{
            position: absolute;
            bottom: 5px;
            background-color:#da0f68;
            padding:5px;
            color:white;
        }
    </style>

</head>
<body>

<div id="adress">
    <span class="title">CoatAndClothes.Shop SA</span>
    <span>   Rue du petit bonheur 69</span>
    <span>   1296 Gland</span>
    <span>   CH - Suisse</span>
</div>
<table width="100%">
    <tr>
        <td valign="top"><img src="{{asset('resources/assets/images/favicon.png')}}" alt="Logo CoatNClothes" width="150"/></td>


    </tr>

    <tr>
        <td align="right">
            <div id="custommerAdress">
                <h3>{{$data['values']['custommer']->users_completeName}}</h3>
                <span>   {{$data['values']['custommer']->adresses_street}}</span>
                <span>   {{$data['values']['custommer']->adresses_locality}} {{$data['values']['custommer']->adresses_npa}}</span>
                <span>   {{$data['values']['custommer']->adresses_state}}</span>
            </div>
        </td>

    </tr>
    <tr>
        <td align="right">
            <h3>{{$data['keys']->bill}} N° {{$data['keys']->id}}</h3>
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
<footer>
    <span>{{$data['keys']->footer}}</span>
</footer>
</body>
</html>