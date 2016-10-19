<OBJECT ID='x' name='x' CLASSID='CLSID:53C732B2-2BEA-4BCD-9C69-9EA44B828C7F' align=center hspace=0 vspace=0></OBJECT>

<hr/>
<input type='button' value='显示Msg属性的值' onclick='ShowMsg()'/>
<input type='button' value='本地打印' onclick='localPrt()'/>
<input type='button' value='详情单补打(原单号)' onclick='rePrintOldNo()'/>
<input type='button' value='详情单补打(新单号)' onclick='rePrintNewNo()'/>
<input type='button' value='打印详情单' onclick='PrintBill()'/>
<input type='button' value='打印详情单(传重)' onclick='PrintBillWeight()'/>
<input type='button' value='打印测试' onclick='TestShowMsg()'/>
<input type='button' value='查询可用单号数' onclick='GetRemaindBillNO()'/>
<input type='button' value='批量打印' onclick='PrtBillBatch()'/>
<input type='button' value='验证' onclick='checkid()'/>
<script type='text/JavaScript'>
    var x = document.getElementById("x");
    var ShowMsg = function () {
        alert(x.PrtMsg);
    };


    //账号验证
    var checkid = function () {
        alert(x.CheckID('42010670114000#%595600830807d207332c36fcd7a5c3e5'));
        alert(x.PrtMsg);
    }

    //本地打印
    var localPrt = function () {
        //head|businessType|billnoType|Billno|dateType|procdate|scontactor|scustMobile|scustTelplus|scustPost|scustAddr|tcontactor|tcustMobile|tcustTelplus|tcustPost|tcustAddr|tcustProvince|tcustCity|tcustCounty|weight|insure|fee|feeUppercase|cargoDesc|bigAccountDataId|customerDn|mainBillNo|blank1|blank2|end
        alert(x.localPrt('head|4|2|{{$order->ems_num}}|2|{{date('Y-m-d H:i:s')}}|易康伴侣|联系方式:4001199802|4001199502|430000|湖北省武汉市东湖新技术开发区高新大道666号光谷生物城C2-4|{{$order->address_name}}|{{$order->address_phone}}||邮编|{{$order->address_detail}}|{{$order->address_province}}|{{$order->address_city}}|{{$order->address_district}}|1||||@foreach($order->products as $product){{'【'.$product->name.'('}}@if($product->pivot->specification_id) {{\App\Models\ProductSpecification::find($product->pivot->specification_id)->specification_name}}@else {{$product->default_spec}}@endif{{ '.)×' . $product->pivot->quantity .'】'}}@endforeach|{{$order->order_sn}}|{{$order->order_sn}}||||end'));
    };

    //补打获取新单号
    var rePrintNewNo = function () {
        alert(x.RePrtHotBillNewNO('A1234567890Z', 'SO121212001'));
    };
    //传入重量打印
    var PrintBillWeight = function () {
        alert(x.PrtHotBillWithInWeight('A1234567890Z', 'SO121212001', '0.235'));
    };
    //补打使用原单号
    var rePrintOldNo = function () {
        alert(x.RePrtHotBill('A1234567890Z#%SO121212001'));
    };
    //批量打印
    var PrtBillBatch = function () {
        alert(x.PrtHotBillBatching('A1234567890Z#%SO121212001'));
//#%P3758017#%1234#%EY318313459CN#%P5256573#%P4758018#%P4758019#%P4758020#%EH0990
    };
    //打印详情单
    var PrintBill = function () {
        alert(x.PrtHotBillAndGetBillNo('A1234567890Z#%SO121212001'));
    };
    //打印测试
    var TestShowMsg = function () {
        alert(x.Test_PrtHotBillAndGetBillNo('A1234567890Z#%SO121212001'));
    };
    //查询可用单号余量
    var GetRemaindBillNO = function () {
        alert(x.CountNotUsedBillNo('A1234567890Z#%01'));
    };


</script>


<div id="info"></div>

<script type="text/javascript">

    var _info = "";

    for (var p in x) {
        _info += p + "：" + x[p] + "<br/>";
    }

    document.getElementById("info").innerHTML = _info;

</script>
