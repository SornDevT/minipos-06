<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/font_lao.css">
    <link rel="stylesheet" href="../../assets/vendor/css/core.css?id=7a74a9d0cfeabd283069bfaa3de33eaa">
<link rel="stylesheet" href="../../assets/vendor/css/theme-default.css?id=3d127db9612959fd1b1297d4adb3d55e">
    <title>ໃບບິນຮັບເງິນ</title>
</head>
<body>
  
<div class="container text-center">
        <p>ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ</p>
        <p>ສັນຕິພາ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນະຖາວອນ</p>

        <h2>ໃບບິນຮັບເງິນ</h2>
        <div class=" d-flex justify-content-end ">
        <span>ໃບບິນເລກທີ່: {{$bill_id}} </span>
        </div>

        <div class="text-start">
           @if($bill[0]['customer_name']=='')
            ລູກຄ້າ: ລູກຄ້າທົ່ວໄປ
            @else
            ລູກຄ້າ: {{ $bill[0]['customer_name'] }}, ເບີໂທ: {{$bill[0]['customer_tel']}}
            @endif
        </div>
       
        <table class="table table-bordered">
            <thead>
                <th width="80">ລ/ດ</th>
                <th class="text-start">ລາຍການ</th>
                <th width="120">ລາຄາ</th>
                <th width="90">ຈຳນວນ</th>
                <th width="160">ລວມ</th>
            </thead>
            <tbody>
                    @php($num=1)
                    @php($total=0)
                    @foreach($bill_list as $b)
                    <tr>
                        <td>{{$num++}}</td>
                        <td class="text-start">{{ $b['name'] }}</td>
                        <td class="text-end">{{ number_format($b['price'],0,',','.') }} </td>
                        <td class="text-end">{{ $b['amount'] }}</td>
                        <td class="text-end">{{ number_format($b['price']*$b['amount'],0,',','.') }}</td>
                        @php($total += $b['price']*$b['amount'])
                    </tr>
                    @endforeach
                <tr>
                    <td colspan='4' > ລວມທັງໝົດ </td>
                    <td class="text-end">   {{number_format($total,0,',','.')}}</td>
                </tr>
            </tbody>
        </table>
        <div class=" d-flex justify-content-between p-4">
            <span >ພະນັກງານ</span>
            <span >ຜູ້ຈ່າຍເງິນ</span>
        </div>
    </div>

     <script>
        window.print();
        setTimeout( 'window.close();', 3000);
     </script>

</body>
</html>